<?php

// require files
require_once( GG_PLUGIN_DIR . '/lib/admin/gg-settings.php' );
require_once( GG_PLUGIN_DIR . '/lib/admin/help.php' );

require_once( GG_PLUGIN_DIR . '/lib/functions/functions.php' );
require_once( GG_PLUGIN_DIR . '/lib/functions/gg-dropdown-posttypes.php' );

require_once( GG_PLUGIN_DIR . '/lib/metaboxes.php' );

// Copy template to Child Folder
if ( ! file_exists ( CHILD_DIR . '/page-genesis_grid.php' ) ) {
	$source = GG_PLUGIN_DIR . '/lib/template/page-genesis_grid.php';
	copy( GG_PLUGIN_DIR . '/lib/template/page-genesis_grid.php' , CHILD_DIR . '/page-gridblog.php' ); 
}
 
// Add new image sizes
$genesis_settings = get_option( 'genesis-settings' );

if ( ( isset( $genesis_settings['gg_features1disable'] ) ) && ( isset( $genesis_settings['gg_features1w'] ) ) && ( isset( $genesis_settings['gg_features1h'] ) ) && ( $genesis_settings['gg_features1disable'] != 1 ) )
	add_image_size( 'Features 1 Column' , $genesis_settings['gg_features1w'] , $genesis_settings['gg_features1h'] , true );

if ( ( isset( $genesis_settings['gg_grid2disable'] ) ) && ( isset( $genesis_settings['gg_grid2w'] ) ) && ( isset( $genesis_settings['gg_grid2h'] ) ) && ( $genesis_settings['gg_grid2disable'] != 1 ) )
	add_image_size( 'Grid 2 Column' , $genesis_settings['gg_grid2w'] , $genesis_settings['gg_grid2h'] , true );

if ( ( isset( $genesis_settings['gg_grid3disable'] ) ) && ( isset( $genesis_settings['gg_grid3w'] ) ) && ( isset( $genesis_settings['gg_grid3h'] ) ) && ( $genesis_settings['gg_grid3disable'] != 1 ) )
	add_image_size( 'Grid 3 Column' , $genesis_settings['gg_grid3w'] , $genesis_settings['gg_grid3h'] , true );

if ( ( isset( $genesis_settings['gg_grid4disable'] ) ) && ( isset( $genesis_settings['gg_grid4w'] ) ) && ( isset( $genesis_settings['gg_grid4h'] ) ) && ( $genesis_settings['gg_grid4disable'] != 1 ) )
	add_image_size( 'Grid 4 Column' , $genesis_settings['gg_grid4w'] , $genesis_settings['gg_grid4h'] , true );

if ( ( isset( $genesis_settings['gg_grid5disable'] ) ) && ( isset( $genesis_settings['gg_grid5w'] ) ) && ( isset( $genesis_settings['gg_grid5h'] ) ) && ( $genesis_settings['gg_grid5disable'] != 1 ) )
	add_image_size( 'Grid 5 Column' , $genesis_settings['gg_grid5w'] , $genesis_settings['gg_grid5h'] , true );

if ( ( isset( $genesis_settings['gg_grid6disable'] ) ) && ( isset( $genesis_settings['gg_grid6w'] ) ) && ( isset( $genesis_settings['gg_grid6h'] ) ) && ( $genesis_settings['gg_grid6disable'] != 1 ) )
	add_image_size( 'Grid 6 Column' , $genesis_settings['gg_grid6w'] , $genesis_settings['gg_grid6h'] , true );
