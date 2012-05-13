<?php
/**
 * Additional Functions
 *
 * @package      Genesis Grid Plugin
 * @author       Travis Smith <travis@wpsmith.net>
 * @copyright    Copyright (c) 2011, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Gets image sizes. Mimics genesis_get_image_sizes.
 *
 * @return 	$gg_sizes	
 *
 */
function gg_get_image_sizes() {
	$sizes = genesis_get_image_sizes();
	foreach ( ( array ) $sizes as $name => $size ) {
		$gg_sizes[] = array('name' => $name.' ('.$size['width'].'x'.$size['height'].')', 'value' => $name) ;
	}
	return $gg_sizes;
}

/**
 * Gets terms for building a tax query.
 *
 * @return 	$gg_terms	
 *
 */
function gg_terms() {
	$gg_terms = array();
	/*array(
		$taxonomy->labels->name => array(
						'name' => $term->name,
						'value' => $term->slug
					),
	);*/
	$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

	$taxonomies = array_filter( $taxonomies, 'gg_exclude_taxonomies' );
	$test = get_taxonomies ( array( 'public' => true ), 'objects' );

	foreach ( $taxonomies as $taxonomy ) { 
		$query_label = '';
		if ( !empty( $taxonomy->query_var ) )
			$query_label = $taxonomy->query_var;
		else
			$query_label = $taxonomy->name;
		$terms = get_terms( $taxonomy->name, 'orderby=name&hide_empty=1' );
		if ($terms)
			$gg_terms[$taxonomy->labels->name] = array();
		$keys = array();
		foreach ( $terms as $term ) {
			$keys[$term->name] = array( 'name' => $term->name, 'value' => esc_attr( $query_label ) . ',' . $term->slug );
		}
		if (!$keys)
			unset($gg_terms[$taxonomy->labels->name]);
		else
			$gg_terms[$taxonomy->labels->name] = $keys;
	}
	
	return $gg_terms;
}

/**
 * Used to exclude taxonomies and related terms from list of available terms/taxonomies in widget form()
 *
 * @author Nick Croft
 * @since 0.1
 * @version 0.2
 * @param string $taxonomy 'taxonomy' being tested
 * @return string
 */
function gg_exclude_taxonomies( $taxonomy ) {
    $filters = apply_filters( 'gg_exclude_taxonomies', array( 'post_tag', 'nav_menu' ) );
    return(!in_array( $taxonomy->name, $filters ));
}

/**
 * Gets taxonomy for a specified selected item.
 *
 * @param 	string	$term	
 * @return 	string	$taxonomy	
 *
 */
function gg_taxonomy($term) {
	if ( !empty( $term ) ) {
		$term_array = explode( ',', $term );
		if ( $term_array['0'] == 'category' )
			$term_array['0'] = 'category_name';
		if ( $term_array['0'] == 'post_tag' )
			$term_array['0'] = 'tag';
	}

	if ( !empty( $term_array['0'] ) ) {
		if( $term_array['0'] == 'category_name' ) 
			$taxonomy = 'category';
		else 
			$taxonomy = $term_array['0'];
	}
	else
		$taxonomy = 'category';
		
	return $taxonomy;
}

/**
 * Pulls term for a specified selected item.
 *
 * @param 	string	$term	
 * @return 	string	$term_array	
 *
 */
function gg_term($term) {
	if ( !empty( $term ) ) {
		$term_array = explode( ',', $term );
		if ( isset( $term_array['1'] ) )
			return $term_array['1'];
		else return false;
	}
	else return false;
}

/**
 * Builds tax_query
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query#Taxonomy_Parameters
 * @param 	string	$term	
 * @return 	string	$term_array	
 *
 */
function gg_build_tax_query($terms) {
	$tax_query = array('relation' => 'OR',);

	if ( ( !empty( $terms ) ) && ( is_array($terms) ) ) {
		//set true for first instance
		$create_new = true;
		foreach ( $terms as $uterm ) {
			$taxonomy = gg_taxonomy( $uterm );
			$term = gg_term( $uterm );
			
			// Check to see if taxonomy already in array
			$i = -1;
			foreach ($tax_query as $tax ) {
				
				if ( is_array( $tax ) ) {
					$i++;
					if ( $taxonomy == $tax['taxonomy'] ) {
						//if so, just add the $term to the terms array
						//first check to see if duplicate
						$duplicate = false;
						foreach( $tax['terms'] as $dupterm ) {
							if( $term == $dupterm ) {
								$duplicate = true;
								break;
							}
						}
						if ($duplicate) {
							//reset duplicate
							$duplicate = false;
							break;
						}
						else {
							//then add
							$tax_query[$i]['terms'][] = $term;
							//reset counter
							$i = -1;
							break;
						}
					}
					else
						$create_new = true;
				}
				
			}
			if ( $create_new ) {	
				// Create new array
				$tax_query[] = array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => array($term)
				);
				//reset create_new
				$create_new = false;
			}
		}
	}
	else
		return false;
		
	return $tax_query;
}


/**
 * Obtains the attachment id from url
 *
 * @param     string		@image_url
 * @return    string/int	@id
 *
 */ 
function gg_get_attachment_id_from_url($image_url) {

	global $wpdb;
	
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_url'";
	$id = $wpdb->get_var( $wpdb->prepare( $query ) );
	
	return $id;

}

/**
 * Adds Open <div class="wrap"> Markup
 *
 *
 */ 
function gg_add_wrap_open() { ?>
	<div class="wrap">
<? }

/**
 * Adds Close Div Markup
 *
 *
 */ 
function gg_add_wrap_close() { ?>
	</div>
<? }

