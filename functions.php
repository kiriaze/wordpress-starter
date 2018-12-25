<?php
/**
 * Mouthwash 1.0
 *
 * This file enables the core features of the Mouthwash site including sidebars, menus, post thumbnails, post formats, header, backgrounds, and more.
 * Some functions are able to be overridden using child themes. These functions will be wrapped in a function_exists() conditional.
 * They are auto loaded from within functions directory.
 *
 * @package     WordPress
 * @subpackage  Mouthwash
 * @version     1.0
*/

require_once locate_template( '/lib/constants.php', true );
require_once locate_template( '/lib/setup.php', true );

add_action( 'after_setup_theme', 'load_functions', 10 );
function load_functions() {

	require_once locate_template( '/lib/admin.php', true );
	require_once locate_template( '/lib/ajax.php', true );
	require_once locate_template( '/lib/breadcrumbs.php', true );
	require_once locate_template( '/lib/comments.php', true );
	require_once locate_template( '/lib/cpt-archive-menu.php', true );
	require_once locate_template( '/lib/custom-templates.php', true );
	require_once locate_template( '/lib/head-scripts.php', true );
	require_once locate_template( '/lib/helpers.php', true );
	require_once locate_template( '/lib/login.php', true );
	require_once locate_template( '/lib/menus.php', true );
	require_once locate_template( '/lib/rewrites.php', true );
	require_once locate_template( '/lib/scripts-styles.php', true );
	require_once locate_template( '/lib/search.php', true );
	require_once locate_template( '/lib/sidebars.php', true );
	require_once locate_template( '/lib/widgets.php', true );
	require_once locate_template( '/lib/wordpress-resets.php', true );
	require_once locate_template( '/lib/wrapper.php', true );

}