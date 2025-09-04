<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-card-link',
			'title'           => __( 'NR Card Link' ),
			'description'     => __( 'Create a card link' ),
			'render_callback' => 'nr_acf_card_link_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'admin-links'],
			'mode' 			  => 'edit'
		] );
	}
 } );

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_card_link_callback( $block ) {
	$title = get_field('title');
	$card_links = get_field('card_links');
	$new_card_links = get_field('new_card_links');

	if (!is_array($card_links)) {
		$card_links = [];
	}

	if (!is_array($new_card_links)) {
		$new_card_links = [];
	}

	$result = array_merge($card_links, $new_card_links);

	?>

	<?php if ($title): ?>
		<h3><?php echo $title ?></h3>
	<?php endif ?>

	<?php if (!empty($result)  ): ?>
		<?php if (!is_admin()): ?>
			<div class="tw-mb-8">
				<?php foreach ($result as $key => $element): ?>
					<card-link
						title="<?php echo $element['title'] ?>"
						description="<?php echo wp_trim_words($element['description'], 20, '...') ?>"
						link="<?php echo $element['link'] ?>"
						<?php echo $element['icon'] !== '' ? 'icon="nr_'.$element['icon'].'"':''; ?>
						<?php echo $key === 0 ? 'is-first-element': ''; ?>
						class="card-link"
					></card-link>
				<?php endforeach ?>
		    </div>
		<?php endif; ?>

		<?php if (is_admin()): ?>
			<div class="tw-mb-8">
				<?php foreach ($result as $key => $element): ?>
					  <a
					  	href="#"
					    class="tw-border-b tw-border-gray-light tw-block tw-flex tw-justify-between tw-items-center tw-py-2 tw-cursor-pointer tw-group"
					  >
						<span
							class="nr-icon-<?php echo $element['icon'] ?> tw-text-primary tw-text-6xl tw-mr-4">
						</span>

					    <div
					      class="tw-pr-4 tw-flex-grow"
					    >
					      <div
					        class="tw-font-bold tw-text-2xl group-hover:tw-text-hyperlinks group-hover:tw-underline"
					      >
					        <?php echo $element['title'] ?>
					      </div>

					      <div class="tw-text-md tw-text-gray-dark tw-hidden md:tw-block">
					        <?php echo $element['description'] ?>
					      </div>
					    </div>

						<span
							class="nr-icon-arrow-right tw-text-primary tw-text-5xl">
						</span>
					  </a>
				<?php endforeach ?>
		    </div>
		<?php endif; ?>
	<?php endif; ?>
	<?php
}
