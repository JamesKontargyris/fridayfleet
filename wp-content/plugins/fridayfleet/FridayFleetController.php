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

	public function getRawData() {
		return $this->get_data->getFinalPriceAverages();
	}

	public function getValueOverTime_GraphData( $ship = '', $timeline = 'quarters' ) {
		return $this->get_data->getValueOverTime_GraphData( $ship, $timeline );

	}

	public function getValueOverTime_XAxisLabels( $ship = '', $timeline = 'quarters' ) {
		return $this->get_data->getValueOverTime_XAxisLabels( $ship, $timeline );
	}

	public function getValueOverTime_TableData( $ship = '', $timeline = 'quarters' ) {
		return $this->get_data->getValueOverTime_TableData( $ship, $timeline );

	}

}