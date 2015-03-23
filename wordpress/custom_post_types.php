<?php
/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - CUSTOM POST TYPES
* Generally I would recommend the use of the Types plugin https://wordpress.org/plugins/types/ but in some cases you may need to code them yourself
* Version 1
*
-------------------------------------------------------------------------------- */
global $theme_name;

// Get Taxonomy Rewrite URL slug
function getrewritetaxslug ($tax){
	$getdataslug = get_taxonomy($tax);
	$dataslug = $getdataslug->rewrite['slug'];
	return $dataslug;
}

// Lista di custom taxonomy non linkate
function lista_tax ($nome_tax){
$terms = get_the_terms( $post->ID, $nome_tax );						
if ( $terms && ! is_wp_error( $terms ) ) : 
$tipi = array();
foreach ( $terms as $term ) {
	$tipi[] = $term->name;
}					
$tipo = join( ", ", $tipi );
return $tipo;
endif;
}

// De-Register theme post types
/*function remove_1() {   
    remove_action( 'init', 'create_package_post' );   
}
add_action( 'after_setup_theme','remove_1', 100 );*/


/* -------------------------------------------------------------------------------- 
*
* POST TYPES
*
-------------------------------------------------------------------------------- */

if(!function_exists('create_posttype_customblock')) {
    function create_posttype_customblock() {
            $labels = array(
                'name' => _x( 'Custom Blocks', 'post type general name', $theme_name ),
                'singular_name' => _x( 'Block', 'post type singular name', $theme_name ),
                'add_new' => _x( 'Add New', 'static block', $theme_name ),
                'add_new_item' => sprintf( __( 'Add New %s', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'edit_item' => sprintf( __( 'Edit %s', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'new_item' => sprintf( __( 'New %s', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'all_items' => sprintf( __( 'All %s', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'view_item' => sprintf( __( 'View %s', $theme_name ), __( 'Custom Block', $theme_name ) ),
                'search_items' => sprintf( __( 'Search %a', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'not_found' =>  sprintf( __( 'No %s Found', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', $theme_name ), __( 'Custom Blocks', $theme_name ) ),
                'parent_item_colon' => '',
                'menu_name' => __( 'Custom Blocks', $theme_name )

            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'customblock' ),
                'capability_type' => 'post',
                'has_archive' => /*'customblocks'*/false,
                'hierarchical' => false,
                'supports' => array( 'title', 'editor'/*, 'thumbnail', 'page-attributes' */),
                'menu_position' => 16
            );
    register_post_type( 'customblock', $args );
	}
}
// Uncomment to have this custom post type, or make your own
//add_action('init', 'create_posttype_customblock');


/* -------------------------------------------------------------------------------- 
*
* TAXONOMIES
*
-------------------------------------------------------------------------------- */

/*add_action( 'init', 'create_portfolio_categories', 1 );

function create_portfolio_categories() {
  $labels = array(
    'name' => _x( 'My Taxonomy Name', 'taxonomy general name', $theme_name ),
    'singular_name' => _x( 'My Taxonomy', 'taxonomy singular name', $theme_name ),
	'add_new' => _x( 'Add New', 'static block', $theme_name ),
    'add_new_item' => sprintf( __( 'Add New %s', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'edit_item' => sprintf( __( 'Edit %s', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'new_item' => sprintf( __( 'New %s', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'all_items' => sprintf( __( 'All %s', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'view_item' => sprintf( __( 'View %s', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'search_items' => sprintf( __( 'Search %a', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'not_found' =>  sprintf( __( 'No %s Found', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', $theme_name ), __( 'Taxonomy Item', $theme_name ) ),
    'parent_item_colon' => '',
    'menu_name' => __( 'My Tax', $theme_name )
  ); 	

  register_taxonomy('portfolio_category',array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'portfolio_category' ),
  ));
}

/* -------------------------------------------------------------------------------- 
*
* TAXONOMIES
*
-------------------------------------------------------------------------------- */

// Portfolio
/*function sh_portfolio_edit_columns($columns){  
        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Progetto'),
			'thumbnail_port' => __( 'Thumb'),
            "type_portfolio" => __( 'Tipologia')
        );    
        return $columns;  
}  
  
function sh_portfolio_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
            case 'type_portfolio':  
                echo get_the_term_list($post->ID, 'type_portfolio', '', ', ','');  
                break;
			 
			case 'thumbnail_port':
				$thumbnail = get_the_post_thumbnail($post->ID, array(150, 85));
				if( isset($thumbnail) ) {
					echo $thumbnail;
				} 
	        break;
        }  
}  

add_filter('manage_edit-portfolio_columns', 'sh_portfolio_edit_columns');  
add_action('manage_posts_custom_column', 'sh_portfolio_custom_columns'); */


?>