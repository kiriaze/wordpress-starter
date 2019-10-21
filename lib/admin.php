<?php

/*	Show Admin bar for admins if theme supports it and add body class
**  Otherwise hide it
================================================== */

if ( current_theme_supports('admin_bar') && current_user_can( 'manage_options' ) ) {
	add_filter('show_admin_bar', 'remove_admin_bar');
	function remove_admin_bar() {
		return true;
	}
	add_filter( 'body_class', 'admin_bar_body_class', 20 );
	function admin_bar_body_class( $classes ){
		$classes[] = 'admin-bar'; // so as to add top/margin on elems
		return $classes;
	}
} else {
	add_filter('show_admin_bar', 'remove_admin_bar');
	function remove_admin_bar() {
		return false;
	}
}

/*
 * Remove Unwanted Admin Menu Items(from admin bar)
 * Filterable: $args['users'] = array(); $args['links'] = array(); return $args;
 */
if ( current_theme_supports('remove_admin_bar_links') ) :

	add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

	function remove_admin_bar_links() {

		global $wp_admin_bar;

		$args  = apply_filters('wps_remove_admin_bar_links', array());
		$users = array_key_exists('users', $args) ? $args['users'] : [];
		$links = array_key_exists('links', $args) ? $args['links'] : [];

		// users to exclude. e.g. multiple admins, exclude targeting main admin
		if ( in_array( wp_get_current_user()->user_login, $users ) ) return;

		// not removing any by default, since no clean way to unset them from child. $elements[] passed from child
		$elements = array(
			// 'wp-logo',
			// 'about',
			// 'wporg',
			// 'documentation',
			// 'support-forums',
			// 'feedback',
			// 'updates',
			// 'comments',
			// 'new-content'
		);

		$elements = array_merge($elements, $links);
		foreach ( $elements as $element ) {
			$wp_admin_bar->remove_menu($element);
		}
	}
endif;


/*
 * Remove Unwanted Admin Menu Items(left hand side)
 *
 * Populate $menu_items array to exclude Admin Menu Items. There's a list of common elements:
 * Appearance, Comments, Links, Media, Pages, Plugins, Posts, Settings, Tools, Users
 * Filterable: $args['users'] = array(); $args['items'] = array(); return $args;
 */

if ( current_theme_supports('remove_admin_menu_items') ) :

	add_action('admin_menu', 'remove_admin_menu_items', 100); // ran after everything to access menu items added late from plugins

	function remove_admin_menu_items() {

		$args  = apply_filters('wps_remove_admin_menu_items', array());
		$users = array_key_exists('users', $args) ? $args['users'] : [];
		$items = array_key_exists('items', $args) ? $args['items'] : [];

		// users to exclude. e.g. multiple admins, exclude targeting main admin
		if ( in_array( wp_get_current_user()->user_login, $users ) ) return;

		// not removing any by default, since no clean way to unset them from child. $menu_items[] passed from child
		$menu_items = array(
			// __('Comments', WPS_THEME_SLUG),
			// __('Links', WPS_THEME_SLUG),
			// __('Posts', WPS_THEME_SLUG),
			// __('Appearance', WPS_THEME_SLUG),
			// __('Plugins', WPS_THEME_SLUG),
			// __('Tools', WPS_THEME_SLUG),
			// __('Settings', WPS_THEME_SLUG),
			// __('Media', WPS_THEME_SLUG)
		);

		$menu_items = array_merge( $menu_items, $items );

		global $menu;

		foreach ( $menu as $key => $item ) {
			$item_name = $item[0] != NULL ? $item[0] : '';
			// if html tags in name, strip em. e.g. Comments/Plugins
			if ( strpos($item_name,'<') !== false ) {
				$item_name = strstr($item_name, ' <', true);
			}
			if ( in_array( $item_name, $menu_items ) ) {
				unset( $menu[$key] );
			}
		}

	}

endif;

// 

// disable the theme editor view within the wp admin
function wps_disable_theme_editing() {
	define('DISALLOW_FILE_EDIT', TRUE);
}
add_action('init','wps_disable_theme_editing');


// /*
//  * If user is not an admin, do not allow access to the dashboard AT ALL.
//  */
// function wps_remove_no_admin_access(){
// 	if ( ! defined( 'DOING_AJAX' ) && ! current_user_can( 'manage_options' ) ) {
// 		wp_redirect( home_url() );
// 		die();
// 	}
// }
// add_action( 'admin_init', 'wps_remove_no_admin_access', 1 );


/*
 * If user is not a SuperAdmin, when they try to access the below URLs they are redirected back to the dashboard.
 */
function restrict_admin_with_redirect() {

	$args  = apply_filters('wps_restrict_admin_with_redirect', array());
	$users = array_key_exists('users', $args) ? $args['users'] : [];
	$items = array_key_exists('items', $args) ? $args['items'] : [];

	// users to exclude. e.g. multiple admins, exclude targeting main admin
	if ( in_array( wp_get_current_user()->user_login, $users ) ) return;

	$restrictions = array(
		// '/wp-admin/widgets.php',
		// '/wp-admin/user-new.php',
		// '/wp-admin/upgrade-functions.php',
		// '/wp-admin/upgrade.php',
		// '/wp-admin/themes.php',
		// '/wp-admin/theme-install.php',
		// '/wp-admin/theme-editor.php',
		// '/wp-admin/setup-config.php',
		// '/wp-admin/plugins.php',
		// '/wp-admin/plugin-install.php',
		// '/wp-admin/options-writing.php',
		// '/wp-admin/options-reading.php',
		// '/wp-admin/options-privacy.php',
		// '/wp-admin/options-permalink.php',
		// '/wp-admin/options-media.php',
		// '/wp-admin/options-head.php',
		// '/wp-admin/options-general.php.php',
		// '/wp-admin/options-discussion.php',
		// '/wp-admin/options.php',
		// '/wp-admin/network.php',
		// '/wp-admin/ms-users.php',
		// '/wp-admin/ms-upgrade-network.php',
		// '/wp-admin/ms-themes.php',
		// '/wp-admin/ms-sites.php',
		// '/wp-admin/ms-options.php',
		// '/wp-admin/ms-edit.php',
		// '/wp-admin/ms-delete-site.php',
		// '/wp-admin/ms-admin.php',
		// '/wp-admin/moderation.php',
		// '/wp-admin/menu-header.php',
		// '/wp-admin/menu.php',
		// '/wp-admin/edit-tags.php',
		// '/wp-admin/edit-tag-form.php',
		// '/wp-admin/edit-link-form.php',
		// '/wp-admin/edit-comments.php',
		// '/wp-admin/credits.php',
		// '/wp-admin/about.php'
	);

	$restrictions = array_merge( $restrictions, $items );

	$site_url = get_bloginfo('url');

	foreach ( $restrictions as $restriction ) {

		// swap current_user_can for either the site_url being local, or my username/email
		// if ( ! current_user_can( 'manage_network' ) && $_SERVER['PHP_SELF'] == $restriction ) {
		if ( $site_url !== WPS_LOCAL_URL && $_SERVER['PHP_SELF'] == $restriction ) {
			wp_redirect( admin_url() );
			exit;
		}

	}

}
add_action( 'admin_init', 'restrict_admin_with_redirect' );
// 
