<?php

/**

 * Ezayo functions and definitions

 *

 * @link https://developer.wordpress.org/themes/basics/theme-functions/

 *

 * @package Ezayo

 */



//define( 'GMAPS_API_KEY', 'AIzaSyColhqX3uNTGPeL0lfGsuE40nFzi_l_2yg' );





if ( ! function_exists( 'ezayo_setup' ) ) :

/**

 * Sets up theme defaults and registers support for various WordPress features.

 *

 * Note that this function is hooked into the after_setup_theme hook, which

 * runs before the init hook. The init hook is too late for some features, such

 * as indicating support for post thumbnails.

 */

function ezayo_setup() {

	/*

	 * Make theme available for translation.

	 * Translations can be filed in the /languages/ directory.

	 * If you're building a theme based on Ezayo, use a find and replace

	 * to change 'ezayo' to the name of your theme in all the template files.

	 */

	load_theme_textdomain( 'ezayo', get_template_directory() . '/languages' );



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



	/*

	 * Enable support for WooCommerce

	 */

	add_theme_support('woocommerce');



	// This theme uses wp_nav_menu() in one location.

	register_nav_menus( array(

		'menu-primary' => esc_html__( 'Primary Navigation', 'ezayo' ),

		'mobile-menu' => esc_html__( 'Mobile Navigation', 'ezayo' ),

		'footer-menu' => esc_html__( 'Inner Footer Menu', 'ezayo' ),

		'home-left-footer-menu' => esc_html__( 'Home Left Footer Menu', 'ezayo' ),

		'home-right-footer-menu' => esc_html__( 'Home Right Footer Menu', 'ezayo' ),

	) );



	/*

	 * Switch default core markup for search form, comment form, and comments

	 * to output valid HTML5.

	 */

	add_theme_support( 'html5', array(

		'search-form',

		'comment-form',

		'comment-list',

		'gallery',

		'caption',

	) );







	// Add theme support for selective refresh for widgets.

	add_theme_support( 'customize-selective-refresh-widgets' );

}

endif;

add_action( 'after_setup_theme', 'ezayo_setup' );



/**

 * Set the content width in pixels, based on the theme's design and stylesheet.

 *

 * Priority 0 to make it available to lower priority callbacks.

 *

 * @global int $content_width

 */

function ezayo_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'ezayo_content_width', 1100 );

}

add_action( 'after_setup_theme', 'ezayo_content_width', 0 );



/**

 * Register widget area.

 *

 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar

 */

function ezayo_widgets_init() {

	register_sidebar( array(

		'name'          => esc_html__( 'Sidebar', 'ezayo' ),

		'id'            => 'sidebar-right',

		'description'   => esc_html__( 'Add widgets here.', 'ezayo' ),

		'before_widget' => '<div id="%1$s" class="%2$s widget"><div class="uk-panel uk-panel-box">',

		'after_widget'  => '</div></div>',

		'before_title'  => '<h4 class="widget-title">',

		'after_title'   => '</h4>',

	) );

}

add_action( 'widgets_init', 'ezayo_widgets_init' );



/**

 * Enqueue scripts and styles.

 */

function ezayo_scripts() {



	// Get the WP Version global.

	global $wp_version;



	//wp_enqueue_style( 'ezayo-style', get_stylesheet_uri() );



	#css

	wp_enqueue_style('wp-mediaelement');

	wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/css/app.css' ,array(),'8.5');

	//wp_enqueue_style( 'select2' );



	#js

	wp_enqueue_script( 'uikit-js', get_template_directory_uri() . '/assets/vendor/uikit/js/uikit.min.js', array('jquery'), '2.27.4', true );

	wp_enqueue_script( 'ticker-js', get_template_directory_uri() . '/assets/js/jquery.marquee.min.js', false, '1.4.0', true );

	wp_enqueue_script( 'dotdot-js', get_template_directory_uri() . '/assets/vendor/jQuery.dotdotdot-master/src/jquery.dotdotdot.min.js', false, '1.8.3', true );

	wp_enqueue_script( 'fitvid-js', get_template_directory_uri() . '/assets/vendor/FitVids.js-master/jquery.fitvids.js', false, '1.1', true );



	wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/theme.js', false, '1.0.5', true );



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

		wp_enqueue_script( 'comment-reply' );

	}

}

add_action( 'wp_enqueue_scripts', 'ezayo_scripts' );



/**

 * Add a pingback url auto-discovery header for singularly identifiable articles.

 */

function ezayo_pingback_header() {

	if ( is_singular() && pings_open() ) {

		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';

	}

}

add_action( 'wp_head', 'ezayo_pingback_header' );







//Theme option

if( function_exists('acf_add_options_page') ) {



	acf_add_options_page(array(

		'page_title' 	=> 'Theme General Settings',

		'menu_title'	=> 'Theme Settings',

		'menu_slug' 	=> 'theme-general-settings',

		'capability'	=> 'edit_posts',

		'redirect'		=> false

	));



}



