<?php
/**
 * The template is for rendering single's.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<?php

if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		get_template_part( 'content/content', get_post_format() );

	endwhile;

else :

	get_template_part( 'partials/no-results' );

endif; wp_reset_postdata();

// For long posts
wp_link_pages();

get_template_part('partials/author-bio');

// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || '0' != get_comments_number() ){
	comments_template('/partials/comments.php');
}

do_action('wps_post_pagination', array( 'showTitles' => false ));
