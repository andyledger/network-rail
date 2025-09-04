<?php

class BridgeStrikeMapPage {
  public function __construct()
  {
    add_action( 'admin_menu', [$this, 'admin_menu']);
    add_action( 'admin_init', [$this, 'register_option']);
  }

  public function admin_menu() {
    add_submenu_page(
      'options-general.php', // $parent_slug
      'Bridge Strike Map', // $page_title
      'Bridge Strike Map', // $menu_title
      'manage_options', // $capability
      'bridge-strike-map', // $menu_slug
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

    register_setting( 'bridge-strike-map', 'bridge_strike_map_sheet_url', $args );
  }

  public function settings_page()
  {
    include dirname(__FILE__) . '/view.php';
  }
}