<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
    // Check if ACF function exists
    if ( function_exists( 'acf_register_block' ) ) {
        acf_register_block( [
            'name'            => 'nr-level-crossing',
            'title'           => __( 'NR Level Crossing', 'text-domain' ),
            'description'     => __( 'Create a level crossing map', 'text-domain' ),
            'render_callback' => 'nr_acf_level_crossing_callback',
            'category'        => 'common',
			'icon'        => ['foreground' => '#e56430','src' => 'admin-site'],
            'mode'            => 'edit',
            'supports'        => [ 'align' => true ],
        ] );
    }
});

/**
 * Render Callback for the block
 */
function nr_acf_level_crossing_callback( $block ) {

	?><level-crossing></level-crossing><?php
}