<?php
/**
 * Plugin Name: Store Locator Plus : Gravity Forms Locations - CompassHB Fork
 * Plugin URI: https://www.storelocatorplus.com/product/gravity-forms-locations/
 * Description: Custom fork of a free add-on pack for Store Locator Plus that supports basic locations for Gravity Forms.
 * Author: Store Locator Plus - De B.A.A.T.
 * Author URI: https://www.de-baat.nl/slp/
 * Requires at least: 4.2
 * Tested up to : 4.6
 * Version: 10.4.6.00
 * GitHub Plugin URI: compasshb/store-locator-plus-gravity-forms-locations-free
 * 
 * Text Domain: slp-gravity-forms-locations-free
 * Domain Path: /languages/
 */


// No direct access allowed outside WordPress
//
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// Since this is an add-on for Store Locator Plus
// we only want to "get started" after all plugins are loaded.
//
// This allows us to check our dependencies knowing SLP
// should be loaded into the PHP stack by now.
//
// Concept Credits: @pippinsplugins, @ipstenu
// @see https://pippinsplugins.com/checking-dependent-plugin-active/
// @see https://make.wordpress.org/plugins/2015/06/05/policy-on-php-versions/
//
function SLPGFL_loader() {
    $this_plugin_name = __( 'Store Locator Plus : Gravity Forms Locations' , 'slp-gravity-forms-locations-free' );
    $min_wp_version   = '4.2';

    // Requires SLP
    //
    if ( ! defined( 'SLPLUS_PLUGINDIR' ) ) {
        add_action(
            'admin_notices',
            create_function(
                '',
                "echo '<div class=\"error\"><p>".
                sprintf(
                    __( '%s requires Store Locator Plus to function properly.' , 'slp-gravity-forms-locations-free' ) ,
                    $this_plugin_name
                ).'<br/>'.
                __( 'This plugin has been deactivated.'                        , 'slp-gravity-forms-locations-free' ) .
				' ' .
                __( 'Please install Store Locator Plus.'                       , 'slp-gravity-forms-locations-free' ) .
                "</p></div>';"
            )
        );
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
        return;
    }

    // Requires WP Version as noted above
    //
    global $wp_version;
    if ( version_compare( $wp_version , $min_wp_version , '<' ) ) {
        add_action(
            'admin_notices',
            create_function(
                '',
                "echo '<div class=\"error\"><p>".
                sprintf(
                    __( '%s requires WordPress %s to function properly.' , 'slp-gravity-forms-locations-free' ) ,
                    $this_plugin_name,
                    $min_wp_version
                ).
				' ' .
                __( 'This plugin has been deactivated.'                  , 'slp-gravity-forms-locations-free' ) .
				' ' .
                __( 'Please upgrade WordPress.'                          , 'slp-gravity-forms-locations-free' ) .
                "</p></div>';"
            )
        );
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
        return;
    }

    // Define some path constants in an attempt to bypass depth-driven confusion.
    //
    if ( ! defined( 'SLP_GFL_REL_DIR'  ) ) { define( 'SLP_GFL_REL_DIR'    , plugin_basename( dirname( __FILE__ ) ) ); }  // Relative directory for this plugin in relation to wp-content/plugins
    if ( ! defined( 'SLP_GFL_FILE'     ) ) { define( 'SLP_GFL_FILE'       ,  __FILE__                              ); }  // FQ File name for this file.

    // Go forth and sprout your tentacles...
    // Get some Store Locator Plus sauce.
    //
    require_once( 'include/class.slp-gravity-forms-locations-free.php' );
    SLP_GFL_Free::init();
}

add_action('plugins_loaded', 'SLPGFL_loader');

