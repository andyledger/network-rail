<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-train-animation',
      'title'           => __( 'NR Train Animation' ),
      'description'     => __( 'Add a train animation' ),
      'render_callback' => 'nr_acf_train_animation_callback',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'video-alt2'],
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
function nr_acf_train_animation_callback($block) {
  $slugs = ['bridgeWorks', 'electrification', 'vegetation', 'levelCrossing', 'noiseVibration', 'roadPathClosure', 'trackRenewal'];
  $titles = ['Bridge Works', 'Electrification', 'Vegetation', 'Level Crossing', 'Noise Vibration', 'Road Path Closure', 'Track Renewal'];
  $elements = [];

  foreach ($slugs as $key => $value) {
    $elements[$key]['slug'] = $value;
    $elements[$key]['title'] = $titles[$key];
    $elements[$key]['description'] = get_field($value);
    $elements[$key]['link'] = get_field($value.'Link');
    $elements[$key]['json'] = file_get_contents(plugin_dir_url(__FILE__).'animations/'.$value.'.json');
  }

  $json_elements = htmlentities(json_encode($elements, JSON_HEX_QUOT), ENT_QUOTES);

  ?>
  <living-by-the-railway
    class="tw-hidden md:tw-block tw-mb-12"
    :animations="<?php echo $json_elements ?>"
  >
    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/lbtr-background.jpeg' ?>" class="tw-w-full">
    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/lbtr-train.png' ?>" class="tw-w-full tw-absolute tw-top-0 train-animation">
    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/lbtr-bridges.png' ?>" class="tw-w-full tw-absolute tw-top-0">
  </living-by-the-railway>

  <div class="md:tw-hidden tw-mb-12">
    <?php foreach ($elements as $element): ?>
      <div class="tw-flex tw-flex-col tw-items-center">
        <img
          src="<?php echo plugin_dir_url( __FILE__ ).'images/'.$element['slug'].'.jpg' ?>"
          alt="<?php echo $element['title'] ?> segment"
          class="tw-block"
        >

        <div class="tw-flex tw-flex-col tw-justify-center tw-items-center">
          <div class="tw-font-bold tw-text-2xl tw-mb-4">
            <?php echo $element['title'] ?>
          </div>

          <?php if ($element['description']): ?>
            <p class="tw-mb-2 tw-text-center"><?php echo $element['description'] ?></p>
          <?php endif ?>

          <?php if (is_array($element['link'])): ?>
            <a
              href="<?php echo $element['link']['url'] ?>"
              class="tw-text-primary tw-block tw-text-xl"
              target="<?php echo $element['link']['target'] ?>"
            >
              More information
            </a>
          <?php endif ?>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  <?php
}
