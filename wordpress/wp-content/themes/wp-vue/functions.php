<?php
/**
 * wp-vue functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-vue
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'wp_vue_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wp_vue_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wp-vue, use a find and replace
		 * to change 'wp-vue' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wp-vue', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'wp-vue' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'wp_vue_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'wp_vue_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_vue_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_vue_content_width', 640 );
}
add_action( 'after_setup_theme', 'wp_vue_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_vue_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wp-vue' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wp-vue' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wp_vue_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wp_vue_scripts() {
	wp_enqueue_style( 'wp-vue-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'wp-vue-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wp-vue-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_vue_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}




/**
 * Creacion de custom endpoint para que las tablas de clientes sean accesibles de la API Rest
 */


//Traer todos los customers
function get_customers_endpoint() {
    register_rest_route( 'v2', 'customers', array(
        'methods'  => 'GET',
        'callback' => 'get_customers',
    ) );
}

add_action( 'rest_api_init', 'get_customers_endpoint' );

function get_customers() {
	global $wpdb;
    
	$table = 'ps_customer';
	$sql = "SELECT * FROM $table";
	$result = $wpdb->get_results( $wpdb->prepare($sql) );

	return $result;
}


//Insertar nuevo customer

/**
   * Prepare the item for create or update operation
   *
   * @param WP_REST_Request $request Request object
   * @return WP_Error|object $prepared_item
   */
   function prepare_item_for_database( $request ) {
    return array();
  }


  function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','add_cors_http_header');



function post_customer_endpoint() {
    register_rest_route( 'v2', 'customer', array(
        'methods'  => 'POST',
		'callback' => 'post_customer',
    ) );
}

add_action( 'rest_api_init', 'post_customer_endpoint' );

function post_customer(WP_REST_Request $request) {
	global $wpdb;

	$data = $request->get_params();
	$result = $wpdb->insert('ps_customer', 
	array(  'firstname' => $data['firstname'],
			'lastname'  => $data['lastname'],
			'company'  => $data['company'],
			'email'  => $data['email'],
			'phone_1'  => $data['phone_1'],
			'phone_2'  => $data['phone_2'],
			'address_1'  => $data['address_1'],
			'address_2'  => $data['address_2'],
			'postcode'  => $data['postcode'],
			'city'  => $data['city'],
			'state'  => $data['state'],
			'country'  => $data['country'],
			'shop'  => $data['shop'],
			'cif'  => $data['cif'],
			'vat_number'  => $data['vat_number'],
			'date_add'  => $data['date_add'],
		));

	return $data;
}