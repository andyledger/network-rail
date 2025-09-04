<?php

require_once "BridgeStrikeMapPage.php";
require_once "BridgeStrikeMap.php";

new BridgeStrikeMapPage();

// Get options
$googleSheetUrl = get_option('bridge_strike_map_sheet_url');

// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] === 'true' && $_GET['page'] === 'bridge-strike-map') {
    $BridgeStrikeMap = new BridgeStrikeMap($googleSheetUrl);

    $str = json_encode(
        $BridgeStrikeMap->createDataModel()
    );

    $json_file = file_put_contents(
        get_template_directory().'/resources/bridge-strike-map.json', $str
    );

    if ( !$json_file === false ) {
        // add message when json file is created
        add_action( 'admin_notices', 'Message::json_admin_notice__success' );
    }

    if ($json_file === false) {
        add_action( 'admin_notices', 'Message::wrong_notice__error' );
    }
}
