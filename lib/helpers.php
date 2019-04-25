<?php
/*
*
*	Helper Functions
*
*	This file is broken in the following areas:
*
*	1. CSS Classes
*		- Body Class
*		- Remove Injected Classes
*		- Post Container Class
*		- Change markup of images inserted in post content
*
*	@package	WPS
*	@since		1.0
*	@version	1.0
*/


/* ============================================
	1. CSS Classes
============================================ */

/*	Body Classes : Remove wp defaults, add clean classes
*   priority 0 to prevent other plugins from messing up body classes
================================================== */
add_filter( 'body_class', 'wps_body_class', 0 );
function wps_body_class( $classes ){

	global $post;

	//	Conditional Checking
	$loggedIn     = is_user_logged_in() ? 'logged-in' : '';
	$template     = !is_tax() && !is_category() ? basename( get_page_template() ) : '';
	$templateName = $template ? 'page-template-'. substr($template, 0, -4) : '';
	
	$posts        = ( is_category() || is_search() || is_home() ) ? 'archive-posts' : '';
	$archive      = is_post_type_archive() ? 'archive-' . strtolower(post_type_archive_title('', false)) : '';
	$author       = is_author() ? 'author-template' : '';
	$single       = is_single() ? 'single-'. $post->post_type : '';

	//	Output classes
	return array(
		$posts,
		$archive,
		$author,
		$templateName,
		$loggedIn,
		$single
	);

	return $classes;

}


/*	Remove Injected classes, ID's and Page ID's from Navigation <li> items
================================================== */
add_filter('nav_menu_css_class', 'wps_css_attributes_filter', 100, 2);
add_filter('nav_menu_item_id', 'remove_wps_css_attributes_filter', 100, 2);
add_filter('page_css_class', 'remove_wps_css_attributes_filter', 100, 2);

function remove_wps_css_attributes_filter($var) {
	$var = is_array($var) ? array_intersect( $var,
		array(
			'current-menu-item',
			'menu-parent-item',
			'current_page_ancestor',
		)
	) : '';
	return $var;
}

function wps_css_attributes_filter($classes, $item) {
	$var = is_array($item->classes) ? array_intersect( $item->classes,
		array(
			'has-children',
			// 'menu-item-has-children',
			'current-menu-item',
			'menu-parent-item',
			'current_page_ancestor',
			 $item->classes['0']
		)
	) : '';
	return $var;
}

// REPLACE "current_page_" WITH CLASS "active"
function current_to_active($text){
	$replace = array(
		// List of classes to replace with "active"
		'current_page_item' => 'active',
		'current_page_parent' => 'active',
		'current_page_ancestor' => 'active',
		// 'current-menu-item' => 'active'
	);
	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;
}
add_filter ('wp_nav_menu','current_to_active');


/*	Post Container Class
================================================== */
add_filter( 'post_class', 'wps_post_class' );
function wps_post_class( $classes ){
	global $post;

	$classes[] = 'post';

	return $classes;
}

/*	Upload svg capability through wp media upload
================================================== */
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


/* ============================================
	2. Debugging
============================================ */

