<div id="g-sheet-loader" class="notice" style="padding-top: 10px; padding-bottom: 50px; ">
  <h2>Anglia Map</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'anglia-map' ); ?>
    <?php do_settings_sections( 'anglia-map' ); ?>

    <p>Url of the Anglia Map google sheet:</p>

    <p>
      <input type="text" name="anglia_map_sheet_url" value="<?php echo esc_attr( get_option('anglia_map_sheet_url') ); ?>" style="width: 1000px;" />
    </p>

    <?php submit_button(); ?>
  </form>

  <p style="margin-top: 30px">Create anglia-map.json file.</p>
  <a href="?page=anglia-map&run=true" class="button button-primary">Run Anglia Map script</a>
</div>
