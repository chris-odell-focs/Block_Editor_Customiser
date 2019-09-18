<?php
/**
 * @package FOFOBec
 */
/*
Plugin Name: Foxdell Folio Block Editor Customiser
Plugin URI: 
Description: Provide a set of hooks which will allow features gutenberg features to be turned off
Version: 1.0.0
Author: Foxdell Folio
Author URI: 
License: GPLv2 or later
Text Domain: fofogutentog
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

/*
    To remove the feature toggler settings from the dashboard completely
    set the FOFO_BEC_SHOW_SETTINGS value to false
*/
if( !defined( 'FOFO_BEC_SHOW_SETTINGS' ) ) {
    define( 'FOFO_BEC_SHOW_SETTINGS', true );
}

/**
 * Include the class file with core functionality & which calls any library functions
 */
include_once plugin_dir_path( __FILE__ ).'includes/class-fofo-bec.php';

/**
 * Bootstrap the pluugin
 * 
 * Creates an instance of the core class and initialises the plugin
 * 
 * @since 1.0.0
 */
function fofo_bec_start() {

    $fofobec = new \FoFoBec\FoFo_Bec();
    $fofobec->attach();
}

fofo_bec_start();


