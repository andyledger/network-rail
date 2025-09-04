<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-before-after',
      'title'           => __( 'NR Before After Slider' ),
      'description'     => __( 'Create an image comparison slider with a before-after effect' ),
      'render_callback' => 'nr_acf_before_after',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'admin-links'],
      'mode'        => 'edit'
    ] );
  }
 } );

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_before_after( $block ) {
  $before = get_field('before');
  $after = get_field('after');
  ?>
  <?php if (isset($before) && !empty($before) && isset($after) && !empty($after)): ?>
    <div class="beer-slider mb-5" data-beer-label="After">
      <?php echo wp_get_attachment_image($after['ID'], 'single-post') ?>

      <div class="beer-reveal" data-beer-label="Before">
        <?php echo wp_get_attachment_image($before['ID'], 'single-post') ?>
      </div>
    </div>
  <?php endif ?>
  <?php 
} 