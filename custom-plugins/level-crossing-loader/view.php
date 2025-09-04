<div id="g-sheet-loader" class="notice" style="padding-top: 10px; padding-bottom: 50px; ">
  <h2>Level Crossing Loader</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'level-crossing-loader' ); ?>
    <?php do_settings_sections( 'level-crossing-loader' ); ?>

    <p>Url of the level crossing google sheet:</p>

    <p>
      <input type="text" name="level_crossing_sheet_url" value="<?php echo esc_attr( get_option('level_crossing_sheet_url') ); ?>" style="width: 1000px;" />
    </p>
    
    <?php submit_button(); ?>
  </form>

  <p style="margin-top: 30px">Create level-crossing.json file.</p>
  <a href="?page=level-crossing-loader&run=true" class="button button-primary">Run Level Crossing loader</a>
</div>