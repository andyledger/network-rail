<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter(
    'excerpt_more',
    function () {
        return '...';
    }
);

add_filter('excerpt_length', function () {
    return 20;
});

/**
 * Modify main query on Home template
 */
add_action(
    'pre_get_posts',
    function () {
        if ($GLOBALS['wp_query']->is_home() && $GLOBALS['wp_query']->is_main_query()) {
            $GLOBALS['wp_query']->set(
                'category_name',
                View\Composers\App::get_cat_name()
            );

            // $GLOBALS['wp_query']->set( 'tag', Controllers\App::getTagName());

            $GLOBALS['wp_query']->set('ignore_sticky_posts', true);
        }
    }
);

/**
 * Remove plugins styles from the front-end
 */
add_action(
    'wp_print_styles',
    function () {
        /**
         * We don't need tablepress styles anymore
         */
        wp_deregister_style('tablepress-default');

    /**
     * This three styles are from Gutemberg editor
     * but shouldn't affect to the front end.
     *
     * Do not remove, .wp-block-columns class depends of these styles.
     */
        // wp_deregister_style('wp-block-library');
        // wp_deregister_style('wp-block-library-theme');
        // wp_deregister_style('wc-blocks-style');
    },
    100
);

/**
 * Remove plugins scripts from the front-end
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        // tablepress
        wp_deregister_script('tablepress-datatables');
        wp_dequeue_script('tablepress-datatables');
        wp_deregister_script('wp-embed');
    },
    999
);


/**
 * Limit search to post_title
 *
 * @param $search
 * @param $wp_query
 *
 * @return $string
 */
add_filter(
    'posts_search',
    function ($search, $wp_query) {
        // $wp_query was a reference
        global $wpdb;

        if (empty($search)) {
            return $search;
        } // skip processing - no search term in query

        $q = $wp_query->query_vars;
        $n = !empty($q['exact']) ? '' : '%';
        $search = $searchand = '';

        foreach ((array) $q['search_terms'] as $term) {
            $term = esc_sql($wpdb->esc_like($term));
            $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
            $searchand = ' AND ';
        }

        if (!empty($search)) {
            $search = " AND ({$search}) ";

            if (!is_user_logged_in()) {
                $search .= " AND ($wpdb->posts.post_password = '') ";
            }
        }

        return $search;
    },
    500,
    2
);

// Remove unwanted SVG filter injection WP
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

add_filter('login_errors', function () {
    return 'Invalid login credentials.';
});


/**
 * Filters the REST API response before executing any callbacks to hide the 'Users' endpoint from
 * non-authenticated users.
 *
 * Note that this filter will not be called for requests that fail to authenticate or
 * fail to match a registered route.
 *
 * @link: https://developer.wordpress.org/reference/hooks/rest_request_before_callbacks/
 *
 * @param \WP_REST_Response|\WP_HTTP_Response|\WP_Error|mixed $response Result to send to the client.
 * @param array $handler Route handler used for the request.
 * @param \WP_REST_Request $request Request used to generate the response.
 * @return \WP_REST_Response|\WP_HTTP_Response|\WP_Error|mixed The filtered request used to generate the response.
 */
\add_filter('rest_request_before_callbacks', function ($response, $handler, $request)
{
    // Bail early - user has relevant permissions.
    if (\current_user_can('list_users')) {
        return $response;
    }

    // Check for allowed capability and allowed route(s).
    if (mb_stripos($request->get_route(), '/wp/v2/users') !== false) {
        return new \WP_Error(
            'forbidden',
            \__('Access forbidden.', 'sage'),
            [
                'status' => 403
            ]
        );
    }

    return $response;
}, 10, 3);


\add_filter('register_post_type_args', function ($args, $post_type) {
    if ($post_type === 'mc-events') {
        $args['show_in_rest'] = true;
    }

    return $args;
}, 10, 2);
