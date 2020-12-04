<?php namespace FridayFleet;

use Simplon\Mysql\Mysql;
use Simplon\Mysql\PDOConnector;

class Queries {

	private $dbConn;

	public function __construct() {
		// TODO: update to ENV variables
		$pdo = new PDOConnector(
			'178.128.47.241', // server
			'james', // user
			'letmeinplease', // password
			'sea3r' // database
		);

		$pdoConn = $pdo->connect( 'utf8', [] ); // charset, options

		// you could now interact with PDO for instance setting attributes etc:
		// $pdoConn->setAttribute($attribute, $value);
		$this->dbConn = new Mysql( $pdoConn );
	}

	public function get_vessel_final_price_averages( $deadweight_category = '', $order = 'ASC' ) {
		$query = 'SELECT * FROM vessel_final_price_averages';
		$bound_variables = [];

		if ( $deadweight_category ) {
			$bound_variables['deadweight_category'] = $deadweight_category;
			$query .= ' WHERE vessel_deadweight_category = :deadweight_category';
		}

		$query .= ' ORDER BY vessel_deadweight_category ASC, year ' . $order . ', quarter ' . $order;

		return $this->dbConn->fetchRowMany( $query, $bound_variables );
	}
}