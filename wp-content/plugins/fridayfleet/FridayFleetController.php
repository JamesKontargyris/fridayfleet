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

	public function getColours() {
		return $this->variables->getColours();
	}

	public function getFixedAgeValueDataForGraph( string $ship_db_slug = '', $timeline = 'quarters', $purpose = 'graph', $order = 'ASC' ) {
		return $this->get_data->getFixedAgeValueData( $ship_db_slug, $timeline, $purpose, $order );

	}

	public function getFixedAgeValueDataForTable( string $ship_db_slug = '', $timeline = 'quarters', $purpose = 'table', $order = 'DESC' ) {
		return $this->get_data->getFixedAgeValueData( $ship_db_slug, $timeline, $purpose, $order );
	}

	public function getFixedAgeValueLatestDataPoint( string $ship_db_slug = '' ) {
		$ship_data   = $this->get_data->getFixedAgeValueData( $ship_db_slug, 'quarters', 'table', 'DESC' );
		$latest_data = [];

		foreach ( $ship_data as $ship_type => $datasets ) {
			$latest_data = array_slice( $datasets, 0, 1 );
		}

		return $latest_data[0];
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
		ksort($data); // sorts array by year, oldest to newest
		foreach ( $data as $year => $dataset ) {
			$last_year = $year;
		}

		return $last_year;
	}

}