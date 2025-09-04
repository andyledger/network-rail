<?php
/**
 * Place ACF JSON in theme directory
 */

add_filter('acf/settings/save_json', function ($path) {
    return get_template_directory() . '/custom-plugins/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = get_template_directory() . '/custom-plugins/acf-json';
    return $paths;
});
