<?php

defined( 'ABSPATH' ) || die( 'Direct file access is forbidden' );

add_action( 'init', function() {
	$args = [
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
    'publicly_queryable' => true,
    'public'            => false,
    'capabilities'      => [
      'manage_terms' => 'manage_station_store_type',
      'edit_terms' => 'manage_station_store_type',
      'delete_terms' => 'manage_station_store_type',
      'assign_terms' => 'manage_station_store_type'
    ]
	];

	register_extended_taxonomy( 'station_store_type', 'station_stores', $args );
});


/**
 * used to link stations pages with retailers acf.
 */
add_action( 'init', function() {
  $args = [
    'hierarchical'      => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'publicly_queryable' => true,
    'public'            => false,
    'show_admin_column' => true,
    'show_in_rest'      => true
  ];

  register_extended_taxonomy( 'page_type', 'page', $args );
});

add_action( 'init', function() {
  $args = [
    'hierarchical'      => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'publicly_queryable' => true,
    'public'            => false,
    'show_admin_column' => true,
    'show_in_rest'      => true,
    'capabilities' => [
      'manage_terms'=> 'edit_blogs',
      'edit_terms'=> 'edit_blogs',
      'delete_terms'=> 'edit_blogs',
      'assign_terms' => 'edit_blogs'
      ]
  ];

  $labels = [
    'singular' => 'Blog Category',
    'plural'   => 'Blog Categories'
  ];

  register_extended_taxonomy( 'blog_category', 'blog', $args, $labels);
});
