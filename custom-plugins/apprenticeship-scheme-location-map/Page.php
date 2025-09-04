<?php

namespace MuPlugins\ApprenticeshipSchemeLocationMap;

class Page {
  public function __construct()
  {
    add_action( 'admin_menu', [$this, 'admin_menu']);
    add_action( 'admin_init', [$this, 'register_option']);
  }

  public function admin_menu() {
    add_submenu_page(
      'options-general.php', // $parent_slug
      'Apprenticeship Scheme Location Map', // $page_title
      'Apprenticeship Scheme Location Map', // $menu_title
      'manage_options', // $capability
      'apprenticeship-scheme-location-map', // $menu_slug
      [
        $this,
        'settings_page'
      ]
    );    
  }

  public function register_option()
  {
    $args = [
      'type' => 'string', 
      'sanitize_callback' => 'sanitize_text_field',
      'default' => NULL    
    ];

    register_setting( 'apprenticeship-scheme-location-map', 'apprenticeship_scheme_location_map_url', $args );
  }

  public function settings_page()
  {
    include dirname(__FILE__) . '/view.php';
  }
}