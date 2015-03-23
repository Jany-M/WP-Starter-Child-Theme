<?php
global $theme_name;

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter Child Theme - SIDEBARS & CUSTOM WIDGETS
*
-------------------------------------------------------------------------------- */

function wp_starter_register_sidebars() {

	/*register_sidebar(array(
	  'name' => 'Home > Top - Block 1',
	  'id' => 'home-top-block-1',
	  'description' =>  'The turquoise block on top of the Homepage.',
	  'before_widget' => '<div id="%1$s" class="service-block service-block-sea service-or %2$s"><div class="service-bg"></div>',
	  'after_widget' => '</div>',
	  'before_title' => '',
	  'after_title' => ''
	));*/
	
	/*register_sidebar(array(
	  'name' => 'Footer > Notice Left',
	  'id' => 'footer-notice',
	  'description' =>  'The notice in the bottom-left Footer.',
	  'before_widget' => '<div id="%1$s" class="col-md-8 %2$s"><p>'.date_i18n('Y', time()).' &copy;</p>',
	  'after_widget' => '</div>',
	  'before_title' => '',
	  'after_title' => ''
	));*/
	
	/*register_sidebar(array(
	  'name' => 'General > Right Sidebar',
	  'id' => 'general-right-sidebar',
	  'description' =>  'Sidebar for all archives and single contents.',
	  'before_widget' => '<div id="%1$s" class="%2$s">',
	  'after_widget' => '</div>',
	  'before_title' => '<h2>',
	  'after_title' => '</h2>'
	));*/

}
add_action( 'widgets_init', 'wp_starter_register_sidebars' );

/* -------------------------------------------------------------------------------- 
*
* WIDGETS
*
-------------------------------------------------------------------------------- */

// The followinf Static Blocks stuff, needs the custom post type Custom Blocks, that you can find in wordpress/custom_post_types.php. You can then have a custom content placed into a sidebar through a dedicated widget

// Static Blocks
/*if(!function_exists('et_get_static_blocks')) {
    function et_get_static_blocks () {
        $return_array = array();
        $args = array( 'post_type' => 'customblock', 'posts_per_page' => 50);
        $myposts = get_posts( $args );
        $i=0;
        foreach ( $myposts as $post ) {
            $i++;
            $return_array[$i]['label'] = get_the_title($post->ID);
            $return_array[$i]['value'] = $post->ID;
        } 
        wp_reset_postdata();
        return $return_array;
    }
}
if(!function_exists('et_show_block')) {
    function et_show_block ($id = false) {
        echo et_get_block($id);
    }
}
add_filter('et_the_content', 'wpautop', 10);
add_filter('et_the_content', 'do_shortcode', 11);
if(!function_exists('et_get_block')) {
    function et_get_block($id = false) {
        if(!$id) return;
        $args = array( 'include' => $id,'post_type' => 'customblock', 'posts_per_page' => 50);
        $output = '';
        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) {
            setup_postdata($post);
            //$output = wpautop(do_shortcode(get_the_content($post->ID)));
            $output = apply_filters('et_the_content', get_the_content());
        } 
        wp_reset_postdata();
        return $output;
   }
}

// Static Block Widget
class Shambix_StaticBlock_Widget extends WP_Widget {
    
    function Shambix_StaticBlock_Widget() {
        $widget_ops = array(
            'classname' => 'shambix_widget_static_block',
            'description' => "Insert a custom block that you created."
        );
        $this->WP_Widget('shambix-static-block', 'Shambix - Custom Block', $widget_ops);
        $this->alt_option_name = 'shambix_widget_static_block';
    }
   
    function widget($args, $instance) {
        extract($args);
        $block_id = $instance['block_id'];
        echo $before_widget;
        et_show_block($block_id);
        echo $after_widget;
    }
   
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['block_id'] = $new_instance['block_id'];
        return $instance;
    }
   
    function form( $instance ) {
        $block_id = 0;
        if(!empty($instance['block_id'])) $block_id = esc_attr($instance['block_id']);
        ?>
        <p><label for="<?php echo $this->get_field_id('block_id'); ?>"><?php _e('Block name:', $theme_name); ?></label>
            <?php $sb = et_get_static_blocks(); ?>
            <select name="<?php echo $this->get_field_name('block_id'); ?>" id="<?php echo $this->get_field_id('block_id'); ?>">
                <option>--Select--</option>
                <?php if (count($sb > 0)): ?>
                    <?php foreach ($sb as $key): ?>
                        <option value="<?php echo $key['value']; ?>" <?php selected( $block_id, $key['value'] ); ?>><?php echo $key['label'] ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </p>
    <?php 
    }
}*/

