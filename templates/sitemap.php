<?php
/**
 * Template Name: Sitemap Template
 * The template is for rendering the sitemap.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<?php if ( have_posts() ) :

	while ( have_posts() ) : the_post(); ?>

		<h4>Last 20 Posts</h4>
		<ul>
			<?php wp_get_archives( array( 'type' => 'postbypost', 'limit' => 20, 'format' => 'custom', 'before' => '<li>', 'after' => '</li>' ) ); ?>
		</ul>

		<h4>Monthly Archives</h4>
		<?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?>

		<h4>Category Archives</h4>
		<?php
		$args = array(
			'orderby' => 'name',
			'order' => 'ASC'
		);
		$categories = get_categories($args);
		foreach( $categories as $category ) {
			echo '<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
			echo '<p> Description:'. $category->description . '</p>';
			echo '<p> Post Count: '. $category->count . '</p>';
		}

	endwhile;

endif; ?>
