<?php
/**
 * Genesis Grid Plugin Settings
 *
 * @package      Genesis Grid Plugin
 * @author       Travis Smith <travis@wpsmith.net>
 * @copyright    Copyright (c) 2011, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */
 

/**
 * Add Genesis Grid Plugin settings to Genesis default theme settings
 *
 *
 * @param     array    Genesis Theme Settings
 * @return    array    Genesis Theme Settings
 *
 */

add_filter( 'genesis_theme_settings_defaults', 'gg_settings' );
function gg_settings( $defaults ) {
	$defaults['genesis_grid'] = 1;
	$defaults['gg_features1w'] = 916 ; 
	$defaults['gg_features1h'] = 301 ; 
	$defaults['gg_features1disable'] = 0 ;
	$defaults['gg_grid2w'] = 441 ; 
	$defaults['gg_grid2h'] = 290 ; 
	$defaults['gg_grid2disable'] = 0 ;
	$defaults['gg_grid3w'] = 288 ; 
	$defaults['gg_grid3h'] = 180 ; 
	$defaults['gg_grid3disable'] = 0 ;
	$defaults['gg_grid4w'] = 192 ; 
	$defaults['gg_grid4h'] = 125 ; 
	$defaults['gg_grid4disable'] = 0 ;
	$defaults['gg_grid5w'] = 163 ; 
	$defaults['gg_grid5h'] = 110 ; 
	$defaults['gg_grid5disable'] = 0 ;
	$defaults['gg_grid6w'] = 130 ; 
	$defaults['gg_grid6h'] = 90 ; 
	$defaults['gg_grid6disable'] = 0 ;
    return $defaults;
} 

//add_action( 'admin_init' , 'gg_add_settings' );
function gg_add_settings() {
	if ( genesis_get_option( 'genesis_grid' ) ) {
		$settings = get_option ( GENESIS_SETTINGS_FIELD );
		$settings = gg_settings ( $settings );
		update_option ( $settings , GENESIS_SETTINGS_FIELD );
	}
}

add_action( 'admin_menu', 'gg_theme_settings_init' );
function gg_theme_settings_init() {
	global $_genesis_admin_settings;

    add_action( 'load-' . $_genesis_admin_settings->pagehook, 'gg_add_child_boxes' , 15 );
	
} 
 
// Add new box to the Genesis -> Theme Settings page
function gg_add_child_boxes() {
	global $_genesis_admin_settings;

	add_meta_box( 'gg-settings-box', __( 'Genesis Grid Plugin Settings', GG_DOMAIN ), 'gg_settings_box', $_genesis_admin_settings->pagehook, 'main' );
	
}
/**
 * Featured Images Settings Box Markup
 *
 *
 */
