<?php

require_once "Page.php";
require_once "Retailers.php";

use MuPlugins\StationRetailDirectory;

new StationRetailDirectory\Page;

function station_retail_diretory_wrap() {
    $retailers = new StationRetailDirectory\Retailers;
    $retailers = $retailers->get_retailers();

    error_log('RETAILERS: ' . json_encode($retailers));

    $json_file = file_put_contents(
        get_template_directory().'/resources/retailers.json', json_encode($retailers)
    );

    if ( !$json_file === false ) {
        // add message when json file is created
        add_action( 'admin_notices', 'Message::json_admin_notice__success' );
    }

    if ($json_file === false) {
        add_action( 'admin_notices', 'Message::wrong_notice__error' );
    }
}

// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] === 'true' && $_GET['page'] === 'station-retail-directory') {

    /**
     * we need to hook it to avoid errors in function like get_field (Retailers:34)
     */
    add_action('init', 'station_retail_diretory_wrap');
}

/**
 * Hook to create the JSON file in case we need to do it periodically
 * Deadctivated for the moment.
 */
// add_action( 'station_retail_directory_hook', 'station_retail_diretory_wrap' );

/**
 * create JSON file every time a retailer is updated
 */
add_action('save_post_station_stores', function ($post_id) {
    station_retail_diretory_wrap();
}, 10, 1);

add_action('save_post_page', function ($post_id) {
    $parent = get_post_parent($post_id);

    if (!empty($parent) && $parent->ID === 3753) {
        station_retail_diretory_wrap();
    }
}, 10, 1);