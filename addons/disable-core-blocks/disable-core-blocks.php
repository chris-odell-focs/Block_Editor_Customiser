<?php

/*
Name: Disable Core Blocks
Description: Disable individual core blocks supplied with WordPress
Version: 1.1.0
*/

require_once( dirname(__FILE__).'/class-fofo-bec-disable-core-blocks.php' );

/**
 * Bootstrap the addon
 * 
 * @return  void
 * @since   1.0.0
 */
function fofo_bec_disable_core_plugin_bootstrap() {

    $dcb = new FoFo_Bec_Disable_Core_Blocks();
    $dcb->attach();
}

fofo_bec_disable_core_plugin_bootstrap();

/**
 * Get the list of disabled blocks as part of the
 * ajax action.
 * 
 * @return  void
 * @since   1.0.0
 */
function fofo_bec_dcb_disabled_blocks() {

    $dcb = new FoFo_Bec_Disable_Core_Blocks();
    $dcb->attach();

    echo json_encode( $dcb->list_disabled_blocks() );

    wp_die();
}

/**
 * Add the action for the 'fofo_bec_dcb_disabled_blocks'
 * api call.
 * 
 * @return  void
 * @since   1.0.0 
 */
add_action( "wp_ajax_fofo_bec_dcb_disabled_blocks", "fofo_bec_dcb_disabled_blocks" );