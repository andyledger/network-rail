<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-blog-categories',
      'title'           => __( 'NR Blog Categories' ),
      'description'     => __( 'Add blogs relatives to a blog category' ),
      'render_callback' => 'nr_acf_blog_categories_callback',
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
function nr_acf_blog_categories_callback($block ) {
  $default_thumbnail = get_field('default_thumbnail', 'options');
  $categories_id = (get_field('select_categories')) ? get_field('select_categories') : [] ;
  $num = get_field('number_of_stories_to_show');

  $cards = get_posts([
    'post_type'       => 'blog',
    'posts_per_page'  => $num,
    'tax_query'       => [
      [
        'taxonomy' => 'blog_category',
        'field'    => 'id',
        'terms'    => $categories_id
      ],
    ],
  ]);

  $has_load_more = false;

  if (count($categories_id) == 1) {
    $category_name = get_term($categories_id[0]);
    $category_name = $category_name->slug;
    $has_load_more = true;
  }
  ?>
  <?php if (isset($cards) && !empty($cards)): ?>
      <div class="tw-grid md:tw-grid-cols-3 tw-gap-8 tw-mb-8">
        <?php if (!is_admin()): ?>
          <?php foreach ($cards as $element): ?>
            <card
              title="<?php echo esc_html($element->post_title) ?>"
              description="<?php echo esc_html(wp_trim_words($element->post_content, 35, '...')) ?>"
              image="<?php echo has_post_thumbnail($element->ID) ? get_the_post_thumbnail_url($element->ID) : fly_get_attachment_image_src($default_thumbnail, [340, 190], true)['src'] ?>"
              link="<?php echo get_permalink($element->ID) ?>"
              date="<?php echo get_the_date('M j, Y', $element->ID) ?>"
              alt-image="<?php echo esc_html(App\View\Composers\App::alt_image($element)) ?>"
              :four-columns="true"
              class="card-component"
            ></card>
          <?php endforeach ?>
        <?php endif ?>

        <?php if (is_admin()): ?>
          <?php foreach ($cards as $element): ?>
            <?php $url = get_post_meta($element->ID, 'feed_meta_seo_name', true) ?>
            <div class="tw-flex tw-flex-col tw-max-w-800">
              <a
                href="#"
                class="tw-block hover:tw-text-hyperlinks tw-cursor-pointer"
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

                <h3 class="tw-font-bold tw-pb-4 tw-text-xl xl:tw-pb-3">
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

      <?php if ($has_load_more): ?>
        <div class="tw-relative tw-flex tw-items-center tw-justify-center tw-mb-8">
          <div class="tw-border-t tw-border-gray-light tw-absolute tw-w-full"></div>

          <a
            href="<?php echo get_permalink( get_page_by_path('Blogs')) .'?cat_blog_name='.$category_name ?>"
            class="tw-relative tw-z-10 tw-bg-white tw-font-bold tw-py-3 tw-px-8 tw-border tw-border-gray-light tw-rounded-md tw-inline-block"
          >Load more posts</a>
        </div>
      <?php endif ?>
  <?php endif ?>
  <?php
}
