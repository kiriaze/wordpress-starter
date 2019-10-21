<?php
/**
 * The template for displaying breadcrumbs. Supports both WPS and Yoast Breadcrumbs.
 *
 * @package WPS
 * @version 1
 * @since   1
 */
?>
<?php

if ( current_theme_supports('wps-breadcrumbs') ) {

	if ( function_exists( 'yoast_breadcrumb' ) ) {

		yoast_breadcrumb( '', '' );

	} else {
		echo WPS_Breadcrumbs::get_breadcrumb_trail( get_the_ID() );
	}

}