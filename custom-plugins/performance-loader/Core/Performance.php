<?php

class Performance {

	protected $googleSheetUrl;

	public function __construct( $googleSheetUrl )
	{
		$this->googleSheetUrl = $googleSheetUrl;
	}

	/**
	 * Build the url
	 * @return [string]
	 */
	protected function getUrl()
	{
		return $spreadsheet_url = $this->googleSheetUrl."?output=csv";
	}

	/**
	 * [get_csv description]
	 * @return [type] [description]
	 */
	protected function getCsv()
	{
		if (($handle = fopen($this->getUrl(), "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        $spreadsheet_data[] = $data;
		    }
		    fclose($handle);
		    return $spreadsheet_data;
		}

		return 'Fail to read google sheet.';
	}

	public function getTocs(){
		$csv = $this->getCsv();
		$tocs = [];

		for ($i=3; $i < 26; $i++) { 
			$tocs[$csv[$i][0]] = [];
		}

		return $tocs;
	}

	public function getData()
	{
		$csv = $this->getCsv();
		$data = [];

		$data['headings']['previous-year'] = $csv[2][2];
		$data['headings']['this-year'] = $csv[2][3];

		for ($i=3; $i < 26 ; $i++) { 
			$data['tocs'][$csv[$i][0]] = [
				'Customer Satisfaction' => $csv[$i][1],
				'PPM' => [
					$csv[$i][2], 
					$csv[$i][3], 
					$csv[$i][4]
				],
				'CaSL' => [
					$csv[$i][5],
					$csv[$i][6],
					$csv[$i][7]	
				]
			];
		}

		return $data;
	}
}