<?php

class Stations {

	protected $stationsId;
	protected $googleSheetUrl;

	public function __construct( $googleSheetUrl, $stationsId )
	{
		$this->googleSheetUrl = $googleSheetUrl;
		$this->stationsId = $stationsId;
	}

	/**
	 * Build the url with the id of the tab
	 * @return [string]
	 */
	protected function getUrl()
	{
		return $spreadsheet_url = $this->googleSheetUrl."?gid=".$this->stationsId."&output=csv";
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
		for ($i=1; $i < 24 ; $i++) { 
			$data[$csv[$i][0]] = explode(",", $csv[$i][1]);
		}
		return $data;
	}
}