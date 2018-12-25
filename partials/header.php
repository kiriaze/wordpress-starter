	<header role="banner" id="header">

		<div class="brand">
			<?php do_action('wps_header_logo', 'wps_header_logo'); ?>
		</div>

		<nav id="nav">
			<?php wps_menu_output( array('theme_location'=>'main-menu', 'container' => '', 'menu_class'=>'main-menu') ); ?>
		</nav>

	</header>