<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-load-more',
			'title'           => __( 'NR Load More' ),
			'description'     => __( 'Add a load more section with 3 cards' ),
			'render_callback' => 'nr_acf_load_more_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'editor-insertmore'],
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
function nr_acf_load_more_callback( $block ) {
	$default_thumbnail = get_field('default_thumbnail', 'options');
	$section_title = get_field('section_title');
	$category = get_field('select_route');

	if ($category == "") {
		$category = "national";
	}

	/**
	 * "category from prgloo" => "category stored in our DB"
	 * use category in the load more button link and the category
	 * stored in our DB to make the request in our DB
	 */
	$parse_categories = [
		"national" => "national",
		"eastern" => "eastern",
		"north-west-central" => "north-west-central",
		"scotland" => "scotlands-railway-scotland",
		"southern" => "southern",
		"wales-and-western" => "wales-western",
		"anglia" => "eastern-anglia",
		"east-coast" => "eastern-east-coast",
		"east-midlands" => "eastern-east-midlands",
		"north-and-east" => "eastern-north-east",
		"central" => "north-west-central-central",
		"north-west" => "north-west-central-north-west",
		"west-coast-mainline-south" => "north-west-central-west-coast-mainline-south",
		"kent" => "southern-kent",
		"network-rail-high-speed" => "southern-network-rail-high-speed",
		"sussex" => "southern-sussex",
		"wessex" => "southern-wessex",
		"wales-and-borders" => "wales-western-wales-borders",
		"western" => "wales-western-western"
	];

	$cards = get_posts([
			'post_type' => 'feeds',
			'posts_per_page' => 3,
			'category_name' => $parse_categories[$category]
		]);
	?>

	<?php if (isset($cards) && !empty($cards)): ?>
    <div class="tw-mb-8">
    	<?php if ($section_title): ?>
      	<h3 class="tw-text-3xl tw-mb-8"><?php echo $section_title ?></h3>
  		<?php endif ?>

      <div class="tw-grid md:tw-grid-cols-3 tw-gap-8 tw-mb-8">
      	<?php if (!is_admin()): ?>
	      	<?php foreach ($cards as $element): ?>
	      		<?php $url = get_post_meta($element->ID, 'feed_meta_seo_name', true) ?>
	          <card
	            title="<?php echo esc_html($element->post_title) ?>"
	            description="<?php echo esc_html(wp_trim_words($element->post_content, 35, '...')) ?>"
	            image="<?php echo has_post_thumbnail($element->ID) ? get_the_post_thumbnail_url($element->ID) : wp_get_attachment_image_url($default_thumbnail); ?>"
	            link="https://www.networkrailmediacentre.co.uk/news/<?php echo !empty($url) ? $url : $element->post_name ?>"
	            date="<?php echo get_the_date('M j, Y', $element->ID) ?>"
	            alt-image="<?php echo esc_html(App\View\Composers\App::alt_image($element->ID)) ?>"
	            class="card-component"
	            :four-columns="true"
	          ></card>
	        <?php endforeach ?>
      	<?php endif ?>

      	<?php if (is_admin()): ?>
      		<?php foreach ($cards as $element): ?>
      			<?php $url = get_post_meta($element->ID, 'feed_meta_seo_name', true) ?>
						<div class="tw-flex tw-flex-col tw-max-w-800">
							<a
								href="#"
								class="tw-block tw-cursor-pointer tw-group"
							>
								<div
									class="tw-relative tw-overflow-hidden tw-mb-6"
									style="background-color: rgb(239, 239, 239); padding-bottom: 56%;"
								>
									<img
										class="tw-absolute tw-object-cover tw-w-full tw-h-full"
										src="<?php echo has_post_thumbnail($element->ID) ? get_the_post_thumbnail_url($element->ID) : wp_get_attachment_image_url($default_thumbnail); ?>"
									>
								</div>

								<h3 class="tw-font-bold tw-pb-4 tw-text-xl xl:tw-pb-3 group-hover:tw-text-hyperlinks group-hover:tw-underline">
									<?php echo $element->post_title ?>
								</h3>
							</a>

							<div class="tw-text-gray-dark tw-mb-4 tw-font-bold">
								<?php echo get_the_date('M j, Y', $element->ID) ?>
							</div>

							<div class="tw-text-gray-dark tw-text-xl xl:tw-text-base">
								<?php echo wp_trim_words($element->post_content, 35, '...') ?>
							</div>
						</div>
					<?php endforeach ?>
      	<?php endif ?>
      </div>

      <div class="tw-relative tw-flex tw-items-center tw-justify-center">
        <div class="tw-border-t tw-border-gray-light tw-absolute tw-w-full"></div>

        <a
          href="https://www.networkrailmediacentre.co.uk/news/r/<?php echo $category ?>"
          target="_blank"
          class="tw-relative tw-z-10 tw-bg-white tw-font-bold tw-py-3 tw-px-8 tw-border tw-border-gray-light tw-rounded-md tw-inline-block hover:tw-text-hyperlinks"
        >See more news</a>
      </div>
    </div>
	<?php endif ?>
	<?php
}
