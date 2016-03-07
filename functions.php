<?php
/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - DEBUG
*
-------------------------------------------------------------------------------- */
/*function display_vars() {
	global $wp_query, $post, $product, $woocommerce, $WCS;

	if(current_user_can('activate_plugins')) : 
		echo '<pre>';
		print_r( $wp_query );
		echo '</pre>';

		echo '<pre>';
		print_r($post);
		echo '</pre>';

		echo '<pre>';
		print_r($product);
		echo '</pre>';

		echo '<pre>';
		print_r($woocommerce);
		echo '</pre>';

		echo '<pre>';
		print_r($WCS);
		echo '</pre>';
	endif;
}
add_action('wp','display_vars');*/

// ERROR HANDLING - DEBUG for Admins
if(current_user_can('activate_plugins')) :
	//error_reporting(E_ALL); // everything
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);// Report all errors except E_NOTICE
	//error_reporting(E_ERROR | E_WARNING | E_PARSE); // Report simple running errors
	else :
	error_reporting(0);
endif;

/*
get_stylesheet_directory_uri(); // Child Theme
get_template_directory_uri(); // Parent Theme
get_theme_root(); // /home/shambs/shambix.com/wp-content/themes
ABSPATH; // /home/shambs/shambix.com/
TEMPLATEPATH; // /home/shambs/shambix.com/wp-content/themes/wp-starter
STYLESHEETPATH; //  /home/shambs/shambix.com/wp-content/themes/shambix_v12
*/

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - SETUP
* Custom theme that works with its parent [WP] Starter https://github.com/Jany-M/WP-Starter
* Developed by Shambix @ http://www.shambix.com
* Please check for info https://github.com/Jany-M/WP-Starter-Child-Theme
*
-------------------------------------------------------------------------------- */

// ADD THEME SUPPORT
global $theme_name, $locale;
$theme = wp_get_theme();
$theme_name = $theme->get( 'TextDomain' ); //use this var when necessary, for inline translations eg. _e('Contact us', $theme_name);

function wp_starter_childtheme_setup() {
	global $theme_name;
	/*add_theme_support( 'post-formats',
		array( 
			'aside',   // title less blurb
			'gallery', // gallery of images
			'link',    // quick link to other site
			'image',   // an image
			'quote',   // a quick quote
			'status',  // a Facebook like status update
			'video',   // video 
			'audio',   // audio
			'chat'     // chat transcript 
		)
	);*/	
	//set_post_thumbnail_size(125, 125, true);   // default thumb size
	//add_theme_support( 'custom-background' );  // wp custom background
	//add_theme_support('automatic-feed-links'); // rss thingy
	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	
	// ADD LANGUAGE FILE
	// Uncomment to load po/mo files from a languages folder (you need to create it first)
	// If you create with PoEdit, it might give you an error since we are using a variable instead of theme name in plain text, in that case just temporarily use this
	//load_child_theme_textdomain( 'wp-starter-child'); //chanhe the theme name if you've changed the Text Domain of this child theme
	load_child_theme_textdomain( $theme_name, get_stylesheet_directory_uri() . '/languages' );
}
add_action('after_setup_theme','wp_starter_childtheme_setup');

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - CSS & JS
*
-------------------------------------------------------------------------------- */
function load_child_files() {

	// By default WP Starter loads jquery 2.1.4 - If it causes problems, please load this one
	/*wp_deregister_script( 'jquery' );
    wp_register_script('jquery', includes_url( '/js/jquery/jquery.js' ), '', '1.11.3');
    wp_enqueue_script( 'jquery' );*/
	
	// Browser Specific
	/*global $wp_styles;
	wp_register_style( 'ie7_css', ''.get_stylesheet_directory_uri().'/assets/css/ie7.css', array('custom_css'), '', screen');
	$wp_styles->add_data( 'ie7_css', 'conditional', 'IE 7' );
	wp_enqueue_style( 'ie7_css' );*/

	// Default CSS
	wp_register_style( 'custom_css', get_stylesheet_directory_uri().'/assets/css/style.css', array('bootstrap_css'), '', 'all');
	wp_enqueue_style( 'custom_css' );

	// Responsive CSS
	if(file_exists(get_stylesheet_directory_uri().'/assets/css/responsive.css')) {
		wp_register_style( 'resp_theme_css', get_stylesheet_directory_uri().'/assets/css/responsive.css', array('custom_css'), '', 'all');
		wp_enqueue_style( 'resp_theme_css' );
	}	
	
	// Print CSS
	if(file_exists(get_stylesheet_directory_uri().'/assets/css/print.css')) {
		wp_register_style( 'print_css', get_stylesheet_directory_uri().'/assets/css/print.css', array('resp_theme_css'), '', 'print');
		wp_enqueue_style( 'print_css' );
	}

}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
	add_action('wp_enqueue_scripts', 'load_child_files', 99);
}

// Add css for Backend Editor
function custom_editor_styles() {
    add_editor_style( get_stylesheet_directory_uri().'/assets/css/editor-style.css' );
}
if(file_exists(get_stylesheet_directory_uri().'/assets/css/editor-style.css')) {
	add_action( 'admin_init', 'custom_editor_styles' );
}

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - CUSTOM FILES & HELPERS
*
-------------------------------------------------------------------------------- */

// script to resize and cache images and more, download at  https://github.com/Jany-M/WP-Imager/
$wpimpager_child = STYLESHEETPATH.'/scripts/wp-imager.php';
$wpimpager_parent = TEMPLATEPATH.'/library/helpers/wp-imager.php';
if(is_file($wpimpager_child) || file_exists($wpimpager_child) || is_file($wpimpager_parent) || file_exists($wpimpager_parent)) { 
	include_once 'scripts/wp-imager.php';
}
// Include [WP] Starter scripts
include_once TEMPLATEPATH.'/library/wordpress/cool_scripts.php';
include_once TEMPLATEPATH.'/library/wordpress/shortcodes.php';

// Include WordPress Related
//include_once 'wordpress/custom_post_types.php'; // use this file to Add Custom Post Types and Custom Taxonomies
//include_once 'wordpress/custom_menus.php'; // use this file to add menus
//include_once 'wordpress/custom_sidebars_widgets.php'; // use this file to add sidebars and custom widgets
//include('wordpress/custom_meta_boxes.php'); // use this file to add custom meta boxes or edit system ones

// Include Custom scripts & functions

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - LOGIN SCREEN
*
-------------------------------------------------------------------------------- */

function custom_login_logo() {
	global $def_login_img_url, $def_login_img_w, $def_login_img_h;

	if(file_exists(dirname(__FILE__) . '/assets/img/logo.png')) {
		$login_img_url = get_stylesheet_directory_uri().'/assets/img/logo.png';
		$login_img_w = '200px';
		$login_img_h = '111px';
	} else {
		$login_img_url = $def_login_img_url;
		$login_img_w = $def_login_img_w;
		$login_img_h = $def_login_img_h;
	}
	?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(<?php echo $login_img_url; ?>);
			background-size: auto auto;
			padding-bottom: 0px;
			width: <?php echo $login_img_w; ?>;
			height: <?php echo $login_img_h; ?>;
		}
	</style>
<?php }
//add_action('login_head', 'custom_login_logo');

?>