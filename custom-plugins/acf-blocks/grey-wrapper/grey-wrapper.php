<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function () {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-grey-wrapper',
			'title'           => __( 'NR Grey wrapper' ),
			'description'     => __( 'Add text within a grey wrapper' ),
			'render_callback' => 'nr_acf_grey_wrapper_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'welcome-write-blog'],
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
function nr_acf_grey_wrapper_callback( $block ) {
	$grey_wrapper = get_field('grey_wrapper');
	?>
	<?php if (isset($grey_wrapper) && !empty($grey_wrapper)): ?>
        <div class="gray-wrapper tw-bg-gray-lighter tw-p-8 md:tw-p-12 tw-text-xl tw-mb-8">
          <?php echo $grey_wrapper ?>
        </div>
	<?php endif ?>
	<?php
}
