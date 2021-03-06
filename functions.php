<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - SETUP
* Custom theme that works with its parent [WP] Starter https://github.com/Jany-M/WP-Starter
* Developed by Shambix @ http://www.shambix.com
* Please check for info https://github.com/Jany-M/WP-Starter-Child-Theme
*
-------------------------------------------------------------------------------- */

//define('WP_STARTER_CHILD_VERS', '1.6.1');

// WP DEFAULTS (most wont work here, place into wp-config instead)
if(!defined('WP_HOME')) { define('WP_HOME', get_bloginfo('url')); }
if(!defined('WP_SITEURL')) { define('WP_SITEURL', get_bloginfo('url')); }
if(!defined('WP_POST_REVISIONS')) { define( 'WP_POST_REVISIONS', 3 ); }
if(!defined('EMPTY_TRASH_DAYS')) { define( 'EMPTY_TRASH_DAYS', 15 ); }
if(!defined('DISALLOW_FILE_EDIT')) { define( 'DISALLOW_FILE_EDIT', true ); }
if(!defined('IMAGE_EDIT_OVERWRITE')) { define( 'IMAGE_EDIT_OVERWRITE', true ); }
if(!defined('WP_AUTO_UPDATE_CORE')) { define( 'WP_AUTO_UPDATE_CORE', false ); }
if(!defined('ENFORCE_GZIP')) { define('ENFORCE_GZIP', true); }
if(!defined('COMPRESS_SCRIPTS')) { define('COMPRESS_SCRIPTS', true); }
if(!defined('COMPRESS_CSS')) { define('COMPRESS_CSS', true); }
if(!defined('CONCATENATE_SCRIPTS')) { define('CONCATENATE_SCRIPTS', true); }
if(!defined('AUTOMATIC_UPDATER_DISABLED')) { define( 'AUTOMATIC_UPDATER_DISABLED', true ); }
if(!defined('WP_ALLOW_REPAIR')) { define( 'WP_ALLOW_REPAIR', true ); }
//if(!defined('WP_MEMORY_LIMIT')) { define('WP_MEMORY_LIMIT', '512M'); }
//@ini_set('mysql.connect_timeout', 600);

// WPML ADJUSTED HOMEPAGE URL
if(function_exists('icl_get_home_url')) {
    define('HOMEPAGE', icl_get_home_url());
} else {
    define('HOMEPAGE', WP_HOME);
}

// WP STARTER FRAMEWORK PATHS - Only change if you know what you're doing
if(!defined('PARENT_THEME')) {
    define('PARENT_THEME', 'wp-starter'); // name of your custom parent template, if not wp-starter
}
if(!defined('WP_STARTER_LIB_PATH')) {
    define('WP_STARTER_LIB_PATH', TEMPLATEPATH.'/lib/');
}
if(!defined('WP_STARTER_LIB_URL')) {
    define('WP_STARTER_LIB_URL', get_template_directory_uri().'/lib/');
}
if(!defined('WP_STARTER_ASSETS_PATH')) {
    define('WP_STARTER_ASSETS_PATH', TEMPLATEPATH.'/assets/');
}
if(!defined('WP_STARTER_ASSETS_URL')) {
    define('WP_STARTER_ASSETS_URL', get_template_directory_uri().'/assets/');
}

// WP STARTER CHILD PATHS - Only change if you know what you're doing
if(!defined('WP_STARTER_CHILD_ASSETS_PATH')) {
	define('WP_STARTER_CHILD_ASSETS_PATH', STYLESHEETPATH.'/assets/');
}
if(!defined('WP_STARTER_CHILD_ASSETS_URL')) {
	define('WP_STARTER_CHILD_ASSETS_URL', get_stylesheet_directory_uri().'/assets/');
}
if(!defined('WP_STARTER_CHILD_LIB_PATH')) {
	define('WP_STARTER_CHILD_LIB_PATH', STYLESHEETPATH.'/lib/');
}
if(!defined('WP_STARTER_CHILD_LANG')) {
	define('WP_STARTER_CHILD_LANG', STYLESHEETPATH.'/languages/'); // 'languages' is compatible with WPML
}

// THEME
if(!defined('PARENT_THEME')) {
    define('PARENT_THEME', 'avoir'); // name of your custom parent template, if not wp-starter
}
$theme_child = wp_get_theme(PARENT_THEME); // child
if(!defined('TEXT_DOMAIN') && $theme_child->get(TEXT_DOMAIN) != '') {
	define('TEXT_DOMAIN', $theme_child->get(TEXT_DOMAIN));
} else {
    define('TEXT_DOMAIN', PARENT_THEME);
}
if(!defined('THEME_NAME')) {
	define('THEME_NAME', $theme_child->get('Name'));
}

