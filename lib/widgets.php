<?php
global $wps_widgets;
$wps_widgets = array( 'wps_example_widget' );

class wps_example_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'wps_example_widget', // unique
			'template: Test Widget',
			array(
				'description' => __( 'WPS Example Widget', WPS_THEME_SLUG )
			)
		);
	}

	public function widget( $args, $instance ) {

		?>
		<div class="widget">
			<h5 class="widgettitle">Widget</h5>
			<p>Test widget</p>
		</div>
		<?php
	}

}

add_action('widgets_init', function() {
	global $wps_widgets;
	if ( is_array( $wps_widgets ) ) :
		foreach ( $wps_widgets as $widget ) {
			register_widget( $widget );
		}
	endif;
});
