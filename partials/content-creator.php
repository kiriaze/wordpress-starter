<?php
// ========================================
// ACF page builder example
// ========================================

// check if the flexible content field has rows of data
if ( have_rows('content_creator') ) :

    // loop through the rows of data
    while ( have_rows('content_creator') ) : the_row();

        if ( get_row_layout() == 'cc_fw' ) :

			$cc_fw_title 		= get_sub_field('cc_fw_title');
			$cc_fw_content 		= get_sub_field('cc_fw_content');
			
 			$html .= '<section class="">';
	 			$html .= $cc_fw_title;
	 			$html .= $cc_fw_content;
			$html .= '</section>';

			echo $html;

        endif;

    endwhile;

else :

    // no layouts found

endif;