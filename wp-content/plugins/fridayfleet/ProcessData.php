<?php namespace FridayFleet;


class ProcessData {

	protected $ship_types = [ // short label used internally => long label used in DB
		'new'   => 'average_new_build',
		'5yr'   => 'average_5_year',
		'10yr'  => 'average_10_year',
		'15yr'  => 'average_15_year',
		'20yr'  => 'average_20_year',
		'25yr'  => 'average_25_year',
		'scrap' => 'average_scrap',
	];

	protected $first_month_of_quarter = [ // number of first month of each quarter
		1 => '01',
		2 => '04',
		3 => '07',
		4 => '10'
	];

	public function processFixedAgeValueData( $ship_data, $timeline = 'quarters', $purpose = 'graph' ) {
		$fixed_age_value_data = []; // the master array of all processed data


		if ( $purpose == 'table' && $timeline == 'quarters' ) {
			return $ship_data; // no need to do any more to the data for the table by quarters
		}

		foreach ( array_keys( $ship_data ) as $ship ) { // ship_data keys are ship types, so loop through them to get data

			if ( $purpose == 'graph' ) {
				foreach ( $this->ship_types as $short_label => $long_label ) {
					$fixed_age_value_data[ $ship ][ $short_label ]['label'] = ucfirst( $short_label );
				}
			}


			if ( $timeline == 'quarters' ) {

				foreach ( $ship_data[ $ship ] as $dataset ) {

					foreach ( $this->ship_types as $short_label => $long_label ) {

						if ( $dataset[ $long_label ] ) {
							$fixed_age_value_data[ $ship ][ $short_label ]['data'][ $dataset['year'] . $this->first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset[ $long_label ];
						} else {
							$fixed_age_value_data[ $ship ][ $short_label ]['data'][ $dataset['year'] . $this->first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
						}

					}

				}

			} elseif ( $timeline == 'years' ) {

				$data_by_year = [];

				if ( $ship_data && $ship ) {

					foreach ( $ship_data[ $ship ] as $dataset ) { // collect all data and store in arrays per year

						foreach ( $this->ship_types as $short_label => $long_label ) {

							if ( $dataset[ $long_label ] ) {
								$data_by_year[ $dataset['year'] ][ $short_label ][] = $dataset[ $long_label ];
							} else {
								$data_by_year[ $dataset['year'] ][ $short_label ][] = 0;
							}

						}

					}

					foreach ( $data_by_year as $year => $dataset ) {

						foreach ( $dataset as $dataset_label => $quarter_values ) {
							$number_of_quarters = count( $quarter_values );
							$year_total         = array_sum( $quarter_values );
							$average            = $year_total / $number_of_quarters;

							if ( $purpose == 'table' ) {
								$fixed_age_value_data[ $ship ][ $year ][ $dataset_label ] = $average ? $average : 0;
							} else { // purpose is graph
								$fixed_age_value_data[ $ship ][ $dataset_label ]['data'][ $year ] = $average ? $average : 0;
							}

						}

					}

				}

			}

			return $fixed_age_value_data;

		}

	}

	public function processDepreciationData( $data ) {
		$depreciation_data = [];

		foreach ( $data as $dataset ) {

			if ( $dataset['adjusted_price'] ) {
				$depreciation_data[ $dataset['comm_advice_year'] . $this->first_month_of_quarter[ $dataset['comm_advice_quarter'] ] ] = $dataset[ 'adjusted_price' ];
			} else {
				$depreciation_data[ $dataset['comm_advice_year'] . $this->first_month_of_quarter[ $dataset['comm_advice_quarter'] ] ] = 0;
			}
		}

		ksort($depreciation_data);

		return $depreciation_data;
	}

}