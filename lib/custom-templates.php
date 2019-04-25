<?php
//	Sidebar template and conditional checker
class WPS_Template_Check {

	private $conditionals;
	private $templates;

	public $display = true;

	function __construct( $conditionals = array(), $templates = array() ) {
		$this->conditionals = $conditionals;
		$this->templates    = $templates;

		$conditionals = array_map(array($this, 'check_conditional_tag'), $this->conditionals);
		$templates    = array_map(array($this, 'check_page_template'), $this->templates);

		if ( in_array(true, $conditionals) || in_array(true, $templates) ) {
			$this->display = false;
		}
	}

	private function check_conditional_tag($conditional_tag) {
		if ( is_array($conditional_tag) ) {
			return $conditional_tag[0]($conditional_tag[1]);
		} else {
			return $conditional_tag();
		}
	}

	private function check_page_template($page_template) {
		return is_page_template($page_template);
	}

}

// Note: move these to setup.php

//	If in array, return true (custom filters within child themes)
function wps_display_sidebar() {
	$sidebar_array = new WPS_Template_Check(
		// wp conditionals
		// * To use a function that accepts arguments, use the following format:
		// array('function_name', array('arg1', 'arg2'))
		// e.g. array( 'is_singular', array($post_type) )
		[
			'is_404'
		],
		// template check
	    [
	    	'templates/full-width.php',
    	]
    );

	return apply_filters('wps_display_sidebar', $sidebar_array->display);
}

//	If in array, return true
function wps_display_custom_template() {
	$custom_array = new WPS_Template_Check(
		// leave empty
		[],
		// template check
	    [
	    	'templates/quiz.php'
	    	// 'templates/home.php',
	    	// 'templates/builder.php',
	    	// 'templates/typography.php'
    	]
    );

	return apply_filters('wps_display_custom_template', $custom_array->display);
}