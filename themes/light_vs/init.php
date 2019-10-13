<?php

function register_vs_light_theme( $fofo_bec_register ) {

    $theme = $fofo_bec_register->get_new_theme();
    $theme->name = 'light_vs';
    $theme->display_name = 'VS Light';
    $theme->settings_page = 'settings';
    $theme->css = 'style';

    $fofo_bec_register->register_theme( $theme );

}

add_action('fofo_bec_register_theme',"register_vs_light_theme");