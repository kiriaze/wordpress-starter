<?php

get_template_part('partials/head');
do_action('get_header');
get_template_part('partials/svg');

get_template_part('partials/cursor');

// not a custom view
if ( wps_display_custom_template() ) : 

	get_template_part('partials/header'); ?>

		<main role="main" class="main-content" data-ajax-wrap>
			<?php include wps_template_path(); ?>
		</main>

	<?php

	get_template_part('partials/footer');

// is custom view
else : ?>
	
	<main role="main" class="main-content" data-ajax-wrap>
		<?php include wps_template_path(); ?>
	</main>

<?php endif;

get_template_part('partials/foot');