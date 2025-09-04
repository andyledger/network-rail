<?php

defined( 'ABSPATH' ) || die( 'Direct file access is forbidden' );

add_action( 'init', function() {

		$s      = 'Feed'; // Singular
		$p      = 'Feeds'; // Plural
		$labels = array(
			'name'               => _x( $s, 'networkrail' ),
			'singular_name'      => _x( $s, 'networkrail' ),
			'menu_name'          => __( $p, 'networkrail' ),
			'parent_item_colon'  => __( "Parent $s", 'networkrail' ),
			'all_items'          => __( "All $p", 'networkrail' ),
			'view_item'          => __( "View $s", 'networkrail' ),
			'add_new_item'       => __( "Add New $s", 'networkrail' ),
			'add_new'            => __( 'Add New', 'networkrail' ),
			'edit_item'          => __( "Edit $s", 'networkrail' ),
			'update_item'        => __( "Update $s", 'networkrail' ),
			'search_items'       => __( "Search $s", 'networkrail' ),
			'not_found'          => __( 'Not Found', 'networkrail' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'networkrail' ),
		);

		$args = array(
			'label'               => __( $p, 'networkrail' ),
			'description'         => __( $s, 'networkrail' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
			'menu_icon'           => 'dashicons-rss',
			'taxonomies'          => array( 'category', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'			 	=> true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'							=> ['slug' => 'news'],
			'capability_type'     => 'feed',
			'map_meta_cap' 		  => true,
			'dashboard_glance' 	  => false
		);

	register_extended_post_type( 'feeds', $args );
} );
