<?php

require_once "AngliaMapPage.php";
require_once "AngliaMap.php";

new AngliaMapPage();

// Get options
$googleSheetUrl = get_option('anglia_map_sheet_url');

// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] === 'true' && $_GET['page'] === 'anglia-map') {
    $AngliaMap = new AngliaMap($googleSheetUrl);

    $str = json_encode(
        $AngliaMap->createDataModel()
    );

    $json_file = file_put_contents(
        get_template_directory().'/resources/anglia-map.json', $str
    );

    if ( !$json_file === false && $str !== 'null' ) {
        // add message when json file is created
        add_action( 'admin_notices', 'Message::json_admin_notice__success' );
    }

    if ($json_file === false || $str === 'null') {
        add_action( 'admin_notices', 'Message::wrong_notice__error' );
    }
}
