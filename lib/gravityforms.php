<?php

// returns a gravity form ID by looking up the gform title; e.g. getGformIDByTitle('My Awesome Form');
function getGformIDByTitle($title) {
	$forms = GFAPI::get_forms();
	$key = array_search($title, array_column($forms, 'title'));
	return $forms[$key]['id'];
}

// pre-populate all gforms fields that match label of 'Select a Product' with products
// albeit if prods get added/removed, the choices of the field dont update until the form is resaved...pointless
// so using an alternative method for fetching products on forms for the front end for now...
add_filter( 'gform_pre_render', 'populate_gform_products_dropdown' );
add_filter( 'gform_pre_validation', 'populate_gform_products_dropdown' );
add_filter( 'gform_pre_submission_filter', 'populate_gform_products_dropdown' );
add_filter( 'gform_admin_pre_render', 'populate_gform_products_dropdown' );
function populate_gform_products_dropdown( $form ) {

	foreach ( $form['fields'] as &$field ) {

		if ( strpos( $field->label, 'Select a Product' ) === false ) {
			continue;
		}
		
		$products = get_posts([
			'posts_per_page' => -1,
			'post_type'      => 'product'
		]);

		$choices = array();

		foreach ( $products as $product ) {
			$choices[] = array( 'text' => $product->post_title, 'value' => $product->post_name );
		}

		// update 'Select a Post' to whatever you'd like the instructive option to be
		$field->placeholder = 'Select a Product';
		$field->choices = $choices;

	}

	return $form;

}
