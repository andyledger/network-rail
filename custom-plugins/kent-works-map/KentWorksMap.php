<?php

class KentWorksMap {
  protected $kent_works_map_sheet_url;

  public function __construct( $kent_works_map_sheet_url )
  {
    $this->kent_works_map_sheet_url = $kent_works_map_sheet_url;
  }

  /**
   * convert csv from url to an array of datq
   * @return array or string in case of fail
   */
  public function convertCsvToArray()
  {
    $spreadsheet_data = [];

    if (($handle = fopen($this->kent_works_map_sheet_url, "r")) !== FALSE) {
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
      $position = explode(',', $csv[$i][0]);     

      $data[$i] = [
        'position' => [
          'lat' => floatval($position[0]),
          'lng' => floatval($position[1])
        ],
        'project' => $csv[$i][1],
        'passengerBenefit' => $csv[$i][2],
        'startDate' => $csv[$i][3],
        'completationDate' => $csv[$i][4],
        'status' => $csv[$i][5],
        'moreInfo' => $csv[$i][6]
      ];
    }

    return $data;
  }
}