<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-cta_button',
			'title'           => __( 'NR CTA button' ),
			'description'     => __( 'Add a call to action button' ),
			'render_callback' => 'nr_acf_cta_button_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'migrate'],
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
function nr_acf_cta_button_callback( $block ) {
	$title = get_field('title');
	$link = get_field('cta_link');
	$is_filled = get_field('cta_fill');
	$color = get_field('cta_color');
	$size = get_field('cta_size');
	$align = $block['align'];
	$text = $link['title'] ? $link['title'] : $link['url'];

	if ($color === 'orange') {
		$color = 'primary';
	}

	if ($color === 'blue') {
		$color = 'secondary';
	}

	// class for admin
	$classes = '';

	if ($color === 'primary' && !$is_filled) $classes .= 'tw-border-primary tw-text-primary hover:tw-bg-primary hover:tw-text-white';

	if ($color === 'secondary' && !$is_filled) $classes .= 'tw-border-secondary tw-text-secondary hover:tw-bg-secondary hover:tw-text-white';

	if ($color === 'black' && !$is_filled) $classes .= 'tw-border-black tw-text-black hover:tw-bg-black hover:tw-text-white';

	if ($color === 'primary' && $is_filled) $classes .= 'tw-border-primary tw-bg-primary tw-text-white hover:tw-bg-primary-dark hover:tw-border-primary-dark';

	if ($color === 'secondary' && $is_filled) $classes .= 'tw-border-secondary tw-bg-secondary tw-text-white hover:tw-bg-white hover:tw-text-secondary';

	if ($color === 'black' && $is_filled) $classes .= 'tw-border-black tw-bg-black tw-text-white hover:tw-bg-white hover:tw-text-black';

	if ($size === 'sm') $classes .= ' tw-py-2 tw-px-4';

	if ($size === 'md') $classes .= ' tw-py-3 tw-px-6 tw-text-lg';

	if ($size === 'lg') $classes .= ' tw-py-4 tw-px-8 tw-text-xl';

	?>
	<?php if (isset($link) && !empty($link)): ?>
		<?php if ($title): ?>
			<h3><?php echo $title ?></h3>
		<?php endif ?>

		<?php if (!is_admin()): ?>
			<div class="tw-text-<?php echo $align ?>">
				<cta-button
					class="cta-button"
					size="<?php echo $size ?>"
					color="<?php echo $color ?>"
					:filled="<?php echo $is_filled ? 'true' : 'false' ?>"
					link="<?php echo $link['url'] ?>"
					:external="<?php echo $link['target'] === "_blank" ? 'true' : 'false' ?>"
					rounded
				><?php echo $text ?></cta-button>
			</div>
		<?php endif ?>

		<?php if (is_admin()): ?>
			<div class="tw-text-<?php echo $align ?>">
	            <a
	            	href="<?php echo $link['url'] ?>"
	            	class="tw-font-bold tw-rounded-full tw-mb-4 tw-mr-4 tw-text-center tw-inline-block tw-min-w-200 tw-border-2 tw-transition-colors tw-duration-200 <?php echo $classes ?>"
	            >
	                <?php echo $text ?>
	            </a>
	        </div>
		<?php endif ?>
	<?php endif ?>
	<?php
}
