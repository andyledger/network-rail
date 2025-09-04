<?php

class Toc {

	protected $id;

	public function __construct($id)
	{
		$this->id = $id;
	}

	/**
	 * Build the url with the id of the tab
	 * @return [string]
	 */
	protected function getUrl()
	{
		$spreadsheet_url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSqvSSSli6tJwYW9tMAi-zzCGFuzQx4lB4OkZz3MjqnKoHRtbRsPLP0IkNw2nvi9d8efyF7PfwLve2M/pub?gid=".$this->id."&output=csv";
		return $spreadsheet_url;
	}

	/**
	 * [get_csv description]
	 * @return [type] [description]
	 */
	public function getCsv()
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

	public function getTocName()
	{
		$csv = $this->getCsv();
		return $tocName = $csv[18][0];
	}

	public function getTocNameLegend()
	{
		$csv = $this->getCsv();
		return $tocName = $csv[21][2];
	}

	/**
	 * [get_table description]
	 * @return [type] [description]
	 */
	public function getTable()
	{
		$csv = $this->getCsv();
		$tableData['Customer Satisfaction'] = $csv[0][1];
		for ($i=0; $i < 3; $i++) { 
			$tableData['RT'][$i] = $csv[2][$i+1];
			$tableData['PPM'][$i] = $csv[3][$i+1];
			$tableData['CaSL'][$i] = $csv[4][$i+1];
		}	
		return $tableData;
	}

	/**
	 * [get_dataset description]
	 * @return [type] [description]
	 */
	public function getDataSetChart()
	{
		$csv = $this->getCsv();
		for ($i=19; $i < 24; $i++) { 
			$dataSet[] = $csv[$i][3];
		}
		return $dataSet;
	}

	/**
	 * Get data from the table and from the chart in one array
	 * @return [type] [description]
	 */
	public function getAllData()
	{
		$addData = [];
		$allData['table'] = $this->getTable();
		$allData['chart'] = $this->getDataSetChart();
		$allData['name'] = $this->getTocName();
		$allData['shortName'] = $this->getTocNameLegend();
		return $allData;
	}

	/**
	 * Create json file
	 * @return [type] [description]
	 */
	public function createJson()
	{
		$json_string = json_encode($this->getAllData());
		$file = 'toc.json';
		file_put_contents($file, $json_string);
	}

}