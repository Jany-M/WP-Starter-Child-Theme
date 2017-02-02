<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - CUSTOM MENUS
* Here are some custom menus and walkers examples (based on Twitter Bootstrap structure)
*
-------------------------------------------------------------------------------- */

// Custom Header Menu
function wpstarter_header_nav() {
    wp_nav_menu(array(
		'theme_location'  => 'wpstarter_header_nav',
    	'menu'			  => 'WP Starter Header Menu',
		'container'		  => false,
		//'container_class' => '',
		//'container_id'    => '',
		'menu_class'	  => 'nav navbar-nav',
		'menu_id'         => 'header-nav',
		//'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '%3$s', // %3$s removes the empty first element, since we're using a Walker, otherwise use <li id="%1$s" class="%2$s">%3$s</li>, or a UL
		//'depth'           => 0,
		'walker' => new WPStarter_Walker_Header_Menu()
    ));
}

// Custom Footer Menu
/*function wpstarter_footer_nav() {
    wp_nav_menu(array(
		'theme_location'  => 'wpstarter_footer_nav',
    	'menu'			  => 'WP Starter Footer Menu',
		'container'		  => false,
		//'container_class' => '',
		//'container_id'    => '',
		'menu_class'	  => 'nav navbar-nav',
		'menu_id'         => 'footer-nav',
		//'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '%3$s', // %3$s removes the empty first element, since we're using a Walker, otherwise use <li id="%1$s" class="%2$s">%3$s</li>, or a UL
		//'depth'           => 0,
		'walker' => new WPStarter_Walker_Header_Menu()
    ));
}*/

// Custom Sidebar Menu
/*function wpstarter_sidebar_nav() {
	// Can turn the array into a var $args and use it in the theme with wp_nav_menu instead of function
    wp_nav_menu(array(
    	'theme_location'  => 'wpstarter_sidebar_nav',
		'menu'			  => 'WP Starter Sidebar Menu',
    	'container'		  => false,
		//'container_class' => '',
		//'container_id'    => '',
		'menu_class'	  => 'list-group sidebar-nav-v1',
		'menu_id'         => 'sidebar-nav',
		//'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		//'depth'           => 0,
    	'walker' => new WPStarter_Walker_Sidebar_Menu()
    ));
}*/

// Assign Menu to Location
function register_menus() {
	register_nav_menus(	array(
		'wpstarter_header_nav' => 'Header Menu',
        //'wpstarter_footer_nav' => 'Footer Menu',
		//'wpstarter_sidebar_nav' => 'Sidebar Menu'
	));
}
// Uncomment to register the menus you created above
//add_action( 'init', 'register_menus' );

// Custom Header Menu Walker
// https://gist.github.com/FStop/2025312
class WPStarter_Walker_Header_Menu extends Walker_Nav_Menu {
	// Save item for start_lvl
	private $curItem;

	function start_lvl( &$output, $depth ) {
		//In a child UL, add the 'dropdown-menu' class
		$indent = str_repeat( "\t", $depth );
		$output	   .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}
    function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent</ul></nav>\n";
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$li_attributes = '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		//Add class and attribute to LI element that contains a submenu UL.
		if ($args->has_children){
			// If this LI isnt a child of a UL, just add dropdown
			if($item->menu_item_parent == 0 ) {
				$classes[] 		= 'dropdown';
			} else { // If this LI is a child of a UL
				$classes[] 		= 'dropdown-submenu';
			}
			$li_attributes .= 'data-dropdown="dropdown"';
		}
		$classes[] = 'menu-item-' . $item->ID;
		//If we are on the current page, add the active class to that menu item.
		$classes[] = ($item->current) ? 'active' : '';
		//Make sure you still add all of the WordPress classes.
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
		//Add attributes to link element.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ($args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//$item_output .= ($args->has_children) ? ' <b class="caret"></b> ' : '';
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	//Overwrite display_element function to add has_children attribute. Not needed in >= Wordpress 3.4
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element ) return;
		$id_field = $this->db_fields['id'];
		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);
		$id = $element->$id_field;
		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
			foreach( $children_elements[ $id ] as $child ){
				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}
		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}
		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}

// Custom Sidebar Menu Walker
// https://gist.github.com/FStop/2025312
/*class WPStarter_Walker_Sidebar_Menu extends Walker_Nav_Menu {
	// Save item for start_lvl
	private $curItem;
	private $catSlug;
	private	$catName;

	function start_lvl(&$output, $depth = 0, $args = array()) {
		//var_dump($this->curItem );
		// Get Category slug
		$category_slug = get_category($this->curItem->object_id)->slug;
		// Check if is current
		$collapse = ($this->curItem->current) ? ' in' : '';
		//$open_default = ($this->curItem->current) ? ' aria-expanded="true"' : '';

		//In a child UL, add the 'dropdown-menu' class
		$indent = str_repeat( "\t", $depth );
		$output	   .= "\n$indent<ul id=\"collapse-".$category_slug."\" class=\"collapse".$collapse."\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		// Need to save this for start_lvl
		$this->curItem = $item;
		// Need to get the category slug again...?
		$catSlug = get_category($item->object_id)->slug;
		$catName = get_category($item->object_id)->name;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$li_attributes = '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		//Add class and attribute to LI element that contains a submenu UL.
		if ($args->has_children){
			$classes[] 		= 'list-toggle';
			$li_attributes .= '';
		}
		$classes[] = 'menu-item-' . $item->ID;

		// Add Unify classes - But NOT if this is li of a child UL, then dont add Unify classes
		if($item->menu_item_parent == 0 ) {
			$classes[] = 'list-group-item';
		}

		//If we are on the current page, add the active class to that menu item.
		$classes[] = ($item->current) ? 'active' : '';

		//Make sure you still add all of the WordPress classes.
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		//Add attributes to link element.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		// If Category Item has Children, remove its href - This however shouldnt happe, since a toggle element must not have an href anyway
		if($args->has_children) {
			$attributes .= ! empty( $item->url ) ? ' href="#collapse-'.$catSlug.'"' : '';
			$attributes .= 'data-parent="#sidebar-nav" data-toggle="collapse"';
		} else {
			$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		}
		//$attributes .= ($args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';

		// Check for menu icon
		//$icon = iconize_get_term_icon_by('name', $catName, 'how-to-category');

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//$item_output .= ($args->has_children) ? ' <b class="caret"></b> ' : '';
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	//Overwrite display_element function to add has_children attribute. Not needed in >= Wordpress 3.4
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element ) return;
		$id_field = $this->db_fields['id'];
		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);
		$id = $element->$id_field;
		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
			foreach( $children_elements[ $id ] as $child ){
				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}
		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}
		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}*/


?>
