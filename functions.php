<?php
/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - SETUP
* Custom theme that works with its parent [WP] Starter https://github.com/Jany-M/WP-Starter
* Developed by Shambix @ http://www.shambix.com
* Please check for info https://github.com/Jany-M/WP-Starter-Child-Theme
*
-------------------------------------------------------------------------------- */
global $theme_name;
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
	// Uncomment to load po/mo files from a languages folder (you need to create it first)
	//load_child_theme_textdomain( $theme_name, get_stylesheet_directory_uri() . '/languages' );
}
add_action('after_setup_theme','wp_starter_childtheme_setup');

// Include [WP] Starter scripts
include_once TEMPLATEPATH.'/library/wordpress/cool_scripts.php';
//include_once TEMPLATEPATH.'/library/wordpress/shortcodes.php';

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - CSS & JS
*
-------------------------------------------------------------------------------- */
function load_child_files() {
	
	// Browser Specific
	/*global $wp_styles;
	wp_register_style( 'ie7_css', ''.get_stylesheet_directory_uri().'/assets/css/ie7.css', array('custom_css'), '', screen');
	$wp_styles->add_data( 'ie7_css', 'conditional', 'IE 7' );
	wp_enqueue_style( 'ie7_css' );*/

	// Default CSS
	wp_register_style( 'custom_css', ''.get_stylesheet_directory_uri().'/assets/css/style.css', array('bootstrap_css'), '', 'all');
	wp_enqueue_style( 'custom_css' );

	// Responsive CSS
	if(file_exists(get_stylesheet_directory_uri().'/assets/css/responsive.css')) {
		wp_register_style( 'resp_theme_css', get_stylesheet_directory_uri().'/assets/css/responsive.css', array('custom_css'), '', 'all');
		wp_enqueue_style( 'resp_theme_css' );
	}	
	
	// Print CSS
	if(file_exists(get_stylesheet_directory_uri().'/assets/css/print.css')) {
		wp_register_style( 'print_css', ''.get_stylesheet_directory_uri().'/assets/css/print.css', array('resp_theme_css'), '', 'print');
		wp_enqueue_style( 'print_css' );
	}

}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
	add_action('wp_enqueue_scripts', 'load_child_files', 99);
}

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - CUSTOM FILES & HELPERS
*
-------------------------------------------------------------------------------- */

// Include WordPress Related
//include_once 'wordpress/custom_post_types.php'; // use this file to Add Custom Post Types and Custom Taxonomies
//include_once 'wordpress/custom_menus.php'; // use this file to add menus
//include_once 'wordpress/custom_sidebars_widgets.php'; // use this file to add sidebars and custom widgets
//include(get_stylesheet_directory_uri().'custom/wordpress/custom_meta_boxes.php'); // use this file to add custom meta boxes or edit system ones

// Include Custom scripts & functions


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

?>