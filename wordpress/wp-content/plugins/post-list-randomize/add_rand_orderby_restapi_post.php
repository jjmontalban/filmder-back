<?php
/**
 * Plugin Name: REST API - Post list randomize
 * Description: Randomize the content list in REST API passing `orderby=rand` as parameter.
 * Version:     1.0.0
 * Author:      Felipe Elia | Codeable
 * Author URI:  https://codeable.io/developers/felipe-elia?ref=qGTOJ
 */

/**
 * Add `rand` as an option for orderby param in REST API.
 * Hook to `rest_{$this->post_type}_collection_params` filter.
 *
 * @param array $query_params Accepted parameters.
 * @return array
 */
function add_rand_orderby_rest_movie_collection_params( $query_params ) {
	$query_params['orderby']['enum'][] = 'rand';
	return $query_params;
}
add_filter( 'rest_movie_collection_params', 'add_rand_orderby_rest_movie_collection_params' );