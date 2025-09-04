<div id="g-sheet-loader" class="notice" style="padding-top: 10px; padding-bottom: 50px; ">
  <h2>Kent Works Map</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'kent-works-map' ); ?>
    <?php do_settings_sections( 'kent-works-map' ); ?>

    <p>Url of the Kent Works Map google sheet:</p>

    <p>
      <input type="text" name="kent_works_map_sheet_url" value="<?php echo esc_attr( get_option('kent_works_map_sheet_url') ); ?>" style="width: 1000px;" />
    </p>
    
    <?php submit_button(); ?>
  </form>

  <p style="margin-top: 30px">Create kent-works-map.json file.</p>
  <a href="?page=kent-works-map&run=true" class="button button-primary">Run Kent Works Map script</a>
</div>