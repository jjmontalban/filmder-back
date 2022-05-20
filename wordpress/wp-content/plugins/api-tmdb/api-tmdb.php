<?php

/**
 * Plugin name: Api TMDB
 * Plugin URI: https://jjmontalban.github.io/
 * Description: Get ratings information from external API (TMDB) in WordPress 
 * Author: JJ Montalban
 * Author URI: https://jjmontalban.github.io/
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: tmdb
 */

// If this file is access directly, abort!!!
defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

// Adding admin menu 
function tmdb_admin_menu()
{
    add_menu_page( "Api TMDB", "Api TMDB", 'activate_plugins', 'api-tmdb', 'tmdb_configuration_page');
}
add_action('admin_menu', 'tmdb_admin_menu');

// Adding Settings
function tmdb_settings()
{		
    register_setting('tmdb_config_group', 'tmdb_options', 'tmdb_sanitize');		
}
add_action('admin_init', 'tmdb_settings');

function tmdb_sanitize($input)
{
    return $input;
}



function tmdb_configuration_page()
{
    ?>
    <h2>Configuration Page</h2>
    <form method="post">
		<input type="submit" name="movies" class="button-primary" value="<?php  echo "Comprobar nuevas valoraciones";  ?>">
	</form>
    <?php if( isset( $_POST['movies'] ) ) { get_tmdb_api_data(); } ?>
    <?php

}


function get_tmdb_api_data() 
{
    
    $args = array(
        'method' => 'GET'
    );
    
    $params = array(
        'api_key' => 'b6ed96d048594e24a1b84f33f7244ce0',
        'account_id' => '5afda9dc0e0a267ec600010e',
        'lang' => 'es-ES',
        'session_id' => '594745b80089c5559b0e2cc4eb11278155c00e72',
        'sort_by' => 'created_at.asc'
    );
    
    $url = 'https://api.themoviedb.org/3/account/'. $params['account_id'] . 
    '/rated/movies?api_key=' . $params['api_key'] . 
    '&language=' . $params['lang'] . 
    '&session_id=' . $params['session_id'] . 
    '&sort_by=' . $params['sort_by'];
    
	$response = wp_remote_get( $url, $args );
    
	if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
		return "Something went wrong: $error_message";
	} 

    $body = wp_remote_retrieve_body( $response );		
    $ratings = json_decode($body, true);		
    $total_pages = $ratings['total_pages']; 	
    $total_results = $ratings['total_results'];
    $cont = 0;

    if( isset( $ratings ) ) 
    {
        if( wp_count_posts('movie')->publish < $total_results ) 
        {
            for( $page = 1; $page <= $total_pages; $page++ ) 
            {
                $url = $url . '&page=' . $page;
                $response = wp_remote_get( $url, $args );
                $body = wp_remote_retrieve_body( $response );
                $ratings = json_decode($body, true);
                $results = $ratings['results'];

                foreach( $results as $movie )
                {
                    // Chek if exist movie with same tmdb_id
                    //https://developer.wordpress.org/reference/functions/get_posts/
                    $args = array(
                        'post_type'  => 'movie',
                        'meta_query' => array(
                            array(
                                'key'   => 'tmdb_id',
                                'value' => $movie['id'],
                            )
                        )
                    );
                    if( empty( get_posts( $args ) ) )
                    {
                        $movie_id = wp_insert_post( array(
                            'post_type' => 'movie',
                            'post_title' => $movie['title'],
                            'post_status' => 'publish'
                        ));
    
                        if( $movie_id ) 
                        {
                            // Get US poster
                            $url_en = 'https://api.themoviedb.org/3/movie/' . $movie['id'] . 
                                   '?api_key=' . $params['api_key'] . 
                                   '&language=en-US';
                            $response_en = wp_remote_get( $url_en );
    
                            if ( is_wp_error( $response_en ) ) {
                                $error_message = $response_en->get_error_message();
                                return "Something went wrong: $error_message";
                            } 
                               
                            $body_en = wp_remote_retrieve_body( $response_en );		
                            $movie_en = json_decode($body_en, true);		
                            $movie['poster_path'] = $movie_en['poster_path'];
                            $url_img = 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'];
    
                            generate_featured_image( $url_img, $movie_id );

                            add_post_meta( $movie_id, 'original_title', $movie['original_title'] );
                            add_post_meta( $movie_id, 'tmdb_id', $movie['id'] );
                            add_post_meta( $movie_id, 'release_date', $movie['release_date'] );
                            add_post_meta( $movie_id, 'vote_avg', $movie['vote_average'] );
                            add_post_meta( $movie_id, 'vote_count', $movie['vote_count'] );
                            add_post_meta( $movie_id, 'rating', $movie['rating'] );
                            $cont++;
                        }

                    }
                }
            }
        }
    }
    echo( $cont . " Films sincronized..." );

}

/**
* Downloads an image from the specified URL and attaches it to a post as a post thumbnail.
*
* @param string $file    The URL of the image to download.
* @param int    $post_id The post ID the post thumbnail is to be associated with.
* @return string|WP_Error Attachment ID, WP_Error object otherwise.
*/
function generate_featured_image( $url_img, $movie_id ){
    // Set variables for storage, fix file filename for query strings.
    preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $url_img, $matches );
    if ( ! $matches ) {
         return new WP_Error( 'image_sideload_failed', __( 'Invalid image URL' ) );
    }

    $file_array = array();
    $file_array['name'] = basename( $matches[0] );

    // Download file to temp location.
    $file_array['tmp_name'] = download_url( $url_img );

    // If error storing temporarily, return the error.
    if ( is_wp_error( $file_array['tmp_name'] ) ) {
        return $file_array['tmp_name'];
    }

    // Do the validation and storage stuff.
    $id = media_handle_sideload( $file_array, $movie_id, $desc );

    // If error storing permanently, unlink.
    if ( is_wp_error( $id ) ) {
        @unlink( $file_array['tmp_name'] );
        return $id;
    }
    return set_post_thumbnail( $movie_id, $id );

}