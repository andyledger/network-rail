<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
    // check function exists
    if ( function_exists( 'acf_register_block' ) ) {
        acf_register_block( [
            'name'            => 'nr-acf-yext',
            'title'           => __( 'NR Yext Station' ),
            'description'     => __( 'Pull station data from Yext' ),
            'render_callback' => 'nr_acf_yext_callback',
            'category'        => 'common',
            'icon'            => ['foreground' => '#e56430','src' => 'menu'],
            'mode'            => 'edit'
        ] );
    }
 });

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_yext_callback( $block ) {
    $station = get_field('station');
    ?>
    <?php if (isset($station) && !empty($station)): ?>
        <yext-location location-id="<?php echo $station ?>"></yext-location>
    <?php endif ?>
    <?php
}
