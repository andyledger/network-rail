<?php

class BridgeStrikeMap {
  protected $bridge_strike_map_sheet_url;

  public function __construct( $bridge_strike_map_sheet_url )
  {
    $this->bridge_strike_map_sheet_url = $bridge_strike_map_sheet_url;
  }

  /**
   * convert csv from url to an array of datq
   * @return array or string in case of fail
   */
  public function convertCsvToArray()
  {
    $spreadsheet_data = [];

    if (($handle = fopen($this->bridge_strike_map_sheet_url, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $spreadsheet_data[] = $data;
        }

        fclose($handle);

        return $spreadsheet_data;
    }

    return 'Fail to read google sheet.';
  }

  public function createDataModel()
  {
    $csv = $this->convertCsvToArray();
    $data = [];

    for ($i=1; $i < count($csv); $i++) {
      if (strpos($csv[$i][1], ',')) {
        $position = explode(',', $csv[$i][1]); 
      } else {
        $position = ['none', 'none'];
      }

      $data[$i] = [
        'position' => [
          'lat' => floatval($position[0]),
          'lng' => floatval($position[1])
        ],
        'bridgeId' => $csv[$i][0],
        'numberOfBridgeStrikes' => $csv[$i][2],
        'cumulativeDelay' => $csv[$i][3],
        'worstIncidentDelay' => $csv[$i][4]
      ];
    }

    return $data;
  }
}