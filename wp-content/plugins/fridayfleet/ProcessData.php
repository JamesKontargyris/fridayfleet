<?php namespace FridayFleet;


class ProcessData {

	public function processValueOverTimeData( $ship_data, $timeline = 'quarters', $purpose = 'graph' ) {
		$value_over_time_data   = []; // the master array of all processed data
		$first_month_of_quarter = [
			1 => '01',
			2 => '04',
			3 => '07',
			4 => '10'
		]; // number of first month of each quarter

		if ( $purpose == 'table' && $timeline == 'quarters' ) {
			return $ship_data; // no need to do any more to the data for the table by quarters
		}

		foreach ( array_keys( $ship_data ) as $ship ) { // ship_data keys are ship types, so loop through them to get data

			if ( $purpose == 'graph' ) {
				$value_over_time_data[ $ship ]['new']['label']   = 'New';
				$value_over_time_data[ $ship ]['5yr']['label']   = '5yr';
				$value_over_time_data[ $ship ]['10yr']['label']  = '10yr';
				$value_over_time_data[ $ship ]['15yr']['label']  = '15yr';
				$value_over_time_data[ $ship ]['20yr']['label']  = '20yr';
				$value_over_time_data[ $ship ]['25yr']['label']  = '25yr';
				$value_over_time_data[ $ship ]['scrap']['label'] = 'Scrap';
			}


			if ( $timeline == 'quarters' ) {

				foreach ( $ship_data[ $ship ] as $dataset ) {

					if ( $dataset['average_new_build'] ) {
						$value_over_time_data[ $ship ]['new']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_new_build'];
					} else {
						$value_over_time_data[ $ship ]['new']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}

					if ( $dataset['average_5_year'] ) {
						$value_over_time_data[ $ship ]['5yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_5_year'];
					} else {
						$value_over_time_data[ $ship ]['5yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}

					if ( $dataset['average_10_year'] ) {
						$value_over_time_data[ $ship ]['10yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_10_year'];
					} else {
						$value_over_time_data[ $ship ]['10yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}

					if ( $dataset['average_15_year'] ) {
						$value_over_time_data[ $ship ]['15yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_15_year'];
					} else {
						$value_over_time_data[ $ship ]['15yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}

					if ( $dataset['average_20_year'] ) {
						$value_over_time_data[ $ship ]['20yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_20_year'];
					} else {
						$value_over_time_data[ $ship ]['20yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}

					if ( $dataset['average_25_year'] ) {
						$value_over_time_data[ $ship ]['25yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_25_year'];
					} else {
						$value_over_time_data[ $ship ]['25yr']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}

					if ( $dataset['average_scrap'] ) {
						$value_over_time_data[ $ship ]['scrap']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = $dataset['average_scrap'];
					} else {
						$value_over_time_data[ $ship ]['scrap']['data'][ $dataset['year'] . $first_month_of_quarter[ $dataset['quarter'] ] ] = 0;
					}
				}

			} elseif ( $timeline == 'years' ) {

				$data_by_year = [];

				if ( $ship_data && $ship ) {

					foreach ( $ship_data[ $ship ] as $dataset ) { // collect all data and store in arrays per year

						if ( $dataset['average_new_build'] ) {
							$data_by_year[ $dataset['year'] ]['new'][] = $dataset['average_new_build'];
						} else {
							$data_by_year[ $dataset['year'] ]['new'][] = 0;
						}

						if ( $dataset['average_5_year'] ) {
							$data_by_year[ $dataset['year'] ]['5yr'][] = $dataset['average_5_year'];
						} else {
							$data_by_year[ $dataset['year'] ]['5yr'][] = 0;
						}

						if ( $dataset['average_10_year'] ) {
							$data_by_year[ $dataset['year'] ]['10yr'][] = $dataset['average_10_year'];
						} else {
							$data_by_year[ $dataset['year'] ]['10yr'][] = 0;
						}

						if ( $dataset['average_15_year'] ) {
							$data_by_year[ $dataset['year'] ]['15yr'][] = $dataset['average_15_year'];
						} else {
							$data_by_year[ $dataset['year'] ]['15yr'][] = 0;
						}

						if ( $dataset['average_20_year'] ) {
							$data_by_year[ $dataset['year'] ]['20yr'][] = $dataset['average_20_year'];
						} else {
							$data_by_year[ $dataset['year'] ]['20yr'][] = 0;
						}

						if ( $dataset['average_25_year'] ) {
							$data_by_year[ $dataset['year'] ]['25yr'][] = $dataset['average_25_year'];
						} else {
							$data_by_year[ $dataset['year'] ]['25yr'][] = 0;
						}

						if ( $dataset['average_scrap'] ) {
							$data_by_year[ $dataset['year'] ]['scrap'][] = $dataset['average_scrap'];
						} else {
							$data_by_year[ $dataset['year'] ]['scrap'][] = 0;
						}

					}

				}

				foreach ( $data_by_year as $year => $dataset ) {

					foreach ( $dataset as $dataset_label => $quarter_values ) {
						$number_of_quarters = count( $quarter_values );
						$year_total         = array_sum( $quarter_values );
						$average            = number_format( $year_total / $number_of_quarters, 2 );

						if ( $purpose == 'table' ) {
							$value_over_time_data[ $ship ][ $year ][ $dataset_label ] = $average ? $average : 0;
						} else { // purpose is graph
							$value_over_time_data[ $ship ][ $dataset_label ]['data'][ $year ] = $average ? $average : 0;
						}

					}

				}

			}

		}


		return $value_over_time_data;

	}

}