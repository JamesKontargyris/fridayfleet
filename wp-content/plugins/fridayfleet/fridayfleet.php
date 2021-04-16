<?php
/*
Plugin Name: Site Plugin for Friday Fleet
Description: Site specific code changes for Friday Fleet
*/
require_once( ABSPATH . 'vendor/autoload.php' ); // autoload composer packages

require_once( 'FridayFleetController.php' );
require_once( 'Variables.php' );
require_once( 'Queries.php' );
require_once( 'GetData.php' );
require_once( 'ProcessData.php' );

require_once( 'vessel_finance_calculator.php' );
require_once( 'helpers.php' );

// WordPress post queries

function get_posts_by_type( $post_type = 'post', $count = 9999, $offset = 0, $ignore_ids = [], $random = false, $orderby = 'none', $order = 'DESC', $meta_key = '' ) {

	$args = [
		'post_status'    => 'publish',
		'post_type'      => $post_type,
		'posts_per_page' => $count,
		'post__not_in'   => $ignore_ids,
		'offset'         => $offset,
		'orderby'        => $orderby,
		'order'          => $order,
		'meta_key'       => $meta_key,
	];

	if ( $random ) {
		$args['orderby'] = 'rand';
	}

	return new WP_Query( $args );
}

// Get ship type by database slug
/**
 * @param string $ship_type_db_slug
 *
 * @return false|int|WP_Post
 */
function get_ship_type_by_database_slug( $ship_type_db_slug = '' ) {


	$args = [
		'post_status'    => 'publish',
		'post_type'      => 'ship_type',
		'posts_per_page' => 1,
		'meta_key'       => 'ship_type_database_slug',
		'meta_value'     => strval( $ship_type_db_slug )
	];

	if ( $ship_type = get_posts( $args ) ) {
		return $ship_type[0];
	}

	return false;
}

// Get ship groups
/**
 * @param int $count
 * @param int $offset
 * @param array $ignore_ids
 * @param false $random
 *
 * @return WP_Query
 */
function get_ship_groups( $count = 9999, $offset = 0, $ignore_ids = [], $random = false ) {

	return get_posts_by_type( 'ship_group', $count, $offset, $ignore_ids, $random );
}

// Get ship type database slugs in an array
/**
 * @param int $count
 * @param int $offset
 * @param array $ignore_ids
 * @param false $random
 *
 * @return array|false
 */
function get_ship_type_database_slugs( $count = 9999, $offset = 0, $ignore_ids = [], $random = false ) {

	$ship_types = get_posts_by_type( 'ship_type', $count, $offset, $ignore_ids, $random );

	if ( ! $ship_types->have_posts() ) {
		return false;
	}

	$ship_type_db_slugs = [];

	while ( $ship_types->have_posts() ) {
		$ship_types->the_post();
		$ship_type_db_slugs[] = get_field( 'ship_type_database_slug' );
	}
	wp_reset_postdata();

	return $ship_type_db_slugs;
}

/**
 * Return all market notes in chronological order, latest first
 *
 * @param int $count
 * @param int $offset
 * @param array $ignore_ids
 * @param false $random
 *
 * @return WP_Query
 */
function get_market_notes( $count = 9999, $offset = 0, $ignore_ids = [], $random = false ) {

	return get_posts_by_type( 'market_note', $count, $offset, $ignore_ids, $random, 'meta_value', 'DESC', 'market_note_date' );
}

function get_market_notes_by_ship_type_id( $ship_type_id = 0, $count = 9999, $offset = 0, $ignore_ids = [], $random = false ) {

	$args = [
		'post_status'    => 'publish',
		'post_type'      => 'market_note',
		'posts_per_page' => $count,
		'post__not_in'   => $ignore_ids,
		'offset'         => $offset,
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
		'meta_key'       => 'market_note_date',
		'meta_query'     => [
			[
				'key'     => 'market_note_ship_types',
				'value'   => '"' . $ship_type_id . '"',
				'compare' => 'LIKE'
			]
		]
	];

	if ( $random ) {
		$args['orderby'] = 'rand';
	}

	return new WP_Query( $args );
}
