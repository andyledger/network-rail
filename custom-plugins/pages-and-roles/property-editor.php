<?php

/**
 * Remove edit from toolbar for Property Editors
 */
add_action('wp_before_admin_bar_render', function() {
    global $wp_admin_bar;

    //Remove the WordPress logo...
    if (is_current_user('property_editor')) {
        $wp_admin_bar->remove_menu('edit');
    }
});

/**
 * Wrap everything until the plugin is loaded
 * Display pages for a 'property_editor' role
 */
add_action( 'plugins_loaded', function() {
    $user_id = get_current_user_id();

    $pages = get_child_and_own_pages($user_id, [3753], [3753]);

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

        if (is_current_user('property_editor') && $post_type == 'page' && $screen == 'edit-page') {
            $query->query_vars['author'] = null;
            $query->query_vars['post__in'] = $pages;
        }

        return $query;
    }, 10, 2);
} );

/**
 * Problem:
 * station pages not loading.
 * Why?
 * this role don't have enough permits and the rest api respond has errors
 * Solution (not the best solution)
 * Give enought permits to this role and hidde menu items:
 *  - edit_others_posts and edit_posts are active again in wp-admin/users.php?page=users-user-role-editor.php
 *  - hidding items on the sidebar menu.
 */
add_action('admin_menu', function() {
    if (is_current_user('property_editor')) {
        // hide Posts
        remove_menu_page('edit.php');
        // hide Tools
        remove_menu_page('tools.php');
    }
});


