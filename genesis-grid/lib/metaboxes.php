<?php

/**
 * Template File
 *
 * Creates the metaboxes for the Grid Template,
 * and sanitizes the options.
 *
 * @package      Genesis Grid Plugin
 * @author       Travis Smith <travis@wpsmith.net>
 * @copyright    Copyright (c) 2011, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
 *
 * FUTURE RELEASE
 * @todo Add more options for portfolio. Add CPTs.
 */


/**
 * Sets Gridblog metaboxes to hidden by default
 *
 */
add_filter('default_hidden_meta_boxes', 'gg_hidden_meta_boxes', 10 , 2);
function gg_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden[] = 'genesis_grid';
	return $hidden;
}

/**
 * Creates metaboxes for 'page' post type for Grid Loop
 *
 */


add_filter( 'cmb_meta_boxes', 'gg_create_metaboxes' );
function gg_create_metaboxes( $meta_boxes ) {
	global $gg_prefix;
	$gg_prefix = '_gg_'; // start with an underscore to hide fields from custom fields list
		
	$meta_boxes[] = array(
		'id' => 'genesis_grid',
		'title' => 'Grid Setup',
		'pages' => array( 'page' ), // post type
		'show_on' => array( 'key' => 'page-template' , 'value' => 'page-genesis_grid.php' ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Grid Featured Posts' , GG_DOMAIN),
				'desc' => __( 'If category/terms are the same AND post type are the same, then whatever you select on post info and post meta will determine the entire schema. However, if you select different terms OR post types, then post info and post meta will be determined by both selections below (one under Grid Featured Posts and on under Grid Posts). Also, leaving Posts per Page (at the bottom) blank can result in nothing appearing.', GG_DOMAIN),
				'type' => 'title',
			),
			array(
				'name' => __( 'Content Section', GG_DOMAIN),
				'desc' => __( 'Show content from the content editor?', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_content_editor',
				'type' => 'checkbox'
			),
			array(
				'name' => __( 'Post Info', GG_DOMAIN),
				'desc' => __( 'Remove Post Info from Features?', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_features_post_info',
				'type' => 'checkbox'
			),
			array(
				'name' => __( 'Post Meta', GG_DOMAIN),
				'desc' => __( 'Remove Post Meta from Features?', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_features_post_meta',
				'type' => 'checkbox'
			),
			array(
			   'name' => __( 'Features Posts Image Size', GG_DOMAIN),
			   'desc' => __( '', GG_DOMAIN),
			   'id' => $gg_prefix . 'grid_feature_image_size',
			   'type' => 'select',
				'options' => gg_get_image_sizes()
			),
			array(
				'name' => __( '# Features', GG_DOMAIN),
				'desc' => __( 'Number of featured posts?', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_features',
				'type' => 'select',
				'options' => array(
					array('name' => '0', 'value' => '0'),
					array('name' => '1', 'value' => '1'),
					array('name' => '2', 'value' => '2'),
					array('name' => '3', 'value' => '3'),
					array('name' => '4', 'value' => '4'),
					array('name' => '5', 'value' => '5'),
					array('name' => '6', 'value' => '6'),
				)
			),
			array(
				'name' => __( 'Features Image Class', GG_DOMAIN),
				'desc' => __( 'Enter classes separating by spaces (no commas!)', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_feature_image_class',
				'type' => 'text'
			),
			array(
				'name' => __( 'Features Content Limit', GG_DOMAIN),
				'desc' => __( 'Entering <strong>0</strong> will default to the entire content.', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_feature_content_limit',
				'type' => 'text_small',
				'std' => 0
			),
			array(
				'name' => __( 'Features Post Type(s)', GG_DOMAIN),
				'desc' => __( 'Select the appropriate post type(s) you would like to include in the Grid.', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_features_post_types',
				'type' => 'multicheck',
				'options' => gg_dropdown_posttypes()
			),
			array(
				'name' => __( 'Features Term/Category', GG_DOMAIN),
				'desc' => __( '', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_features_term',
				'type' => 'select_group',
				'options' => gg_terms()
			),
			array(
				'name' => __( 'Grid Posts', GG_DOMAIN),
				'desc' => __( 'Leaving Posts per Page blank can result in no Grid posts appearing.', GG_DOMAIN),
				'type' => 'title',
			),
			array(
				'name' => __( 'Post Info', GG_DOMAIN),
				'desc' => __( 'Remove Post Info from Grid?', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_post_info',
				'type' => 'checkbox'
			),
			array(
				'name' => __( 'Post Meta', GG_DOMAIN),
				'desc' => __( 'Remove Post Meta from Grid?', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_post_meta',
				'type' => 'checkbox'
			),
			array(
			   'name' => __( 'Grid Posts Image Size', GG_DOMAIN),
			   'desc' => __( '', GG_DOMAIN),
			   'id' => $gg_prefix . 'grid_image_size',
			   'type' => 'select',
				'options' => gg_get_image_sizes()
			),
			array(
				'name' => __( 'Grid Image Class', GG_DOMAIN),
				'desc' => __( 'enter classes separating by spaces (no commas!)', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_image_class',
				'type' => 'text'
			),
			array(
				'name' => __( 'Grid Content Limit', GG_DOMAIN),
				'desc' => __( 'Entering <strong>0</strong> will default to the excerpt.', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_content_limit',
				'type' => 'text_small',
				'std' => 0
			),
			array(
				'name' => __( 'Grid Post Type', GG_DOMAIN),
				'desc' => __( 'Select the appropriate post type(s) you would like to include in the Grid.', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_post_types',
				'type' => 'multicheck',
				'options' => gg_dropdown_posttypes()
			),
			array(
				'name' => __( 'Grid Terms', GG_DOMAIN),
				'desc' => __( '', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_terms_checkbox',
				'type' => 'multicheck_group',
				'options' => gg_terms()
			),
			array(
				'name' => __( 'Grid Columns', GG_DOMAIN),
				'desc' => __( '', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_columns',
				'type' => 'select',
				'options' => array(
					array('name' => '0', 'value' => '0'),
					array('name' => '1', 'value' => '1'),
					array('name' => '2', 'value' => '2'),
					array('name' => '3', 'value' => '3'),
					array('name' => '4', 'value' => '4'),
					array('name' => '5', 'value' => '5'),
					array('name' => '6', 'value' => '6'),
				)
			),
			array(
				'name' => __( 'General', GG_DOMAIN),
				'desc' => __( 'General Settings for all posts.', GG_DOMAIN),
				'type' => 'title',
			),
			array(
				'name' => __( 'Posts per Page?', GG_DOMAIN),
				'desc' => __( 'Leaving this blank can result in no Grid posts appearing.', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_posts_per_page',
				'type' => 'text_small',
				'std' => 0
			),
			array(
				'name' => __( 'Read More Text', GG_DOMAIN),
				'desc' => __( '', GG_DOMAIN),
				'id' => $gg_prefix . 'grid_read_more',
				'type' => 'text_medium'
			),
			
		),
	);
 	
 	return $meta_boxes;
}

// Initialize the metabox class
add_action( 'init', 'be_initialize_cmb_meta_boxes', 999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( GG_PLUGIN_DIR . '/lib/metabox/init.php' );  
	}
}