<?php namespace FridayFleet;

class GetData {

	protected $queries;
	protected $process_data;
	protected $variables;

	public function __construct() {
		$this->queries      = new Queries;
		$this->process_data = new ProcessData;
		$this->variables    = new Variables;
	}

	public function getFixedAgeValueData( $ship_db_slug = '', $timeline = 'quarters', $purpose = 'graph', $order = 'ASC' ) {
		$data = $this->getFinalPriceAverages( $ship_db_slug, $order );

		return $this->process_data->processFixedAgeValueData( $data, $timeline, $purpose );
	}

	public function getFinalPriceAverages( $ship_db_slug = '', $order = 'ASC' ) {
		$datasets = [];

		if ( ! $ship_db_slug ) {
			foreach ( $this->variables->getShips() as $s ) {
				$datasets[ $s ] = $this->queries->get_vessel_final_price_averages( $s, $order );
			}
		} elseif ( is_array( $ship_db_slug ) ) {
			foreach ( $ship_db_slug as $s ) {
				$datasets[ $s ] = $this->queries->get_vessel_final_price_averages( $s, $order );
			}
		} else {
			$datasets[ $ship_db_slug ] = $this->queries->get_vessel_final_price_averages( $ship_db_slug, $order );
		}

		return $datasets;
	}


}