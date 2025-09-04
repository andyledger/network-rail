<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-cards-xs',
			'title'           => __( 'NR Cards xs' ),
			'description'     => __( 'Add a cards section with at least 4 xs cards' ),
			'render_callback' => 'nr_acf_cards_xs_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'editor-table'],
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
function nr_acf_cards_xs_callback( $block ) {
	$cards_xs = get_field('section_cards_xs');
	$title = get_field('title');

	if (isset($cards_xs) && !empty($cards_xs)): ?>
		<?php if ($title): ?>
			<h3><?php echo $title ?></h3>
		<?php endif ?>

		<?php if (!is_admin()): ?>
			<div class="lg:tw-grid lg:tw-grid-cols-4 lg:tw-gap-4 lg:tw-gap-6 xl:tw-gap-8 tw-mb-8">
				<?php foreach ($cards_xs as $key => $element): ?>
					<card-xs
						title="<?php echo $element['title'] ?>"
						description="<?php echo htmlentities(wp_trim_words($element['description'], 12, '...'),ENT_QUOTES) ?>"
						icon-name="nr_<?php echo $element['icon'] ?>"
						link="<?php echo $element['link'] ?>"
						<?php echo $key === 0 ? 'first-element': ''; ?>
						class="card-xs-component"
					></card-xs>
				<?php endforeach ?>
			</div>
	    <?php endif ?>

	    <?php if (is_admin()): ?>
			<div class="lg:tw-grid lg:tw-grid-cols-4 lg:tw-gap-4 lg:tw-gap-6 xl:tw-gap-8 tw-mb-8">
				<?php foreach ($cards_xs as $key => $element): ?>
					<a
						class="tw-py-4 sm:tw-py-8 lg:tw-pb-2/3 lg:tw-py-0 tw-block tw-border-b tw-overflow-hidden tw-group lg:tw-border tw-border-gray-light lg:hover:tw-border-hyperlinks tw-group lg:tw-relative lg:tw-max-w-400"
					>
						<div class="tw-items-center lg:tw-items-start tw-w-full tw-flex tw-justify-between lg:tw-justify-start lg:tw-flex-col lg:tw-p-8 lg:tw-absolute">
							<span
								class="nr-icon-<?php echo $element['icon'] ?> tw-hidden sm:tw-pr-4 lg:tw-pr-0 sm:tw-block tw-text-6xl lg:tw-text-8xl tw-text-primary">
							</span>

							<div class="lg:tw-flex lg:tw-flex-col sm:tw-flex-grow lg:tw-flex-grow-0 tw-min-w-0 lg:min-w-full">
								<h3
									class="tw-font-bold lg:tw-py-6 tw-text-xl xl:tw-text-2xl 2xl:tw-text-3xl group-hover:tw-text-hyperlinks group-hover:tw-underline"
								><?php echo $element['title'] ?></h3>

								<p
								 	class="tw-truncate lg:tw-break-normal lg:tw-whitespace-normal tw-hidden sm:tw-block tw-text-md tw-text-gray-dark 2xl:tw-text-xl"
								><?php echo wp_trim_words($element['description'], 12, '...') ?></p>
							</div>

						 	<span
						 		class="nr-icon-<?php echo $element['icon'] ?> tw-block lg:tw-hidden tw-text-primary tw-text-4xl group-hover:tw-text-hyperlinks"
						 	></span>
						</div>
					</a>
				<?php endforeach ?>
			</div>
	    <?php endif ?>
	<?php endif ?>
	<?php
}
