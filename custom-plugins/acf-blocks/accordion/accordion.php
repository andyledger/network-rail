<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-accordion',
			'title'           => __( 'NR Accordion' ),
			'description'     => __( 'Create an accordion' ),
			'render_callback' => 'nr_acf_accordion_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'menu'],
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
function nr_acf_accordion_callback( $block ) {
	$accordion = get_field('accordion');
	$title = get_field('title');
	$id = $block['id'];
	$counter = 1;
	$accordion_items = htmlentities(json_encode($accordion, JSON_HEX_QUOT), ENT_QUOTES);
	?>
	<?php if (isset($accordion) && !empty($accordion)): ?>
		<?php if ($title): ?>
			<h3><?php echo $title ?></h3>
		<?php endif ?>

        <?php if (!is_admin()): ?>
            <accordion class="tw-mb-8 accordion-block">
                <template v-slot:accordion="slotProps">
                    <accordion-item
                        v-for="(item, i) in <?php echo $accordion_items ?>"
                        :key="i"
                        :i="i"
                        :title="item.title"
                        :icon-name="item.icon"
                        :description="item.description"
                        :is-expanded="slotProps.activeItem === i ? true : false"
                        @expand="slotProps.handleExpand"
                    ></accordion-item>
                </template>
            </accordion>
        <?php endif ?>

        <?php if (is_admin()): ?>
        	<div class="tw-border tw-p-8">
        		<p>create plain version of the accordion</p>
        	</div>
        <?php endif ?>
	<?php endif ?>
	<?php
}