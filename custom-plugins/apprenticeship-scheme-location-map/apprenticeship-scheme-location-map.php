<?php

require_once "Page.php";
require_once "Data.php";

new MuPlugins\ApprenticeshipSchemeLocationMap\Page();

// Get options
$googleSheetUrl = get_option('apprenticeship_scheme_location_map_url');

// run the script when click the button
if ( isset( $_GET['run'] ) && $_GET['run'] === 'true' && $_GET['page'] === 'apprenticeship-scheme-location-map') {
    $data = new MuPlugins\ApprenticeshipSchemeLocationMap\Data($googleSheetUrl);

    $str = json_encode(
        $data->createDataModel()
    );

    $json_file = file_put_contents(
        get_template_directory().'/resources/apprenticeship-scheme-location-map.json', $str
    );

    if ( !$json_file === false ) {
        // add message when json file is created
        add_action( 'admin_notices', 'Message::json_admin_notice__success' );
    }

    if ($json_file === false) {
        add_action( 'admin_notices', 'Message::wrong_notice__error' );
    }
}
