<?php
/**
 * The template is for rendering the share.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<ul class="social-share">
	<li>Share:</li>
	<li>
		<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php __(the_title(), WPS_THEME_SLUG); ?>" target="_blank">
			<svg><use xlink:href="#icon-facebook"></use></svg>
		</a>
	</li>
	<li>
		<a href="http://twitter.com/intent/tweet?text=<?php __(the_title(), WPS_THEME_SLUG); ?>+<?php the_permalink(); ?>+@<?php bloginfo('name'); ?>" target="_blank">
			<svg><use xlink:href="#icon-twitter"></use></svg>
		</a>
	</li>
</ul>