/*	Debug Bar
============================================ */
add_action('wp_footer', 'wps_debug');
function wps_debug($current_user){

	global $template;
	$template 		= basename( wps_template_path() );
	$template 		= explode( '/', $template );
	$array_count 	= count( $template );
	$array_count 	= $array_count - 1;
	$template 		= $template[$array_count];

	// if theme enables it
	if ( current_theme_supports('debug')  )

	// if user is currently logged in and its in local env
	if ( is_user_logged_in() && ($_SERVER['SERVER_NAME'] === 'localhost' || strpos($_SERVER['SERVER_NAME'], '.local') !== false) ) {

		global $current_user;
		get_currentuserinfo();

	?>

	<script type="text/javascript">
		console.log( 'Template: <?php echo $template; ?>' );
	</script>

	<?php

		$debug_bar = '<style>
						#debug-bar{
							position: fixed;
							max-width: 40px;
							width: auto;
							height: 40px;
							z-index: 100;
							bottom: 10px;
							left: 10px;
							background: #FFFFFF;
							border: 1px solid #ddd;
							font-family: "Open Sans", sans-serif;
							padding: 10px 13px;
							color: #535353;
							text-transform: uppercase;
							transition: max-width .35s linear;
							white-space: nowrap;
							cursor: pointer;
							overflow: hidden;
						}
						#debug-bar i {
							vertical-align: middle;
						}
						#debug-bar p {
							font-size: 12px;
							display: inline-block;
							text-indent: 12px;
							vertical-align: top;
							padding: 0;
							margin: 0;
							line-height: 1.8;
						}
						#debug-bar:hover {
							max-width: 800px;
						}
						</style>';
		$debug_bar .= '<div id="debug-bar">';
		$debug_bar .= '<i class="fa fa-gear"></i><p>';
		$debug_bar .= 'User: <a href="/admin">' . $current_user->display_name . '</a>';
		$debug_bar .= ' | Role: ' . $current_user->roles[0];
		$debug_bar .= ' | Template: ' . $template;
		$debug_bar .= '</p>';
		$debug_bar .= '</div>';

		echo $debug_bar;
	}

}


/*	WPS Print
*	Ex. Usage:
*	sp($var, array('strip_tags' => true, 'allow_tags' => '<p><a>'));
*	sp([$foo, $bar, $foobar, $text], ['strip_tags' => true, 'allow_tags' => '<p><a>']);
================================================== */

function clean($el, $args = []) {
	if ( array_key_exists('tags', $args) ) {
		return strip_tags($el, htmlspecialchars_decode($args['tags']));
	} else {
		return strip_tags($el);
	}
}

function sp( $var = [], $args = [] ) {

	$defaults = array(
		'strip_tags'  	=> false,
		'allow_tags'	=> null
	);

	$options = array_merge($defaults, array_map('htmlspecialchars', $args));

	if ( $options['strip_tags'] ) {

		if ( $options['allow_tags'] ) {
			$tags            = $options['allow_tags'];
			$options['tags'] = $tags;
		}

		if ( is_array($var) ) {
			foreach ( $var as $key => $item ) {
				if ( is_array($item) ) {
					foreach ($item as $key2 => $value) {
						echo '<pre>';
						echo clean($value, $options);
						echo '</pre>';
					}
				} else {
					echo '<pre>';
					echo clean($item, $options);
					echo '</pre>';
				}
			}
		} else {
			echo '<pre>';
			echo clean($var, $options);
			echo '</pre>';
		}

	} else {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

}


/* ============================================
	3. Removals
============================================ */


/*	Remove 'text/css' from our enqueued stylesheet
================================================== */
add_filter('style_loader_tag', 'wps_style_remove');
function wps_style_remove($tag) {
	return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}


/*	Remove <p> tags in Dynamic Sidebars
================================================== */
add_filter('widget_text', 'shortcode_unautop');


/*	Remove invalid rel attribute
================================================== */
add_filter('the_category', 'remove_category_rel_from_category_list');
function remove_category_rel_from_category_list($thelist) {
	return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}


/*	Remove wp_head() injected Recent Comment styles
================================================== */
add_action('widgets_init', 'wps_remove_recent_comments_style');
function wps_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array(
		$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
		'recent_comments_style'
	));
}


/*	Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
================================================== */
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
function remove_thumbnail_dimensions( $html ) {
	$html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
	return $html;
}


/*	Remove <p> tags from the images and iFrame
================================================== */
add_filter('the_content', 'wps_img_iframe_unautop');
function wps_img_iframe_unautop( $content ){
	$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}


/* ============================================
	4. Text Mods
============================================ */

