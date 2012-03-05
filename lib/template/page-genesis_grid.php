<?php
/**
 * Template Name: Genesis Grid
 *
 * This file is responsible for generating the
 * Genesis Grid loop using the custom field
 * metaboxes. 
 *
 *
 * @package      Genesis Grid Plugin
 * @author       Travis Smith <travis@wpsmith.net>
 * @copyright    Copyright (c) 2011, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
 */


/**
 * Setup Grid Globals
 * @author Travis Smith
 * 
 * @global	int	@gg_columns 
 * @global	boolean/int	@gg_content 
 * @global	int	@gg_features
 */
add_action( 'genesis_before' , 'gg_grid_setup' );
function gg_grid_setup() {
	global $gg_columns, $gg_content, $gg_features;
	
	$gg_columns = genesis_get_custom_field('_gg_grid_columns');
	$gg_content = (genesis_get_custom_field('_gg_grid_content_editor')) ? genesis_get_custom_field('_gg_grid_content_editor') : '';
	$gg_features = genesis_get_custom_field('_gg_grid_features');
}

// Remove default content/loop
remove_action('genesis_post_content', 'genesis_do_post_content');
remove_action('genesis_loop', 'genesis_do_loop');

// Remove the archive thumbnail from the home page
remove_action('genesis_post_content', 'genesis_do_post_image');

// Force Layout
add_filter('genesis_pre_get_option_site_layout', 'gg_cat_layout');
update_post_meta( $post->ID, '_genesis_layout', 'full-width-content' );
 
// Allow user defined tags 
add_filter('get_the_content_limit_allowedtags', 'gg_get_the_content_limit_allowedtags');

/**
 * Genesis Grid Loop Helper Function
 * @author Travis Smith
 *
 * @global array $paged
 * @global boolean/int $gg_content
 *
 */
add_action('genesis_after_endwhile', 'genesis_posts_nav');
add_action( 'genesis_loop', 'gg_grid_loop_helper' );

/** Add support for Genesis Grid Loop **/
function gg_grid_loop_helper() {
    global $paged;
	
	$feat_post_info = genesis_get_custom_field('_gg_grid_features_post_info');
	$feat_post_meta = genesis_get_custom_field('_gg_grid_features_post_meta');
	
	$grid_post_info = genesis_get_custom_field('_gg_grid_post_info');
	$grid_post_meta = genesis_get_custom_field('_gg_grid_post_meta');
	$grid_post_title = genesis_get_custom_field('_gg_grid_post_title');
	
    if ( function_exists( 'genesis_grid_loop' ) ) {
		$grid_terms = array();
        //set featured grid_args from metaboxes/globals
		$feat_terms = genesis_get_custom_field('_gg_grid_features_term');
		$grid_terms = gg_get_custom_field('_gg_grid_terms_checkbox');
		
		$feat_tax_query = gg_build_tax_query(array($feat_terms));
		$grid_tax_query = gg_build_tax_query($grid_terms);
		$feat_post_types = genesis_get_custom_field('_gg_grid_features_post_types');
		$grid_post_types = genesis_get_custom_field('_gg_grid_post_types');
		
		if ( ( $feat_tax_query != $grid_tax_query ) || ( $feat_post_types != $grid_post_types ) ) {
			// if features cat/term differs from grid cat/terms, create 2 $grid_args
			$grid_args_featured = array(
				'features' => genesis_get_custom_field('_gg_grid_features'),
				'feature_image_size' => genesis_get_custom_field('_gg_grid_feature_image_size'),
				'feature_image_class' => genesis_get_custom_field('_gg_grid_feature_image_class'),
				'feature_content_limit' => genesis_get_custom_field('_gg_grid_feature_content_limit'),
				'grid_image_size' => 0,
				'grid_image_class' => '',
				'grid_content_limit' => 0,
				'more' => genesis_get_custom_field('_gg_grid_read_more'),
				'posts_per_page' => genesis_get_custom_field('_gg_grid_features'),
				'post_type' => $feat_post_types,
				'tax_query' => $feat_tax_query,
				'paged' => 0
			);
			$grid_args_rest = array(
				'features' => 0,
				'feature_image_size' => 0,
				'feature_image_class' => '',
				'feature_content_limit' => 0,
				'grid_image_size' => genesis_get_custom_field('_gg_grid_image_size'),
				'grid_image_class' => genesis_get_custom_field('_gg_grid_image_class'),
				'grid_content_limit' => genesis_get_custom_field('_gg_grid_content_limit'),
				'tax_query' => $grid_tax_query,
				'post_type' => $grid_post_types,
				'more' => genesis_get_custom_field('_gg_grid_read_more'),
				'posts_per_page' => genesis_get_custom_field('_gg_grid_posts_per_page'),
				'paged' => $paged
				
			);
			
			gg_post_remove( $feat_post_info , $feat_post_meta );

			//assuming that features won't go beyond 1 page
			if ( ($grid_args_featured['paged'] > 1) || ($grid_args_rest['paged'] > 1) ) {
				gg_post_remove( $grid_post_info , $grid_post_meta , $grid_post_title );
				genesis_grid_loop( $grid_args_rest ); //do not show featured after page 1
			}
			else {
				genesis_grid_loop( $grid_args_featured );
				
				gg_post_remove( $grid_post_info , $grid_post_meta , $grid_post_title );
				
				genesis_grid_loop( $grid_args_rest );
			}
		}
		else {
			
			gg_post_remove( $feat_post_info , $feat_post_meta );
			$grid_args = array(
				'features' => genesis_get_custom_field('_gg_grid_features'),
				'feature_image_size' => genesis_get_custom_field('_gg_grid_feature_image_size'),
				'feature_image_class' => genesis_get_custom_field('_gg_grid_feature_image_class'),
				'feature_content_limit' => genesis_get_custom_field('_gg_grid_feature_content_limit'),
				'grid_image_size' => genesis_get_custom_field('_gg_grid_image_size'),
				'grid_image_class' => genesis_get_custom_field('_gg_grid_image_class'),
				'grid_content_limit' => genesis_get_custom_field('_gg_grid_content_limit'),
				'more' => genesis_get_custom_field('_gg_grid_read_more'),
				'posts_per_page' => genesis_get_custom_field('_gg_grid_posts_per_page'),
				'post_type' => genesis_get_custom_field('_gg_grid_features_post_types'),
				'tax_query' => $feat_tax_query, //doesn't matter which since they are the same
				'paged' => $paged
			);
			
			genesis_grid_loop( $grid_args );
		}

    } else {
        genesis_standard_loop();
    }
}  
 
// Add some extra post classes to the grid loop so we can style the columns
add_filter( 'genesis_grid_loop_post_class', 'gg_grid_loop_post_class' );


/**
 * Adds content from the content editor to the post
 * @author Travis Smith
 *
 * @global array $post
 * @global boolean/int $gg_content
 *
 */
add_action( 'genesis_before_loop' , 'gg_content_intro' );
function gg_content_intro() { 
	global $post, $gg_content;
	
	if ( $gg_content ) {
		if ( have_posts() ) : while ( have_posts() ) : the_post(); // the loop
		?>

		<div class="post">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>

	<?php
		endwhile;
		endif;
	}
}

// Add the <div class="clear"></div> after a row of teasers
add_action('genesis_after_post', 'gg_grid_divider');

genesis();

