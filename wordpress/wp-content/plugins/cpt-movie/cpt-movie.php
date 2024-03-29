<?php

/**
 * Plugin name: CPT Movie
 * Plugin URI: https://jjmontalban.github.io/
 * Description: Register a CPT Movie 
 * Author: JJ Montalban
 * Author URI: https://jjmontalban.github.io/
 * version: 0.1.0
 * License: GPL2 or later.
 * cpt-movies: custom post type, CPT
 * Text Domain: cpt-movie
 * Domain path: /lang
 */


/**
 * Translations
 *
 * @link https://decodecms.com/internacionalizar-plugin-wordpress/
 * .pot creation (wp-cli): "wp i18n make-pot . lang/cpt-movie.pot"
 */
function jj_plugin_load_textdomain(){
    
    $text_domain	= 'cpt-movie';
	$path_languages = basename(dirname(__FILE__)).'/lang/';
    
    load_plugin_textdomain($text_domain, false, $path_languages );
}
add_action('plugins_loaded', 'jj_plugin_load_textdomain');



/**
 * Register custom post type 'movie'.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * 
 */
function register_movie_post_type()
{
    /* Añado las etiquetas que aparecerán en el escritorio de WordPress */
    $labels = array(
        'name'               => _x( 'Movies', 'post type general name', 'cpt-movie' ),
        'singular_name'      => _x( 'Movie', 'post type singular name', 'cpt-movie' ),
        'menu_name'          => _x( 'Movies', 'admin menu', 'cpt-movie' ),
        'add_new'            => _x( 'Add New', 'movie', 'cpt-movie' ),
        'add_new_item'       => __( 'Add New Movie', 'cpt-movie' ),
        'new_item'           => __( 'New Movie', 'cpt-movie' ),
        'edit_item'          => __( 'Edit Movie', 'cpt-movie' ),
        'view_item'          => __( 'Movie', 'cpt-movie' ),
        'all_items'          => __( 'All Movies', 'cpt-movie' ),
        'search_items'       => __( 'Search Movie', 'cpt-movie' ),
        'not_found'          => __( 'No Movies.', 'cpt-movie' ),
        'not_found_in_trash' => __( 'No movies in Trash.', 'cpt-movie' )
    );

    /* Configuro el comportamiento y funcionalidades del nuevo custom post type */
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Show Movie Information', 'cpt-movie' ),
        'public'             => true,
        'show_in_rest'       => true,
        'rest_base'          => 'movies',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'movie' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'thumbnail')
    );
    register_post_type( 'movie', $args );
}
add_action('init', 'register_movie_post_type');

// Creamos dos taxonomías, genre y director para el custom post type "movie"

function create_movie_taxonomies() 
{
    /* Configuramos las etiquetas que mostraremos en el escritorio de WordPress */
    $labels = array(
        'name'             => _x( 'Genres', 'taxonomy general name', 'cpt-movie' ),
        'singular_name'    => _x( 'Genre', 'taxonomy singular name', 'cpt-movie' ),
        'search_items'     =>  __( 'Search for Genre', 'cpt-movie' ),
        'all_items'        => __( 'All Genres', 'cpt-movie' ),
        'parent_item'      => __( 'Root Genre', 'cpt-movie' ),
        'parent_item_colon'=> __( 'Root Genre:', 'cpt-movie' ),
        'edit_item'        => __( 'Edit Genre', 'cpt-movie' ),
        'update_item'      => __( 'Update Genre', 'cpt-movie' ),
        'add_new_item'     => __( 'Add New Genre', 'cpt-movie' ),
        'new_item_name'    => __( 'New Genre Name', 'cpt-movie' ),
    );
    
    /* Registramos la taxonomía y la configuramos como no jerárquica */
    register_taxonomy( 'genre', array( 'movie' ), array(
        'hierarchical'       => true,
        'labels'             => $labels,
        'show_ui'            => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'genre' ),
    ));    
}
// Lo enganchamos en la acción init y llamamos a la función create_movie_taxonomies() cuando arranque
add_action( 'init', 'create_movie_taxonomies', 0 );  

/**
 * Agrega un meta box al CPT Movie
 * https://developer.wordpress.org/reference/functions/add_meta_box/
 * add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args );
 * 
 * $id: para un CSS custom o hacer algo con Javascript
 * $title: mostrado en la parte superior del metabox
 * $callback es la función que dará uso a nuestro metabox
 * $page es donde queremos que se muestre nuestro metabox
 * $context es dónde queremos que se muestre nuestro metabox. «normal» «side» «advanced»
 */
