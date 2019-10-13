<?php

namespace FoFoBec;

/**
 * Abstract out the data access.
 * 
 * In this case the Options APi is being used to persist information.
 * Make this testable & interchangle by wrapping it in it's own
 * class.
 * 
 * @since 1.2.0
 * 
 */
class FoFo_Bec_Dal {

    /**
     * Get the version 1 options
     * 
     * @return array {
     *      @type   string  $key    The option key
     *      @type   string  $value  The option value
     * }
     * 
     * @since 1.2.0
     */
    public function get_v1_options() {

        return get_option( FOFO_BEC_OPTIONS_KEY, '' );
    }

    /**
     * Set the version 1 options
     * 
     * @param   mixed   Any value that the Options API update_option will take
     * 
     * @return void
     * @since 1.2.0
     */
    public function set_v1_options( $value ) {

        update_option( FOFO_BEC_OPTIONS_KEY, $value );
    }

    /**
     * Get the current theme. If a theme isn't found, default to the default theme.
     * 
     * @return  string  FoFoBec\FoFo_Bec_Theme
     * @since 1.2.0
     */
    public function get_current_theme() {

        $theme = new \FoFoBec\FoFo_Bec_Theme();
        $theme->name = 'default';
        $theme->display_name = 'Default';
        $theme->settings_page = 'settings';
        $theme->css = '';

        return get_option( FOFO_BEC_CURRENT_THEME, $theme );
    }

    /**
     * Set the current theme
     * 
     * @param   FoFoBec\FoFo_Bec_Theme  The current theme
     * 
     * @return void
     * @since 1.2.0
     */
    public function set_current_theme( $theme ) {

        update_option( FOFO_BEC_CURRENT_THEME, $theme );
    }

    /**
     * Get the javascript generated from the theme to set the values
     * in the block editor screen
     * 
     * @return  string  The generated javascript
     * @since 1.2.0
     */
    public function get_generated_js() {

        return get_option( FOFO_BEC_JS_KEY, '' );
    }

    /**
     * Set the generated javascript after having passed through the
     * customiser
     * 
     * @param   string  The generated javascript
     * 
     * @return void
     * @since 1.2.0
     */
    public function set_generated_js( $js ) {

        update_option( FOFO_BEC_JS_KEY, $js );
    }

    /**
     * Persist the themes which have been registered
     * 
     * @param   array {
     *      @type   FoFoBec\FoFo_Bec_Theme  A FoFo BEC theme object
     * }  
     * 
     * @return  void
     * @since 1.2.0
     */
    public function set_registered_themes( $themes )  {

        update_option( FOFO_BEC_THEME_REGISTER, $themes );
    }

    /**
     * Get the list of stored themes
     * 
     * @return array {
     *      @type   FoFoBec\FoFo_Bec_Theme  A FoFo BEC theme object
     * }  
     * @since 1.2.0
     */
    public function get_registered_themes() {

        return get_option( FOFO_BEC_THEME_REGISTER, [] );
    }
}