/**

 * Enable SVG uploads

 */

function cc_mime_types($mimes) {

	$mimes['svg'] = 'image/svg+xml';

	return $mimes;

}

add_filter('upload_mimes', 'cc_mime_types');



/**

 * Function for just returning the content of a particular page by the ID of that page

 *

 * @link https://css-tricks.com/snippets/wordpress/get-content-by-id/

 */

function get_the_content_by_id($post_id) {

	$page_data = get_page($post_id);

	if ($page_data)

		return $page_data->post_content;

	else

		return false;

}



function new_excerpt_more( $more ) {

	return '';

}

add_filter('excerpt_more', 'new_excerpt_more');



function check_user($params, $content = null){

	//check tha the user is logged in

	if ( !is_user_logged_in() ){

		//user is not logged in so show the content

		return '<div class="forgot-pass-link">'. $content . '</div>';

	}

	else {

		return;

	}

}



//add a shortcode which calls the above function

add_shortcode('notloggedin', 'check_user' );



/**

 * Custom template tags for this theme.

 */

require get_template_directory() . '/inc/template-tags.php';



/**

 * WC additions.

 *

 * @since Twenty Fifteen 1.0

 */

require get_template_directory() . '/inc/wc-custom-functions.php';



/**

 * WP Job Manager additions.

 *

 */

require get_template_directory() . '/inc/wpjm-custom-functions.php';



/**

 * Add Custom Widgets

 *

 */

require get_template_directory() . '/inc/widgets.php';



/**

 * Cookie admin and editor to exclude from GA tracking

 *

 */

function my_exclude_admin_cookie() {

    $expire_time = time() + 60 * 60 * 24 * 180;

    setcookie( 'user_is_admin', 'true', $expire_time, '/' );

}

if( current_user_can('editor') || current_user_can('administrator') ) {

    add_action('init', 'my_exclude_admin_cookie');

}


/*if( $_REQUEST['custom_call'] == 'vaneet' ) {
	add_action('init', 'sha_jrem_cron_job_copy', 10 );
}*/


add_filter( 'woocommerce_add_to_cart_validation', 'woo_custom_add_to_cart_before' );
function woo_custom_add_to_cart_before( $cart_item_data ) {
 
    global $woocommerce;
    $woocommerce->cart->empty_cart();
 
    // Do nothing with the data and return
    return true;
}


/* Start Schema Fields Added */
add_filter( 'wpjm_get_job_listing_structured_data', 'my_custom_web_schema_filter' );
function my_custom_web_schema_filter( $website_schema ){
	$website_schema['responsibilities'][] =  get_the_responsibilities( $post );
	$website_schema['qualifications'][] =  get_the_qualifications( $post );
	$website_schema['industry'][] =  get_the_industry( $post );
	$website_schema['educationRequirements'][] =  get_the_educationRequirements( $post );
	$website_schema['experienceRequirements'][] =  get_the_experienceRequirements( $post );
	$website_schema['hiringOrganization']['name'][] = get_the_companyname($post);
	
	return $website_schema;
	
}

function get_the_responsibilities( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'job_listing' !== $post->post_type ) {
		return '';
	}
	$job_duties=strip_tags($post->_job_duties);
	return apply_filters( 'the_responsibilities', $job_duties, $post );
}

function get_the_qualifications( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'job_listing' !== $post->post_type ) {
		return '';
	}
	$job_requirements=strip_tags($post->_job_requirements);
	return apply_filters( 'the_qualifications', $job_requirements, $post );
}

function get_the_industry( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'job_listing' !== $post->post_type ) {
		return '';
	}
	$industries		= wp_get_post_terms($post->ID, 'job_listing_industry', array("fields" => "names"));
	//return apply_filters( 'the_industry', $post->_yoast_wpseo_primary_job_industry, $post );
	return apply_filters( 'the_industry', $industries, $post );
}

function get_the_educationRequirements( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'job_listing' !== $post->post_type ) {
		return '';
	}

	return apply_filters( 'the_educationRequirements', $post->_job_qualification, $post );
}

function get_the_experienceRequirements( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'job_listing' !== $post->post_type ) {
		return '';
	}

	return apply_filters( 'the_experienceRequirements', $post->_job_experience, $post );
}

function get_the_companyname( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'job_listing' !== $post->post_type ) {
		return '';
	}

	$user_id		= $post->post_author;
	
	$is_search_post = get_post_meta($post->ID, '_search_firm_post', true) ? get_post_meta($post->ID, '_search_firm_post', true) : false; 
	
	if($is_search_post){
		$user_company	= get_post_meta($post->ID, '_custom_company_name', true);
	}else{
		$user_company	= get_user_meta($user_id, 'billing_company', true) ? get_user_meta($user_id, 'billing_company', true) : '';
	}
	return apply_filters( 'the_companyname', $user_company, $post );
}
/* End Schema Fields Added */