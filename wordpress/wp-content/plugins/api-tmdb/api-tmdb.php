<?php

/**
 * Plugin name: Api TMDB
 * Plugin URI: https://jjmontalban.github.io/
 * Description: Get ratings information from external API (TMDB) in WordPress 
 * Author: JJ Montalban
 * Author URI: https://jjmontalban.github.io/
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: query-apis
 */

// If this file is access directly, abort!!!
defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

add_action( 'admin_init' , 'callback_function_name');

function callback_function_name() {
    
    $arguments = array(
        'method' => 'GET'
    );

	$page = 1;
	
    $url_params = array(
        'api_key' => 'b6ed96d048594e24a1b84f33f7244ce0',
        'account_id' => '5afda9dc0e0a267ec600010e',
        'lan' => 'en-US',
        'session_id' => '594745b80089c5559b0e2cc4eb11278155c00e72',
        'sort_by' => 'created_at.asc',
        'page' => $page
    );

    $url = 'https://api.themoviedb.org/3/account/'. $url_params['account_id'] . 
            '/rated/movies?api_key=' . $url_params['api_key'] . 
            '&language=' . $url_params['lang'] . 
            '&session_id=' . $url_params['session_id'] . 
            '&sort_by=' . $url_params['sort_by'] . 
            '&page=' . $url_params['page'];
            
	$response = wp_remote_get( $url, $arguments );

	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		return "Something went wrong: $error_message";
	} 


		//url test: https://api.themoviedb.org/3/account/5afda9dc0e0a267ec600010e/rated/movies?api_key=b6ed96d048594e24a1b84f33f7244ce0&language=en-US&session_id=594745b80089c5559b0e2cc4eb11278155c00e72&sort_by=created_at.asc&page=1

    }