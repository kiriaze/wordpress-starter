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

	<?php 
	// using add_theme_support( 'title-tag' ); instead
	/*<title><?php wp_title(''); ?></title>*/ 
	?>

	<meta name="description" content="<?php is_single() ? single_post_title('', true) : bloginfo('name'); echo " - "; bloginfo('description'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta name="theme-color" content="#fafafa">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
	<!--[if IE]>
	   <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->