<?php
//If uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

$gg_settings = array(
	'genesis_grid',
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
);
$theme_settings = get_option('genesis-settings');

foreach ($theme_settings as $setting => $data) {
	
	foreach ( $gg_settings as $gg_setting ) {
		if ( $setting == $gg_setting )
			unset( $theme_settings[$setting] );
	}
		
}
