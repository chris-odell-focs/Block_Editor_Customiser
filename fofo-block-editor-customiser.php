<?php
/**
 * @package FOFOBec
 */
/*
Plugin Name: Foxdell Folio Block Editor Customiser
Plugin URI: 
Description: Provide a set of hooks which will allow features gutenberg features to be turned off
Version: 1.2.0
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
 * Autoload to load class files & includes
 */
spl_autoload_register(function ($class){

	$namspace = 'FoFoBec\\';
	if( false !== strpos( $class, $namspace ) ) {

		$class = str_replace( $namspace, '', $class );
		$class_stub = strtolower( str_replace( '_', '-', $class ).'.php' );
		$_s = DIRECTORY_SEPARATOR;

		$require_types = [ 'class', 'abstract', 'interface' ];
		$folders = [ 'includes' ];

		foreach( $folders as $folder_stub ) {

			$base_dir = dirname( __FILE__ ).$_s.$folder_stub.$_s;

			foreach( $require_types as $require_type ) {

				if( file_exists( $base_dir.$require_type.'-'.$class_stub ) ) {

					require_once( $base_dir.$require_type.'-'.$class_stub );
				}
			}
		}
	}
});


/**
 * Bootstrap the plugin
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


