<?php
/**
 * The template is for rendering the header.
 *
 * @package   WordPress
 * @subpackage  WPS
 * @version   1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie7 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie7 lt-ie8 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php __(wp_title('&laquo;', true, 'right'), WPS_THEME_SLUG); ?></title>

    <meta name="description" content="<?php is_single() ? single_post_title('', true) : bloginfo('name'); echo " - "; bloginfo('description'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
	<!--[if lt IE 8]><div class="alert alert-warning"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience. <a class="close" data-dismiss="alert" href="#">&times;</a>', WPS_THEME_SLUG); ?></div><![endif]-->

	<?php
		do_action('get_header');
		get_template_part( 'partials/header' );
	?>