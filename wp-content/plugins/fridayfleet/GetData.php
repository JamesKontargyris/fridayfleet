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

	public function getValueOverTime_GraphData( $ship = '', $timeline = 'quarters' ) {
		$data = $this->getFinalPriceAverages( $ship );

		return $this->process_data->processValueOverTime_GraphData( $data, $timeline );
	}

	public function getValueOverTime_TableData( $ship = '', $timeline = 'quarters' ) {
		return $this->getFinalPriceAverages( $ship, $timeline );
	}

	public function getValueOverTime_XAxisLabels( $ship = '', $timeline = 'quarters' ) {
		$labels = [];

		if ( is_string( $ship ) ) {

			$data            = $this->getFinalPriceAverages( $ship, $timeline );
			$labels[ $ship ] = $this->process_data->processValueOverTime_XAxisLabels( $data, $timeline );

		} elseif ( is_array( $ship ) ) {

			foreach ( $ship as $s ) {
				$data         = $this->getFinalPriceAverages( $s, $timeline );
				$labels[ $s ] = $this->process_data->processValueOverTime_XAxisLabels( $data, $timeline );
			}

		} else {

			foreach ( $this->variables->getShips() as $s ) {
				$data         = $this->getFinalPriceAverages( $s, $timeline );
				$labels[ $s ] = $this->process_data->processValueOverTime_XAxisLabels( $data, $timeline );
			}

		}

		return $labels;

	}


	public function getFinalPriceAverages( $ship = '', $timeline = 'quarters' ) {
		$datasets = [];

		if ( ! $ship ) {
			foreach ( $this->variables->getShips() as $s ) {
				$datasets[ $s ] = $this->queries->get_vessel_final_price_averages( $s, $timeline );
			}
		} elseif ( is_array( $ship ) ) {
			foreach ( $ship as $s ) {
				$datasets[ $s ] = $this->queries->get_vessel_final_price_averages( $s, $timeline );
			}
		} else {
			$datasets[ $ship ] = $this->queries->get_vessel_final_price_averages( $ship, $timeline );
		}

		return $datasets;
	}


}