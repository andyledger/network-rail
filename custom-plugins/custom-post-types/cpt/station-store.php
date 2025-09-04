<?php

defined( 'ABSPATH' ) || die( 'Direct file access is forbidden' );

add_action( 'init', function() {

	$s = 'Retailer'; // Singular
	$p = 'Retailers'; // Plural

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
		'label'               => __( $p, 'networkrail' ),
		'description'         => __( $s, 'networkrail' ),
		'labels'              => $labels,
		'supports'            => [
			'title',
			'editor',
			'author',
			'thumbnail',
		],
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-screenoptions',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false, // we're using a shortcode so don't need / want the default archive as this will cause a conflict
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'retailer',
		'rewrite'             => false,
		'taxonomies'          => [ 'station_store_type' ],
		'map_meta_cap' 				=> true,
		'dashboard_glance' => false
	];

	register_extended_post_type( 'station_stores', $args );

} );
