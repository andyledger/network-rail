<?php

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

/**
 * This file manages how some roles only have access to certain pages,
 * plus its own pages.
 *
 * You can find more info in the next links:
 * https://wordpress.stackexchange.com/questions/191658/allowing-user-to-edit-only-certain-pages
 * http://mawaha.com/allow-user-to-edit-specific-post-using-map_meta_cap/
 * https://wordpress.stackexchange.com/questions/155644/whats-the-difference-between-role-and-meta-capabilities-when-to-use-map-meta-c/215389
 * http://justintadlock.com/archives/2010/07/10/meta-capabilities-for-custom-post-types
 * https://www.elegantthemes.com/blog/tips-tricks/how-to-restrict-access-to-areas-of-your-wordpress-website
 */


/**
 * @param $page_id int
 * @return bool true is child or our stations page
 */
function is_child_of_our_stations($page_id) {
    $our_station_page_id = 3753;

    $page = get_post($page_id);

    if (isset($page->post_parent)) {
        return ($page->post_parent == $our_station_page_id);
    }

    return false;
}

/**
 * @param  int  $user_id
 * @param  int  $page_id
 * @return boolean If a page belongs to a user with the property editor role
 */
function is_a_property_editor_page($user_id, $page_id) {
    $author_id = get_post_field('post_author', $page_id);

    $user_meta = get_userdata($user_id);

    $user_roles = $user_meta->roles;

    return in_array('property_editor', $user_roles);
}

/**
 * Customisable capability mapping for updateable pages
 *
 * @param $caps A list of required capabilities for this action
 * @param $cap The capability being checked
 * @param $user_id The current user ID
 * @param $args A numerically indexed array of additional arguments dependent on the meta cap being used
 */

// failing update station page ratailer, so we come back to edit all pages because is filtering the stations in the
// sidebar Pages menu

// add_filter( 'map_meta_cap', function( $caps, $cap, $user_id, $args ) {
//     /* Return the capabilities required by the user. */
//     if ( isset($args[0]) && user_can($user_id, 'publish_stations')
//         && ( is_child_of_our_stations($args[0]) || is_a_property_editor_page($user_id, $args[0]) )
//     ) {
//         $caps = [];
//         $caps[] = 'publish_stations';
//     }

//     return $caps;
// }, 10, 4 );

/**
 * @return Array - IDs of all pages that a user with Property editor role should access
 */
function property_editor_pages($user_id) {
    $pages = [];

    $stations = get_posts([
        'post_type' => 'page',
        'post_parent' => 3753,
        'posts_per_page' => -1
    ]);

    foreach ($stations as $station) {
        $pages[] = $station->ID;
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

    $pages[] = 68282;

    return $pages;
}

/**
 * @return boolean if a user is a Property Editor
 */
function is_current_user_property_editor() {
    $user_id = get_current_user_id();

    if ($user_id) {
        $user_meta = get_userdata($user_id);

        $user_roles = $user_meta->roles;

        return in_array('property_editor', $user_roles);
    }

    return false;
}

/**
 * @return boolean if a user is a Admin or NR Admin
 */
function is_current_user_admin_or_nr_admin() {
    $user_id = get_current_user_id();

    if ($user_id) {
        $user_meta = get_userdata($user_id);

        $user_roles = $user_meta->roles;

        return (in_array('administrator', $user_roles) || in_array('nr_admin', $user_roles));
    }

    return false;
}

/**
 * Wrap everything until the plugin is loaded
 */
add_action( 'plugins_loaded', function() {
    $user_id = get_current_user_id();

    $pages = property_editor_pages($user_id);

    /**
     * Show only child pages of our station and own pages in the pages menu
     * for Property Editors users
     *
     * https://wordpress.stackexchange.com/questions/91330/restrict-admin-access-to-certain-pages-for-certain-users
     */
    add_filter( 'parse_query', function($query) use ($pages) {
        global $post_type, $pagenow;

        if (is_current_user_property_editor() && $post_type == 'page') {
            $query->query_vars['author'] = null;
            $query->query_vars['post__in'] = $pages;
        }

        return $query;
    }, 10, 2);
} );

/**
 * Remove edit from toolbar for Property Editors
 */
add_action('wp_before_admin_bar_render', function() {
    global $wp_admin_bar;

    //Remove the WordPress logo...
    if (is_current_user_property_editor()) {
        $wp_admin_bar->remove_menu('edit');
    }
});


// Nested pages cannot manage this properly
// add_filter( 'nestedpages_page_listing', function($query_args) {
//     $user_id = get_current_user_id();

//     $user_meta = get_userdata($user_id);

//     $user_roles = $user_meta->roles;

//     if (in_array('property_editor', $user_roles)) {
//         $query_args['post_parent'] = 3753;
//     }

//     return $query_args;
// });


// add_filter( 'parent_page_filter', function($parent) {
//     $user_id = get_current_user_id();

//     $user_meta = get_userdata($user_id);

//     $user_roles = $user_meta->roles;

//     if (in_array('property_editor', $user_roles)) {
//         $parent = 3753;
//     }

//     return $parent;
// });
