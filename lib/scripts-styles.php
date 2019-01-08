<?php

function theme_enqueue_scripts() {

	wp_deregister_script('jquery'); // Deregister WordPress jQuery

	// Gzip Compression
	global $compress_scripts, $concatenate_scripts;
	$compress_scripts = 1;
	$concatenate_scripts = 1;

	if ( defined('ENFORCE_GZIP') ) {
		define('ENFORCE_GZIP', true);
	}

	// Register Styles & Scripts
	
	// CSS
	
	// only load css if not on local environment
	// as this conflicts with local js that imports scss

	if ( $_SERVER['SERVER_NAME'] !== 'localhost' && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' ) :
		wp_register_style( 'app', get_stylesheet_directory_uri() . '/assets/css/app.bundle.css' );
		wp_enqueue_style('app');
	endif;

	// JS

	if ( $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ) :
		wp_register_script('app', '//127.0.0.1:3000/assets/js/app.bundle.js', [], '', true );
	else :
		wp_register_script('app', get_stylesheet_directory_uri() . '/assets/js/app.bundle.js', [], '', true );
	endif;

	wp_localize_script( 'app', 'adminAjax',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce('ajax-nonce')
		)
	);
	
	wp_enqueue_script('app');

}


// // Admin Styles & Scripts
// function theme_enqueue_admin_scripts(){
// 	wp_register_style( 'admin',  get_stylesheet_directory_uri().'/admin/admin.css' );
// 	wp_register_script('admin', get_stylesheet_directory_uri().'/admin/admin.js', array('jquery'));
// 	wp_enqueue_style('admin');
// 	wp_enqueue_script('admin');
// });

// // Page Specific Scripts
// function theme_example_scripts() {
//     if ( is_singular( 'example' ) || is_post_type_archive('example') ) {
//         wp_enqueue_script('example');
//     }
// }


add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
// add_action('admin_enqueue_scripts', 'theme_enqueue_admin_scripts' );
// add_action('wp_enqueue_scripts', 'theme_example_scripts');
