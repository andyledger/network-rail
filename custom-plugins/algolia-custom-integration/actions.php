<?php

namespace AlgoliaCustomPlugin;

class Actions {
    public function reindex( $name ) {
        global $algolia;

        $index = $algolia->initIndex($name);

        $index->clearObjects()->wait();

        $paged = 1;
        $count = 0;

        $post_type = explode(',', get_option('algolia_postTypes'));
        $post__not_in = explode(',', get_option('algolia_excludeIds'));

        do {
            $posts = new \WP_Query([
                'posts_per_page' => 100,
                'paged' => $paged,
                'post_type' => $post_type,
                'post_status' => 'publish',
                'post__not_in' => $post__not_in
            ]);

            if (! $posts->have_posts()) {
                break;
            }

            $records = [];
            foreach ($posts->posts as $post) {
                $record = (array) apply_filters('item_to_record', $post);

                if (! isset($record['objectID'])) {
                    $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
                }

                $records[] = $record;
                $count++;
            }

            $index->saveObjects($records);

            $paged++;

        } while (true);

        $index->setSettings([
          'replicas' => [
            $name.'_date_desc'
          ]
        ]);

        $replicaIndex = $algolia->initIndex($name.'_date_desc');

        $replicaIndex->setSettings([
          'ranking' => [
            'desc(post_date_timestamp)'
          ]
        ]);

        ?>
            <div class="notice notice-success">
                <p><?php echo $count." posts indexed in Algolia" ?></p>
            </div>
        <?php
    }
}