/*	TRUNCATE ANYTHING - CHARACTERS
================================================== */
function truncate_text( $string, $character_limit = 50, $truncation_indicator = '...' ) {

	$truncated = null == $string ? '' : $string;
	$getlength = strlen($truncated);

	if ( $getlength > $character_limit ) {

		$truncated = substr( $truncated, 0, strrpos(substr($truncated, 0, $character_limit), ' ') );
		$truncated .= '...';

		$truncated = $truncated . $truncation_indicator;
	}

	return sprintf( __('%s', WPS_THEME_SLUG), $truncated );
}

/*	TRUNCATE ANYTHING - WORDS
================================================== */
function truncate_words( $text, $limit, $truncation_indicator = '...' ) {

	if ( str_word_count($text, 0) > $limit ) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]) . '...' . $truncation_indicator;
	}
	return $text;
}

/*	EXCERPTS
================================================== */
//	Add Excerpts for Pages
add_post_type_support( 'page', 'excerpt' );
//	Hide auto generated excerpts
function full_excerpt() {
	if ( !has_excerpt() ) {
		echo '';
	} else {
		echo get_the_excerpt();
	}
}

//	Set "more" context for excerpts
add_filter('excerpt_more', 'wps_excerpt_more');
function wps_excerpt_more() {
	global $post;
	return '<br /><a href="'. get_permalink($post->ID) . '" class="read-more">' . __( 'Read More', WPS_THEME_SLUG) . '</a>';
}

// Example combining truncate_text and wps_excerpt_more
// echo truncate_text( get_the_excerpt(), 50, wps_excerpt_more() );

/*	WPS title for pages : wps_title();
================================================== */
function wps_title() {

	if ( is_home() ) {
		if ( get_option('page_for_posts', true) ) {
			$title = get_the_title( get_option('page_for_posts', true) );
		} else {
			$title = __('Latest Posts', WPS_THEME_SLUG);
		}
	} elseif ( is_archive() ) {
		$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
		if ( $term ) {
			$title = $term->name;
		} elseif ( is_post_type_archive() ) {
			$title = get_queried_object()->labels->name;
		} elseif ( is_day() ) {
			$title = sprintf( __('Daily Archives: %s', WPS_THEME_SLUG), get_the_date() );
		} elseif ( is_month() ) {
			$title = sprintf( __('Monthly Archives: %s', WPS_THEME_SLUG), get_the_date('F Y') );
		} elseif ( is_year() ) {
			$title = sprintf( __('Yearly Archives: %s', WPS_THEME_SLUG), get_the_date('Y') );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			$title = sprintf( __('Author Archives: %s', WPS_THEME_SLUG), $author->display_name );
		} else {
			$title = single_cat_title( '',false );
		}
	} elseif ( is_search() ) {
		$title = sprintf( __('Search Results for %s', WPS_THEME_SLUG), get_search_query() );
	} elseif ( is_404() ) {
		$title = __('Not Found', WPS_THEME_SLUG);
	} else {
		$title = get_the_title();
	}

	return $title;

}

/* ============================================
	5. Search & Pagination
============================================ */

/*	WPS Search Form
============================================ */
function wps_search_form( $form ) {
	$form = '
<form role="search" method="get" class="search-form" action="'.home_url() .'">
	<label>
		<input type="search" class="search-field" placeholder="'. __('Type and press enter', WPS_THEME_SLUG) .'" value="" name="s" title="'. __('Search for:', WPS_THEME_SLUG) .'">
	</label>
	<input type="submit" class="search-submit" value="Search">
</form>
	';

	return $form;
}

add_filter( 'get_search_form', 'wps_search_form' );


/*	Redirect to result if only one found
============================================ */
if ( current_theme_supports('single-search-result') ) :
	function single_search_result() {
		if ( is_search() ) {
			global $wp_query;
			if ( $wp_query->post_count == 1 ) {
				wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
			}
		}
	}
	add_action('template_redirect', 'single_search_result');
endif;

