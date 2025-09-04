<?php

require_once "KentWorksMapPage.php";
require_once "KentWorksMap.php";

new KentWorksMapPage();

// Get options
$googleSheetUrl = get_option('kent_works_map_sheet_url');

// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] === 'true' && $_GET['page'] === 'kent-works-map') {
    $KentWorksMap = new KentWorksMap($googleSheetUrl);

    $str = json_encode(
        $KentWorksMap->createDataModel()
    );

    $json_file = file_put_contents(
        get_template_directory().'/resources/kent-works-map.json', $str
    );

    if ( !$json_file === false ) {
        // add message when json file is created
        add_action( 'admin_notices', 'Message::json_admin_notice__success' );
    }

    if ($json_file === false) {
        add_action( 'admin_notices', 'Message::wrong_notice__error' );
    }
}
