<?php

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 */
function wps_nice_search_redirect() {
	
	global $wp_rewrite;

	if ( !isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->get_search_permastruct() ) {
		return;
	}

	$search_base = $wp_rewrite->search_base;

	if ( is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false && strpos($_SERVER['REQUEST_URI'], '&') === false ) {
		wp_redirect(get_search_link());
		exit();
	}

}

if ( current_theme_supports('nice-search') ) {
	add_action('template_redirect', 'wps_nice_search_redirect');
}


/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function wps_request_filter($query_vars) {
	if (isset($_GET['s']) && empty($_GET['s'])) {
		$query_vars['s'] = ' ';
	}
	return $query_vars;
}
add_filter('request', 'wps_request_filter');

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 * Global custom search form ( defaults to generic form )
 * Can extend to different templates if needed; e.g. different form for cpt
 */
if ( current_theme_supports('custom_searchform') ) :
	function wps_get_search_form($form) {
		global $wp_query;
		$form = '';
		$post_type = $_GET['post_type'];
		if ( $wp_query->is_search && !is_admin() ) {
			if ( $post_type == 'questions' ) {
				locate_template('/templates/search-questions.php', true, false);
			} else {
				locate_template('/templates/search-default.php', true, false);
			}
		}
		return $form;
	}
	add_filter('get_search_form', 'wps_get_search_form');
endif;


/**
 * Search for Questions CPT (help)
 * Required for CPT's otherwise WP errors out
 */
if ( current_theme_supports('cpt-search-result') ) :
	function searchfilter($query) {
		global $_wp_theme_features;
		$args = $_wp_theme_features['cpt-search-result'][0];
		if ( $query->is_search && !is_admin() ) {
			if ( isset($_GET['post_type']) ) {
				$type = $_GET['post_type'];
				if ( in_array($type, $args) ) {
					$query->set('post_type', $args);
				}
			} else {
				$query->set('post_type', 'post');
			}
		}
		return $query;
	}
	add_filter('pre_get_posts', 'searchfilter');
endif;