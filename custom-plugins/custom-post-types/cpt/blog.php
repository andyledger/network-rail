<?php

defined( 'ABSPATH' ) || die( 'Direct file access is forbidden' );

add_action( 'init', function() {
  register_extended_post_type( 'blog', [
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail'],
    'capability_type' => 'blog',
    'map_meta_cap' => true,
    'taxonomies' => ['blog_category'],
    'dashboard_glance' => false
  ] );
} );
