<?php
	global $single;

	setup_postdata( $post );

	$page_object = get_queried_object();
	$page_id     = get_queried_object_id();

	$single      = $post->ID == $page_id ? true : false;
?>

<header>

	<h2 class="hero-heading">
		<span>
		<?php if ( !$single ) : ?>
			<a href="<?php the_permalink(); ?>"><?php echo truncate_text(get_the_title(), 100, '...'); ?></a>
		<?php else : ?>
			<?php the_title(); ?>
			<?php edit_post_link( __( 'Edit Post.', WPS_THEME_SLUG ), '<span class="edit-link">', '</span>', $post->ID ); ?>
		<?php endif; ?>
		</span>
	</h2>

	<!-- author, date, tags, cats -->

</header>
