<?php

class LevelCrossing {

  protected $levelCrossingSheetUrl;

  public function __construct( $levelCrossingSheetUrl )
  {
    $this->levelCrossingSheetUrl = $levelCrossingSheetUrl;
  }

  /**
   * [get_csv description]
   * @return [type] [description]
   */
  protected function getCsv()
  {
    if (($handle = fopen($this->levelCrossingSheetUrl, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $spreadsheet_data[] = $data;
        }
        fclose($handle);
        return $spreadsheet_data;
    }
    return 'Fail to read google sheet.';
  }

  protected function createRiskValue($str) {
    preg_match_all('!\d+!', $str, $number);
    preg_match_all('/[A-M]/', $str, $letter);
    
    $result['number'] = $number[0][0]; 
    $result['letter'] = $letter[0][0];

    $alphabet = range('M', 'A');
    
    if ( array_search($result['letter'], $alphabet) == 0) {
      $result = 14 - $result['number'];
    } else {
      $result = (array_search($result['letter'], $alphabet) * 13) + (14 - $result['number']);
    }
    
    return $result;
  }

  public function getData()
  {
    $csv = $this->getCsv();
    $data = [];

    for ($i=1; $i < count($csv); $i++) {
      $position = explode(',', $csv[$i][0]);     
      $lineSpeed = explode(' ', $csv[$i][9]);

      $data[$i] = [
        'position' => [
          'lat' => floatval($position[0]),
          'lng' => floatval($position[1])
        ],
        'crossingName'=> $csv[$i][1],
        'crossingType'=> $csv[$i][2],
        'location'=> $csv[$i][3],
        'currentAssessmentDate'=> $csv[$i][4],
        'nextAssessmentDueDate'=> $csv[$i][5],
        'riskScore'=> $csv[$i][6],
        'riskScoreNumber' => $this->createRiskValue($csv[$i][6]),
        'keyRiskDrivers'=> explode(PHP_EOL, $csv[$i][7]),
        'typeOfTrain'=> $csv[$i][8],
        'lineSpeed'=> $lineSpeed[0],
        'numberTrainsPerDay'=> $csv[$i][10],
        'census'=> $csv[$i][11],
        'currentProtectionArrangements'=> explode(PHP_EOL, $csv[$i][12]),
        'recordedIncidentHistory'=> $csv[$i][13],
        'elrMilesYards' => $csv[$i][14]
      ];
    }

    return $data;
  }
}