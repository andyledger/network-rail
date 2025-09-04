<?php
/*
Plugin Name: Sftp NR
Description: Copy iRec file from NR server to WP Engine
Version: 1.0.0
Author: Carlos Ortiz
License: GPL
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

require_once "vendor/autoload.php";
use phpseclib\Net\SFTP;

class Connect_to_NR_server
{
	public static function connect() {
		$sftp = new SFTP('uk-sftps.thruinc.com');

		if (!$sftp->login('VacPost_Prod', '@qs@Zmr5')) {
			throw new Exception('Login failed');
		}

		// select folder
		$sftp->chdir('/VacPostFeed_UnProcessed/');

		// save file to folder -> get(file.remote, file.local)
		$file = $sftp->get('XXNR_IREC_EXTERNAL_VACANCY_FEED.TXT', get_template_directory().'/resources/iRec.txt');

		// send email if it fails
		if (!$file) {
		    date_default_timezone_set('Europe/London');
		    $to = 'carlosor@gmail.com';
		    $subject = 'connect NR sftp';
			$message = 'There has been a problem uploading the iRec file to '.$_SERVER['HTTP_HOST'].' at '.date("Y-m-d H:i:s");
			$headers = ['From: WordPress <NRdeveloper@gmail.com>'];
			wp_mail( $to, $subject, $message, $headers);
		}
	}
}

add_action( 'sftp_nr_hook', [ __NAMESPACE__ . '\Connect_to_NR_server','connect' ] );
