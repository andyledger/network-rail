<?php

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

require_once dirname(__FILE__).'/utils.php';
// require_once dirname(__FILE__).'/property-editor.php';
// require_once dirname(__FILE__).'/southern-region-role.php';
// 
// Just run once, then disable it

/**
 * Delete default roles except admin and create new ones
 */
// add_action('init', function() {
//     global $wp_roles;

//     $roles_to_remove = ['subscriber', 'contributor', 'author', 'editor'];

//     foreach ($roles_to_remove as $role) {
//         if (isset($wp_roles->roles[$role])) {
//             $wp_roles->remove_role($role);
//         }
//     }

//     $roles_to_add = [
//         ['nr_admin', 'NR Admin'],
//         ['property_editor', 'Property Editor'],
//         ['southern_region_editor', 'Southern Region Editor'],
//         ['media_editor', 'Media Editor'],
//         ['training_author', 'Trainin Author']
//     ];

//     foreach ($roles_to_add as $role) {
//         if (!isset($wp_roles->roles[$role[0]])) {
//             $wp_roles->add_role($role[0], $role[1]);
//         }
//     }
// });

// add_action('admin_menu', function() {
//     global $wp_roles;

//     $wp_roles->add_role('subscriber', 'Subscriber', ['read']);
// });

/**
 * Add custom capabilities to 'administrator' role,
 * custom capabilities will appear in the User Role Editor
 * then you can add them to any role
 */
// add_action( 'admin_init', function() {
//     // gets the author role
//     $role = get_role( 'administrator' );

//     // capabilities to be added
//     $capabilities = [
//         'manage_options_nr',
//         'manage_station_store_type',
//         'manage_alert_message',
//         'tablepress_edit_tables',
//         'tablepress_delete_tables',
//         'tablepress_list_tables',
//         'tablepress_add_tables',
//         'tablepress_copy_tables',
//         'tablepress_import_tables',
//         'tablepress_export_tables',
//         'tablepress_access_options_screen',
//         'tablepress_access_about_screen',
//         'create_pages'
//     ];

//     foreach ($capabilities as $capability) {
//         if (!isset($role->capabilities[$capability])) {
//             $role->add_cap( $capability );
//         }
//     }
// });
