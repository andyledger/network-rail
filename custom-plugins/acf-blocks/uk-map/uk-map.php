<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-uk-map',
			'title'           => __( 'NR UK map' ),
			'description'     => __( 'Insert an UK map' ),
			'render_callback' => 'nr_acf_uk_map_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'admin-site'],
			'mode' 			  => 'edit'
		] );
	}
});


 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_uk_map_callback( $block ) {
	$links = get_field('routes');
	$title = get_field('title');
	$paths = json_decode(
		file_get_contents( __DIR__ .'/paths.json' ), true
	);

	$data = [];

	$counter = 0;
	foreach ($paths as $route_name => $path) {
		$url = '';

		if( isset($links[$counter]['link']['url']) ) {
			$url = $links[$counter]['link']['url'];
		}

		$data[$route_name] = [
			'path' => $path,
			'link' => $url
		];

		$counter++;
	}
	?>

	<?php if ($title): ?>
		<h3><?php echo $title ?></h3>
	<?php endif ?>

  <div class="tw-flex tw-justify-center tw-mb-8">
    <svg 
	    xmlns="http://www.w3.org/2000/svg" 
	    version="1.1" 
	    viewBox="0 0 330 590" 
	    preserveAspectRatio="xMinYMax meet"
	    class="tw-w-full tw-block tw-p-8 tw-max-w-400"
	  >
      <g>
	    	<?php foreach ($data as $key => $element): ?>
	    		<a
	    			id="<?php echo $key ?>-path" <?php echo (!empty($element['link'])) ? 'href="'.$element['link'].'"' : '' ; ?>
	    			content="<?php echo str_replace('_', ' ', $key) ?>"
	    			v-tippy
	    			aria-label="<?php echo str_replace('_', ' ', $key) ?> region link"
	    		>
	    			<path class="tw-stroke-path tw-fill-secondary hover:tw-fill-primary tw-transition" d="<?php echo $element['path'] ?>"></path>
	    		</a>
	    	<?php endforeach ?>
      </g>
    </svg>
  </div>

	<?php
}
