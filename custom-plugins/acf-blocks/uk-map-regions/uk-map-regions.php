<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-uk-map-regions',
      'title'           => __( 'NR UK map regions' ),
      'description'     => __( 'Insert an UK map with 5 regions' ),
      'render_callback' => 'nr_acf_uk_map_regions_callback',
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
function nr_acf_uk_map_regions_callback( $block ) {
  $links = get_field('regions');
  $title = get_field('title');
  $is_coloured = get_field('coloured');

  $routes = ['anglia', 'central', 'east-coast', 'east-midlands', 'high-speed', 'kent', 'north-east', 'north-west', 'scotland', 'sussex', 'wales', 'wessex', 'western'];

  $regions = [
    'eastern' => [
      'routes' => ['anglia', 'east-coast', 'east-midlands', 'north-east'],
      'link' => [],
      'title' => 'Eastern',
      'color' => 'primary',
      'color-hover' => 'primary-light'
    ],
    'north-west-and-central' => [
      'routes' => ['north-west', 'central'],
      'link' => [],
      'title' => 'North West and Central',
      'color' => 'green',
      'color-hover' => 'green-light'
    ],
    'scotland' => [
      'routes' => ['scotland'],
      'link'  => [],
      'title' => "Scotland's Railway",
      'color' => 'secondary',
      'color-hover' => 'secondary-light'
    ],
    'southern' => [
      'routes' => ['kent', 'high-speed', 'sussex', 'wessex'],
      'link' => [],
      'title' => 'Southern',
      'color' => 'turquesa',
      'color-hover' => 'turquesa-light'
    ],
    'wales-and-western' => [
      'routes' => ['wales', 'western'],
      'link' => [],
      'title' => 'Wales and Western',
      'color' => 'magenta',
      'color-hover' => 'magenta-light'
    ]
  ];

  $counter = 0;
  foreach ($regions as $key => $element) {
    if (is_array($links[$counter]['link'])) {
      $regions[$key]['link']['url'] = $links[$counter]['link']['url'];
      $regions[$key]['link']['target'] = $links[$counter]['link']['target'];
    }

    $counter++;
  }
  ?>
    <?php if ($title): ?>
      <h3><?php echo $title ?></h3>
    <?php endif ?>

    <div class="tw-flex tw-justify-center tw-mb-8">
      <svg
        xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 595.28 841.89" preserveAspectRatio="xMinYMax meet"
        class="tw-w-full tw-block tw-p-8 tw-max-w-400"
      >
        <g>
          <?php foreach ($regions as $key => $route): ?>
            <a
              href="<?php echo !empty($route['link']['url']) ? $route['link']['url'] : '#' ?>"
              content="<?php echo $route['title'] ?>"
              v-tippy
              aria-label="<?php echo $route['title'] ?> region link"
            >
              <g
                class="tw-stroke-path tw-transition"
                :class="[<?php echo !$is_coloured ? 'true' : 'false'  ?> ? 'tw-fill-secondary' : 'tw-fill-<?php echo $route['color'] ?> hover:tw-fill-<?php echo $route['color']?>-light']"
              >
                <?php echo file_get_contents(plugin_dir_url(__FILE__).'regions_svg/'.$key.'.svg'); ?>
              </g>
            </a>
          <?php endforeach ?>
        </g>
      </svg>
    </div>
  <?php
}
