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
     * Set the versin 1 options
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
     * Get the current theme in it's serialised form
     * 
     * @return  string  String-ified theme object
     * @since 1.2.0
     */
    public function get_current_theme() {

        return get_option( FOFO_BEC_CURRENT_THEME, '' );
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

        update_option( FOFO_BEC_CURRENT_THEME, $theme->to_json() );
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
     * Get the theme name which has been selected in the front end
     * 
     * @return  string  The theme name
     * @since 1.2.0
     */
    public function get_selected_theme_name() {

        return get_option( 'FOFO_BEC_'.FOFO_BEC_SELECTED_THEME_NAME, 'default' );
    }

    /**
     * Set the theme name selected in the front end
     * 
     * @param   string  $theme_name The theme name
     * 
     * @return  void
     * @since 1.2.0
     */
    public function set_selected_theme_name( $theme_name ) {

        update_option( 'FOFO_BEC_'.FOFO_BEC_SELECTED_THEME_NAME, $theme_name );
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