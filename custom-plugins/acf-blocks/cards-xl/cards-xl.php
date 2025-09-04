<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-cards-xl',
			'title'           => __( 'NR Cards xl' ),
			'description'     => __( 'Add a cards section with at least 2 xl cards' ),
			'render_callback' => 'nr_acf_cards_xl_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'grid-view'],
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
function nr_acf_cards_xl_callback( $block ) {
	$cards_xl = get_field('section_cards_xl');
	$title = get_field('title');
	$default_thumbnail = get_field('default_thumbnail', 'options');
	$new_cards = get_field('new_cards');

  $cards = [];

  if (is_array($cards_xl)) {
    foreach ($cards_xl as $key => $element) {
      $cards[$key]['card_title'] = $element->post_title;
      $cards[$key]['picture'] = App\View\Composers\App::on_the_fly_thumbnail($element->ID, [702, 394]) ?? '';
      $cards[$key]['card_content'] = ($element->post_excerpt) ? $element->post_excerpt : wp_trim_words($element->post_content, 40);
      $cards[$key]['card_link'] = get_the_permalink($element);
      $cards[$key]['alt-image'] = App\View\Composers\App::alt_image($element);
    }
  }

  $cards2 = [];

  if (is_array($new_cards)) {
    foreach ($new_cards as $key => $element) {
      $cards2[$key]['card_title'] = $element['card_title'];
      $cards2[$key]['picture'] = !empty($element['picture']) ? fly_get_attachment_image_src($element['picture'], [702, 394], true)['src'] ?? '' : fly_get_attachment_image_src($default_thumbnail, [702, 394], true)['src'];
      $cards2[$key]['card_content'] = $element['card_content'];
      $cards2[$key]['card_link'] = $element['card_link'];
      $cards2[$key]['alt-image'] = App\View\Composers\App::alt_image_from_id($element['picture']);
    }
  }

  $result = array_merge($cards, $cards2);
	?>

	<?php if ($result): ?>
		<?php if (!is_admin()): ?>
			<div class="tw-grid md:tw-grid-cols-2 tw-gap-8 tw-mb-8">
				<?php foreach ($result as $key => $element): ?>
					<card
						title="<?php echo $element['card_title'] ?>"
						description="<?php echo htmlentities($element['card_content'], ENT_QUOTES) ?>"
						image="<?php echo $element['picture'] ?>"
						link="<?php echo $element['card_link'] ?>"
						alt-image="<?php echo $element['alt-image'] ?>"
						class="card-xl-component"
					></card>
				<?php endforeach ?>
	    </div>
		<?php endif ?>

		<?php if (is_admin()): ?>
			<div class="tw-grid md:tw-grid-cols-2 tw-gap-8 tw-mb-8">
				<?php foreach ($result as $key => $element): ?>
					<div class="tw-flex tw-flex-col tw-max-w-800">
						<a
							href="//localhost:3001/who-we-are/"
							class="tw-block tw-cursor-pointer tw-group"
						>

							<div
								class="tw-relative tw-overflow-hidden tw-mb-6"
								style="background-color: rgb(239, 239, 239); padding-bottom: 56%;"
							>
								<img
									alt="<?php echo $element['alt-image'] ?>"
									data-src="<?php echo $element['picture'] ?>"
									class="tw-absolute tw-object-cover tw-w-full tw-h-full"
									src="<?php echo $element['picture'] ?>" data-loaded="true"
								>
							</div>

							<h3 class="tw-font-bold tw-pb-4 tw-text-xl xl:tw-text-3xl group-hover:tw-text-hyperlinks group-hover:tw-underline">
								<?php echo $element['card_title'] ?>
							</h3>
						</a>

						<div class="tw-text-gray-dark tw-text-xl">
							<?php echo htmlentities($element['card_content'], ENT_QUOTES) ?>
						</div>
					</div>
				<?php endforeach ?>
	    </div>
		<?php endif ?>
	<?php endif ?>
	<?php
}
