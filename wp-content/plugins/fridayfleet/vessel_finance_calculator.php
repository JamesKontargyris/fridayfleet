<?php

add_action( "wp_ajax_update_vessel_finance_calculator", "update_vessel_finance_calculator" );
add_action( "wp_ajax_nopriv_update_vessel_finance_calculator", "update_vessel_finance_calculator" );

function update_vessel_finance_calculator() {
	$form_data_array = $_REQUEST['form_data'];
	$form_data       = [];

	// form_data is structured like this:
	// array =>
	//     0 =>
	//        array =>
	//                'name' => 'build-date'
	//                'value' => '1 January 2021'
	// etc.

	foreach ( $form_data_array as $form_data_group ) {
		$form_data[ trim( $form_data_group['name'] ) ] = trim( $form_data_group['value'] );
	}
	get_template_part( 'template-parts/partials/partial', 'vessel-finance-calculator-graph-and-data', [ 'form_data' => $form_data ] );

	die(); // necessary for AJAX calls
}
