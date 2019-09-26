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
     *      @type   callable    $callable   The function to call to set the valuue on the property
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
     * The nonce key to use to verify repsonse data
     * 
     * @var string  $nonce_key
     * @since   1.1.0
     */
    private $nonce_key;

    //feature keys

    /**
     * The category panel feature slug
     * 
     * @var   string  self::CATEGORY_PANEL
     * @since   1.1.0
     */
    const CATEGORY_PANEL = 'category_panel';

    /**
     * The tag panel feature slug
     * 
     * @var   string  self::TAG_PANEL
     * @since   1.1.0
     */
    const TAG_PANEL = 'tag_panel';

    /**
     * The featured image panel feature slug
     * 
     * @var   string  self::FEATURED_IMAGE_PANEL
     * @since   1.1.0
     */
    const FEATURED_IMAGE_PANEL = 'featured_image_panel';

    /**
     * The excerpt panel feature slug
     * 
     * @var   string  self::EXCERPT_PANEL
     * @since   1.1.0
     */
    const EXCERPT_PANEL = 'excerpt_panel';

    /**
     * The discussion panel feature slug
     * 
     * @var   string  self::DISCUSSION_PANEL
     * @since   1.1.0
     */
    const DISCUSSION_PANEL = 'discussion_panel';
    
    /**
     * The permalink panel feature slug
     * 
     * @var   string  self::PERMALINK_PANEL
     * @since   1.1.0
     */
    const PERMALINK_PANEL = 'permalink_panel';

    /**
     * The key name in $_REQUEST global variabl
     * 
     * @var   string  self::REQUEST_KEY
     * @since   1.1.0
     */
    const REQUEST_KEY = 'fofo_bec';

    /**
     * Constructor - initialisation
     * 
     * @param   FoFoBec\FoFo_Bec_Theme  $theme  The theme values to set
     * 
     * @return void
     * @since 1.1.0
     */
    public function __construct( $bec_theme ) {

        $this->bec_theme = $bec_theme;

        $this->update_functions = [
            self::CATEGORY_PANEL => function( $value ){ $this->set_panel_state( self::CATEGORY_PANEL, $value  ); },
            self::TAG_PANEL => function( $value ){ $this->set_panel_state( self::TAG_PANEL, $value  ); },
            self::FEATURED_IMAGE_PANEL => function( $value ){ $this->set_panel_state( self::FEATURED_IMAGE_PANEL, $value  ); },
            self::EXCERPT_PANEL => function( $value ){ $this->set_panel_state( self::EXCERPT_PANEL, $value  ); },
            self::DISCUSSION_PANEL => function( $value ){ $this->set_panel_state( self::DISCUSSION_PANEL, $value  ); },
            self::PERMALINK_PANEL => function( $value ){ $this->set_panel_state( self::PERMALINK_PANEL, $value  ); },
        ];

        $this->option_feature_names = [
            self::CATEGORY_PANEL => 'Category Panel',
            self::TAG_PANEL => 'Tags Panel',
            self::FEATURED_IMAGE_PANEL => 'Featured Image Panel',
            self::EXCERPT_PANEL => 'Excerpt Panel',
            self::DISCUSSION_PANEL => 'Discussion Panel',
            self::PERMALINK_PANEL => 'Permalink Panel'
        ];

        $this->nonce_key = implode( '-', array_keys( $this->update_functions ) );
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

        $updates = isset( $request[ self::REQUEST_KEY ] ) ? $request[ self::REQUEST_KEY ] : null;

        if( null !== $updates ) {

            foreach( $updates as $feature => $update ) {

                $this->update_functions[ $feature ]( $update );            
            }
        }

        return $this->bec_theme;
    }

    /**
     * Set the panel state with values updated from the settings panel
     * also provides sanitisation/validation of the data.
     * 
     * @param   string  $panel_name The name of the panel to change the state of
     * @param   string  $state      Either on or off
     * 
     * @return void
     * @since 1.1.0
     */
    private function set_panel_state( $panel_name, $state ) {

        $panel_state = $state === FOFO_BEC_PANEL_ON ? FOFO_BEC_PANEL_ON : FOFO_BEC_PANEL_OFF;
        $this->bec_theme->{$panel_name} = $panel_state;
    }

    /**
     * Build the settings ppage based on the state values in the contained
     * BEC theme.
     * 
     * @return  string  The HTML for the settinggs page
     * @since 1.1.0
     */
    public function to_ui() {

        $page = '
            <div class="wrap">
                <h1>Foxdell Folio Block Editor Customiser</h1>
                <form method="post" action="admin.php?page=fofo_bec_plugin_page" novalidate="novalidate">
                    '.wp_nonce_field( $this->nonce_key, '_wpnonce', true, false ).'
                    <table class="form-table" style="width : 75%">
                        <tbody>
                            <tr>'.$this->get_panel_row( self::CATEGORY_PANEL ).$this->get_panel_row( self::TAG_PANEL ).'</tr>
                            <tr>'.$this->get_panel_row( self::FEATURED_IMAGE_PANEL ).$this->get_panel_row( self::EXCERPT_PANEL ).'</tr>
                            <tr>'.$this->get_panel_row( self::DISCUSSION_PANEL ).$this->get_panel_row( self::PERMALINK_PANEL ).'</tr>
                        </tbody>
                    </table>
                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
                </form>
            </div>
        ';

        return $page;
    }

    /**
     * Build the HTML for a panel
     * 
     * @param   string  $panel_name The name/slug of the panel to get the state of
     * 
     * @return  string  The HTML for a row based on the panel name
     * @since 1.1.0
     */
    private function get_panel_row( $panel_name ) {

        $css_id = 'fofobec-'.$panel_name;

        $html = '<th><label for="'.$css_id.'">'.esc_html( $this->option_feature_names[ $panel_name ] ).'</label></th>
            <td>
                <input type="hidden" 
                name="'.esc_attr( self::REQUEST_KEY.'['.$panel_name.']').'" 
                value="'.esc_attr( FOFO_BEC_PANEL_OFF ).'" />

                <input id="'.$css_id.'" 
                name="'.esc_attr( self::REQUEST_KEY.'['.$panel_name.']').'" 
                type="checkbox" '.esc_attr( $this->bec_theme->{$panel_name} == FOFO_BEC_PANEL_ON ? 'checked' : '' ).' 
                value="'.esc_attr( FOFO_BEC_PANEL_ON ).'"/>
            <td>';

        return $html;
    }
}