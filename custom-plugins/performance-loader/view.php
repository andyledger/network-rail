<div id="g-sheet-loader" class="notice" style="padding-top: 10px; padding-bottom: 50px; ">
	<h2>Performance Loader</h2>

	<form method="post" action="options.php">
	    <?php settings_fields( 'google-sheet-loader' ); ?>
	    <?php do_settings_sections( 'google-sheet-loader' ); ?>
		<p>Url of the google sheet:</p>
		<p>
			<input type="text" name="google_sheet_url" value="<?php echo esc_attr( get_option('google_sheet_url') ); ?>" style="width: 1000px;" />
		</p>
		<p>Id of the Delay responsability tab:</p>
		<p>
			<input type="text" name="delay_id" value="<?php echo esc_attr( get_option('delay_id') ); ?>" style="width: 200px;" />
		</p>
		<p>Id of the Major stations served tab:</p>
		<p>
			<input type="text" name="stations_id" value="<?php echo esc_attr( get_option('stations_id') ); ?>" style="width: 200px;" />
		</p>
	    <?php submit_button(); ?>
	</form>

	<p style="margin-top: 30px">Create performance, delay and stations json files.</p>
	<a href="?page=performance-loader&run=true" class="button button-primary">Run google sheet loader</a>

</div>
	