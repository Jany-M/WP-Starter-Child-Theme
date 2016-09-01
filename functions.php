<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - SETUP
* Custom theme that works with its parent [WP] Starter https://github.com/Jany-M/WP-Starter
* Developed by Shambix @ http://www.shambix.com
* Please check for info https://github.com/Jany-M/WP-Starter-Child-Theme
*
-------------------------------------------------------------------------------- */

define('WP_STARTER_CHILD_VERS', '1.4');

// WP DEFAULTS
if(!defined('WP_HOME'))
    define('WP_HOME', get_bloginfo('url'));
if(!defined('WP_SITEURL'))
    define('WP_SITEURL', get_bloginfo('url'));

// WPML ADJUSTED HOMEPAGE URL
if(function_exists('icl_get_home_url')) {
    define('HOMEPAGE', icl_get_home_url());
} else {
    define('HOMEPAGE', WP_HOME);
}

// WP STARTER FRAMEWORK PATHS
if(!defined('WP_STARTER_LIB_PATH'))
    define('WP_STARTER_LIB_PATH', TEMPLATEPATH.'/lib/');
if(!defined('WP_STARTER_LIB_URL'))
    define('WP_STARTER_LIB_URL', get_template_directory_uri().'/lib/');
if(!defined('WP_STARTER_ASSETS_PATH'))
    define('WP_STARTER_ASSETS_PATH', TEMPLATEPATH.'/assets/');
if(!defined('WP_STARTER_ASSETS_URL'))
    define('WP_STARTER_ASSETS_URL', get_template_directory_uri().'/assets/');

// WP STARTER CHILD PATHS
if(!defined('WP_STARTER_CHILD_ASSETS_PATH'))
	define('WP_STARTER_CHILD_ASSETS_PATH', STYLESHEETPATH.'/assets/');
if(!defined('WP_STARTER_CHILD_ASSETS_URL'))
	define('WP_STARTER_CHILD_ASSETS_URL', get_stylesheet_directory_uri().'/assets/');
if(!defined('WP_STARTER_CHILD_LIB_PATH'))
	define('WP_STARTER_CHILD_LIB_PATH', STYLESHEETPATH.'/lib/');
if(!defined('WP_STARTER_CHILD_LANG'))
	define('WP_STARTER_CHILD_LANG', STYLESHEETPATH.'/languages/'); // 'languages' is compatible with WPML

// THEME
$theme_child = wp_get_theme('wp-starter'); // child
if(!defined('TEXT_DOMAIN'))
	define('TEXT_DOMAIN', $theme_child->get('TextDomain'));
if(!defined('THEME_NAME'))
	define('THEME_NAME', $theme_child->get('Name'));

// WPML - DEFAULT SITE LANG
/*if(array_key_exists('sitepress', $GLOBALS)) {
	global $sitepress;
	$deflang = $sitepress->get_default_language(); // This is WP default lang, as set from WPML
    global $deflang;
	if(defined('ICL_LANGUAGE_CODE')) {
		$lang = ICL_LANGUAGE_CODE; // This is the
        global $lang;
	}
} else {
	//$lang = $locale; //set your default lang
    $lang = '';
}*/


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
* [WP] Starter Child Theme - DEBUG
*
-------------------------------------------------------------------------------- */

include_once(WP_STARTER_CHILD_ASSETS_LIB_PATH.'debug_tools.php');

global $locale;

