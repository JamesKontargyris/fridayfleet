<?php namespace FridayFleet;

use Simplon\Mysql\Mysql;
use Simplon\Mysql\PDOConnector;
use Dotenv\Dotenv;

class Queries {

	private $dbConn;

	public function __construct() {
		$dotenv = Dotenv::createImmutable( ABSPATH );
		$dotenv->load();

		$pdo = new PDOConnector(
			$_ENV['SEA3R_DB_HOST'], // server
			$_ENV['SEA3R_DB_USER'], // user
			$_ENV['SEA3R_DB_PASSWORD'], // password
			$_ENV['SEA3R_DB_NAME'] // database
		);
//		$pdo = new PDOConnector(
//			'188.166.62.246', // server
//			'sea3r', // user
//			'C3R2020abc', // password
//			'sea3r' // database
//		);

		$pdoConn = $pdo->connect( 'utf8', [] ); // charset, options

		// you could now interact with PDO for instance setting attributes etc:
		// $pdoConn->setAttribute($attribute, $value);
		$this->dbConn = new Mysql( $pdoConn );
	}

	public function get_vessel_final_price_averages( $deadweight_category = '', $order = 'ASC' ) {
		$query           = 'SELECT * FROM vessel_final_price_averages';
		$bound_variables = [];

		if ( $deadweight_category ) {
			$bound_variables['deadweight_category'] = $deadweight_category;
			$query                                  .= ' WHERE vessel_deadweight_category = :deadweight_category';
		}

		$query .= ' ORDER BY vessel_deadweight_category ASC, year ' . $order . ', quarter ' . $order;

		return $this->dbConn->fetchRowMany( $query, $bound_variables );
	}

	public function get_vessel_prices_at_age( $build_date = '', $deadweight_category = '' ) {
		$bound_variables['build_date']                = $build_date;
		$bound_variables['deadweight_category'] = $deadweight_category;

		$query = 'call sp_getVesselPricesAtSpecificAge( :build_date, :deadweight_category )';

		return $this->dbConn->fetchRowMany( $query, $bound_variables );
	}
}