<?php

/**
 * Theme helpers.
 */

namespace App;

/*
 * This function add "async" and "defer" paremeters to script tag.
 * Add "async" or "defer" in the name of the handle in
 * the wp_register_script function
 *
 * @param $tag
 * @param $handle
 *
 * @return mixed
 */

use App\View\Composers\Menu;
use WP_REST_Response;

add_filter(
    'script_loader_tag',
    function ($tag, $handle) {
        if (strpos($handle, "async")) {
            $tag = str_replace(' src', ' async="async" src', $tag);
        }

        if (strpos($handle, "defer")) {
            $tag = str_replace(' src', ' defer="defer" src', $tag);
        }

        return $tag;
    },
    10,
    2
);
