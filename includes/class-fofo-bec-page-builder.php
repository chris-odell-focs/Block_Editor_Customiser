<?php

namespace FoFoBec;

/**
 * Helper class to build the settings page
 */
class FoFo_Bec_Page_Builder {

    /**
     * Registry of functions which return the HTML to render for an option
     * 
     * @var array  {
     *      @type   string      $key    The key for the setting
     *      @type   callable    $func   The function to call to get the html
     * }
     * 
     * @since 1.2.0
     */
    private $html_registry = [];
    
    /**
     * The current Bloc Editor Customiser theme
     * 
     * @var FoFoBec\FoFo_Bec_Theme  $bec_theme
     * 
     * @since 1.1.0
     */
    private $bec_theme;

    /**
     * Initialisation.
     * 
     * Set the theme and build the html registry
     * 
     * @param   \FoFoBec\FoFo_Bec_Theme     $bec_theme The theme to use to build the page
     * 
     * @return  void
     * @since 1.2.0
     */
    public function __construct( $bec_theme ) {

        $this->build_html_registry();
        $this->bec_theme = $bec_theme;
    }

    /**
     * Construct the HTML registry
     * 
     * @return void
     * @since 1.2.0
     */
    private function build_html_registry() {

        $this->html_registry =[
            FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY => function( $args ){ return $this->get_document_panel_html( FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY, $args ); },
            FOFO_BEC_FEATURE_DOC_PANEL_TAG => function( $args ){ return $this->get_document_panel_html( FOFO_BEC_FEATURE_DOC_PANEL_TAG, $args ); },
            FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE => function( $args ){ return $this->get_document_panel_html( FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE, $args ); },
            FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT => function( $args ){ return $this->get_document_panel_html( FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT, $args ); },
            FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION => function( $args ){ return $this->get_document_panel_html( FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION, $args ); },
            FOFO_BEC_FEATURE_DOC_PANEL_PEMALINK => function( $args ){ return $this->get_document_panel_html( FOFO_BEC_FEATURE_DOC_PANEL_PEMALINK, $args ); },
        ];
    }

    /**
     * Show the selected option in the theme specific settings page
     * 
     * @param   string  $option     The option/feature name to display in the settings
     * @param   string  $title      The content of the label to display in front of the field.
     * @param   string  $wrap       And sprintf compatible string which wraps around the option html generated
     * @param   string  $css_id     The css id to attach to the generated element.
     * 
     * @return  string  The html for the settings page.
     * @since 1.2.0
     */
    public function show_option( $option, $title, $wrap = '', $css_id = '' ) {
        
        return $this->html_registry[ $option ]( compact( 'option', 'title', 'wrap', 'css_id' ) );
    }

    /**
     * Get the html for a document panel setting
     * 
     * @param   string  $panel_name     The panel name to generate the html for
     * @param   array   {
     *      @type   string  $key    The argument name in the wrap @1.2.0 can be one of option|title|wrap|css_id
     *      @type   string  $value  The value of the arguument
     * }
     * 
     * @return  string  The html to output
     * @since 1.2.0
     */
    private function get_document_panel_html( $panel_name, $args ) {

        $wrap = $args[ 'wrap' ];
        $css_id = $args[ 'css_id' ];

        $option = sprintf(
                $wrap,
                '<input type="hidden" 
                name="'.esc_attr( FOFO_BEC_REQUEST_KEY.'['.$panel_name.']').'" 
                value="'.esc_attr( FOFO_BEC_PANEL_OFF ).'" />

                <input id="'.$css_id.'" 
                name="'.esc_attr( FOFO_BEC_REQUEST_KEY.'['.$panel_name.']').'" 
                type="checkbox" '.esc_attr( $this->bec_theme->{$panel_name} == FOFO_BEC_PANEL_ON ? 'checked' : '' ).' 
                value="'.esc_attr( FOFO_BEC_PANEL_ON ).'"/>'
        );

        return $option;
    }
}