// WPML - DEFAULT SITE LANG
if(array_key_exists('sitepress', $GLOBALS)) {
    global $locale, $sitepress;
	$deflang = $sitepress->get_default_language(); // This is WP default lang, as set from WPML
    global $deflang;
	if(defined('ICL_LANGUAGE_CODE')) {
        global $lang;
		$lang = ICL_LANGUAGE_CODE;
	}
} else {
	$lang = $locale; //set your default lang
    //$lang = '';
}
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);

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
	load_child_theme_textdomain( TEXT_DOMAIN, WP_STARTER_CHILD_LANG);
}
add_action('after_setup_theme','wp_starter_childtheme_setup');

// CONTENT WIDTH FOR EMBEDS
// Set Jetpack galleries width
if ( ! isset( $content_width ) ) {
	$content_width = 1170; // Bootstrap default
}

/* some ref functions
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

// ERROR HANDLING - DEBUG for Admins
if(current_user_can('activate_plugins')) :
	//ini_set('error_reporting', E_ALL); // everything
	ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT);// Report all errors except E_NOTICE and Strict Standards
	//ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE); // Report simple running errors
else :
	ini_set('error_reporting', 0);
endif;

ini_set('log_errors',TRUE);
if (defined('ABSPATH')) {
	$path_to_err_log = ABSPATH; // defined in wp-config - root of wp
} else {
	$path_to_err_log = dirname(dirname(dirname(dirname(__FILE__)))) . '/'; // custom path - defaults to root of wp
}
ini_set('error_log', $path_to_err_log.'error_log.txt');

if(file_exists(WP_STARTER_CHILD_ASSETS_LIB_PATH.'debug_tools.php')) {
    include_once WP_STARTER_CHILD_ASSETS_LIB_PATH.'debug_tools.php';
}


/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - CSS & JS
*
-------------------------------------------------------------------------------- */

function load_child_files() {

	// Keep in mind that Bootstrap and FontAwesome are already loaded through WP-Starter (parent theme), if you want you can deregister them and/or load them again here

	/*wp_deregister_script( 'boostrap_js' );
	wp_deregister_style('bootstrap_css');
	wp_deregister_style('fontawesome_css');
	*/

	// By default WP loads its own version of jQuery - I prefer to load the version I want
	wp_deregister_script( 'jquery' );

	/* ------------------------------------------------
	| Popular CDNs for JS libraries
	|
	| https://cdnjs.com/libraries/jquery/
	| https://developers.google.com/speed/libraries/
	| ________________________________________________ */

	// Latest jQuery - IE < 9 not supported
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1');
	// Latest 2x
	//wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), '2.2.4');
	// Latest 1x
	//wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', '', '1.12.4');
	wp_enqueue_script( 'jquery' );

	// Default CSS
	wp_register_style( 'custom_css', WP_STARTER_CHILD_ASSETS_URL.'css/style.css', array('bootstrap_css'), '', 'all');
	wp_enqueue_style( 'custom_css' );

    // Browser Specific (example with IE7)
    if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'css/responsive.css')) {
    	global $wp_styles;
    	wp_register_style( 'ie7_css', WP_STARTER_CHILD_ASSETS_PATH.'css/ie7.css', array('custom_css'), '', 'screen');
    	$wp_styles->add_data( 'ie7_css', 'conditional', 'IE 7' );
    	wp_enqueue_style( 'ie7_css' );
    }

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
if(is_file($wpimpager_child) && file_exists($wpimpager_child)) {
	include_once WP_STARTER_CHILD_LIB_PATH.'helpers/wp-imager.php';
} else {
	add_action( 'admin_notices', 'wp_imager_admin_msg' );
}

/*if(file_exists(WP_STARTER_LIB_PATH.'wordpress/shortcodes.php'))
    include_once WP_STARTER_LIB_PATH.'wordpress/shortcodes.php';*/

// Include WordPress Related
//include_once WP_STARTER_CHILD_LIB_PATH.'wordpress/custom_post_types.php'; // use this file to Add Custom Post Types and Custom Taxonomies
/*if(file_exists(WP_STARTER_CHILD_LIB_PATH.'wordpress/custom_menus.php')) // use this file to add menus//include_once
    include_once WP_STARTER_CHILD_LIB_PATH.'wordpress/custom_menus.php'; */
/*if(file_exists(WP_STARTER_CHILD_LIB_PATH.'wordpress/custom_sidebars_widgets.php'))// use this file to add sidebars and custom widgets
    include_once WP_STARTER_CHILD_LIB_PATH.'wordpress/custom_sidebars_widgets.php';*/
//include_once WP_STARTER_CHILD_LIB_PATH.'custom/wordpress/custom_meta_boxes.php'); // use this file to add custom meta boxes or edit system ones

