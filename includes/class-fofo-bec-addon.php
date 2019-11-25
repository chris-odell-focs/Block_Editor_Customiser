<?php

namespace FoFoBec;

/**
 * Represent an add on
 * 
 * @since 1.4.0
 */
class FoFo_Bec_Addon {

    /**
     * The properties for an addon
     * 
     * array $features {
     *      @type   string  $key    The addon name
     *      @type   string  $value  The value of the property
     * }
     * 
     * @since 1.1.0
     */
    private $properties = [];

    /**
     * Constructor - perform mininal initialisation
     * 
     * @return void
     * @since 1.4.0
     */
    public function __construct() {

        $this->set_defaults();
    }

    /**
     * Build the list of properties supported by an addon
     * 
     * @return void
     * @since 1.1.0
     */
    private function set_defaults() {

        $this->properties = [
            FOFO_BEC_EXTENSION_NAME_KEY => 'name',
            FOFO_BEC_EXTENSION_DESCRIPTION_KEY => '',
            FOFO_BEC_ADDON_DISPLAY_NAME_KEY => '',
            FOFO_BEC_ADDON_SCHEMA_VERSION => '1.0.0',
            FOFO_BEC_ADDON_FILE_LOCATION_KEY => '',
            FOFO_BEC_ADDON_ACTIVATED_KEY => '',
            FOFO_BEC_EXTENSION_VERSION_KEY => ''
        ];
    }

    /**
     * Set the addon
     * 
     * @param   FoFoBec\FoFo_Bec_Addon  $addon
     * @since 1.1.0
     */
    public function set_theme( $addon ) {

        $this->properties = $addon->properties;
    }

    /**
     * Magic getter for the addon properties
     * 
     * @param   string  $property   The property name to retreive the value for
     * @return  void
     * @since   1.4.0
     */
    public function __get( $property ) {

        if( array_key_exists( $property, $this->properties ) ) {

            return $this->properties[ $property ];
        }

        if( $property === 'properties' ) {
            return $this->properties;
        }
    }

    /**
     * Magic setter for the addon properties
     * 
     * @param   string  $property       The property name to set the value of
     * @param   string  $value          The value to set the property to
     * @return  void
     * @since   1.4.0
     */
    public function __set( $property, $value ) {

        if( array_key_exists( $property, $this->properties ) ) {

            $this->properties[ $property ] = $value;
        }

        if( $property === 'properties' ) {
            $this->properties = value;
        }        
    }
}