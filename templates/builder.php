<?php 
/**
 * Template Name: Builder
 * The template is for rendering the content creator acf fields.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<?php if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		get_template_part( 'partials/content', 'creator' );

	endwhile; 

else :

	get_template_part( 'partials/no-results' );

endif; wp_reset_postdata(); ?>