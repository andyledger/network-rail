<?php

class Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'registerSetting' ) );
	}

	public function admin_menu() {
		add_submenu_page(
			'options-general.php', // $parent_slug
			'Performance Loader', // $page_title
			'Performance Loader', // $menu_title
			'manage_options', // $capability
			'performance-loader', // $menu_slug
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
		register_setting( 'google-sheet-loader', 'google_sheet_url', $args );
		register_setting( 'google-sheet-loader', 'delay_id', $args );
		register_setting( 'google-sheet-loader', 'stations_id', $args );
	}

	public function settings_page(){
		include dirname(__FILE__) . '/view.php';
	}
}