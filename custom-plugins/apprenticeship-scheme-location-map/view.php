<div id="g-sheet-loader" class="notice" style="padding-top: 10px; padding-bottom: 50px; ">
  <h2><?php echo get_admin_page_title() ?></h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'apprenticeship-scheme-location-map' ); ?>
    <?php do_settings_sections( 'apprenticeship-scheme-location-map' ); ?>

    <p>Url of the Apprenticeship Scheme Location Map google sheet:</p>

    <p>
      <input 
        type="text" 
        name="apprenticeship_scheme_location_map_url" 
        value="<?php echo esc_attr( get_option('apprenticeship_scheme_location_map_url') ); ?>" 
        style="width: 1000px;" 
      />
    </p>
    
    <?php submit_button(); ?>
  </form>

  <p style="margin-top: 30px">Create apprenticeship-scheme-location-map.json file.</p>
  
  <a href="?page=apprenticeship-scheme-location-map&run=true" class="button button-primary">Run script</a>
</div>