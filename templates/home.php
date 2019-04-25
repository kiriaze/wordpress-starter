<?php 
/**
 * Template Name: Home Page
 * The template is for rendering the home page.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<?php if ( have_posts() ) :

	while ( have_posts() ) : the_post(); ?>

		<?php get_template_part('partials/home'); ?>

	<?php endwhile;

endif; wp_reset_postdata(); ?>