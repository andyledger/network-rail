<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-wistia',
			'title'           => __( 'NR Wistia video' ),
			'description'     => __( 'Add a wistia video' ),
			'render_callback' => 'nr_acf_wistia_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'controls-play'],
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
function nr_acf_wistia_callback( $block ) {
	$video = get_field('video');
	$title = get_field('title');

	(strpos($video, 'http') !== false) ? $video_id = basename($video) : $video_id = $video ;

	?>

	<?php if (isset($video) && !empty($video)): ?>
		<?php if ($title): ?>
			<h4><?php echo $title ?></h4>
		<?php endif ?>

		<?php if (!is_admin()): ?>
			<wistia-video
				url="https://support.wistia.com/medias/<?php echo $video_id ?>"
				class="tw-mb-8"
			></wistia-video>
		<?php endif ?>

		<?php if (is_admin()): ?>
			<div class="tw-border tw-p-8">
				<p>WIP</p>
			</div>
		<?php endif ?>
	<?php endif ?>
	<?php
}
