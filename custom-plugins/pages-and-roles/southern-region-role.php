<?php

/**
 * Remove edit from toolbar for Southern Editors
 */
// add_action('wp_before_admin_bar_render', function() {
//     global $wp_admin_bar;

//     //Remove the WordPress logo...
//     if (is_current_user('southern_region_editor')) {
//         $wp_admin_bar->remove_menu('edit');
//         $wp_admin_bar->remove_menu('new-post');
//     }
// });

/**
 * Wrap everything until the plugin is loaded
 * Display pages for a 'property_editor' role
 */
// add_action( 'plugins_loaded', function() {
//     $user_id = get_current_user_id();

//     $pages = get_child_and_own_pages($user_id, [66126, 66127, 4078, 59323, 66407], [] );

//     /**
//      * Show only child pages of our station and own pages in the pages menu
//      * for Property Editors users
//      *
//      * https://wordpress.stackexchange.com/questions/91330/restrict-admin-access-to-certain-pages-for-certain-users
//      */
//     add_filter( 'parse_query', function($query) use ($pages) {
//         global $post_type, $pagenow;

//         // check if we are only in "edit.php?post_type=page"
//         // don't apply it in other part
//         $screen = false;

//         if ( function_exists('get_current_screen') && $screen = get_current_screen() ) {
//             $screen = $screen->id;
//         }

//         if (is_current_user('southern_region_editor') && $post_type == 'page' && $screen == 'edit-page') {
//             $query->query_vars['author'] = null;
//             $query->query_vars['post__in'] = $pages;
//         }

//         return $query;
//     }, 10, 2);
// } );

/**
 * Since the logic that fails is testing a global variable called $pagenow,
 * we can dynamically alter this, when necessary, using our filter function.
 * https://herbmiller.me/wordpress-capabilities-restrict-add-new-allowing-edit/
 */
// add_action('init', function(){
//     if ( is_current_user('southern_region_editor') ) {
//         get_post_type_object('page')->cap->create_posts = 'create_pages';
//     }

//     global $pagenow;

//     if ( $pagenow == "edit.php" && isset( $_REQUEST['post_type'] ) ) {
//        $pagenow .= '?post_type=' . $_REQUEST['post_type' ];
//     }
// });

/**
 * Implement "add_menu_classes" filter for pages
 * https://herbmiller.me/wordpress-capabilities-restrict-add-new-allowing-edit/
 */
// add_filter( "add_menu_classes", function( $menu ) {
//   global $pagenow;

//   if ( false !== strpos( $pagenow, "edit.php" ) ) {
//     $pagenow = "edit.php";
//   }

//   *
//    * we have had to set edit_posts to true to enable feature image, and doing that
//    * it appears posts and tools in the menu, so we unset them to hidde them.
//    * It seems the featured image only appears if you are the owner of the image, if not the
//    * ajax request get an error and cannot update the page. I've added the capability
//    * edit_others_posts to the Southern Editor Role to fix this, as far as posts are hidden
//    * and Blogs is a new CPT with its own capabilities should work.
   
//   if (is_current_user('southern_region_editor')) {
//     unset($menu[2]);
//     unset($menu[8]);
//   }

//   return( $menu );
// } );


