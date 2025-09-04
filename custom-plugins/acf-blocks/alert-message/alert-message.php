<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-alert-message',
      'title'           => __( 'NR Alert Message' ),
      'description'     => __( 'Create an alert message' ),
      'render_callback' => 'nr_acf_alert_message_callback',
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
function nr_acf_alert_message_callback( $block ) {
  $alert_message = get_field('message');
  $icon = get_field('icon');
  ?>
  <?php if (isset($alert_message) && !empty($alert_message)): ?>
    <div class="tw-border-2 tw-border-primary tw-p-4 sm:tw-p-8 md:tw-p-12 tw-flex tw-flex-col tw-items-center tw-max-w-5xl tw-mx-auto tw-mb-8">
      <inline-svg
        name="nr_<?php echo $icon ?>"
        type="div"
        class="tw-text-primary tw-mb-8"
        style="font-size: 12rem;"
      ></inline-svg>

      <div><?php echo $alert_message ?></div>
    </div>
  <?php endif ?>
  <?php
}
