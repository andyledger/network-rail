<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-jump-links',
			'title'           => __( 'NR Jump Links Menu' ),
			'description'     => __( 'Add Jump Links Menu' ),
			'render_callback' => 'nr_acf_jump_links_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'admin-links'],
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
function nr_acf_jump_links_callback( $block ) {
    $jumpLinks = get_field('jump_links');

    if (empty($jumpLinks)) {
        return;
    }
?>

    <div class="jump-links">
        <h2 class="wp-block-heading jump-links-heading">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" class="tw-mr-4">
                <path d="M27.3333 14L24.9833 11.65L15.6666 20.95V0.666626H12.3333V20.95L3.03329 11.6333L0.666626 14L14 27.3333L27.3333 14Z" fill="black"/>
            </svg>
            <span>Jump to</span>
        </h2>
        <nav>
            <ul>
                <?php foreach ($jumpLinks as $jumpLink) : ?>
                <li>
                    <a href="#<?php echo str_replace('#', '', $jumpLink['jump_link_hash']);?>">
                        <?php echo $jumpLink['jump_link_title'];?>
                    </a>
                </li>
                <?php endforeach ;?>
            </ul>
        </nav>
    </div>


	<?php
}
