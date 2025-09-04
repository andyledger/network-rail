<?php

/**
 * Model of the record to be push to Algolia
 * valid for pages, posts and feeds, all together
 * @param  [WP_Post] $post - the wp_post object
 * @return [array] return an array to the item_to_record filter
 */
add_filter('item_to_record', function (\WP_Post $post) {
    $excerpt = wp_strip_all_tags(
      html_entity_decode($post->post_excerpt)
    );

    if (empty($post->post_excerpt)) {
      $excerpt = wp_trim_words(
        wp_strip_all_tags(
          html_entity_decode($post->post_content)
        ), 40, '...' );
    }

    $categories = [];
    $categoriesName = [];

    if ($post->post_type == 'post') {
       $categories = get_the_category($post->ID);

       foreach ($categories as $cat) {
         $categoriesName[] = html_entity_decode($cat->name);
       }
    }

    return [
        'objectID' => implode('#', [$post->post_type, $post->ID]),
        'post_type' => $post->post_type,
        'title' => html_entity_decode($post->post_title),
        'content' => wp_strip_all_tags(html_entity_decode($post->post_content)),
        'excerpt' => $excerpt,
        'categories' => $categoriesName,
        'url' => get_permalink($post->ID),
        'post_date' => $post->post_date,
        'post_date_timestamp' => (int) strtotime($post->post_date)
    ];
});

/**
 * update or create Algolia record when press update or publish button
 * delete record from Algolia when the post is sent to the bin
 */
add_action('save_post', function($post_ID, \WP_Post $post, $update) {
    /**
     * check if we are in production
     */
    if ($_SERVER['SERVER_NAME'] !== 'www.networkrail.co.uk') {
        return $post;
    }

    /**
     * check if is post or page (no feeds)
     */
    if ($post->post_type !== 'post' && $post->post_type !== 'page') {
        return $post;
    }

    if (wp_is_post_revision( $post_ID) || wp_is_post_autosave( $post_ID )) {
        return $post;
    }

    global $algolia;

    $record = (array) apply_filters('item_to_record', $post);

    if ( !isset($record['objectID']) ) {
      $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
    }

    $index = $algolia->initIndex(get_option('algolia_indexName'));

    // create a copy in this index too
    $indexNoFeeds = $algolia->initIndex('production_index_no_feeds');

    if ($post->post_status !== 'publish') {
        $index->deleteObject($record['objectID']);
        $indexNoFeeds->deleteObject($record['objectID']);
    } else {
        $index->saveObject($record);
        $indexNoFeeds->saveObject($record);
    }

    return $post;
}, 10, 3);
