<?php

//	Register Sidebars
$wps_sidebars = array('Default', 'Blog');

array_push($wps_sidebars, 'Footer');
// Multiple Sidebars for stacked widgets
// array_push($wps_sidebars, 'Footer Widget 1', 'Footer Widget 2', 'Footer Widget 3', 'Footer Widget 4');

foreach ( $wps_sidebars as $sidebar ) {
	$sidebar_args = array(
		'name'			=> $sidebar,
		'id'			=> 'sidebar_'.preg_replace('/\W/', '_', strtolower($sidebar) ),
		'before_widget'	=>	'<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h6 class="widgettitle">',
		'after_title'	=> '</h6>'
	);
	register_sidebar($sidebar_args);
}