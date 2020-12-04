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

	public function getValueOverTimeData( $ship = '', $timeline = 'quarters', $purpose = 'graph', $order = 'ASC' ) {
		$data = $this->getFinalPriceAverages( $ship, $order );

		return $this->process_data->processValueOverTimeData( $data, $timeline, $purpose );
	}

	public function getFinalPriceAverages( $ship = '', $order = 'ASC' ) {
		$datasets = [];

		if ( ! $ship ) {
			foreach ( $this->variables->getShips() as $s ) {
				$datasets[ $s ] = $this->queries->get_vessel_final_price_averages( $s, $order );
			}
		} elseif ( is_array( $ship ) ) {
			foreach ( $ship as $s ) {
				$datasets[ $s ] = $this->queries->get_vessel_final_price_averages( $s, $order );
			}
		} else {
			$datasets[ $ship ] = $this->queries->get_vessel_final_price_averages( $ship, $order );
		}

		return $datasets;
	}


}