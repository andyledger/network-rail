<?php

class KentWorksMapPage {
  public function __construct()
  {
    add_action( 'admin_menu', [$this, 'admin_menu']);
    add_action( 'admin_init', [$this, 'register_option']);
  }

  public function admin_menu() {
    add_submenu_page(
      'options-general.php', // $parent_slug
      'Kent Works Map', // $page_title
      'Kent Works Map', // $menu_title
      'manage_options', // $capability
      'kent-works-map', // $menu_slug
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

    register_setting( 'kent-works-map', 'kent_works_map_sheet_url', $args );
  }

  public function settings_page()
  {
    include dirname(__FILE__) . '/view.php';
  }
}