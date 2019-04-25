<?php
/**
 * The template is for rendering the header.
 *
 * @package   WordPress
 * @subpackage  WPS
 * @version   1.0
 */
?>
<!doctype html>
<!--[if IE 9]> <html class="ie9 no-js supports-no-cookies" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js supports-no-cookies" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php __(wp_title('&laquo;', true, 'right'), WPS_THEME_SLUG); ?></title>

	<meta name="description" content="<?php is_single() ? single_post_title('', true) : bloginfo('name'); echo " - "; bloginfo('description'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
	<!--[if lt IE 8]><div class="alert alert-warning"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience. <a class="close" data-dismiss="alert" href="#">&times;</a>', WPS_THEME_SLUG); ?></div><![endif]-->