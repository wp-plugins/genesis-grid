<?php
/**
 * This function creates a dropdown select box,
 * for all custom post types with the option to include
 * pages and posts (but not the other builtins).
 *
 * Version: 1.0
 * Author: Travis Smith
 * URI: http://wpsmith.net
 *
 *
 * @param     html string   Output
 * @return    array			Args
 *
 * @access    private
 * @since     1.0
 */
 
function gg_dropdown_posttypes($args = array('selected' => 0)) {
	$defaults = array(
		'include_builtins' => array('page','post','attachment'), //also mediapage, revision (not public), nav_menu_item (not public)
		'excludes' => '', //array of cpts to exclude
	); 
	
	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$post_types = get_post_types( array('public' => true,'_builtin' => false) , 'objects' , 'and' ); 
	$output = array();
	
	if ( ( !empty($post_types) ) || (!empty($include_builtins)) ) {

		if ( $include_builtins ) {
			foreach ($include_builtins  as $builtin ) {
				$obj = get_post_type_object($builtin);
				$output[$obj->name] = $obj->labels->name;
			}
		}
		foreach ($post_types  as $post_type ) {
			if ($excludes) {
				$skip = false;
				foreach ($excludes  as $exclude ) {
					if ($exclude == $post_type->name) {
						$skip = true;
						break;
					}
				}
				if ($skip) break;
			}
			
			$output[$post_type->name] = $post_type->label;
		}
	}

	return $output;
}
