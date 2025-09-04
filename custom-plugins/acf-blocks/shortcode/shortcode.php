<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-shortcode',
			'title'           => __( 'NR Shortcode' ),
			'description'     => __( 'Display shortcode' ),
			'render_callback' => 'nr_acf_shortcode_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'media-code'],
			'mode' 			  => 'edit'
		] );
	}	
});

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_shortcode_callback( $block ) {
	$shortcode = get_field('shortcode');
	$title = get_field('title');

	// check if it is a shortcode
	if (substr($shortcode, 0, 1) === '[' && substr($shortcode, -1, 1) === ']') {
		if ($title) {
			echo "<h3>{$title}</h3>";
		}

		echo do_shortcode($shortcode);
	} else {
		echo 'This is not a shortcode or wrong shortcode';
	}	
} 