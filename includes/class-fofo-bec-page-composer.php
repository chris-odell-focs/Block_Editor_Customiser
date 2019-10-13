<?php

namespace FoFoBec;

/**
 * Provides functions which alloww the settings page to be composed
 * 
 * When a settings page is composed it will be made up of elements from the 
 * theme settings and general gloabl settings e.g. selected theme
 */
class FoFo_Bec_Page_Composer {

    /**
     * The nonce key to use when rendering the form fo the settings page
     * 
     * @var string  $nonce_key
     * 
     * @since 1.2.0
     */
    private $nonce_key = '';

    /**
     * Set of functions to call to set a property in the injected theme
     * 
     * @var array   {
     *      @type   string      $key        The feature slug/name
     *      @type   callable    $callable   The function to call to set the value on the property
     * }
     * 
     * @since   1.2.0
     */
    private $update_functions;

    /**
     * The data access layer. Used to abstract out options API
     * 
     * @var FoFoBec\FoFo_Bec_Dal  $dal
     * 
     * @since 1.2.0
     */
    private $dal;

    /**
     * The theme registry
     * 
     * @var     FoFo_Bec_Theme_Registry     $theme_registry
     */
    private $theme_registry;

    /**
     * Initialisation
     * 
     * Set up the member fields fo use in other methods
     * 
     * @since   1.2.0
     */
    public function __construct( $dal, $theme_registry ) {

        $this->nonce_key = 'fofo-bec-customiser-updates';
        $this->dal = $dal;
        $this->theme_registry = $theme_registry;
        $this->build_update_functions();
    }

    /**
     * Build the list of functions which will be used to update the
     * general settings in a page.
     * 
     * @return  void
     * @since   1.2.0 
     */
    private function build_update_functions() {

        $this->update_functions = [
            FOFO_BEC_SELECTED_THEME_NAME => function( $theme_name ){ $this->set_current_theme( $theme_name ); },
        ];
    }

    /**
     * Build the html for the settings page
     * 
     * @param   string  $theme_page_part    The html from the theme settings
     * 
     * @return  string  The HTML of the settings page
     * @since 1.2.0
     */
    public function build_page( $theme_page_part ) {

        $page = '
            <div class="wrap">
                <h1>Foxdell Folio Block Editor Customiser</h1>
                <form method="post" action="admin.php?page=fofo_bec_plugin_page" novalidate="novalidate">
                    '.wp_nonce_field( $this->nonce_key, '_wpnonce', true, false ).
                    $this->get_theme_selector().
                    $theme_page_part.
                    '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
                </form>
            </div>
        ';

        return $page;
    }

    /**
     * Apply any general settings updates
     * 
     * @param   array   {
     *      @type   string  $key    The name of the value in the $_REQUEST server variable
     *      @type   any     $value  The value in the $_REQUEST server variable associated wwith $key 
     * }    The request data from the post back
     * 
     * @return  void
     * @since   1.2.0
     */
    public function apply_ui_updates( $request ) {

        $updates = isset( $request[ FOFO_BEC_REQUEST_KEY ] ) ? $request[ FOFO_BEC_REQUEST_KEY ] : null;

        if( null !== $updates ) {

            foreach( $updates as $feature => $update ) {

                if( array_key_exists( $feature, $this->update_functions ) ) {

                    $this->update_functions[ $feature ]( $update );          
                }  
            }
        }
    }

    /**
     * Get the html for the theme selector
     * 
     * @return  void
     * @since   1.2.0
     */
    private function get_theme_selector() {

        $registered_themes = $this->dal->get_registered_themes();
        $page = '
            <label>Selected Theme</label>
            <select name="'.esc_attr( FOFO_BEC_REQUEST_KEY.'['.FOFO_BEC_SELECTED_THEME_NAME.']').'">';

        $current_theme = $this->dal->get_current_theme();
        
        foreach( $registered_themes as $key => $theme ) {

            $selected = $current_theme->name === $theme->name ? 'selected' : '' ;
            $page .= '<option '.$selected.' value="'.esc_attr( $theme->name ).'">'.$theme->display_name.'</option>';
        }

        $page .= '</select>';
        return $page;
    }

    /**
     * Set the current theme name from the postback value
     * 
     * @param   string  $value  The selected theme name
     * 
     * @return  void
     * @since 1.2.0
     */
    private function set_current_theme( $theme_name ) {

        if( $this->theme_registry->theme_exists( $theme_name ) ) {

            $selected_theme = $this->theme_registry->get_theme( $theme_name );
            $this->theme_registry->set_current_theme( $selected_theme );
        }
    }
}