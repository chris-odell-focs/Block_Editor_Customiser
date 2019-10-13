<?php

function register_bec_default_theme( $fofo_bec_register ) {

    $theme = $fofo_bec_register->get_new_theme();
    $theme->name = 'default';
    $theme->display_name = 'Default';
    $theme->settings_page = 'settings';
    $theme->css = '';

    $fofo_bec_register->register_theme( $theme );

}

add_action( 'fofo_bec_register_theme', 'register_bec_default_theme' );