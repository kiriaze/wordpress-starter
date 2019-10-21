<header class="header" data-ajax-links>
	<?php
	// clean_custom_menu('main-menu', 'main__menu');
	// wps_menu_output([
	// 	'container'      => '',
	// 	'menu_class'     => 'main__menu',
	// 	'theme_location' => 'main-menu',
	// 	'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	// ]);
	
	// to fade them in
	$menu = new NestedMenu('main-menu');
	if ( $menu ) {
		echo '<ul class="main__menu">';
			foreach ( $menu->items as $key => $item ) :
				// sp($item);
				echo '<li data-skrolly="fade-up" data-skrolly-delay="'. ($key+1)*75 .'ms">
						<a class="link" href="'. $item->url .'">'. $item->title .'</a>
					</li>';
				// $submenu = $menu->get_submenu($item);
				// if ( $submenu ) :
				// 	foreach ( $submenu as $subitem ) :
				// 		sp($subitem);
				// 	endforeach;
				// endif;
			endforeach;
		echo '</ul>';
	}
	?>
</header>