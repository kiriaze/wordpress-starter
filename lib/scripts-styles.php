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

	// JS
	// if local
	if ( $_SERVER['SERVER_NAME'] === 'localhost' || strpos($_SERVER['SERVER_NAME'], '.local') !== false ) :

		$path = '//127.0.0.1:3000/';
		$footer = false;

	else :

		$path = get_stylesheet_directory_uri();
		$footer = true;

		// CSS
		
		// only load css if not on local environment
		// as this conflicts with local js that imports scss

		wp_register_style( 'app', $path . '/assets/css/app.bundle.css' );
		wp_enqueue_style('app');
		
		wp_register_style( 'styleguide', $path . '/assets/css/styleguide.bundle.css' );
		wp_enqueue_style('styleguide');

	endif;
	
	wp_register_script('app', $path . '/assets/js/app.bundle.js', [], '', $footer );
	wp_register_script('styleguide', $path . '/assets/js/styleguide.bundle.js', [], '', $footer );

	wp_localize_script( 'app', 'adminAjax',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce('ajax-nonce')
		)
	);
	
	wp_enqueue_script('app');

	if ( is_page('styleguide') ) {
		wp_enqueue_script('styleguide');
	}

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
