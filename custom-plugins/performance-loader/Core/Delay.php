<?php

class Delay {

	protected $delayId;
	protected $googleSheetUrl;

	public function __construct( $googleSheetUrl, $delayId )
	{
		$this->googleSheetUrl = $googleSheetUrl;
		$this->delayId = $delayId;
	}

	/**
	 * Build the url with the id of the tab
	 * @return [string]
	 */
	protected function getUrl()
	{
		return $spreadsheet_url = $this->googleSheetUrl."?gid=".$this->delayId."&output=csv";
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

	public function getData()
	{
		$csv = $this->getCsv();
		$data = [];
		for ($i=2; $i < 25 ; $i++) { 
			$data[$csv[$i][0]] = [
				$csv[$i][1],
				$csv[$i][2],
				$csv[$i][3],
				$csv[$i][4],
				$csv[$i][5],
				$csv[$i][6],
				$csv[$i][7],
			];
		}
		return $data;
	}
}