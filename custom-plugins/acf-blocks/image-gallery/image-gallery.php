<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-image-gallery',
			'title'           => __( 'NR Image Gallery' ),
			'description'     => __( 'Create an image gallery slider' ),
			'render_callback' => 'nr_acf_image_gallery_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'images-alt2'],
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
function nr_acf_image_gallery_callback( $block ) {
	$gallery = get_field('gallery');
	$title = get_field('title');
	$descriptions = [];

	$items = [];

	if (is_array($gallery) && !empty($gallery)) {
		foreach ($gallery as $key => $value) {
			$items[$key]['lazySrc'] = fly_get_attachment_image_src($value['ID'], [900, 600], true)['src'] ?? '';
			$items[$key]['altImage'] = App\View\Composers\App::alt_image_from_id($value['ID']);
			$items[$key]['description'] = wp_trim_words($value['caption'], 16, '...');
		}
	}

	$items = htmlentities(json_encode($items, JSON_HEX_QUOT), ENT_QUOTES);

	?>

	<?php if (isset($gallery) && !empty($gallery)): ?>
		<?php if ($title): ?>
			<h3><?php echo $title ?></h3>
		<?php endif ?>

		<?php if (!is_admin()): ?>
		    <n-slider class="tw-mb-12 n-slider" :items="<?php echo $items ?>"></n-slider>
		<?php endif ?>

		<?php if (is_admin()): ?>
			<div class="tw-border tw-p-8">
				<p>create plain version of the gallery block.</p>
			</div>
		<?php endif ?>
	<?php endif ?>
	<?php
}
