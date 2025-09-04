<?php

class Functions{

	/**
	 * add js to the footer
	 * @param  [type] $hook [description]
	 * @return [type]       [description]
	 */
	public static function google_sheet_loader_scripts() 
	{
		wp_enqueue_script( 'my-script', plugins_url( 'google-sheet-loader/my-script.js' ), ['jquery'], '1.0', true );
	}

	/**
	 * [json_admin_notice__success description]
	 * @return [type] [description]
	 */
	public static function json_admin_notice__success() {
	    ?>
	    <div class="notice notice-success is-dismissible">
	        <p><strong>json files successfully created</strong></p>
	    </div>
	    <?php
	}

	public static function wrong_notice__error() {
	    ?>
	    <div class="notice notice-error is-dismissible">
	        <p><strong>Something went wrong</strong></p>
	    </div>
	    <?php
	}

}
