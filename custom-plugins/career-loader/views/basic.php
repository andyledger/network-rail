<form method="post" action="options.php">
    <?php settings_fields( 'NRCareerLoader_basic' ); ?>
    <?php do_settings_sections( 'NRCareerLoader_basic' ); ?>
    <table class="form-table">
      <tr valign="top">
          <th scope="row">File url:</th>
          <td>
            <input type="text" name="fileUrl" value="<?php echo esc_attr( get_option('fileUrl') ); ?>" style="width: 500px;" /><br/>
          </td>
        </tr>
      <tr>
          <th scope="row">Emails:<br><span style="font-size: 12px; font-weight: 400;">Send notification to these emails in case or error.</span></th>
          <td>
            <input type="text" name="emails" value="<?php echo esc_attr( get_option('emails') ); ?>" style="width: 500px;" /><br/>
          </td>
        </tr>
    </table>

    <?php submit_button(); ?>
</form>

<hr>

<a
  href="?page=nr_career_loader&skip_download_file=1&NRCareerLoader_run=true"
  class="button button-primary"
>Run the import jobs script</a>

<?php
  if( isset( $_GET['NRCareerLoader_run'] ) ){
    NRCareerLoader::loadCareer();
  }
?>
