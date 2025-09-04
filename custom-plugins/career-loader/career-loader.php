<?php
/*
Plugin Name: Career loader
Plugin URI: http://www.wholegraindigital.com/
Description: Load careers from txt file and create JSON
Version: 1.0.0
Author: Wholegrain Digital
Author URI: http://www.wholegraindigital.com/
License: GPL
Copyright: Wholegrain Digital
Text Domain: career-loader
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}


class NRCareerLoader {
	private static $initiated = false;
	private static $pluginPath;
	private static $pluginUrl;
	private static $prefix = "NRCareerLoader_";
	private static $columns;
	private static $indexes;
	private static $monthsMap;
	public static $message = "";
	public static $results;
	private static $fileUrl;
	private static $emails;
	private static $vacancyIdError;

	public static function init(){
		if ( ! self::$initiated ) {
			self::initHooks();
		}
	}


	public static function initHooks() {
		self::$initiated = true;
		self::$indexes   = array();

		// Set Plugin Path
        self::$pluginPath = dirname(__FILE__);

        // Set Plugin URL
        self::$pluginUrl = WP_PLUGIN_URL . '/career-loader';

		self::$fileUrl = get_option('fileUrl');

		self::$columns = array(
			'VACANCY_ID',
			'POSTING_CONTENT_ID',
			'VACANCY_NAME',
			'VAC_ADVERTISE_START_DATE',
			'VAC_ADVERTISE_END_DATE',
			'JOB_FUNCTION',
			'TOWN_OR_CITY',
			'POSTAL_CODE',
			'FUNCTION',
			'EMPLOYEEMENT_STATUS',
			'VACANCY_CONTEXT',
			'MIN_SALARY',
			'MAX_SALARY',
			'SEARCH_ATTR_7',
			'DISPLAYED_JOB_TITLE',
			'DEPARTMENT_AND_HOW_IT_RELATES_TO_THE_ROLE'
		);

		self::$monthsMap = array(
			'JAN' => '01',
			'FEB' => '02',
			'MAR' => '03',
			'APR' => '04',
			'MAY' => '05',
			'JUN' => '06',
			'JUL' => '07',
			'AUG' => '08',
			'SEP' => '09',
			'OCT' => '10',
			'NOV' => '11',
			'DEC' => '12'
		);

        add_action( 'admin_menu', array( 'NRCareerLoader', 'loadMenu' ) );
        add_action( 'admin_init', array( 'NRCareerLoader', 'registerSetting' ) );
	}


	public static function loadMenu() {
		add_submenu_page(
			'options-general.php', // $parent_slug
			'Career loader', // $page_title
			'Career loader', // $menu_title
			'manage_options', // $capability
			'nr_career_loader', // $menu_slug
			array('NRCareerLoader', 'viewBasic') // $function
		);
	}


	public static function registerSetting(){
		register_setting( 'NRCareerLoader_basic', 'fileUrl' );
		register_setting( 'NRCareerLoader_basic', 'emails' );
	}


	public static function viewBasic(){
		include self::$pluginPath . '/views/basic.php';
	}


	public static function loadCareer(){

        // if (empty($_GET['skip_download_file'])) {
        //     \Connect_to_NR_server::connect();
        // }

		if( !empty(self::$fileUrl) ){

			// Prepare request
			$options = array(
			    'http' => array(
			        'header'  => "User-Agent: Fiddler \r\n",
			        'method'  => 'GET',
			        'content' => http_build_query(array())
			    )
			);
			$context = stream_context_create($options);
			$data = file_get_contents(self::$fileUrl, false, $context);

			$file_encoding = mb_detect_encoding(self::$fileUrl);
			self::$message .= "<div class='notice notice-success'>File encoding: ".$file_encoding.".</div>";

			// Change file encoding from ASCII to UTF-8
			$data = mb_convert_encoding($data, 'UTF-8', $file_encoding);
			self::$message .= "<div class='notice notice-success'>File encoding changed to UTF-8.</div>";

			// Change file encoding from UTF-8 to HTML-ENTITIESI
			$data = mb_convert_encoding($data, 'HTML-ENTITIES', 'UTF-8');
			self::$message .= "<div class='notice notice-success'>File encoding changed to HTML-ENTITIES.</div>";

			// Split the data into lines
			$lines = preg_split ('/$\R?^/m', $data);

			// Split the lines into cells
			foreach ($lines as $key => &$line) {
				$line = explode('^|', $line);
			}

			/**
			 * The loop below finds all the indexes of needed columns
			 * array (  'VACANCY_ID'         => 0,
			 * 			'POSTING_CONTENT_ID' => 1,
			 * 			'VACANCY_CONTEXT'    => 21,
			 * 			'MIN_SALARY'         => 42, )
			 */
			foreach (self::$columns as $column) {
				self::$indexes[$column] = array_search ($column, $lines[1]);
			}

			self::$emails = get_option('emails');

			// send email if iRec file has errors
			if ( !self::checkCareer($lines) ) {
				$to = self::$emails;
				$subject = 'iRec file error';
				$message = 'There has been an error creating the json file in '.$_SERVER['HTTP_HOST'].'. Vacancy_id: '.self::$vacancyIdError;
				$headers = ['From: WordPress <NRdeveloper@gmail.com>'];
				wp_mail( $to, $subject, $message, $headers );

				$message = 'iRec file has errors, not saved. Check the vacancy '.self::$vacancyIdError;
				self::irec_notice($message);
			} else {
				// Try to save each item
				self::saveCareer($lines);
			}
		}
	}

	/**
	 * Return false if any of the arrays have less than 176 elements
	 * @param  array $lines
	 * @return bool
	 */
	public static function checkCareer($lines) {
		$arrayBool = [];
		for ($i=1; $i < count($lines); $i++) {
			if ( count($lines[$i] ) < 176 ) {
				$arrayBool[] = false;
				self::$vacancyIdError = $lines[$i][0];
				break;
			} else {
				$arrayBool[] = true;
			}
		}

		if ( in_array(false, $arrayBool) ) {
			return false;
		}

		return true;
	}

	/**
	 * [irec_notice description]
	 * @param  string  $message message of the notice
	 * @param  boolean $error   if it is a error notice or a success notice. Default error notice.
	 * @return html
	 */
	public static function irec_notice($message, $error=true) {
	    ?>
	    <div class="notice <?php echo ($error) ? 'notice-error' : 'notice-success' ; ?> is-dismissible">
	        <p><strong><?php echo $message ?></strong></p>
	    </div>
	    <?php
	}

	public static function saveCareer($lines){
		$n = 0;
		$postCodesCache = array();

		$JSON = array();

		/**
		 * Each line has all the columns
		 *  array(	0 => 'VACANCY_ID',
		 *	  		1 => 'POSTING_CONTENT_ID',
		 *	    	2 => 'VACANCY_NAME',
		 *      	3 => ...				   )
		 */
		foreach ($lines as $key => $line) {
			if( $key > 1 ){
				$n++;
				$dataSet = array();

				/**
				 * This loop runs through indexes and saves data to $dataSet
				 */
				foreach (self::$indexes as $key2 => $index) {

					// Data fix for Firefox
					// Changing format from "10-AUG-16" to "2016-08-10"
					if ( $key2 == "VAC_ADVERTISE_START_DATE" || $key2 == "VAC_ADVERTISE_END_DATE" ) {
						if ( !empty( $line[$index] ) ){
							$date = explode("-",$line[$index]);
							$line[$index] = "20".$date[2].'-'.self::$monthsMap[$date[1]].'-'.$date[0];
						}else{
							$line[$index] = "";
						}
					}
					$dataSet[$key2] = $line[$index];
				}

				// Add LATITUDE and LONGITUDE
				if( !empty($line[self::$indexes['POSTAL_CODE']]) ){

					$postcode = $line[self::$indexes['POSTAL_CODE']];
					self::$message .= "<div class='notice notice-info'>". $postcode."</div>";

					// google version
					// $postCodeNice = urlencode($postcode);

					// Free version
					$postCodeNice = preg_replace('/\s/', '', $postcode);

					if ( !empty($postCodesCache[$postCodeNice]) ){
						self::$message .= "<div class='notice notice-success'>Reused: ".$postCodesCache[$postCodeNice]['LATITUDE']." ".$postCodesCache[$postCodeNice]['LONGITUDE']."</div>";
						$dataSet['LATITUDE'] = $postCodesCache[$postCodeNice]['LATITUDE'];
						$dataSet['LONGITUDE'] = $postCodesCache[$postCodeNice]['LONGITUDE'];
					} else {
						// Get JSON results from this request
						$url = 'http://api.postcodes.io/postcodes/'.$postCodeNice;
						// Google option
						// $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$postCodeNice.'&components=country:UK&sensor=false&key=AIzaSyA0aCLMAFyTqYWqdEYZOdAhT-r0YlrNHDI');

						// Free option (only UK)

						// check headers
						if ( self::get_http_response_code($url) == '404' ) {
						   self::$message .= "<div class='notice notice-error'>Something went wrong. Status message: Postcode not found</div>";
						   // TO DO try with google api
						} elseif ( self::get_http_response_code($url) == '200' ) {
							$geo = file_get_contents($url);
							$geo = json_decode($geo, true);

							if ( $geo['status'] == 200 ) { // 'OK' using google, 200 using free api
								/*
								 * Get Lat & Long
								 */

								// Google option
								// $latitude = $geo['results'][0]['geometry']['location']['lat'];
								// $longitude = $geo['results'][0]['geometry']['location']['lng'];

								// Free option
								$latitude = $geo['result']['latitude'];
								$longitude = $geo['result']['longitude'];

								self::$message .= "<div class='notice notice-success'>".$latitude." ".$longitude." | ";
								$dataSet['LATITUDE'] = $latitude;
								$dataSet['LONGITUDE'] = $longitude;
								$postCodesCache[$postCodeNice] = array('LATITUDE' => $latitude,'LONGITUDE' => $longitude);
								self::$message .= " Cached: [".$postCodeNice."]</div>";

							} else {
								// just in case a different status than 200 and 404
								self::$message .= "<div class='notice notice-error'>Something went wrong. Status: ".$geo['status']."</div>";
							}
						}
					}
				}
				$careers[] = $dataSet;
			}
		}
		$JSON['career'] = $careers;

		$JSON = json_encode ( $JSON );

		// Save JSON to career.json
		self::$message .= "<div class='notice notice-success'>Saving JSON to careers.json.</div>";
		file_put_contents(get_template_directory().'/resources/careers.json', $JSON);

		if (get_template_directory().'/career.json') {
			self::$message .= "<div class='correct'>Saved</div>";
		} else {
			self::$message .= "<div class='notice notice-error'>Not saved.</div>";
		}

		self::$message .= "<hr>";
		self::$message .= "<div class='notice notice-success'>Added ".$n." careers.</div>";

		echo self::$message;
	}

	public static function get_http_response_code($url) {
	  $headers = get_headers($url);
	  $headers = explode(' ', $headers[0]);
	  return $headers[1];
	}


	/*
	** Check valid link
	*/

	public static function checkValidLink( $link ){

		$file_headers = self::checkHeaders( $link );

		//$this->save_history( $link , $file_headers );

		$headerStatus = trim(preg_replace('/\s\s+/', ' ', $file_headers[0] ));

		$allow_files = array( 'HTTP/1.1 200 OK' , 'HTTP/1.0 200 OK' );

		if( in_array( $headerStatus , $allow_files ) && !empty( $file_headers ) ) {
		    return true;
		} else {
		   	return false;
		}

	}

	/*
	** Check Headers
	*/

	public static function checkHeaders( $link ){

		$file_headers = @get_headers( $link );

		if( empty( $file_headers ) ){

			$curl = curl_init();
			curl_setopt_array( $curl, array(
			    CURLOPT_HEADER => true,
			    //CURLOPT_NOBODY => true,
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
			    CURLOPT_URL => $link ) );
			$file_headers = explode( "\n", curl_exec( $curl ) );
			curl_close( $curl );

		}

		return $file_headers;

	}


}
NRCareerLoader::init();

add_action( 'nrcareerloader_hook', array( 'NRCareerLoader', 'loadCareer' ) );
