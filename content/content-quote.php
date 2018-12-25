<article role="article" <?php post_class(); ?>>

	<?php get_template_part('partials/header-content'); ?>

	<blockquote>
		<?php
		$quote 	= get_field('wps-quote');
		$author = get_field('wps-quote-author');
		?>
		<p><?php echo $quote; ?></p>
		<?php if ( $author ) : ?>
		<cite>- <?php echo $author; ?></cite>
		<?php endif; ?>
	</blockquote>

	<?php get_template_part( 'partials/post-meta' ); ?>

</article>
