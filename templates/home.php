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

<div class="container">

<?php if ( have_posts() ) :

	while ( have_posts() ) : the_post(); ?>

		<?php $i = 0; while ($i <= 10) { ?>
			
		<h1 style="font-size: 10rem">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum minima dolorem voluptate sed reiciendis voluptatem soluta cumque laborum veniam, tempora, facere nemo eaque fugiat perferendis? Eius nesciunt, excepturi! Quaerat, architecto.</h1>

		<div class="row">
			<div class="col-6">
				<div class="lazyload">
					<img data-src="https://www.fillmurray.com/1200/600" alt="">
				</div>
			</div>
			<div class="col-6">
				<div class="lazyload">
					<img data-src="https://res.cloudinary.com/forhims/image/upload/q_auto,f_auto,fl_lossy/hers-home-softfooter-d-2x" alt="">
				</div>
			</div>
		</div>

		<?php $i++; } ?>

	<?php endwhile;

endif; wp_reset_postdata(); ?>

</div>