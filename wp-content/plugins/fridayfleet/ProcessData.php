<?php namespace FridayFleet;


class ProcessData {

	public function processValueOverTime_GraphData( $ship_data ) {
		$value_over_time_data = []; // the master array of all processed data

		foreach ( array_keys( $ship_data ) as $ship ) { // ship_data keys are ship sizes, so loop through them to get data
			$new       = '';
			$avg_5     = '';
			$avg_10    = '';
			$avg_15    = '';
			$avg_20    = '';
			$avg_25    = '';
			$avg_scrap = '';

			foreach ( $ship_data[ $ship ] as $dataset ) {
				$new       .= "'" . ( $dataset['average_new_build'] ? $dataset['average_new_build'] : 0 ) . "',";
				$avg_5     .= "'" . ( $dataset['average_5_year'] ? $dataset['average_5_year'] : 0 ) . "',";
				$avg_10    .= "'" . ( $dataset['average_10_year'] ? $dataset['average_10_year'] : 0 ) . "',";
				$avg_15    .= "'" . ( $dataset['average_15_year'] ? $dataset['average_15_year'] : 0 ) . "',";
				$avg_20    .= "'" . ( $dataset['average_20_year'] ? $dataset['average_20_year'] : 0 ) . "',";
				$avg_25    .= "'" . ( $dataset['average_25_year'] ? $dataset['average_25_year'] : 0 ) . "',";
				$avg_scrap .= "'" . ( $dataset['average_scrap'] ? $dataset['average_scrap'] : 0 ) . "',";
			}

			$value_over_time_data[ $ship ]['new']['data']             = $new;
			$value_over_time_data[ $ship ]['new']['data_label']       = 'New build';
			$value_over_time_data[ $ship ]['avg_5']['data']           = $avg_5;
			$value_over_time_data[ $ship ]['avg_5']['data_label']     = '5yr';
			$value_over_time_data[ $ship ]['avg_10']['data']          = $avg_10;
			$value_over_time_data[ $ship ]['avg_10']['data_label']    = '10yr';
			$value_over_time_data[ $ship ]['avg_15']['data']          = $avg_15;
			$value_over_time_data[ $ship ]['avg_15']['data_label']    = '15yr';
			$value_over_time_data[ $ship ]['avg_20']['data']          = $avg_20;
			$value_over_time_data[ $ship ]['avg_20']['data_label']    = '20yr';
			$value_over_time_data[ $ship ]['avg_25']['data']          = $avg_25;
			$value_over_time_data[ $ship ]['avg_25']['data_label']    = '25yr';
			$value_over_time_data[ $ship ]['avg_scrap']['data']       = $avg_scrap;
			$value_over_time_data[ $ship ]['avg_scrap']['data_label'] = 'Scrap';

		}

		return $value_over_time_data;
	}

	public function processValueOverTime_XAxisLabels( $data, $timeline = 'quarters' ) {
		$labels = '';

		foreach ( $data as $ship_data ) {

			foreach ( $ship_data as $dataset ) {
				if ( $timeline == 'quarters' ) {
					$labels .= "'" . $dataset['year'] . ' Q' . $dataset['quarter'] . "', ";
				} elseif ( $timeline == 'years' ) {
					$labels .= "'" . $dataset['year'] . "', ";
				}
			}

		}

		return $labels;
	}


}