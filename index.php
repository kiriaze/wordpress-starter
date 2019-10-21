<?php
/**
 * The template is for rendering the index.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<?php

if ( is_post_type_archive($post_type) ) :
	// for search results, when $_GET post_type is passed
	// allows usage when the search form doesn't redirect
	if ( is_array($post_type) ) $post_type = $post_type[0];
	if ( $post_type && locate_template( '/templates/archive-'. $post_type .'.php' ) != '' ) :
		$template = '/templates/archive-'. $post_type .'.php';
	else :
		$template = '/templates/archive.php';
	endif;

elseif ( is_404() || is_search() ) :

	$template = '/templates/404.php';

elseif ( is_page() ) :

	$slug = $post->post_name;

	if ( locate_template( '/templates/page-'. $slug .'.php' ) != '' ) :
		$template = '/templates/page-'. $slug .'.php';
	else :
		$template = '/templates/page.php';
	endif;

elseif ( is_singular($post_type) ) :

	if ( $post_type && locate_template( '/templates/single-'. $post_type .'.php' ) != '' ) :
		$template = '/templates/single-'. $post_type .'.php';
	else :
		$template = '/templates/single.php';
	endif;

elseif ( is_tax() ) :

	$tax      = $wp_query->get_queried_object();
	$taxonomy = $tax->taxonomy;

	if ( locate_template( '/templates/taxonomy-'. $taxonomy .'.php' ) != '' ) :
		$template = '/templates/taxonomy-'. $taxonomy .'.php';
	else :
		$template = '/templates/archive.php';
	endif;

elseif ( is_archive() ) :

	$template = '/templates/archive.php';

else :

	// posts page setting; e.g. blog

	$template = '/templates/archive.php';

endif;

require_once locate_template( $template );
