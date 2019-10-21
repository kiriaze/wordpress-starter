<?php
/**
 * WPS theme wrapper based on scribu and roots
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 * @link http://roots.io
 */
function wps_template_path() {
	return WPS_Wrapping::$main_template;
}

// In conjunction with custom-templates.php
function wps_sidebar_path() {
	return new WPS_Wrapping('partials/sidebar.php');
}

class WPS_Wrapping {

	// Stores the full path to the main template file
	static $main_template;

	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	static $base;

	public function __construct( $template = 'template.php' ) {
		$this->slug = basename( $template, '.php' );
		$this->templates = array($template);
		
		if ( self::$base ) {
			$str = substr($template, 0, -4);
			array_unshift( $this->templates, sprintf($str . '-%s.php', self::$base) );
		}
	}
	
	// magic: must return a string, e.g. 'page'
	public function __toString() {
		$this->templates = apply_filters('wps_wrapper_' . $this->slug, $this->templates);
		return locate_template($this->templates);
	}
	
	static function wrap($main) {
		self::$main_template = $main;
		self::$base = basename( self::$main_template, '.php' );

		if ( self::$base === 'index' ) {
			self::$base = false;
		}
		
		return new WPS_Wrapping();
	}
}

add_filter('template_include', array('WPS_Wrapping', 'wrap'), 99);