<?php

defined( 'ABSPATH' ) || die( 'Direct file access is forbidden' );

add_action( 'init', function() {

	$s = 'File list'; // Singular
	$p = 'File lists'; // Plural

	$labels = [
		'name'                => _x( $p, 'networkrail' ),
		'singular_name'       => _x( $s, 'networkrail' ),
		'menu_name'           => __( $p, 'networkrail' ),
		'parent_item_colon'   => __( "Parent $s", 'networkrail' ),
		'all_items'           => __( "All $p", 'networkrail' ),
		'view_item'           => __( "View $s", 'networkrail' ),
		'add_new_item'        => __( "Add New $s", 'networkrail' ),
		'add_new'             => __( "Add New $s", 'networkrail' ),
		'edit_item'           => __( "Edit $s", 'networkrail' ),
		'update_item'         => __( "Update $s", 'networkrail' ),
		'search_items'        => __( "Search $s", 'networkrail' ),
		'not_found'           => __( 'Not Found', 'networkrail' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'networkrail' ),
	];

	$args = [
		'label'               	=> __( $p, 'networkrail' ),
		'description'         	=> __( $s, 'networkrail' ),
		'labels'              	=> $labels,
		'supports'            	=> ['title', 'revisions'],
		'menu_icon'           	=> 'dashicons-editor-ul',
		'hierarchical'        	=> false,
		'public'              	=> false,
		'show_ui'             	=> true,
		'show_in_menu'        	=> true,
		'show_in_nav_menus'   	=> true,
		'show_in_admin_bar'   	=> true,
		'menu_position'       	=> 20,
		'can_export'          	=> true,
		'has_archive'         	=> false,
		'exclude_from_search' 	=> false,
		'publicly_queryable'  	=> false,
		'capability_type'     	=> 'downloads_list',
		'show_in_rest'		  		=> true,
		'rest_base'          		=> 'file-list',
  	'rest_controller_class' => 'WP_REST_Posts_Controller',
		'map_meta_cap' 					=> true,
		'dashboard_glance' => false
	];

	register_extended_post_type( 'downloads_list', $args );

} );