function register_movie_meta_box() {
    add_meta_box( 'info-movie', __('Movie information', 'cpt-movie'), 'content_movie_meta_box', 'movie', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'register_movie_meta_box' );


/**
 * Añadir campos al metabox
 * @param WP_Post $post WordPress Post object
 */
function content_movie_meta_box( $movie ) 
{
       
    $original_title = get_post_meta( $movie->ID, 'original_title', true );
    $overview = get_post_meta( $movie->ID, 'overview', true );
    $release_date = get_post_meta( $movie->ID, 'release_date', true );
    $vote_avg = get_post_meta( $movie->ID, 'vote_avg', true );
    $vote_count = get_post_meta( $movie->ID, 'vote_count', true );
    $rating = get_post_meta( $movie->ID, 'rating', true );
    $tmdb_id = get_post_meta( $movie->ID, 'tmdb_id', true );
    
    //Usaremos este nonce field más adelante cuando guardemos en twp_save_meta_box()
    wp_nonce_field( 'movie_meta_box_nonce', 'meta_box_nonce' );
    
    ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="original_title"><?php _e('Original Title', 'cpt-movie') ?></label></th>
                <td><input type="text" name="original_title" id="original_title" value="<?php echo esc_html( $original_title ); ?>" /></td>
            </tr>
            <tr>
                <th><label for="release_date"><?php _e('Release Date', 'cpt-movie') ?></label></th>
                <td><input type="date" name="release_date" id="release_date" value="<?php echo esc_html( $release_date ); ?>"/></td>
            </tr>
            <tr>
                <th><label for="vote_avg"><?php _e('Vote Average', 'cpt-movie') ?></label></th>
                <td><input type="text" name="vote_avg" id="vote_avg" value="<?php echo esc_html( $vote_avg ); ?>" /></td>
            </tr>
            <tr>
                <th><label for="vote_count"><?php _e('Vote Count', 'cpt-movie') ?></label></th>
                <td><input type="text" name="vote_count" id="vote_count" value="<?php echo esc_html( $vote_count ); ?>" /></td>
            </tr>
            <tr>
                <th><label for="rating"><?php _e('Rating', 'cpt-movie') ?></label></th>
                <td><input type="text" name="rating" id="rating" value="<?php echo esc_html( $rating ); ?>" /></td>
            </tr>
	    </tbody>
    </table>
    <?php
}

//Guardar
function movie_save_meta_box( $movie_id ) {
    //Ignorar los autoguradados
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;
    //Valor nonce creado en content_movie_meta_box()
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'movie_meta_box_nonce' ) ) 
        return;
    //Si el usuario actual no puede editar
    if( !current_user_can( 'edit_post' ) ) 
        return;
    // Guardamos
    if( isset( $_POST['original_title'] ) )
        update_post_meta( $movie_id, 'original_title', wp_kses( $_POST['original_title'], $allowed ) );
    if( isset( $_POST['release_date'] ) )
        update_post_meta( $movie_id, 'release_date', wp_kses( $_POST['release_date'], $allowed ) );
    if( isset( $_POST['vote_avg'] ) )
        update_post_meta( $movie_id, 'vote_avg', wp_kses( $_POST['vote_avg'], $allowed ) );
    if( isset( $_POST['vote_count'] ) )
        update_post_meta( $movie_id, 'vote_count', wp_kses( $_POST['vote_count'], $allowed ) );
    if( isset( $_POST['rating'] ) )
        update_post_meta( $movie_id, 'rating', wp_kses( $_POST['rating'], $allowed ) );
    if( isset( $_POST['tmdb_id'] ) )
        update_post_meta( $movie_id, 'tmdb_id', wp_kses( $_POST['tmdb_id'], $allowed ) );
}

add_action( 'save_post', 'movie_save_meta_box' );

//Registro de ruta Rest API propia para acceder a las movies
function my_plugin_rest_route_for_post( $route, $post ) {
    if ( $post->post_type === 'movie' ) {
        $route = '/wp/v2/movies/' . $post->ID;
    }
 
    return $route;
}
add_filter( 'rest_route_for_post', 'my_plugin_rest_route_for_post', 10, 2 );



// Agregando los Post Meta Movies a la Rest API

add_action( 'rest_api_init', 'crear_campo_adicional_api_posts' );
 
function crear_campo_adicional_api_posts() 
{
	register_rest_field( 'movie', 'movie_data',  
                            array( 'get_callback' => 'read_movie_data' )
						);
}
 
function read_movie_data( $object ) {
	$post_id = $object['id'];
	return get_post_meta( $post_id );
}



// Get featured image Movie from Rest API 
// https://github.com/dalenguyen/wordpress-snippets/blob/master/src/get_featured_image_from_rest_api.php

add_action('rest_api_init', 'register_rest_movie_image' );

function register_rest_movie_image()
{
    register_rest_field( 'movie', 'movie_image',
                            array(
                                    'get_callback'    => 'get_rest_featured_image',
        )
    );
}

function get_rest_featured_image( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
        return $img[0];
    }
    return false;
}