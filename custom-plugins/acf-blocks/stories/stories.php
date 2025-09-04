<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-stories',
      'title'           => __( 'NR Stories' ),
      'description'     => __( 'Add stories relatives to a category or tag' ),
      'render_callback' => 'nr_acf_stories_callback',
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
function nr_acf_stories_callback( $block ) {
  $default_thumbnail = get_field('default_thumbnail', 'options');
  $categories_id = (get_field('select_categories')) ? get_field('select_categories') : [] ;
  $tags_id = (get_field('select_tags')) ? get_field('select_tags') : [] ;
  $num = get_field('number_of_stories_to_show');

  $cards = get_posts([
    'post_type' => 'post',
    'posts_per_page' => $num,
    'category__in' => $categories_id,
    'tag__in' => $tags_id
  ]);

  $counter = 1;

  $str = get_permalink( get_page_by_path('stories') );

  if (count($categories_id) == 1) {
    $category_name = get_term($categories_id[0]);
    $category_name = $category_name->slug;

    $str = get_permalink( get_page_by_path( 'stories' ) ).'?cat='.$category_name;
  }

  ?>
  <?php if (isset($cards) && !empty($cards)): ?>
    <?php if (!is_admin()): ?>
      <div class="tw-grid md:tw-grid-cols-3 tw-gap-8 tw-mb-8">
        <?php foreach ($cards as $key => $element): ?>
          <?php
            if (has_post_thumbnail($element)) {
              $image = get_the_post_thumbnail_url($element, 'post-thumbnail');
            } else {
              $image = wp_get_attachment_image_src($default_thumbnail, 'post-thumbnail');
              $image = $image[0];
            }
          ?>
          <?php if (get_post_meta($element->ID, '_yoast_wpseo_metadesc', true)) {
                $stories_excerpt = substr(get_post_meta($element->ID, '_yoast_wpseo_metadesc', true), 0, 200);
            } else {
                $stories_excerpt = wp_trim_words($element->post_content, 35, '...');
            } ?>
          <card
            title="<?php echo esc_html($element->post_title); ?>"
            description="<?php echo esc_html($stories_excerpt); ?>"
            image="<?php echo $image; ?>"
            link="<?php echo get_permalink($element); ?>"
            date="<?php echo get_the_date('M j, Y', $element->ID); ?>"
            alt-image="<?php echo esc_html(App\View\Composers\App::alt_image($element)); ?>"
            class="card-component"
            four-columns
          ></card>
        <?php endforeach ?>
      </div>
    <?php endif ?>

    <?php if (is_admin()): ?>
      <div class="tw-grid md:tw-grid-cols-3 tw-gap-8 tw-mb-8">
        <?php foreach ($cards as $key => $element): ?>
          <?php
            if (has_post_thumbnail($element)) {
              $image = get_the_post_thumbnail_url($element, 'post-thumbnail');
            } else {
              $image = wp_get_attachment_image_src($default_thumbnail, 'post-thumbnail');
              $image = $image[0];
            }
          ?>
          <div class="tw-flex tw-flex-col tw-max-w-800">
            <a
              href="<?php echo get_permalink($element) ?>"
              class="tw-block tw-cursor-pointer tw-group"
            >
              <div
                class="tw-relative tw-overflow-hidden tw-mb-6"
                style="background-color: rgb(239, 239, 239); padding-bottom: 56%;"
              >
                <img
                  class="tw-absolute tw-object-cover tw-w-full tw-h-full"
                  src="<?php echo $image ?>"
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
      </div>
    <?php endif ?>

    <div class="tw-relative tw-flex tw-items-center tw-justify-center tw-mb-8">
      <div class="tw-border-t tw-border-gray-light tw-absolute tw-w-full"></div>

      <a
        href="<?php echo $str ?>"
        class="tw-relative tw-z-10 tw-bg-white tw-font-bold tw-py-3 tw-px-8 tw-border tw-border-gray-light tw-rounded-md tw-inline-block hover:tw-text-hyperlinks"
      >Load more stories</a>
    </div>
  <?php endif ?>
  <?php
}
