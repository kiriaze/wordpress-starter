<?php

// faster load times for acf in backend
// by removing wp meta fields - test
add_filter('acf/settings/remove_wp_meta_box', '__return_true', 20);

// 
function my_acf_google_map_api( $api ){
	$api['key'] = '';
	return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// theme options page - acf
if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page([
		'page_title' 	=> 'Global Settings',
		'menu_title'	=> 'Global Settings',
		'menu_slug' 	=> 'global-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	]);
	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Site Footer Settings',
	// 	'menu_title'	=> 'Footer',
	// 	'parent_slug'	=> 'global-general-settings',
	// ));
}


// hide acf from remote servers, only available on local
// do not sync on remote servers, keep things clean
add_filter('acf/settings/show_admin', 'da_hide_acf_admin');
function da_hide_acf_admin() {

	// get the current site url
	$site_url = get_bloginfo( 'url' );

	if ( $site_url === 'https://kannavis.local' ) {
		// show the acf menu item 
		return true;
	} else {
		// hide the acf menu item 
		return false;
	}
}