// Custom Recent Posts Widget - Customize and uncomment
/*class Shambix_RecentPosts_Widget extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
        parent::__construct('recent-posts', __('Shambix - Recent Posts'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }
    
    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts', 'widget');
        if ( !is_array($cache) )
            $cache = array();
        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;
        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }
        ob_start();
        extract($args);
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
		echo $before_widget;
		// Open Block
		echo '<div class="recent_posts_widget posts margin-bottom-40">';
		// Customize Title
		$before_title = '<div class="headline headline-md"><h2>';
		$after_title = '</h2></div>';
		if ( $title ) echo $before_title . $title . $after_title; ?>
        <!-- <ul> -->
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<dl class="dl-horizontal">
				<dt><?php echo wp_imager(60, 60, '', 'img-responsive', true); ?></dt>
                <dd>
					<h3><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h3> 
					<?php if ( $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>
				</dd>
	        </dl>
        <?php endwhile; ?>
        <!-- </ul> -->
		<?php // Close Block
		echo '</div>';
        echo $after_widget;
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }
    
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();
        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');
        return $instance;
    }
    
    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }
    
    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
	?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
	<?php
    }
}*/

// Custom TOC Widget + Affix - Customize and uncomment
// This widgets is meant to be used with the Table of Contents Plus plugin https://wordpress.org/plugins/table-of-contents-plus/ and placed ideally in a left sidebar that will scroll along with the page
/*class Shambix_TOC_Affix_Widget extends WP_Widget {
   
    function __construct() {
        $widget_options = array('classname' => 'widget_toc_affix', 'description' => 'Enhanced TOC Widget with Affix.');
        $control_options = array( 
            'width' => 250, 
            'height' => 350, 
            'id_base' => 'widget-toc-affix'
        );
        $this->WP_Widget( 'widget-toc-affix', 'Shambix - TOC', $widget_options, $control_options );
    }

    function widget( $args, $instance ) {
        global $tic, $wp_query;
        $items = $custom_toc_position = '';
        $find = $replace = array();
            
        $toc_options = $tic->get_options();
        $post = get_post( $wp_query->post->ID );
        $custom_toc_position = strpos( $post->post_content, '[toc]' );  // at this point, shortcodes haven't run yet so we can't search for <!--TOC-->
            
        if ( $tic->is_eligible($custom_toc_position) ) {
            extract( $args );
                
            $items = $tic->extract_headings( $find, $replace, wptexturize($post->post_content) );
            $title = apply_filters('widget_title', $instance['title'] );
            if ( strpos($title, '%PAGE_TITLE%') !== false ) $title = str_replace( '%PAGE_TITLE%', get_the_title(), $title );
            if ( strpos($title, '%PAGE_NAME%') !== false ) $title = str_replace( '%PAGE_NAME%', get_the_title(), $title );
            $hide_inline = $toc_options['show_toc_in_widget_only'];

            $css_classes = '';
            // Nav Classes
            $css_classes = 'nav sidenav';
            // bullets?
            if ( $toc_options['bullet_spacing'] )
                $css_classes .= ' have_bullets';
            else
                $css_classes .= ' no_bullets';
                
            if ( $items ) {
                // Nav element
                $before_widget .= '<nav id="affix-nav">';
                echo $before_widget;
                // Affix
                $affix_attr = 'data-spy="affix" data-offset-top="10"';

                // display the widget title if one was input (before and after defined by themes)
                if ( !$title ) $title = $toc_options['heading_text'];
                    echo '<ul class="toc_widget_list ' . $css_classes . '" '.$affix_attr .'>';
                    echo $before_title . $title . $after_title;
                    echo $items;
                    echo '</ul>';
                    
                $after_widget .= '</nav>';
                echo $after_widget;

                echo '<script type="text/javascript">
                        jQuery(document).ready(function() {
                            $(".toc_widget_list li a").click(function() {
                            // remove classes from all
                            $(".toc_widget_list li").removeClass("active");
                            // add class to the one we clicked
                            $(this).parent().addClass("active");
                        });
                    });
                    </script>';
            }
        }
    }

    function update( $new_instance, $old_instance ) {
        global $tic;
        $instance = $old_instance;

        // strip tags for title to remove HTML (important for text inputs)
        $instance['title'] = strip_tags( $new_instance['title'] );
            
        // no need to strip tags for the following
        //$instance['hide_inline'] = $new_instance['hide_inline'];
        $tic->set_show_toc_in_widget_only( $new_instance['hide_inline'] );
        $tic->set_show_toc_in_widget_only_post_types( (array)$new_instance['show_toc_in_widget_only_post_types'] );

        return $instance;
    }      
    
    // Displays the widget settings on the widget panel.
    
    function form( $instance )  {
        global $tic;
        $toc_options = $tic->get_options();
        
        $defaults = array( 'title' => '' );
        $instance = wp_parse_args( (array)$instance, $defaults );
        ?>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $toc_options['show_toc_in_widget_only'], 1 ); ?> id="<?php echo $this->get_field_id( 'hide_inline' ); ?>" name="<?php echo $this->get_field_name( 'hide_inline' ); ?>" value="1" /> 
            <label for="<?php echo $this->get_field_id( 'hide_inline' ); ?>"> <?php _e('Show the table of contents only in the sidebar', 'toc+'); ?></label>
        </p>
        <div class="show_toc_in_widget_only_post_types" style="margin: 0 0 25px 25px; display: <?php echo ( $toc_options['show_toc_in_widget_only'] == 1 ) ? 'block' : 'none'; ?>;">
            <p><?php _e('For the following content types:', 'toc+'); ?></p>
            <?php
            foreach (get_post_types() as $post_type) {
                // make sure the post type isn't on the exclusion list
                if ( !in_array($post_type, $tic->get_exclude_post_types()) ) {
                    echo '<input type="checkbox" value="' . $post_type . '" id="' . $this->get_field_id( 'show_toc_in_widget_only_post_types_' . $post_type ) . '" name="' . $this->get_field_name( "show_toc_in_widget_only_post_types" ) . '[]"';
                    if ( in_array($post_type, $toc_options['show_toc_in_widget_only_post_types']) ) echo ' checked="checked"';
                    echo ' /><label for="' . $this->get_field_id( 'show_toc_in_widget_only_post_types_' . $post_type ) . '"> ' . $post_type . '</label><br />';
                }
            }
            ?>
        </div>

        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#<?php echo $this->get_field_id( 'hide_inline' ); ?>').click(function() {
                $(this).parent().siblings('div.show_toc_in_widget_only_post_types').toggle('fast');
            });
        });
        </script>
<?php
    }
}*/

