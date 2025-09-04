<div id="g-sheet-loader" class="notice" style="padding-top: 10px; padding-bottom: 50px; ">
  <h2>Bridge Strike Map</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'bridge-strike-map' ); ?>
    <?php do_settings_sections( 'bridge-strike-map' ); ?>

    <p>Url of the Brige Strike Map google sheet:</p>

    <p>
      <input 
        type="text" 
        name="bridge_strike_map_sheet_url" 
        value="<?php echo esc_attr( get_option('bridge_strike_map_sheet_url') ); ?>" 
        style="width: 1000px;" 
      />
    </p>
    
    <?php submit_button(); ?>
  </form>

  <p style="margin-top: 30px">Create bridge-strike-map.json file.</p>
  <a href="?page=bridge-strike-map&run=true" class="button button-primary">Run Bridge Strike Map script</a>
</div>