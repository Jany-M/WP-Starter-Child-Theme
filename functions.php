<?php
/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - SETUP
* Custom theme that works with its parent [WP] Starter https://github.com/Jany-M/WP-Starter
* Developed by Shambix @ http://www.shambix.com
* Version 1
*
-------------------------------------------------------------------------------- */
global $theme_name;

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
	
	// Default CSS
	wp_register_style( 'custom_css', ''.get_stylesheet_directory_uri().'/assets/css/style.css', array('bootstrap_css'), '', 'all');
	wp_enqueue_style( 'custom_css' );

	// Browser Specific
	/*global $wp_styles;
	wp_register_style( 'ie7_css', ''.get_stylesheet_directory_uri().'/assets/css/ie7.css', array('custom_css'), '', screen');
	$wp_styles->add_data( 'ie7_css', 'conditional', 'IE 7' );
	wp_enqueue_style( 'ie7_css' );*/
	
	// Responsive CSS
	if(file_exists(get_stylesheet_directory_uri().'/assets/css/responsive.css')) {
		wp_register_style( 'resp_theme_css', get_stylesheet_directory_uri().'/assets/css/responsive.css', array('custom_css'), '', 'all');
		wp_enqueue_style( 'resp_theme_css' );
	}	
	
	// Print CSS
	/*wp_register_style( 'print_css', ''.get_stylesheet_directory_uri().'/assets/css/print.css', array('resp_theme_css'), '', 'screen');
	wp_enqueue_style( 'print_css' );*/

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

?>