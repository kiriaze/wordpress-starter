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

	// max-width of site container? 1680/1920
	// general rul for full-width elements; hero/banners/etc
	// add_image_size('full', 1680, 0);
	// add_image_size('article-hero', 1680, 400, true); // maybe set crop orientation to top left for all?
	// add_image_size('article-card', 400, 250, array( 'left', 'top' )); // maybe increase size for the larger res too
	// add_image_size('article-card-large', 890, 710, true); // archive cards / 770x600 for comp, but larger for large resolutions
	// // 

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
	add_theme_support('wps-breadcrumbs');        //  Enable breadcrumbs
	// add_theme_support('debug');                     //  Enable debug bar
	// add_theme_support('admin_bar');                 //  Enable admin bar

	// remove_theme_support in child theme if undesired, all enabled by default
	add_theme_support('custom_searchform');         //  Enable use of custom searchform template - /templates/searchform.php
	add_theme_support('nice-search');               //  Enables clean search in url; from /?s= to /search/result
	// add_theme_support('single-search-result');      //  Enables redirect to first result
	// add_theme_support('cpt-search-result', ['questions']);      //  Enables cpt for search results
	
	// add_theme_support('remove_admin_menu_items');   //  Remove Unwanted Admin Menu Items(left hand side)
	// add_theme_support('remove_admin_bar_links');    //  Remove Unwanted Admin Menu Items(admin bar)

	///////////////////////////////////////////
	// Other
	///////////////////////////////////////////

	// remove gutenburg editor for pages
	add_filter('use_block_editor_for_post_type', 'disable_gutenberg', 10, 2);
	function disable_gutenberg($is_enabled, $post_type) {
		
		switch ($post_type) {
			
			case 'page':
			case 'questions':
				return false;
				break;
			
			default:
				break;
		}

		return $is_enabled;
		
	}

	///////////////////////////////////////////
	// ACF
	///////////////////////////////////////////

	// faster load times for acf in backend
	// by removing wp meta fields - test
	add_filter('acf/settings/remove_wp_meta_box', '__return_true', 20);

	// theme options page - acf
	if ( function_exists('acf_add_options_page') ) {
		acf_add_options_page();
	}

}