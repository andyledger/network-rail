<?php

/**
 * Removes output from Yoast SEO on the frontend for a specific post, page or custom post type.
 * https://developer.yoast.com/customization/yoast-seo/disabling-yoast-seo/
 */
add_action( 'template_redirect', function() {
    $station_pages_ids = [5636, 5618, 5619, 5620, 5621, 5622, 5623, 5624, 5625, 5626, 5627, 5628, 5629, 5630, 5631, 5632, 5633, 5234, 5635, 5637];

    /**
     * All the station pages
     */
    if (is_page($station_pages_ids) ) {
        $front_end = YoastSEO()->classes->get( Yoast\WP\SEO\Integrations\Front_End_Integration::class );

        remove_action( 'wpseo_head', [ $front_end, 'present_head' ], -9999 );
    }
});

add_action( 'wp_head', function() {
    $station_pages_ids = [5636, 5618, 5619, 5620, 5621, 5622, 5623, 5624, 5625, 5626, 5627, 5628, 5629, 5630, 5631, 5632, 5633, 5234, 5635, 5637];

    /**
     * Add title to stations pages
     * We've deactivated Yoast previously in these pages
     * so we need to add it manually.
     */
    if ( is_page($station_pages_ids)) {
        ?>
        <title><?php wp_title() ?></title>
        <?php
    }
});