/**
 * Adds a break after row of teasers
 * @author Bill Erickson
 *
 */
function gg_grid_divider() {
	global $loop_counter, $paged, $gg_features, $gg_columns;
	$count = $loop_counter + 1; // Loop counter starts at zero
	
	// For first page, offset by features
	if ($paged == 0) {
		if ( ( $count > $gg_features ) && ( ($count - $gg_features) % $gg_columns == 0 ) ) echo '<div class="clear"></div>';
		
	// For other pages, just count normally
	} else {
		if ($count % $gg_columns == 0) echo '<div class="clear"></div>';
	}
	
	// Add break after teasers
	if ( ($count == $gg_features) && ($paged == 0)) echo '<div class="clear"></div>';
}

/**
 * Add some extra body classes to grid posts.
 *
 * Change the $gg_columns value to alter how many columns wide the grid uses.
 *
 * @author Gary Jones
 * @link http://dev.studiopress.com/genesis-grid-loop-advanced.htm
 *
 * @global array $_genesis_loop_args
 * @global integer $loop_counter
 * @param array $grid_classes
 */
function gg_grid_loop_post_class( $grid_classes ) {
    global $_genesis_loop_args, $loop_counter, $gg_columns, $gg_features;
	
	$gg_columns = ($gg_columns) ? $gg_columns : 3;
	
    // Only want extra classes on grid posts, not feature posts
    if ( $loop_counter >= $_genesis_loop_args['features'] ) {
 
        // Add genesis-grid-column-? class to know how many columns across we are
        $grid_classes[] = sprintf( 'genesis-grid-column-%s', ( ( $loop_counter - $_genesis_loop_args['features'] ) % $gg_columns ) + 1 );
 
        // Add size1of? class to make it correct width
        $grid_classes[] = sprintf( 'size1of%s', $gg_columns );
    }
	elseif ( ( $gg_features == 1 ) && ( $loop_counter == 0 ) ) {
		$grid_classes[] = sprintf( 'feature1', $gg_columns );
	}
	
    return $grid_classes;
}

/**
 * Enable user defined tags
 * @author Travis Smith
 *
 */
function gg_get_the_content_limit_allowedtags() {
	$tags = genesis_get_option('gg_portfolio_tags');
	return $tags;
}

/**
 * Forces layout
 * @author Travis Smith
 *
 */
function gg_cat_layout($opt) {
	$opt = 'full-width-content';
	return $opt;
} 

/**
 * Enable user defined tags
 * @author Travis Smith
 * 
 * @param	boolean/int	@post_info 
 * @param	boolean/int	@post_meta 
 */
function gg_post_remove($post_info='', $post_meta='' , $post_title='' ) {
	if ($post_info)
		remove_action('genesis_before_post_content', 'genesis_post_info');
	if ($post_meta)
		remove_action('genesis_after_post_content', 'genesis_post_meta');
	if ($post_title)
		remove_action('genesis_post_title', 'genesis_do_post_title');
}

/**
 * Modified genesis_get_custom_field() to accept arrays in custom fields
 * These functions can be used to easily and efficiently pull data from a
 * post/page custom field. Returns FALSE if field is blank or not set.
 *
 * @param string $field used to indicate the custom field key
 * @link http://www.studiopress.com/support/showthread.php?t=68957
 *
 * @since 0.1.3
 */
function gg_get_custom_field($field, $single = false) {

    global $id, $post;

    if ( null === $id && null === $post ) {
        return false;
    }

    $post_id = null === $id ? $post->ID : $id;

    $custom_field = get_post_meta( $post_id, $field, $single );

    if ( ( $custom_field ) && ( !is_array($custom_field) ) ) {
        /** sanitize and return the value of the custom field */
        return stripslashes( wp_kses_decode_entities( $custom_field ) );
    }
    elseif ( ( $custom_field ) && ( is_array($custom_field) ) ) {
        foreach ( $custom_field as $key => $value ) {
            $custom_field[$key] = stripslashes( wp_kses_decode_entities( $value ) );
        }
        return $custom_field;
    }
    else {
        /** return false if custom field is empty */
        return false;
    }

}

// Features Terms
add_action( 'cmb_render_select_group' , 'gg_select_group' , 10 , 2 );
function gg_select_group( $field, $meta ) {

		echo '<select name="', $field['id'], '" id="', $field['id'], '">';
		echo '<option value="">Default</option>';
		foreach ($field['options'] as $optgroup => $options) {
			echo '<optgroup label="', $optgroup, '"';
			foreach ($options as $option) {
				echo '<option value="', $option['value'], '"', $meta == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
			}
			echo '</optgroup>';
		}
		echo '</select>';
		echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
		
}

// Grid Terms
add_action( 'cmb_render_multicheck_group' , 'gg_multicheck_group' , 10 , 2 );
function gg_multicheck_group( $field, $meta ) {
	echo '<ul class="cmb_multicheck_group_title">';
	foreach ($field['options'] as $optgroup => $options) {
		// Append `[]` to the name to get multiple values
		// Use in_array() to check whether the current option should be checked
		echo '<li><strong>'. $optgroup . '</strong>';
		echo '<ul>';
		foreach ($options as $option) {
			echo '<li><input type="checkbox" name="', $field['id'], '[]" id="', $field['id'], '" value="', $option['value'], '"', in_array( $option['value'], (array)$meta ) ? ' checked="checked"' : '', ' /><label>', $option['name'], '</label></li>';
		}
		echo '</ul></li>';
	}
	echo '<span class="cmb_metabox_description">', $field['desc'], '</span>';
}
