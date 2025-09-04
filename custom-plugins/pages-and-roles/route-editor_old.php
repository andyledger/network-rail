<?php

/**
 * @return Array - IDs of all pages that a user with Route Editor role should access
 */
function route_editor_pages($user_id) {
    $pages = [];

    // add routes
    $routes = [66126, 66127, 4078, 59323, 66407];

    // child pages of 66126 and 66127
    $child_of_routes = get_posts([
        'post_type' => 'page',
        'post_parent__in' => $routes,
        'posts_per_page' => -1
    ]);

    foreach ($child_of_routes as $page) {
        $pages[] = $page->ID;
    }

    foreach ($routes as $page) {
        $pages[] = $page;
    }

    $own_pages = get_posts([
        'author' => $user_id,
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_status' => ['publish', 'draft']
    ]);

    foreach ($own_pages as $page) {
        $pages[] = $page->ID;
    }

    // TO DO
    // add extra pages id to the array with a custom field
    // $pages[] = 68282;

    return $pages;
}

/**
 * Remove edit from toolbar for Property Editors
 */
add_action('wp_before_admin_bar_render', function() {
    global $wp_admin_bar;

    //Remove the WordPress logo...
    if (is_current_user('route_editor')) {
        $wp_admin_bar->remove_menu('edit');
    }
});

/**
 * Wrap everything until the plugin is loaded
 * Display pages for a 'property_editor' role
 */
add_action( 'plugins_loaded', function() {
    $user_id = get_current_user_id();

    $pages = route_editor_pages($user_id);

    /**
     * Show only child pages of our station and own pages in the pages menu
     * for Property Editors users
     *
     * https://wordpress.stackexchange.com/questions/91330/restrict-admin-access-to-certain-pages-for-certain-users
     */
    add_filter( 'parse_query', function($query) use ($pages) {
        global $post_type, $pagenow;

        // check if we are only in "edit.php?post_type=page"
        // don't apply it in other part
        $screen = false;

        if ( function_exists('get_current_screen') && $screen = get_current_screen() ) {
            $screen = $screen->id;
        }

        if (is_current_user('route_editor') && $post_type == 'page' && $screen == 'edit-page') {
            $query->query_vars['author'] = null;
            $query->query_vars['post__in'] = $pages;
        }

        return $query;
    }, 10, 2);
} );
