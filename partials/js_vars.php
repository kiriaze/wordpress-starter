<script>
	// JAVASCRIPT HOOK VARS
	var framework_url	 		= '<?php echo get_template_directory_uri(); ?>/';
	var template_url 			= '<?php echo get_stylesheet_directory_uri(); ?>/';
	var plugins_url 			= '<?php echo plugins_url(); ?>/';
	var front_page   			= '<?php echo is_front_page(); ?>';
	var is_singular				= '<?php echo is_singular(); ?>';
	var page_name				= "<?php echo preg_replace('/\W/', '_', strtolower(wps_title()) ); ?>";
	var iOS						= ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
	var wps_theme_slug			= '<?php echo strtolower(get_template()); ?>';

	var site_url				= "<?php echo site_url(); ?>";
	var template				= "<?php echo basename( get_page_template() ); ?>"
</script>