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

	// set the title tag automatically / seo/yoast support
	add_theme_support( 'title-tag' );

	// Custom Image Sizes
	add_theme_support( 'post-thumbnails' );

	// general rule for full-width elements; hero/banners/etc
	add_image_size('full', 1680, 0);

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
	// add_theme_support('cpt-search-result', ['events']);      //  Enables cpt for search results
	
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
			case 'product':
				return false;
				break;
			
			default:
				break;
		}

		return $is_enabled;
		
	}

	///////////////////////////////////////////
	// Other
	///////////////////////////////////////////
	
	// define local url per project for functions site wide
	define( 'WPS_LOCAL_URL', 'https://dev.local' );

	// local vs prod / hide things on prod
	$site_url = get_bloginfo('url');
	if ( $site_url === WPS_LOCAL_URL ) {

	} else {

		// 
		add_filter('wps_remove_admin_menu_items', 'wps_rami_args', 999);

		// 
		add_filter('wps_restrict_admin_with_redirect', 'wps_rawr_args', 999);

		// temp: prevent client from adding plugins since they're shady and avoiding payment for over 2 weeks now, and lying to get access to files, and hiring another developer behind our back, dafuq is wrong with people - 
		// removes the plugin and theme file editor (which are a terrible idea anyway) and removes the ability to install plugins and themes from the admin area.
		define('DISALLOW_FILE_MODS', true);

	}

	// add to which items in admin get hidden, ran in condish above
	function wps_rami_args() {
		$args = [
			'items' => [
				'SMCPT Settings'
			]
		];
		return $args;
	}

	function wps_rawr_args() {
		$args = [
			'items' => [
				'/wp-admin/themes.php',
				'/wp-admin/theme-install.php',
				'/wp-admin/theme-editor.php',
				'/wp-admin/plugins.php',
				'/wp-admin/plugin-install.php',
			]
		];
		return $args;
	}

	///////////////////////////////////////////
	// ACF
	///////////////////////////////////////////

	require_once locate_template( '/lib/acf.php', true );

	///////////////////////////////////////////
	// Gravity Forms
	///////////////////////////////////////////

	require_once locate_template( '/lib/gravityforms.php', true );

	///////////////////////////////////////////
	// WP JSON API Endpoints
	///////////////////////////////////////////

	// adding cpts to wp-json/wp/v2/posts endpoint for search by query param type[]=cptName
	add_action( 'rest_post_query', function( $args, $request ){
		$post_types = $request->get_param( 'type' );
		if( ! empty( $post_types ) ){
			if( is_string( $post_types ) ){
				$post_types = array( $post_types );
				foreach ( $post_types as $i => $post_type ){
					$object=  get_post_type_object( $post_type );
					if( ! $object || ! $object->show_in_rest   ){
						unset( $post_types[ $i ] );
					}
				}
			}
			$post_types[] = $args[ 'post_type' ];
			$args[ 'post_type' ] = $post_types;
		}
		return $args;
	}, 10, 2 );

}