<?php

class LevelCrossingPage {

  public function __construct() {
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    add_action( 'admin_init', array( $this, 'registerSetting' ) );
  }

  public function admin_menu() {
    add_submenu_page(
      'options-general.php', // $parent_slug
      'Level Crossing Loader', // $page_title
      'Level Crossing Loader', // $menu_title
      'manage_options', // $capability
      'level-crossing-loader', // $menu_slug
      array(
        $this,
        'settings_page'
      )
    );
  }

  /**
   * Register google_sheet_gids in options
   * @return [type] [description]
   */
  public function registerSetting(){
    $args = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize_text_field',
            'default' => NULL,
            );
    register_setting( 'level-crossing-loader', 'level_crossing_sheet_url', $args );
  }

  public function settings_page(){
    include dirname(__FILE__) . '/view.php';
  }
}