/*	Search only posts, not pages
============================================ */
if ( !is_admin() ) {
	function wps_search_filter($query) {
		if ( $query->is_search && !is_admin() ) {
			$post_types	= apply_filters('wps_search_filter', $query);
			$query->set( 'post_type', $post_types );
		}
		return $query;
	}
	add_filter('pre_get_posts','wps_search_filter');
}

/* ============================================
	6. Commenting
============================================ */

/*	Switch off Comments on Pages by default.
================================================== */
function wps_default_comments_off( $data ) {

	if ( $data['post_type'] == 'page' && $data['post_status'] == 'auto-draft' ) {
		$data['comment_status'] = 0;
	}

	return $data;
}

add_filter( 'wp_insert_post_data', 'wps_default_comments_off' );


/*	Change default fields, add placeholder and change type attributes.
================================================== */
// add_filter( 'comment_form_default_fields', 'wps_comment_form_placeholders' );
// function wps_comment_form_placeholders( $fields ) {

// 	// // name
// 	// $fields['author'] = str_replace(
// 	// 	'<input id="author"',
// 	// 	'<input type="text" placeholder="Your name" id="author" name="author"',
// 	// 	$fields['author']
// 	// );

// 	// // email
// 	// $fields['email'] = str_replace(
// 	//     '<input id="email"',
// 	//     '<input type="email" placeholder="Email Address" id="email" name="email"',
// 	//     $fields['email']
// 	// );

// 	// // website
// 	$fields['url'] = ''; // removes website field
// 	// $fields['url'] = str_replace(
// 	//     '<input id="url"',
// 	//     '<input placeholder="http://example.com" id="url" name="url" type="url"',
// 	//     $fields['url']
// 	// );

// 	return $fields;
// }


/*	Threaded Comments
================================================== */

add_action('get_header', 'enable_threaded_comments');
function enable_threaded_comments() {
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}
	}
}


/* ============================================
	8. Meta
============================================ */

/*	Wordcount
================================================== */
// function wordcount() {
//     ob_start();
//     the_content();
//     $content = ob_get_clean();
//     return sizeof( explode(" ", $content) );
// }


/*	Reading Time
================================================== */
function reading_time() {
	global $post;
	// READING TIME CALCULATIONS
	$mycontent = $post->post_content;
	$words = str_word_count(strip_tags($mycontent));
	$reading_time = floor($words / 200); // avg is 250 words per min

	// IF LESS THAN A MINUTE - DISPLAY 1 MINUTE
	if ($reading_time == 0 )  {
		$reading_time = '1';
	}
	return $reading_time;
}


/*	Post Views
================================================== */
// function wpb_set_post_views($postID) {
//     $count_key = 'wpb_post_views_count';
//     $count = get_post_meta($postID, $count_key, true);
//     if($count==''){
//         $count = 0;
//         delete_post_meta($postID, $count_key);
//         add_post_meta($postID, $count_key, '0');
//     }else{
//         $count++;
//         update_post_meta($postID, $count_key, $count);
//     }
// }
// // To keep the count accurate, lets get rid of prefetching
// // remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // done in wordpress-resets.php

// // Set View Count
// function wpb_track_post_views( $postID ) {
//     if ( !is_single() ) return;
//     if ( empty ( $postID) ) {
//         global $post;
//         $postID = $post->ID;
//     }
//     wpb_set_post_views($postID);
// }
// add_action( 'wp_head', 'wpb_track_post_views');

// // Get View Count
// function wpb_get_post_views( $postID = null ) {
//     if ( empty ( $postID) ) {
//         global $post;
//         $postID = $post->ID;
//     }
//     $count_key = 'wpb_post_views_count';
//     $count = get_post_meta($postID, $count_key, true);
//     if($count==''){
//         delete_post_meta($postID, $count_key);
//         add_post_meta($postID, $count_key, '0');
//         return "0 Views";
//     }
//     return $count.' Views';
// }




/* ============================================
	9. Add custom columns to admin
============================================ */

