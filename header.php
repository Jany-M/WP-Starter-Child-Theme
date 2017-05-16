<!doctype html>
<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="author" content="<?php bloginfo('name'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="title" content="<?php bloginfo('name'); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<!-- <meta name="keywords" content="">
	<meta name="robots" content="INDEX, FOLLOW">
	<meta name="revisit-after" content="7 days">
	<meta name="document-distribution" content="Global">
	<meta name="Audience" content="General">
	<meta name="Rating" content="General">
	<meta name="expires" content="never"> -->
	<title><?php
		global $wp_query;

		if (is_home() || is_front_page()) {
			bloginfo('name'); echo ' - '; bloginfo('description'); }
		elseif (!(is_404()) && (is_single()) || (is_page())) {
			the_title(); echo ' &raquo; '; bloginfo('name'); }
		elseif (function_exists('is_tag') && is_tag()) {
			single_tag_title(__('Tag Archive for', TEXT_DOMAIN)); echo ' &raquo; '; bloginfo('name'); }
		elseif(is_tax('categoria-progetto')) {
			$tax = $wp_query->query_vars['taxonomy'];
			echo _e('Content in ', TEXT_DOMAIN); echo get_term_by('slug', $wp_query->query_vars['term'], $tax)->name; echo ' &raquo; '; bloginfo('name');}
		elseif (is_archive()) {
			wp_title(''); echo '&quot; - '; bloginfo('name'); }
		elseif (is_search()) {
			_e('Search', TEXT_DOMAIN); echo ' &quot;'.wp_specialchars($s).'&quot; '; bloginfo('name'); }
		elseif (is_404()) {
			_e('404 - Not Found', TEXT_DOMAIN); }
		else {
			bloginfo('name'); }
		if ($paged>1) {
			echo ' - pag.'. $paged; echo ' &raquo; '; bloginfo('name'); }
	?></title>
	<?php if(file_exists(WP_STARTER_CHILD_ASSETS_PATH.'img/favicon.ico')) { ?>
		<link rel="shortcut icon" href="<?php get_stylesheet_directory_uri(); ?>/assets/img/favicon.ico">
	<?php } ?>
	<!-- media-queries.js (fallback) -->
	<!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<!-- html5.js -->
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
	<?php wp_head(); ?>


</head>

<?php
	// Body classes extras
	global $wp_query, $post;
	$classes = '';

	/* echo '<pre>';
	  //var_dump($wp_query);
	  var_dump($post);
	  echo '</pre><br><br>----------------------------------------------<br>';
	  echo  $post->post_name; */

	if (is_page() || is_singular())
		$classes = $post->post_name.' '.$post->post_name.'-section';
	    if ( function_exists('icl_object_id') ) {
	        if(ICL_LANGUAGE_CODE == 'en') {
	            $classes .= ' en';
	        } else {
	            $classes .= ' it';
	        }
	    }
		//if(is_archive()) $classes = $wp_query->query['category_name'];
?>

<body <?php body_class($classes); ?>>
