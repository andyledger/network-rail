<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
  // check function exists
  if ( function_exists( 'acf_register_block' ) ) {
    acf_register_block( [
      'name'            => 'nr-acf-azure-blob',
      'title'           => __( 'NR Azure Blob' ),
      'description'     => __( 'Display a folder from Azure Storage' ),
      'render_callback' => 'nr_acf_azure_blob',
      'category'        => 'common',
      'icon'            => ['foreground' => '#e56430','src' => 'portfolio'],
      'mode'            => 'edit'
    ] );
  }
 } );

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */

function nr_acf_azure_blob( $block ) {
  $title = get_field('title');
  $folder_name = get_field('folder');
  $folder_name = array_map('trim', explode("/", $folder_name));
  $folder_name = implode("/", $folder_name);

  ?>
    <?php if (!is_admin()): ?>
      <azure-blob
        title="<?php echo esc_html($title) ?>"
        folder="<?php echo $folder_name ?>"
        class="tw-mb-8 azure-block"
      ></azure-blob>
    <?php endif ?>

    <?php if (is_admin()): ?>
      <div class="tw-border tw-p-8">
        <p>Azure blob block not available in the admin area yet.</p>
      </div>
    <?php endif ?>
  <?php
}
