<?php

namespace MuPlugins\ApprenticeshipSchemeLocationMap;

class Data {
  protected $url;

  public function __construct( $url )
  {
    $this->url = $url;
  }

  /**
   * convert csv from url to an array of datq
   * @return array or string in case of fail
   */
  public function convertCsvToArray()
  {
    $spreadsheet_data = [];

    if (($handle = fopen($this->url, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $spreadsheet_data[] = $data;
        }

        fclose($handle);

        return $spreadsheet_data;
    }

    return 'Fail to read google sheet.';
  }

  protected function from_postcode_to_lat_lng($postCode)
  {
    $url = 'http://api.postcodes.io/postcodes/'.$postCode;

    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch); 

    $geo = json_decode($output, true);

    if ( $geo['status'] == 200 ) {
      return [
        'lat' => $geo['result']['latitude'],
        'lng' => $geo['result']['longitude']
      ];
    }

    return '';
  }

  public function createDataModel()
  {
    $csv = $this->convertCsvToArray();
    $data = []; 

    for ($i=1; $i < count($csv); $i++) {
      $data[$i] = [
        'location' => $csv[$i][0],
        'postCode' => $csv[$i][1],
        'link' => $csv[$i][2],
        'position' => $this->from_postcode_to_lat_lng($csv[$i][1])
      ];
    }

    return $data;
  }
}