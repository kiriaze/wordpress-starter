<?php

/**
 * Sets up theme defaults and registers the various WordPress features that
 * WPS supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, post thumbnails, featured content, and infinite scroll.
 * @uses flush_rewrite_rules() To reset permalinks on theme activation.
 * @uses set_post_thumbnail_size() and add_image_size To set default custom post thumbnail size and others.
 *
 * @package   WordPress
 * @subpackage  WPS
 * @version   1.0
 * @author    Constantine Kiriaze
 */


add_action( 'after_setup_theme', 'wps_setup', 10 );
function wps_setup() {

	// // Text Domain / Localization
	// load_theme_textdomain( strtolower(wps_THEME_SLUG), get_stylesheet_directory() . '/theme/assets/lang' );

	//  $content_width is a global variable used by WordPress for max image upload sizes and media embeds (in pixels).
	global $content_width;
	if ( !isset($content_width) ) {
		$content_width = 960; // set it to $medium
	}

	// add editor styles
	add_editor_style();

	// Automatic Feed Links (RSS)
	add_theme_support('automatic-feed-links');

	// Custom Image Sizes
	add_theme_support( 'post-thumbnails' );
	// add_image_size('custom-size-example', 1400, 720, true);

	// HTML5 -Switches default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	));

	// Post Formats
	add_theme_support( 'post-formats', array(
		'quote',
		'link',
		'video',
		'audio',
		'aside',
		'gallery',
		'image'
	));

	// WPS Framework Supports
	add_theme_support('wps-relative-urls');      //  Enable relative URLs
	add_theme_support('wps-rewrites');           //  Enable URL rewrites for only parent theme
	add_theme_support('wps-breadcrumbs');        //  Enable breadcrumbs
	add_theme_support('debug');                     //  Enable debug bar
	add_theme_support('admin_bar');                 //  Enable admin bar
	add_theme_support('jquery-cdn');                //  Enable to load jQuery from the Google CDN. Issue with infinite scroll if enabled, include migrate

	// remove_theme_support in child theme if undesired, all enabled by default
	add_theme_support('custom_searchform');         //  Enable use of custom searchform template - /templates/searchform.php
	add_theme_support('nice-search');               //  Enables clean search in url; from /?s= to /search/result
	add_theme_support('single-search-result');      //  Enables redirect to first result
	
	// add_theme_support('remove_admin_menu_items');   //  Remove Unwanted Admin Menu Items(left hand side)
	// add_theme_support('remove_admin_bar_links');    //  Remove Unwanted Admin Menu Items(admin bar)

}