//	Add page columns
function add_custom_page_columns( $columns ) {
	$columns['template'] = __( 'Page Template', WPS_THEME_SLUG );
	$column_thumb        = array( 'thumbnail' => __( 'Thumbnail', WPS_THEME_SLUG ) );
	$columns             = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );
	$columns['id']       = 'ID';
	return $columns;
}
add_filter( 'manage_page_posts_columns', 'add_custom_page_columns', 10 );


// Add post columns
function add_custom_post_columns( $columns ) {
	global $post;
	if ( $post->post_type === 'product' ) return;
	$column_thumb  = array( 'thumbnail' => __( 'Thumbnail', WPS_THEME_SLUG ) );
	$columns       = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );
	$columns['id'] = 'ID';
	return $columns;
}
add_filter( 'manage_posts_columns', 'add_custom_post_columns', 10 );


//	Add thumbnails to columns
function display_custom_column_data( $column ) {

	global $post;

	// if ( $post->post_type === 'product' ) return;

	if ( get_post_type($post) == 'post' || get_post_type($post) == 'page' ) :
		if ( $column == 'thumbnail' ) :
			echo get_the_post_thumbnail( $post->ID, array(35, 35) );
		endif;
	endif;

	switch ( $column ) {

		case 'template':

			if ( get_post_type($post) == 'page' ) :

				$template_name = '';

				// If we're looking at our custom column, then let's get ready to render some information.
				if ( 'template' == $column ) :

					// First, the get name of the template
					$template_name = get_page_template_slug( $post->ID );

					// If the file name is empty or the template file doesn't exist (because, say, meta data is left from a previous theme)...
					if ( 0 == strlen( trim( $template_name ) ) || ! file_exists( get_stylesheet_directory() . '/' . $template_name ) ) :

						// ...then we'll set it as default
						$template_name = __( 'Default', WPS_THEME_SLUG );

					// Otherwise, let's actually get the friendly name of the file rather than the name of the file itself
					// by using the WordPress `get_file_description` function
					else:

						$template_name = get_file_description( get_stylesheet_directory() . '/' . $template_name );

					endif;

				endif;

				// Finally, render the template name
				echo $template_name;

				endif;

		break;

		case 'id':
			echo $post->ID;
		break;

	}

}
add_action( 'manage_posts_custom_column', 'display_custom_column_data', 10, 2 );
add_action( 'manage_pages_custom_column', 'display_custom_column_data', 10, 2 );


//	Register the column as sortable
function custom_column_register_sortable( $columns ) {
	$columns['id']        = 'id';
	$columns['thumbnail'] = 'thumbnail';
	$columns['template']  = 'template';

	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'custom_column_register_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'custom_column_register_sortable' );


// Output CSS for width of new column ID
function id_css() {
?>
<style type="text/css">
	#id {
		width: 50px;
	}
	/* also wp_auth_check modal when session expired in admin styles */
	#wp-auth-check-wrap #wp-auth-check {
		padding: 0;
	}
	#wp-auth-check-wrap #wp-auth-check-form {
		overflow: hidden;
	}
	#wp-auth-check-wrap #wp-auth-check-form iframe {
		height: 100%;
	}
</style>
<?php
}
add_action('admin_head', 'id_css');


/* ============================================
	10. Other
============================================ */

// boolval fix for php versions under 5.5
if ( !function_exists('boolval') ) {
	function boolval($val) {
		return (bool) $val;
	}
}

// Check if on login page
function is_login() {
	return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
}

// get_template_part without echo
function load_template_part($template_name, $part_name = null) {
	ob_start();
	get_template_part($template_name, $part_name);
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}

// wps get_template_part with optional params
function wps_get_template_part($path, $args = [], $echo = true) {
	if (!empty($args)) {
		extract($args);
	}
	if ($echo) {
		include(locate_template($path . '.php'));
		return;
	}
	ob_start();
	include(locate_template($path . '.php'));
	return ob_get_clean();
}