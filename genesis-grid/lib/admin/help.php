<?php

add_action( 'add_meta_boxes' , 'gg_help' , 10 , 2 );
function gg_help ( $post_type, $post ) {
	global $wp_version;
	if ( $wp_version >= 3.3 ) {
		if ( 'page' == $post_type ) {
			$genesis_grid = '<p>' . __( 'By default, the Genesis Grid meta box appears. However, the template still defaults to the Default template. If you forget to change the template, in order for the various Genesis Grid options/fields meta box to appear again, change the template to the Genesis Grid template and update/save the post. Once saved, various options/fields will appear.') . '</p>';

			get_current_screen()->add_help_tab( array(
				'id'      => 'genesis-grid',
				'title'   => __( 'Genesis Grid' , GG_DOMAIN ),
				'content' => $genesis_grid,
			) );
		}
	}
}