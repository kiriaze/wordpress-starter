	<footer role="contentinfo" id="footer">

		<?php do_action('wps_footer_widgets', 'wps_footer_widgets'); ?>

		<div class="row footer-top">
		    <nav class="columns-2">
		        <?php wps_menu_output(array('theme_location'=>'footer-menu','container' => '','menu_class'=>'footer-menu')); ?>
		    </nav>
			<div class="columns-2 social-foot-wrapper">
	    		<?php
		        	do_action('wps_social_footer', array(
		        		'icon'	=>	false,
						// 'classes' 	=> array('flip','square', 'btn'),
						'iconFont'	=> 'fa'
					));
				?>
	    	</div>
	    </div>

	    <div class="row footer-bottom">
	    	<div class="columns-30 copyright">
	    		<p>
	    			<!-- copyright -->
	    		</p>
	    	</div>
	    	<nav class="columns-70">
		        <?php wps_menu_output(array('theme_location'=>'footer-menu','container' => '','menu_class'=>'footer-menu')); ?>
		    </nav>
	    </div>

	</footer>