// Un-register default Custom Menu Widget
/*function remove_default_widget() {
    unregister_widget('WP_Nav_Menu_Widget');
}
add_action( 'widgets_init', 'remove_default_widget' );*/

// Custom Menu Widget
// With this widget you can assign a menu with custom walker to a sidebar
/*class Shambix_QuickLinks_Widget extends WP_Widget {
    
    public function __construct() {
        $widget_ops = array( 'description' => __('Add a custom menu to your sidebar.') );
        parent::__construct( 'nav_menu', __('Shambix - Quick Links'), $widget_ops );
    }
    
    public function widget($args, $instance) {
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
        if ( !$nav_menu )
            return;
        // This filter is documented in wp-includes/default-widgets.php
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( !empty($instance['title']) )
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
        $nav_menu_args = array(
            //'fallback_cb' => '',
            //'menu'        => $nav_menu
            'theme_location'  => 'wpstarter_sidebar_nav',
            'menu'            => $nav_menu,
            'container'       => false,
            //'container_class' => '',
            //'container_id'    => '',
            'menu_class'      => 'list-group sidebar-nav-v1',
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
        );
        wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args ) );
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        if ( ! empty( $new_instance['nav_menu'] ) ) {
            $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        }
        return $instance;
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        // Get menus
        $menus = wp_get_nav_menus();

        // If no menus exists, direct the user to go and create some.
        if ( !$menus ) {
            echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
            <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <option value="0"><?php _e( '&mdash; Select &mdash;' ) ?></option>
        <?php
            foreach ( $menus as $menu ) {
                echo '<option value="' . $menu->term_id . '"'
                    . selected( $nav_menu, $menu->term_id, false )
                    . '>'. esc_html( $menu->name ) . '</option>';
            }
        ?>
            </select>
        </p>
        <?php
    }
}*/

// Register Custom Widgets - Customize and Uncomment
//add_action( 'widgets_init', 'register_general_widgets' );
function register_general_widgets() {
    register_widget('Shambix_StaticBlock_Widget');
    register_widget('Shambix_RecentPosts_Widget');
    register_widget('Shambix_TOC_Affix_Widget');
    register_widget('Shambix_QuickLinks_Widget');
}
?>