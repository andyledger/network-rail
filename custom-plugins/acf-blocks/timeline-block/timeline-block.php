<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-timeline',
      'title'           => __( 'NR Timeline' ),
      'description'     => __( 'Create a timeline slider' ),
      'render_callback' => 'nr_acf_timeline_callback',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'menu'],
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
function nr_acf_timeline_callback( $block ) {
  $timeline = get_field('timeline');
  ?>
  <?php if (is_admin()): ?>

    <div style="font-size: 12px; font-style: italic; margin-bottom: 10px;">This is the admin version of the block, due to incompatibilities between React and Vue.js this is a simplified version with restricted functionality.</div>

    <div style="display: flex;">
      <?php for ($i = 1; $i <= 3; $i++): ?>
        <div>
          <div><img src="<?php echo $timeline[$i]['image']['sizes']['card-sm'] ?>"></div>

          <div><?php echo $timeline[$i]['year'] ?></div>

          <div><?php echo $timeline[$i]['description'] ?></div>
        </div>
      <?php endfor ?>
    </div>

  <?php else: ?>

    <div id="timeline-block">
      <timeline-block style="margin-bottom: 30px; position: relative;">
        <?php foreach ($timeline as $element): ?>
          <div class="carousel-cell">
            <div style="margin-bottom: 20px; position: relative;">
              <img
                src="<?php echo $element['image']['sizes']['card-sm'] ?>"
                alt="<?php echo $element['image']['alt'] ?>"
                style="width: 100%"
                class="imgFlicker"
              />

              <div
                class="orange-overlay"
                style="top: 0; height: 100%; width: 100%; position: absolute; background: rgb(299, 100, 48, 0.5)"
              ></div>
            </div>

            <div class="carousel-cell__body">
              <div style="text-align: center; font-size: 34px; font-weight: bold; margin-bottom: 10px"><?php echo $element['year'] ?></div>

              <div style="text-align: center; font-size: 16px;"><?php echo $element['description'] ?></div>
            </div>
          </div>
        <?php endforeach ?>
      </timeline-block>
    </div>
  <?php endif ?>

  <?php
}
