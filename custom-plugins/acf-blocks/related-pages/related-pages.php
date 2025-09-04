<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-related-pages',
      'title'           => __( 'NR Related Pages' ),
      'description'     => __( 'Add a related pages section with 3 cards' ),
      'render_callback' => 'nr_acf_related_pages_callback',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'editor-insertmore'],
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
function nr_acf_related_pages_callback( $block ) {
  $cards = get_field('pages');
  $default_thumbnail = get_field('default_thumbnail', 'options');
;
?>

<?php if (isset($cards) && !empty($cards)): ?>
  <div class="tw-grid md:tw-grid-cols-3 tw-gap-8 tw-mb-8">
    <?php foreach ($cards as $element): ?>
      <?php if (!is_admin()): ?>
        <card
          title="<?php echo esc_html($element->post_title) ?>"
          description="<?php echo esc_html(wp_trim_words($element->post_content, 35, '...')) ?>"
          image="<?php echo App\View\Composers\App::on_the_fly_thumbnail($element->ID, [340, 190]) ?>"
          link="<?php echo get_permalink($element) ?>"
          alt-image="<?php echo esc_html(App\View\Composers\App::alt_image($element)) ?>"
          class="card-component"
          :four-columns="true"
        ></card>
      <?php endif ?>

      <?php if (is_admin()): ?>
        <div class="tw-flex tw-flex-col tw-max-w-800">
          <a
            href="#"
            class="tw-block tw-group tw-cursor-pointer"
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

          <div class="tw-text-gray-dark tw-text-xl xl:tw-text-base">
            <?php echo wp_trim_words($element->post_content, 35, '...') ?>
          </div>
        </div>
      <?php endif ?>
    <?php endforeach ?>
  </div>
<?php endif ?>

<?php
}
