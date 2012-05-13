<?php
/*
Plugin Name: Genesis Grid
Plugin URI: http://www.wpsmith.net/genesis-featured-images
Description: The first generation of this plugin will provide a template and a GUI for using the Genesis Grid Loop.
Version: 0.6 Beta
Author: Travis Smith
Author URI: http://www.wpsmith.net/
License: GPLv2

    Copyright 2012  Travis Smith  (email : http://wpsmith.net/contact)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'GG_DOMAIN' , 'genesis-grid' );
define( 'GG_PLUGIN_DIR', dirname( __FILE__ ) );
define( "GG_URL" , WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );

/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    wp_die( __( "Sorry, you are not allowed to access this page directly.", 'GFI' ) );
}

register_activation_hook( __FILE__, 'gg_activation_check' );

/**
 * Checks for minimum Genesis Theme version before allowing plugin to activate
 *
 * @author Nathan Rice
 * @uses gg_truncate()
 * @since 0.1
 * @version 0.2
 */
function gg_activation_check() {

    $latest = '1.7';

    $theme_info = get_theme_data( TEMPLATEPATH . '/style.css' );

    if ( basename( TEMPLATEPATH ) != 'genesis' ) {
        deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate ourself
        wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed and actived %1$sGenesis%2$s or a %3$sGenesis Child Theme%2$s', 'GFI' ), '<a href="http://wpsmith.net/go/genesis">', '</a>', '<a href="http://wpsmith.net/go/spthemes">' ) );
    }

    $version = gg_truncate( $theme_info['Version'], 3 );

    if ( version_compare( $version, $latest, '<' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate ourself
        wp_die( sprintf( __( 'Sorry, you can\'t activate without %1$sGenesis %2$s%3$s or greater', 'GFI' ), '<a href="http://wpsmith.net/go/genesis">', $latest, '</a>' ) );
    }
}

//	add "Settings" link to plugin page
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__) , 'gg_action_links' );
function gg_action_links( $links ) {
	$gif_settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=genesis' ), __( 'Settings' ) );
	array_unshift($links, $gif_settings_link);
	return $links;
}

add_action( 'genesis_init', 'gg_init', 15 );
/** Loads required files when needed */
function gg_init() {

	require_once( GG_PLUGIN_DIR . '/lib/init.php' );

}

/**
 *
 * Used to cutoff a string to a set length if it exceeds the specified length
 *
 * @author Nick Croft
 * @since 0.1
 * @version 0.2
 * @param string $str Any string that might need to be shortened
 * @param string $length Any whole integer
 * @return string
 */
function gg_truncate( $str, $length = 10 ) {

    if ( strlen( $str ) > $length ) {
        return substr( $str, 0, $length );
    } else {
        $res = $str;
    }

    return $res;
}


// Enqueue styles
add_action( 'wp_enqueue_scripts' , 'gg_styles' );
function gg_styles () {
	global $post;
	//$template = get_page_template();
	$template = get_post_meta( $post->ID, '_wp_page_template' , true );
	if ( $template == 'page-genesis_grid.php' )
		wp_enqueue_style( 'gg_style' , GG_URL . "/lib/css/gg-styles.css" , null , '1.0' );
}

