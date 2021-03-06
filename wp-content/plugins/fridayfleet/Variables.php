<?php namespace FridayFleet;


class Variables {

	protected $ships;
	protected $colours;

	public function __construct() {
		$this->colours      = [
			'82, 227, 225', // blue
			'160, 228, 38', // green
			'253, 241, 72', // yellow
			'255, 171, 0', // orange
			'240, 80, 174', // pink
			'221, 28, 26', // red
			'158, 92, 196', // purple
		];
	}

	public function getColours() {
		return $this->colours;
	}
}