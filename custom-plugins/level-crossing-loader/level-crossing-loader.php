<?php

require_once "LevelCrossingPage.php";
require_once "LevelCrossing.php";

// create plugin page and menu
new LevelCrossingPage();

// Get options
$googleSheetUrl = get_option('level_crossing_sheet_url');

// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] === 'true' && $_GET['page'] === 'level-crossing-loader') {
    $LevelCrossing = new LevelCrossing($googleSheetUrl);

    $str = json_encode(
        $LevelCrossing->getData()
    );

    $json_file = file_put_contents(get_template_directory().'/resources/level-crossing-map.json', $str);

    if ( !$json_file === false ) {
        // add message when json file is created
        add_action( 'admin_notices', 'Message::json_admin_notice__success' );
    }

    if ($json_file === false) {
        add_action( 'admin_notices', 'Message::wrong_notice__error' );
    }
}
