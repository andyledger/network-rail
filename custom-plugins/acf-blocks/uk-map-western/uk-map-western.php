<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-uk-map-western',
      'title'           => __( 'NR UK map western' ),
      'description'     => __( 'Insert a Western Region map' ),
      'render_callback' => 'nr_acf_uk_map_western_callback',
      'category'        => 'common',
      'icon'        => ['foreground' => '#e56430','src' => 'admin-site'],
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
function nr_acf_uk_map_western_callback( $block ) {
  $links = get_field('regions');
  $title = get_field('title');

  $titles = ['Berkshire, Oxfordshire and Wiltshire', 'South West Peninsular', 'Thames valley', 'West of England'];
  $slugs = ['berkshire-oxfordshire-and-wiltshire', 'south-west-peninsular', 'thames-valley', 'west-of-england'];

  foreach ($links as $key => $value) {
    $links[$key]['title'] = $titles[$key];
    $links[$key]['slug'] = $slugs[$key];
  }

  $areas = htmlentities(json_encode($links, JSON_HEX_QUOT), ENT_QUOTES);

  ?>
    <?php if ($title): ?>
      <h3><?php echo $title ?></h3>
    <?php endif ?>

    <?php if (!is_admin()): ?>
      <n-uk-western-map
        class="n-uk-western-map"
        map-title="Western Route"
        :areas="<?php echo $areas ?>"
      ></n-uk-western-map>
    <?php endif; ?>

    <?php if (is_admin()): ?>
      <p>create simplify map version</p>
    <?php endif ?>
  <?php
}
