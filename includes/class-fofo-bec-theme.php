<?php

namespace FoFoBec;

/**
 * Represent the options saved for the block editor as a theme
 * 
 * @since 1.1.0
 */
class FoFo_Bec_Theme {

    /**
     * The features a theme has
     * 
     * array $features {
     *      @type   string  $key    The feature name/slug
     *      @type   string  $value  The value of the feature e.g. on/off
     * }
     * 
     * @since 1.1.0
     */
    private $features = [];

    /**
     * Constructor - perform mininal initialisation
     * 
     * @return void
     * @since 1.1.0
     */
    public function __construct() {

        $this->build_feature_registry();
    }

    /**
     * Build the list of features supported by a theme
     * 
     * @return void
     * @since 1.1.0
     */
    private function build_feature_registry() {

        $this->features = [
            'category_panel' => FOFO_BEC_PANEL_ON,
            'tag_panel' => FOFO_BEC_PANEL_ON,
            'featured_image_panel' => FOFO_BEC_PANEL_ON,
            'excerpt_panel' => FOFO_BEC_PANEL_ON,
            'discussion_panel' => FOFO_BEC_PANEL_ON,
            'permalink_panel' => FOFO_BEC_PANEL_ON,
            'version' => '1.0.0'
        ];
    }

    /**
     * Set the theme from the values saved as json
     * 
     * @return void
     * @since 1.1.0
     */
    public function from_json( $serialised_theme ) {

        if( '' !== $serialised_theme ) {
            $this->features = json_decode( $serialised_theme, true );
        }
    }

    /**
     * Convert the current theme to json
     * 
     * @return  string  The serialised version of the theme
     * @since 1.1.0
     */
    public function to_json() {

        return json_encode( $this->features );
    }

    /**
     * Set the theme the theme passed in as an argument
     * 
     * @param   FoFoBec\FoFo_Bec_Theme  $theme
     * @since 1.1.0
     */
    public function set_theme( $theme ) {

        $this->features = $theme->theme;
    }

    /**
     * Magic getter for the theme properties/features
     * 
     * @see build_feature_registry
     * 
     * @param   string  $feature_name   The property/feature name to retreive the value for
     * @return void
     * @since 1.1.0
     */
    public function __get( $feature_name ) {

        if( array_key_exists( $feature_name, $this->features ) ) {

            return $this->features[ $feature_name ];
        }

        if( $feature_name === 'theme' ) {
            return $this->features;
        }
    }

    /**
     * Magic setter for the theme properties/features
     * 
     * @see build_feature_registry
     * 
     * @param   string  $feature_name   The property/feature name to retreive the value for
     * @param   string  $value          The vale to set the property to
     * @return void
     * @since 1.1.0
     */
    public function __set( $feature_name, $value ) {

        if( array_key_exists( $feature_name, $this->features ) ) {

            $this->features[ $feature_name ] = $value;
        }
    }

    /**
     * Helper function to get the features of the theme
     * 
     * @return void
     * @since 1.1.0
     */
    public function features() {
        return $this->features;
    }
}