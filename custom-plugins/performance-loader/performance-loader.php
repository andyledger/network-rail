<?php
/*
Plugin Name: Performance loader
Plugin URI: http://www.carlosortiz.co.uk/
Description: Load TOCs performance from a google sheet and create a json file.
Version: 1.1
Author: Carlos Ortiz
Author URI: http://www.carlosortiz.co.uk/
License: GPL2
*/

require_once "Page.php";
require_once "Core/Performance.php";
require_once "Core/Delay.php";
require_once "Core/Stations.php";
require_once "Functions.php";

// create plugin page and menu
new Page();

// Get options
$googleSheetUrl = get_option('google_sheet_url');
$delayId = get_option('delay_id');
$stationsId = get_option('stations_id');



// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] == 'true') {

	if (!empty($googleSheetUrl) && !empty($delayId) && !empty($stationsId)) {

		$performance = new Performance( $googleSheetUrl );
		$delay = new Delay( $googleSheetUrl, $delayId );
		$stations = new Stations( $googleSheetUrl, $stationsId );

		// create json files
		$json_string_performance = json_encode($performance->getData());
		$json_string_delay = json_encode($delay->getData());
		$json_string_stations = json_encode($stations->getData());

		$json_file_performance = file_put_contents(get_template_directory().'/performance.json', $json_string_performance);
		$json_file_delay = file_put_contents(get_template_directory().'/delay.json', $json_string_delay);
		$json_file_stations = file_put_contents(get_template_directory().'/stations.json', $json_string_stations);

		if ( !$json_file_performance === false && !$json_file_delay === false && !$json_file_stations === false ) {
			// add message when json file is created
			add_action( 'admin_notices', 'Functions::json_admin_notice__success' );
		} else {
			add_action( 'admin_notices', 'Functions::wrong_notice__error' );
		}

	} else {
		// do something
	 	add_action( 'admin_notices', 'Functions::wrong_notice__error' );
	}

}