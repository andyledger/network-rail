<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-cards-md',
      'title'           => __( 'NR Cards md' ),
      'description'     => __( 'Add a cards section with md cards' ),
      'render_callback' => 'nr_acf_cards_md_callback',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'grid-view'],
      'mode'        => 'edit'
    ] );
  }
});

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_cards_md_callback( $block ) {
  $cards_md = get_field('cards_md');
  $title = get_field('title');
  $child_of_id = get_field('childs_of');
  $default_thumbnail = get_field('default_thumbnail', 'options');

  $childs_of = [];

  if (isset($child_of_id) && !empty($child_of_id)) {
    $childs_of = get_pages([ 'child_of' => $child_of_id ]);
  }

  if (!is_array($cards_md)) {
    $cards_md = [];
  }

  $result = array_merge($cards_md, $childs_of);

  ?>
  <?php if ($result): ?>
    <?php if ($title): ?>
      <h3><?php echo $title ?></h3>
    <?php endif ?>

    <?php if ($result): ?>
      <?php if (!is_admin()): ?>
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-x-8 tw-mb-8">
          <?php foreach ($result as $key => $element): ?>
            <card-image
              title="<?php echo $element->post_title ?>"
              alt-image="<?php echo App\View\Composers\App::alt_image($element) ?>"
              image="<?php echo has_post_thumbnail($element->ID) ? get_the_post_thumbnail_url($element->ID) : fly_get_attachment_image_src($default_thumbnail, [340, 190], true)['src'] ?? '' ?>"
              link="<?php echo get_permalink($element) ?>"
              :class="{'tw-border-t md:tw-border-0' : <?php echo $key ?> === 0}"
              class="card-image"
            ></card-image>
          <?php endforeach ?>
        </div>
      <?php endif ?>

      <?php if (is_admin()): ?>
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-x-8 tw-mb-8">
          <?php foreach ($result as $key => $element): ?>
            <a
              href="#"
              class="tw-block hover:tw-text-hyperlinks tw-cursor-pointer md:tw-border-0 tw-border-b tw-border-gray-light"
            >
              <div
                class="tw-relative tw-overflow-hidden tw-hidden md:tw-block"
                style="background-color: rgb(239, 239, 239); padding-bottom: 56%;"
              >
                <img
                  alt="<?php echo App\View\Composers\App::alt_image($element) ?>"
                  data-src="<?php echo has_post_thumbnail($element->ID) ? get_the_post_thumbnail_url($element->ID) : wp_get_attachment_image_url($default_thumbnail); ?>"
                  class="tw-absolute tw-object-cover tw-w-full tw-h-full"
                  src="<?php echo has_post_thumbnail($element->ID) ? get_the_post_thumbnail_url($element->ID) : wp_get_attachment_image_url($default_thumbnail); ?>"
                  data-loaded="true"
                >
              </div>

              <h3 class="tw-font-bold tw-py-6 tw-text-xl"><?php echo $element->post_title ?></h3>
            </a>
          <?php endforeach ?>
        </div>
      <?php endif ?>
    <?php endif ?>
  <?php endif ?>
  <?php
}