// ADD THEME SUPPORT
function wp_starter_childtheme_setup() {
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
	load_child_theme_textdomain( THEME_DOMAIN, WP_STARTER_CHILD_LANG);
}
add_action('after_setup_theme','wp_starter_childtheme_setup');

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - CSS & JS
*
-------------------------------------------------------------------------------- */
function load_child_files() {

	// By default WP Starter loads jquery 2.1.4 - If it causes problems, deregister it and load a diff one
	/*wp_deregister_script( 'jquery' );
	// Latest jQuery - IE <9 not supported
	wp_register_script('jquery', 'http'.($_SERVER['SERVER_PORT'] == 443 ? 's' : '').'://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), '3.0.0');
	// This version is older and discontinued, but is more compatible with existing scripts & plugins
	//wp_register_script( 'jquery', '//code.jquery.com/jquery-1.11.2.min.js', '', '1.11.2');
	wp_enqueue_script( 'jquery' );*/

	// Browser Specific
	/*global $wp_styles;
	wp_register_style( 'ie7_css', ''.get_stylesheet_directory_uri().'/assets/css/ie7.css', array('custom_css'), '', screen');
	$wp_styles->add_data( 'ie7_css', 'conditional', 'IE 7' );
	wp_enqueue_style( 'ie7_css' );*/

	// Default CSS
	wp_register_style( 'custom_css', WP_STARTER_CHILD_ASSETS_URL.'css/style.css', array('bootstrap_css'), '', 'all');
	wp_enqueue_style( 'custom_css' );

	// Responsive CSS
	if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'css/responsive.css')) {
		wp_register_style( 'resp_theme_css', WP_STARTER_CHILD_ASSETS_URL.'css/responsive.css', array('custom_css'), '', 'all');
		wp_enqueue_style( 'resp_theme_css' );
	}

	// Print CSS
	if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'css/print.css')) {
		wp_register_style( 'print_css', WP_STARTER_CHILD_ASSETS_URL.'css/print.css', array('resp_theme_css'), '', 'print');
		wp_enqueue_style( 'print_css' );
	}

}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
	add_action('wp_enqueue_scripts', 'load_child_files', 99);
}

// Add css for Backend Editor
function custom_editor_styles() {
    add_editor_style(WP_STARTER_CHILD_ASSETS_URL.'css/editor-style.css' );
}
if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'css/editor-style.css')) {
	add_action( 'admin_init', 'custom_editor_styles' );
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - CUSTOM FILES & HELPERS
*
-------------------------------------------------------------------------------- */

function wp_imager_admin_msg() { ?>
	<div class="notice notice-error">
	    <p><?php _e('The file <code>wp-imager.php</code> was not found in the Child Template', THEME_DOMAIN); ?> <i><?php echo THEME_NAME; ?></i>.</p>
		<p><?php _e('Please download it from <a href="https://github.com/Jany-M/WP-Imager" target="_blank">GitHub</a> and place it in the folder <code>/lib/helpers/</code>', THEME_DOMAIN); ?>.</p>
	</div>
    <?php
}

// script to resize and cache images and more, download at  https://github.com/Jany-M/WP-Imager/
$wpimpager_child = WP_STARTER_CHILD_LIB_PATH.'helpers/wp-imager.php';
$wpimpager_parent = WP_STARTER_LIB_PATH.'helpers/wp-imager.php';
if(is_file($wpimpager_child) || file_exists($wpimpager_child)) {
	include_once WP_STARTER_CHILD_LIB_PATH.'helpers/wp-imager.php';
} elseif (is_file($wpimpager_parent) || file_exists($wpimpager_parent)) {
	include_once WP_STARTER_LIB_PATH.'helpers/wp-imager.php';
} else {
	add_action( 'admin_notices', 'wp_imager_admin_msg' );
}

include_once WP_STARTER_LIB.'wordpress/cool_scripts.php';
//include_once WP_STARTER_LIB.'wordpress/shortcodes.php';

// Include WordPress Related
//include_once WP_STARTER_CHILD_LIB.'wordpress/custom_post_types.php'; // use this file to Add Custom Post Types and Custom Taxonomies
//include_once WP_STARTER_CHILD_LIB.'wordpress/custom_menus.php'; // use this file to add menus
//include_once WP_STARTER_CHILD_LIB.'wordpress/custom_sidebars_widgets.php'; // use this file to add sidebars and custom widgets
//include_once WP_STARTER_CHILD_LIB.'custom/wordpress/custom_meta_boxes.php'); // use this file to add custom meta boxes or edit system ones

// Include Custom scripts & functions

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - LOGIN SCREEN
*
-------------------------------------------------------------------------------- */

function custom_login_logo() {
	global $def_login_img_url, $def_login_img_w, $def_login_img_h;

	if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'img/logo.png')) {
		$login_img_url = WP_STARTER_CHILD_ASSETS_URL.'img/logo.png';
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
