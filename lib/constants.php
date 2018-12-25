<?php

/**
 * Sets up global theme constants.
 *
 * @package   WordPress
 * @subpackage  WPS
 * @version   1.0
 * @author    Constantine Kiriaze
 */


/* DEFINE THEME DIRECTORY LOCATION CONSTANTS */
define( 'PARENT_DIR', get_template_directory() );

/* DEFINE THEME URL LOCATION CONSTANTS */
define( 'PARENT_URL', get_template_directory_uri() );

/* DEFINE THEME INFO CONSTANTS */
$theme 			= wp_get_theme();
$theme_title 	= $theme->name; 
$theme_version 	= $theme->version;

define( 'WPS_THEME_SLUG', get_template() ); 	// theme folder. else, strntolower($theme_title)
define( 'WPS_THEME_NAME', $theme_title ); 	// style.css name
define( 'WPS_THEME_VER', $theme_version );

/*	DEFINE GENERAL CONSTANTS
================================================== */
define( 'WPS_IMAGES_DIR', PARENT_DIR . '/assets/images' );
define( 'WPS_LIB_DIR', PARENT_DIR . '/lib' );
define( 'WPS_JS_DIR', PARENT_DIR . '/assets/js' );
define( 'WPS_CSS_DIR', PARENT_DIR . '/assets/css' );
define( 'WPS_FUNCTIONS_DIR', WPS_LIB_DIR . '/functions' );
define( 'WPS_CONTENT_DIR', PARENT_DIR . '/content' );
define( 'WPS_LANGUAGES_DIR', PARENT_DIR . '/assets/lang' );

define( 'WPS_IMAGES_URL', PARENT_URL . '/assets/images' );
define( 'WPS_LIB_URL', PARENT_URL . '/lib' );
define( 'WPS_JS_URL', PARENT_URL . '/assets/js' );
define( 'WPS_CSS_URL', PARENT_URL . '/assets/css' );
define( 'WPS_FUNCTIONS_URL', WPS_LIB_URL . '/functions' );


/*	DEFINE ADMIN CONSTANTS
================================================== */
define( 'WPS_ADMIN_DIR', WPS_LIB_DIR . '/admin' );
define( 'WPS_ADMIN_IMAGES_DIR', WPS_LIB_DIR . '/admin/assets/images' );
define( 'WPS_ADMIN_CSS_DIR', WPS_LIB_DIR . '/admin/assets/css' );
define( 'WPS_ADMIN_JS_DIR', WPS_LIB_DIR . '/admin/assets/js' );
		
define( 'WPS_ADMIN_URL', WPS_LIB_URL . '/admin' );
define( 'WPS_ADMIN_IMAGES_URL', WPS_LIB_URL . '/admin/assets/images' );
define( 'WPS_ADMIN_CSS_URL', WPS_LIB_URL . '/admin/assets/css' );
define( 'WPS_ADMIN_JS_URL', WPS_LIB_URL . '/admin/assets/js' );
	
define( 'WPS_FRAMEWORK_VERSION', '1.0' );