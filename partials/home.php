<?php get_template_part('partials/menu-overlay'); ?>
<?php get_template_part('partials/contact-overlay'); ?>
<?php get_template_part('partials/recent-posts'); ?>
<?php get_template_part('partials/lookbook'); ?>
<?php get_template_part('partials/client-list'); ?>
<?php get_template_part('partials/product-grid-3up'); ?>

<div class="">
	<a href="javascript:;" class="link">Lookbook</a>
	<a href="javascript:;" class="link">Shop All</a>
</div>


<?php if ( have_rows('modules') ) : ?>
	<?php while ( have_rows('modules') ) : the_row(); ?>
		<?php

		if ( get_row_layout() == 'hero' ) :

			$heading  = get_sub_field('heading') ? get_sub_field('heading') : '';
			$blurb    = get_sub_field('blurb') ? get_sub_field('blurb') : '';
			$byline   = get_sub_field('byline') ? get_sub_field('byline') : '';
			$ctaText  = get_sub_field('cta_text') ? get_sub_field('cta_text') : '';
			$ctaURL   = get_sub_field('cta_url') ? get_sub_field('cta_url') : '/quiz';
			$bgImage  = get_sub_field('background_image') ? get_sub_field('background_image') : '';
			$imgURL   = $bgImage && $bgImage['sizes'] ? $bgImage['sizes']['full'] : ($bgImage ? $bgImage['url'] : '');
		?>

		<!-- markup -->

		<?php

		elseif ( get_row_layout() == 'banner' ) :

			$copy = get_sub_field('copy') ? get_sub_field('copy') : '';
		
		endif;

	endwhile;
endif; ?>