function gg_settings_box() { ?>
	<!-- Image Size Settings -->
	<h4><?php _e( 'Image Size Settings' , GG_DOMAIN ); ?></h4>
	<p><span class="description"><?php printf( __('If you change these, you will need to regenerate your thumbnails for any images that are already uploaded. Try <a href="%s" target="_blank">Regenerate Thumbnails</a> plugin by <a href="http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/" target="_blank">ViperOO7Bond</a> at your own risk. Any changes here will affect any images uploaded to WordPress in the future.', GG_DOMAIN) , admin_url('plugin-install.php?tab=search&type=term&s=Regenerate+Thumbnails&plugin-search-input=Search+Plugins') ); ?></span></p>
	<p><span class="description"><?php printf( __('NOTE: Enter <strong>numbers only</strong>. If you disable any of these, upload images, and then re-enable at a later date, you will have to regenerate thumbnails.', GG_DOMAIN) ); ?></span></p>
	<table><tbody>
	<tr>
	<td width="130px"><?php _e('Features 1 Column: ', GG_DOMAIN); ?><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1w]"></td><td width="130px"><?php _e('Width: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1w]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1w]" value="<?php echo (genesis_get_option('gg_features1w')) ? esc_attr( genesis_get_option('gg_features1w') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1h]"></td><td width="130px"><?php _e('Height: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1h]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1h]" value="<?php echo (genesis_get_option('gg_features1h')) ? esc_attr( genesis_get_option('gg_features1h') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?></td><td width="90px"><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1disable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1disable]" value="1" <?php checked(1, genesis_get_option('gg_features1disable')); ?> /><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_features1disable]"><?php _e('Disable?', GG_DOMAIN); ?></label></td></tr>
	<tr><td></td><td colspan = "3"><p class="description"><?php _e( 'Defaults to 916px x 301px' , GG_DOMAIN); ?></p></td></tr>
	<tr><td><?php _e('Grid 2 Column: ', GG_DOMAIN); ?><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2w]"></td><td><?php _e('Width: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2w]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2w]" value="<?php echo (genesis_get_option('gg_grid2w')) ? esc_attr( genesis_get_option('gg_grid2w') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2h]"></td><td><?php _e('Height: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2h]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2h]" value="<?php echo (genesis_get_option('gg_grid2h')) ? esc_attr( genesis_get_option('gg_grid2h') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?></td><td><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2disable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2disable]" value="1" <?php checked(1, genesis_get_option('gg_grid2disable')); ?> /><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid2disable]"><?php _e('Disable?', GG_DOMAIN); ?></label></td></tr>
	<tr><td></td><td colspan = "3"><p class="description"><?php _e( 'Defaults to 441px x 290px' , GG_DOMAIN); ?></p></td></tr>
	<tr><td><?php _e('Grid 3 Column: ', GG_DOMAIN); ?><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3w]"></td><td><?php _e('Width: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3w]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3w]" value="<?php echo (genesis_get_option('gg_grid3w')) ? esc_attr( genesis_get_option('gg_grid3w') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3h]"></td><td><?php _e('Height: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3h]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3h]" value="<?php echo (genesis_get_option('gg_grid3h')) ? esc_attr( genesis_get_option('gg_grid3h') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?></td><td><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3disable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3disable]" value="1" <?php checked(1, genesis_get_option('gg_grid3disable')); ?> /><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid3disable]"><?php _e('Disable?', GG_DOMAIN); ?></label></td></tr>
	<tr><td></td><td colspan = "3"><p class="description"><?php _e( 'Defaults to 288px x 180px' , GG_DOMAIN); ?></p></td></tr>
	<tr><td><?php _e('Grid 4 Column: ', GG_DOMAIN); ?><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4w]"></td><td><?php _e('Width: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4w]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4w]" value="<?php echo (genesis_get_option('gg_grid4w')) ? esc_attr( genesis_get_option('gg_grid4w') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4h]"></td><td><?php _e('Height: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4h]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4h]" value="<?php echo (genesis_get_option('gg_grid4h')) ? esc_attr( genesis_get_option('gg_grid4h') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?></td><td><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4disable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4disable]" value="1" <?php checked(1, genesis_get_option('gg_grid4disable')); ?> /><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid4disable]"><?php _e('Disable?', GG_DOMAIN); ?></label></td></tr>
	<tr><td></td><td colspan = "3"><p class="description"><?php _e( 'Defaults to 192px x 125px' , GG_DOMAIN); ?></p></td></tr>
	<tr><td><?php _e('Grid 5 Column: ', GG_DOMAIN); ?><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5w]"></td><td><?php _e('Width: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5w]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5w]" value="<?php echo (genesis_get_option('gg_grid5w')) ? esc_attr( genesis_get_option('gg_grid5w') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5h]"></td><td><?php _e('Height: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5h]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5h]" value="<?php echo (genesis_get_option('gg_grid5h')) ? esc_attr( genesis_get_option('gg_grid5h') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?></td><td><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5disable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5disable]" value="1" <?php checked(1, genesis_get_option('gg_grid5disable')); ?> /><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid5disable]"><?php _e('Disable?', GG_DOMAIN); ?></label></td></tr>
	<tr><td></td><td colspan = "3"><p class="description"><?php _e( 'Defaults to 163px x 110px' , GG_DOMAIN); ?></p></td></tr>
	<tr><td><?php _e('Grid 6 Column: ', GG_DOMAIN); ?><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6w]"></td><td><?php _e('Width: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6w]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6w]" value="<?php echo (genesis_get_option('gg_grid6w')) ? esc_attr( genesis_get_option('gg_grid6w') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?>
	<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6h]"></td><td><?php _e('Height: ', GG_DOMAIN); ?><input type="text" size="5" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6h]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6h]" value="<?php echo (genesis_get_option('gg_grid6h')) ? esc_attr( genesis_get_option('gg_grid6h') ) : ''; ?>" /></label><?php _e('px', GG_DOMAIN); ?></td><td><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6disable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6disable]" value="1" <?php checked(1, genesis_get_option('gg_grid6disable')); ?> /><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[gg_grid6disable]"><?php _e('Disable?', GG_DOMAIN); ?></label></td></tr>
	<tr><td></td><td colspan = "3"><p class="description"><?php _e( 'Defaults to 130px x 90px' , GG_DOMAIN); ?></p></td></tr>
	</tbody></table>
	<input type="hidden" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[genesis_grid]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[genesis_grid]" value="1" />
	
<?php
}

/**
 * Sanitizes Genesis Grid Plugin Options
 *
 */
add_action( 'genesis_settings_sanitizer_init', 'gg_register_grid_sanitization_filters' );
function gg_register_grid_sanitization_filters() {
    genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD,
        array(
			'gg_features1w',
			'gg_features1h',
			'gg_features1disable',
			'gg_grid2w',
			'gg_grid2h',
			'gg_grid2disable',
			'gg_grid3w',
			'gg_grid3h',
			'gg_grid3disable',
			'gg_grid4w',
			'gg_grid4h',
			'gg_grid4disable',
			'gg_grid5w',
			'gg_grid5h',
			'gg_grid5disable',
			'gg_grid6w',
			'gg_grid6h',
			'gg_grid6disable',
        ) );
	genesis_add_option_filter( 'one_zero', GENESIS_SETTINGS_FIELD,
		array(
			'genesis_grid',
		) );
	
}

?>
