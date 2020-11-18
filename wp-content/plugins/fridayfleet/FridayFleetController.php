<?php namespace FridayFleet;


class FridayFleetController {

	protected $get_data;
	protected $process_data;
	protected $ships;
	protected $colours;
	protected $variables;

	public function __construct() {
		$this->get_data     = new GetData;
		$this->process_data = new ProcessData;
		$this->variables    = new Variables;
	}

	public function getShips() {
		return $this->variables->getShips();
	}

	public function getColours() {
		return $this->variables->getColours();
	}

	public function getValueOverTimeDataForGraph( $ship = '', $timeline = 'quarters', $purpose = 'graph' ) {
		return $this->get_data->getValueOverTimeData( $ship, $timeline, $purpose );

	}

	public function getValueOverTimeDataForTable( $ship = '', $timeline = 'quarters', $purpose = 'table' ) {
		return $this->get_data->getValueOverTimeData( $ship, $timeline, $purpose );
	}

	public function getNumberOfDatasets( $data = [], $array_key = 'data' ) {
		$no_of_datasets = 0;
		foreach ( $data as $dataset ) {
			if ( array_key_exists( $array_key, $dataset ) ) {
				$no_of_datasets ++;
			}
		}

		return $no_of_datasets;
	}

	public function getLastYearOfData( $data = [] ) {
		$last_year = 0;
		foreach ( $data as $year => $dataset ) {
			$last_year = $year;
		}

		return $last_year;
	}

}