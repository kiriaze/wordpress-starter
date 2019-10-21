<?php

// Change login page style adding your custom css in $output
function wps_login_head() {
	
	if ( $_SERVER['SERVER_NAME'] !== 'localhost' && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' ) :
		wp_enqueue_style( 'wps_login_head', get_stylesheet_directory_uri() . '/assets/css/login.bundle.css', false );
	endif;

	if ( $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ) :
		wp_register_script('login', '//127.0.0.1:3000/assets/js/login.bundle.js', [], '', true );
	else:
		wp_register_script( 'login', get_stylesheet_directory_uri() . '/assets/js/login.bundle.js', [], '', true );
	endif;

	wp_enqueue_script('login');
	
	// $output = '
	// 	.login h1 a {
	// 		background: url() no-repeat center !important;
	// 		text-indent: -9999em !important;
	// 	}
	// ';
	// echo "\n<style>\n" . preg_replace( '/\s+/', ' ', $output ) . "\n</style>\n";

}

function wps_login_url() {
	return home_url();
}

function wps_login_title() {
	// return 'Simple';
	// return get_bloginfo('site');
	return get_option( 'blogname' );
}

// Enable custom login style uncommenting the line below
add_action('login_enqueue_scripts', 'wps_login_head', 10);
// Change url of logo for login screen uncommenting the line below
add_filter( 'login_headerurl', 'wps_login_url' );
// Change title for login screen uncommenting the line below
add_filter( 'login_headertitle', 'wps_login_title' );