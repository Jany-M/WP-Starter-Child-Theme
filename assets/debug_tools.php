<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - DEBUG
*
-------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------
*
* [WP] Starter Child Theme - DEBUG
*
-------------------------------------------------------------------------------- */
function display_vars() {
    global $query, $wp_query, $post, $product, $woocommerce, $WCS;

        echo '<pre><strong>WP QUERY</strong>';
        print_r( $wp_query );
        echo '-------------------------------------------------------------------------------------------------------';
        echo "</pre>\r\n";

        echo '<pre><strong>QUERY</strong>';
        print_r( $query );
        echo '-------------------------------------------------------------------------------------------------------';
        echo "</pre>\r\n";

        /*echo '<pre>';
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
        echo '</pre>';*/

}
if(current_user_can('activate_plugins')) :
    //add_action('wp','display_vars');
endif;

// ERROR HANDLING - DEBUG for Admins
if(current_user_can('activate_plugins')) :
    //error_reporting(E_ALL); // everything
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);// Report all errors except E_NOTICE
    //error_reporting(E_ERROR | E_WARNING | E_PARSE); // Report simple running errors
    else :
    error_reporting(0);
endif;

?>