// Include Custom scripts & functions

// Include Custom scripts & functions
if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'scripts/custom.php')) {
    include_once(WP_STARTER_CHILD_ASSETS_PATH.'scripts/custom.php');
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - LOGIN SCREEN
*
-------------------------------------------------------------------------------- */

function custom_login_logo() {
	if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'img/logo.png')) {
		$login_img_url = WP_STARTER_CHILD_ASSETS_URL.'img/logo.png';
		$login_img_w = '200px';
		$login_img_h = '111px';
	} else {
        $def_login_img_url = WP_STARTER_ASSETS_URL.'img/shambix.png';
		$def_login_img_w = '100px';
		$def_login_img_h = '100px';
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
add_action('login_head', 'custom_login_logo');

// Custom Login form CSS
/*function wp_starter_login_css() {
    echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/library/css/login.css">';
}
add_action('login_head', 'wp_starter_login_css');*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - REMOVE WP DEFAULT SCRIPTS
*
-------------------------------------------------------------------------------- */

// Remove Top Admin Bar in Frontend - NOT active by default
function remove_wp_adminbar() {
	if( has_filter('show_admin_bar') ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
    wp_deregister_script( 'admin-bar' );
    wp_deregister_style( 'admin-bar' );
    remove_action('wp_footer','wp_admin_bar_render',1000);
	remove_action('init','wp_admin_bar_init');
	remove_action('wp_head','wp_admin_bar_render',1000);
	remove_action('wp_head','wp_admin_bar_css');
	remove_action('wp_head','wp_admin_bar_dev_css');
	remove_action('wp_head','wp_admin_bar_rtl_css');
	remove_action('wp_head','wp_admin_bar_rtl_dev_css');
	remove_action('wp_footer','wp_admin_bar_js');
	remove_action('wp_footer','wp_admin_bar_dev_js');
	add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );
	add_filter( 'show_admin_bar', '__return_false' );
	remove_action( 'personal_options', '_admin_bar_preferences' );
}
if (!is_admin()){
	//add_action('after_setup_theme', 'remove_wp_adminbar');
}

// Remove all emoji BS
function disable_wp_emojicons() {
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

add_filter( 'emoji_svg_url', '__return_false' );

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - MEMCACHED FLUSH
*
-------------------------------------------------------------------------------- */

// Flush Cache from Admin bar
/*function flush_memcache_button() {
	global  $wp_admin_bar,
            $_wp_using_ext_object_cache;

    if($_wp_using_ext_object_cache === false)
        return;

	if ( !is_user_logged_in() || !is_admin_bar_showing() )
		return false;

	if ( function_exists('current_user_can') && false == current_user_can('activate_plugins') )
		return false;

	$wp_admin_bar->add_menu( array(
		'parent' => '',
		'id' => 'flush_memcache_button',
		'title' => __( 'Flush Cache' ),
		'meta' => array( 'title' => __( 'Flush persistent object cache' )),
		'href' => wp_nonce_url( admin_url( 'index.php?action=delcachepage'), 'flush_memcache_button' ))
	);
}
if ( file_exists( WP_CONTENT_DIR . '/object-cache.php' ) ) {
	add_action( 'admin_bar_menu', 'flush_memcache_button', 35 );
}

function flush_memcache() {
	global $_wp_using_ext_object_cache;

    if($_wp_using_ext_object_cache === false)
        return;

	if ( function_exists('current_user_can') && false == current_user_can('activate_plugins') )
		return false;

	if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'delcachepage' && ( isset( $_GET[ '_wpnonce' ] ) ? wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'flush_memcache_button' ) : false ) ) {

		//error_log(shell_exec("sudo /usr/bin/systemctl restart memcached2")); // replace with your server's memcached flush command

		wp_redirect(admin_url().'?cache_type=object&cache_status=flushed');
		die();
	} else {
		wp_redirect(admin_url().'?cache_type=object&cache_status=not_flushed');
		die();
	}

}
if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'delcachepage' ) {
	add_action( 'admin_init', 'flush_memcache');
}*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - WP STARTER SCRIPTS
*
-------------------------------------------------------------------------------- */

if(file_exists(WP_STARTER_LIB_PATH.'scripts/setup_extra.php')) {
    include_once WP_STARTER_LIB_PATH.'scripts/setup_extra.php';
}

if(file_exists(WP_STARTER_LIB_PATH.'scripts/security.php')) {
    include_once WP_STARTER_LIB_PATH.'scripts/security.php';
}

if(file_exists(WP_STARTER_LIB_PATH.'wordpress/cool_scripts.php')) {
    include_once WP_STARTER_LIB_PATH.'wordpress/cool_scripts.php';
}

?>
