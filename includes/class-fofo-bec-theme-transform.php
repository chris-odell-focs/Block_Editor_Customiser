<?php

namespace FoFoBec;

/**
 * Transform functions for generating the settings 
 * page from a theme, and updating a theme from options saved
 * on the settings page.
 */
class FoFo_Bec_Theme_Transform {

    /**
     * @var     \FoFoBec\FoFo_Bec_Theme $bec_theme
     * @since   1.1.0
     */
    private $bec_theme;

    /**
     * Set of functions to call to set a property in the injected theme
     * 
     * @var array   {
     *      @type   string      $key        The feature slug/name
     *      @type   callable    $callable   The function to call to set the value on the property
     * }
     * 
     * @since   1.1.0
     */
    private $update_functions;

    /**
     * List of names of supported feature to display on the settings page
     * 
     * @var array   {
     *      @type   string  $key            Name/slug of the feature
     *      @type   string  $display_name   The display name of the feature
     * }
     * 
     * @since 1.1.0
     */
    private $option_feature_names;

    /**
     * Constructor - initialisation
     * 
     * @param   FoFoBec\FoFo_Bec_Theme          $theme          The theme values to set
     * 
     * @return void
     * @since 1.1.0
     */
    public function __construct( $bec_theme ) {

        $this->bec_theme = $bec_theme;

        $this->update_functions = [
            FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY, $value  ); },
            FOFO_BEC_FEATURE_DOC_PANEL_TAG => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_DOC_PANEL_TAG, $value  ); },
            FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE, $value  ); },
            FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT, $value  ); },
            FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION, $value  ); },
            FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK, $value  ); },
            FOFO_BEC_FEATURE_TOP_TOOLBAR => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_TOP_TOOLBAR, $value  ); },
            FOFO_BEC_FEATURE_SPOTLIGHT_MODE => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_SPOTLIGHT_MODE, $value  ); },
            FOFO_BEC_FEATURE_FULLSCREEN => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_FULLSCREEN, $value  ); },
            FOFO_BEC_FEATURE_MORE_OPTIONS_MENU => function( $value ){ $this->set_feature_state( FOFO_BEC_FEATURE_MORE_OPTIONS_MENU, $value  ); },
        ];
    }

    /**
     * Apply updates from the UI to the contained theme
     * 
     * @param  $request array {
     *      @type   string  $key    A key in the name-value data in the $_REQUEST 
     *      @type   any     $value  The value passed from the name-value data from the $_REQUEST
     * }
     * 
     * @return  FoFoBec\FoFo_Bec_Theme  The updated BEC theme
     * @since 1.1.0
     */
    public function from_ui( $request ) {

        $updates = isset( $request[ FOFO_BEC_REQUEST_KEY ] ) ? $request[ FOFO_BEC_REQUEST_KEY ] : null;

        if( null !== $updates ) {
            foreach( $updates as $feature => $update ) {

                if( array_key_exists( $feature, $this->update_functions ) ) {

                    $this->update_functions[ $feature ]( $update );          
                }  
            }
        }

        return $this->bec_theme;
    }

    /**
     * Set the featuure state with values updated from the settings panel
     * also provides sanitisation/validation of the data.
     * 
     * @param   string  $feature    The name of the panel to change the state of
     * @param   string  $state      Either on or off
     * 
     * @return void
     * @since 1.1.0
     */
    private function set_feature_state( $feature, $state ) {

        $panel_state = $state === FOFO_BEC_PANEL_ON ? FOFO_BEC_PANEL_ON : FOFO_BEC_PANEL_OFF;
        $this->bec_theme->{$feature} = $panel_state;
    }

    /**
     * Build the settings page based on the state values in the contained
     * BEC theme.
     * 
     * @return  string  The HTML for the settinggs page
     * @since 1.1.0
     */
    public function to_ui( $page_builder ) {

        extract( [ 'page_builder' => $page_builder ] );
        ob_start();	
        
        include_once $this->bec_theme->my_location;
        echo call_user_func_array( $this->bec_theme->settings_page, [ $page_builder ] );
        
        return ob_get_clean();        
    }
}