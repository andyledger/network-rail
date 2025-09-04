<?php

/**
 * Create custom options to the feeds api end-point
 */
add_filter('rest_prepare_feeds', function ($data, $post, $context) {
    $featured_image_id = $data->data['featured_media']; // get featured image id

    $featured_image_url = wp_get_attachment_image_src($featured_image_id, 'card-lg'); // get url of the original size

    if ($featured_image_url) {
        $data->data['featured_image_url'] = $featured_image_url[0];
    }

    $categories = get_the_category($data->data['id']);

    $categories_name = [];

    foreach ($categories as $category) {
        $categories_name[] = $category->name;
    }

    if ($categories_name) {
        $data->data['categories_name'] = $categories_name;
    }

    return $data;
}, 10, 3);

/**
 * Filter options in feeds end-point
 */
add_filter('rest_prepare_feeds', function ($data, $post, $context) {
    return [
        'id'        => $data->data['id'],
        'title'     => $data->data['title']['rendered'],
        'date'     => $data->data['date'],
        'link'      => $data->data['link'],
        'categories' => $data->data['categories'],
        'categories_name' => $data->data['categories_name'],
        'tags' => $data->data['tags'],
        'featured_media' => $data->data['featured_media'],
        'featured_image_url' => $data->data['featured_image_url']
    ];
}, 12, 3);

/**
 * Filter options in menu end-point TODO
 */
add_filter('rest_prepare_nav_menu_item', function ($data, $post, $context) {
    return [
        'id'        => $data->data['id']
    ];
}, 12, 3);


/**
 * Algolia public data.
 * this data is for ajax purpose
 * @return arr
 */
function algolia_public_data()
{
    return [
        'algolia_applicationID' => get_option('algolia_applicationID'),
        'algolia_searchApiKey' => get_option('algolia_searchApiKey'),
        'algolia_indexName' => get_option('algolia_indexName'),
    ];
}

/**
 * wp-json/options/v1/algolia_public_data
 */
add_action('rest_api_init', function () {
    register_rest_route('options/v1', '/algolia_public_data', [
        'methods' => 'GET',
        'callback' => 'algolia_public_data',
        'permission_callback' => '__return_true'
    ]);
});

/**
 * Helper funcition for the main-slider end-point
 *
 * @param  WP_post $post
 * @return array
 */
function main_slider_map($post)
{
    return [
        'title'         => $post->post_title,
        'description'   => $post->post_excerpt,
        'content'       => wp_trim_words($post->post_content, 4, '...'),
        'link'          => $post->guid,
        'imgUrl'        => wp_get_attachment_image_url(get_post_thumbnail_id($post), 'slider-bg-xxl'),
        'imgUrlSrcSet'  => wp_get_attachment_image_srcset(get_post_thumbnail_id($post)),
        'array'         => $post
    ];
}
/**
 * Create main-slider end point to pull the data
 * from acf main_slider of the front page
 * wp-json/options/v1/main-slider
 */
add_action('rest_api_init', function () {
    register_rest_route('options/v1', '/main-slider', [
        'methods'   => 'GET',
        'callback'  => function () {
            $front_page_id = get_option('page_on_front');

            $data = get_field('main_slider', $front_page_id);

            return array_map('main_slider_map', $data);

            return $data;
        },
        'permission_callback' => '__return_true'
    ]);
});



/**
 * Add careers end-point with the data from careers.json file
 * wp-json/options/v1/careers
 *
 */
add_action('rest_api_init', function () {
    register_rest_route('options/v1', '/careers', [
        'methods'   => 'GET',
        'callback'  => function () {
            $file_as_a_string = file_get_contents(get_template_directory_uri().'/resources/careers.json');

            return json_decode($file_as_a_string);
        },
        'permission_callback' => '__return_true'
    ]);
});

/**
 * Create search page no results end point to get
 * the ID of the page with the title 'Search page – no results'
 * From that page we pull the data to be rendered at
 * the search page when there is no results.
 * wp-json/options/v1/search-page-no-results-id
 */
add_action('rest_api_init', function () {
    register_rest_route('options/v1', '/search-page-no-results-id', [
        'methods'   => 'GET',
        'callback'  => function () {
            $page =  get_page_by_path('search-page-no-results');

            if ($page) {
                return $page->ID;
            }

            return false;
        },
        'permission_callback' => '__return_true'
    ]);
});


/**
 * Deactivate users endpoint
 *
 * https://www.networkrail.co.uk/wp-json/wp/v2/users
 *
 * consider another option to delete this endpoint because
 * it is used by the admin panel and it may cause different
 * issues.
 *
 */
// add_filter('rest_endpoints', function ($endpoints) {
    // print_r($endpoints);

    // if (isset($endpoints['/wp/v2/users'])) {
    //     unset($endpoints['/wp/v2/users']);
    // }

    // if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
    //     unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    // }

    // return $endpoints;
// });
