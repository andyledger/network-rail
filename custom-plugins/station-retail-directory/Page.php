<?php

namespace MuPlugins\StationRetailDirectory;

class Page
{
  public function __construct()
  {
    add_action( 'admin_menu', [$this, 'admin_menu']);
  }

  public function admin_menu() {
    add_submenu_page(
      'options-general.php', // $parent_slug
      'Station Retail Directory', // $page_title
      'Station Retail Directory', // $menu_title
      'manage_options', // $capability
      'station-retail-directory', // $menu_slug
      [
        $this,
        'settings_page'
      ]
    );    
  }

  public function settings_page()
  {
    include dirname(__FILE__) . '/view.php';
  }
}