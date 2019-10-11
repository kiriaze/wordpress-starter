<?php

// faster load times for acf in backend
// by removing wp meta fields - test
add_filter('acf/settings/remove_wp_meta_box', '__return_true', 20);

// // 
// add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
// function my_acf_google_map_api( $api ){
// 	$api['key'] = '';
// 	return $api;
// }

// add_action('acf/init', 'my_acf_init');
// function my_acf_init() {
// 	acf_update_setting('google_api_key', 'xxx');
// }


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

	if ( $site_url === 'https://relef.local' ) {
		// show the acf menu item 
		return true;
	} else {
		// hide the acf menu item 
		return false;
	}
}

// get gform id and title for select field "form"
add_filter('acf/load_field/name=form', 'acf_load_form_field_choices');
function acf_load_form_field_choices( $field ) {

	// reset choices
	$field['choices'] = [];

	// get the textarea value from options page without any formatting
	$forms      = GFAPI::get_forms();
	$formIds    = array_column($forms, 'id');
	$formTitles = array_column($forms, 'title');
	$choices    = array_combine($formIds, $formTitles);
	// sp($choices); // id, title

	// remove any unwanted white space
	$choices = array_map('trim', $choices);

	// loop through array and add to field 'choices'
	if ( is_array($choices) ) {
		foreach( $choices as $key => $choice ) {
			// sp([$key, $choice]);
			// id => title
			$field['choices'][$key] = $choice;
		}
	}

	// return the field
	return $field;

}