<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-midland-mainline-animation',
      'title'           => __( 'NR Midland Mainline Programme animation' ),
      'description'     => __( 'Add the Midland Mainline Programme animation' ),
      'render_callback' => 'nr_acf_midland_mainline_callback',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'video-alt2'],
      'mode'        => 'edit'
    ] );
  }
});

add_action('wp_enqueue_scripts', function () {
  if (is_page('midland-main-line-upgrade')) {
    wp_enqueue_script( 'jc_vendor_js', plugin_dir_url(__FILE__) . 'assets/js/vendor.min.js', [], false, true );
    wp_enqueue_script( 'jc_app_js', plugin_dir_url(__FILE__) . 'assets/js/app.js', [], false, true );
    wp_enqueue_style( 'jc_vendor_css', plugin_dir_url(__FILE__) . 'assets/css/vendor.min.css' );
    wp_enqueue_style( 'jc_style_css', plugin_dir_url(__FILE__) . 'assets/css/style.min.css' );
    wp_enqueue_script('mmp-js', plugin_dir_url(__FILE__) . 'assets/animation/Main2.hyperesources/main2_hype_generated_script.js', [], '', true);
  }
}, 10);

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_midland_mainline_callback($block) {
    $top_content_title = get_field('top_content_title');
    $top_content = get_field('top_content');
    $hotspots = get_field('hotspots');
    $hotspots_name = ['neighbours', 'more-seats', 'platforms', 'station-upgrade', 'electrification', 'freight' ];
    $footer_content_title = get_field('footer_content_title');
    $footer_content = get_field('footer_content');
  ?>

  <?php if (!is_admin()): ?>
  <section class="animation-section tw-overflow-hidden">
    <?php if ( !empty( $top_content_title ) || !empty( $top_content ) ) : ?>
      <div class="container-custom">
        <div class="text-box-white">
          <?php if ( !empty($top_content_title) ) : ?>
            <h2 class="h1"><?php echo $top_content_title; ?></h2>
          <?php endif; ?>

          <?php echo $top_content; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="information-wrapper">
      <div class="animation-holder">
        <div id="main2_hype_container" class="desktop-animation" style="margin:auto;position:relative;width:100%;height:100%;overflow:hidden;">
        </div>

        <div class="mobile-placeholder">
          <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/animation-placeholder-mob.png" alt="animation image">
        </div>
      </div>

    <div class="accordion-holder" id="accordion1">
      <?php $counter = 1 ?>
      <?php foreach ($hotspots as $hotspot): ?>
        <div class="box box<?php echo $counter ?>">
          <div class="animation-mobile">
            <div class="gif-holder">
              <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/<?php echo $hotspot['key'] ?>.gif" alt="<?php echo $hotspot['key'] ?> animation">
            </div>
          </div>

          <span class="opener"></span>

          <div class="box-content">
            <?php if ( ! empty( $hotspot['title'] ) ) : ?>
              <h3 class="title"><?php echo $hotspot['title']; ?></h3>
            <?php endif; ?>

            <?php echo $hotspot['description']; ?>
          </div>
        </div>
        <?php $counter++ ?>
      <?php endforeach ?>
    </div>

    <?php if ( !empty( $footer_content_title ) || !empty( $footer_content ) ) : ?>
      <div class="container-custom">
        <div class="text-box-white">
          <?php if ( !empty($footer_content_title) ) : ?>
            <h2 class="h1"><?php echo $footer_content_title; ?></h2>
          <?php endif; ?>

          <?php echo $footer_content; ?>
        </div>
      </div>
    <?php endif ?>

  </section>
  <?php else: ?>
    <p>Midland mainline programme animation.</p>

    <p>This block only works on midland-main-line-upgrade page front-end</p>
  <?php endif ?>
  <?php
}
