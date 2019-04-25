<?php

// possibly abstract the array of menus into setup.php
// and pass them into this function; if so, do the same with widgets, sidebars, templates, etc.
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'main-menu' 	=> 'Main Menu',
			'footer-menu' 	=> 'Footer Menu',
			'mobile-menu' 	=> 'Mobile Menu',
		)
	);
}

if ( !function_exists('wps_menu_output') ) {

	function wps_menu_output($args=array()){

		$defaults = array(
			'theme_location'  => '',
			'menu'            => '',
			'container'       => false,
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => '',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);

		$options = array_merge($defaults, $args);

		echo wp_nav_menu($args);

	}

}

// This function is responsible for adding custom class to parent menu item's
// look at helper menu class filters to ignore removal
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class', 10, 2 );
function add_menu_parent_class( $items ) {
	
	$parents = array();
	
	foreach ( $items as $item ) {
		// Check if the item is a parent item
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'has-children';
		}
	}

	return $items;
}

// initial menu registration in admin
add_action('after_setup_theme', 'initial_menu_setup', 10);
function initial_menu_setup() {

	// register menus in dropdown
	$menus = get_registered_nav_menus();
	foreach ( $menus as $key => $value ) {

		$wps_nav_mod = false;

		$main_menu = wp_get_nav_menu_object($value);

		if ( !$main_menu ) {
			$main_menu_id = wp_create_nav_menu($value, array('slug' => $value));
			$wps_nav_mod[$value] = $main_menu_id;
		} else {
			$wps_nav_mod[$value] = $main_menu->term_id;
		}

		if ( $wps_nav_mod ) {
			set_theme_mod('nav_menu_locations', $wps_nav_mod);
		}
	}

}

// Get Nested Menu Array Output
// Usage
// $menu = new NestedMenu('menu-name');
// foreach ( $menu->items as $item ) :
// sp($item);
// $submenu = $menu->get_submenu($item);
// if ( $submenu ) :
// foreach ( $submenu as $subitem ) :
// sp($subitem);
// endforeach;
// endif;
// endforeach;
class NestedMenu {

	private $flat_menu;
	public $items;

	function __construct($name) {

		$this->flat_menu = wp_get_nav_menu_items($name);
		$this->items     = array();

		if ( $this->flat_menu ) {
			foreach ( $this->flat_menu as $item ) {
				if ( !$item->menu_item_parent ) {
					array_push($this->items, $item);
				}
			}
		}

	}

	public function get_submenu($item) {
		$submenu = array();
		foreach ( $this->flat_menu as $subitem ) {
			if ( $subitem->menu_item_parent == $item->ID ) {
				array_push($submenu, $subitem);
			}
		}
		return $submenu;
	}

}

// Return sub menus only, accepts multiple through arrays
// array(
// 	'menu'      => 'mega-menu',
// 	'submenu'   => array('Page Name'),
// 	'container' => '',
// );
add_filter('wp_nav_menu_objects', 'nav_submenu_objects_filter', 10, 2);
function nav_submenu_objects_filter( $items, $args ) {
	
	// $loc should be an array of items. if it's empty, move along
	$loc = isset( $args->submenu ) ? $args->submenu : '';
	
	if ( !isset($loc) || empty($loc) ) {
		return $items;
	}
	
	if ( is_string($loc) ) {
		$loc = split("/", $loc);
	}

	if ( empty($loc) ) {
		return $items;
	}

	// prepare a slug for every item
	foreach ( $items as $item ) {
		if ( empty($item->slug) ) {
			$item->slug = sanitize_title_with_dashes($item->title);
		}
	}

	//  find the selected parent item ID(s)
	$cursor = 0;
	foreach ( $loc as $slug ) {
		$slug = sanitize_title_with_dashes($slug);
		foreach ( $items as $item ) {
			if ( $cursor == $item->menu_item_parent && $slug == $item->slug ) {
				$cursor = $item->ID;
				continue 2;
			}
		}
		return array();
	}

	//  walk finding items until all levels are exhausted
	$parents = array($cursor);
	$out     = array();

	while ( !empty($parents) ) {

		$newparents = array();

		foreach ( $items as $item ) {
			if ( in_array( $item->menu_item_parent, $parents ) ) {
				if ( $item->menu_item_parent == $cursor ) {
					$item->menu_item_parent = 0;
				}
				$out[]        = $item;
				$newparents[] = $item->ID;
			}
		}

		$parents = $newparents;
	}

	return $out;
}


// Custom menu markup
// Used primarily for the Plans dropdown with extra details like image
// Intented to use with locations, like 'primary'
// clean_custom_menu("primary");
function clean_custom_menu( $theme_location, $menu_class ) {
	if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
	
		$menu       = get_term( $locations[$theme_location], 'nav_menu' );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		
		$menu_list  = '<ul class="menu '. $menu_class .'">' ."\n";
		
		$count      = 0;
		$submenu    = false;

		// store parent id's of items for has-children class
		$parents = [];
		foreach( $menu_items as $menu_item ) {
			// Check if the item is a parent item
			if ( $menu_item->menu_item_parent && $menu_item->menu_item_parent > 0 ) {
				$parents[] = $menu_item->menu_item_parent;
			}

		}
		// 

		foreach( $menu_items as $menu_item ) {

			$link    = $menu_item->url;
			$title   = $menu_item->title;
			$desc    = $menu_item->description;
			$obj     = $menu_item->object;
			$classes = '';
			$image   = get_field('menu_item_image', $menu_item) ? get_field('menu_item_image', $menu_item) : '';

			// assign parent class to items with children
			if ( in_array( $menu_item->ID, $parents ) ) {
				$menu_item->classes[] = 'has-children';
				// remove empty classes, and space delimiter
				$classes = implode(' ', array_filter($menu_item->classes));
			}

			if ( !$menu_item->menu_item_parent ) {
				$parent_id = $menu_item->ID;
				$menu_list .= '<li class="menu__item '. $classes .'">' ."\n";
				$menu_list .= '<a href="'.$link.'">'.$title.'</a>' ."\n";
			}

			if ( $parent_id == $menu_item->menu_item_parent ) {

				if ( !$submenu ) {
					$submenu = true;
					$sub_class = $image ? 'sub-menu--image' : '';
					$menu_list .= '<ul class="sub-menu '. $sub_class .'">' ."\n";
				}

				$menu_list .= '<li class="menu__item">' ."\n";

				// if item has an image attached
				// show an alternate layout for submenu items
				if ( $image ) {
					$menu_list .= '<a href="'.$link.'">';
						$menu_list .= '<img src="'. $image['sizes']['shop_single']  .'" alt="">';
						$menu_list .= '<h5>' . $title . '</h5>';
						$menu_list .= '<h6>' . $menu_item->description . '</h6>';
					$menu_list .= '</a>' ."\n";
				} else {
					$menu_list .= '<a href="'.$link.'">'.$title.'</a>' ."\n";
				}

				$menu_list .= '</li>' ."\n";


				if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
					$menu_list .= '</ul>' ."\n";
					$submenu = false;
				}

			}

			if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id ) { 
				$menu_list .= '</li>' ."\n";      
				$submenu = false;
			}

			$count++;
		
		}

		$menu_list .= '</ul>' ."\n";

	} else {
		$menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
	}
	
	echo $menu_list;

}