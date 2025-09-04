<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-video_carousel',
			'title'           => __( 'NR Video slider' ),
			'description'     => __( 'Add a video slider' ),
			'render_callback' => 'nr_acf_video_carousel_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'controls-forward'],
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
function nr_acf_video_carousel_callback( $block ) {
	$videos = get_field('video_slider');
	$title = get_field('title');
	?>

	<?php if (isset($videos) && !empty($videos)): ?>
		<?php if ($title): ?>
			<h3><?php echo $title ?></h3>
		<?php endif ?>

		<?php if (!is_admin()): ?>
			<div class="wistia-carousel-wrapper tw-mb-8">
			    <flickity 
			    	:options="{prevNextButtons: false}"
			    	ref="flickityComponent"
			    >
				    <?php foreach ($videos as $video): ?>
				    	<?php (strpos($video['url'], 'http') !== false) ? $video_id = basename($video['url']) : $video_id = $video['url'] ; ?>
						<div class="tw-w-full">
							<wistia-video
								url="https://support.wistia.com/medias/<?php echo $video_id ?>"
								@video-loaded="resizeFlickity"
							></wistia-video>

							<figcaption
								class="tw-bottom-0 tw-bg-white tw-italic tw-py-3 tw-w-full tw-z-10"
								style="min-height: 3rem;"
							>
								<?php echo wp_trim_words($video['caption'], 30) ?>
							</figcaption>
						</div>
				    <?php endforeach ?>
			    </flickity>
		    </div>
	    <?php endif ?>

	    <?php if (is_admin()): ?>
			<div class="tw-border tw-p-8">
				<p>WIP</p>
			</div>
	    <?php endif ?>
	<?php endif ?>
	<?php
}
