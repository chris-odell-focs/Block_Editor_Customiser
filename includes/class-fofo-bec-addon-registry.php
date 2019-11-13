<?php

namespace FoFoBec;

/**
 * Manage the registry of addons
 */
class FoFo_Bec_Addon_Registry {

    /**
     * The data access layer. Used to abstract out options API
     * 
     * @var FoFoBec\FoFo_Bec_Dal  $dal
     * 
     * @since 1.4.0
     */
    private $dal;

    /**
     * Initialisation
     * 
     * @param   FoFoBec\FoFo_Bec_Dal    $dal    Injected data access layer instance.
     * 
     * @since   1.4.0
     */
    public function __construct( $dal ) {

        $this->dal = $dal;
        //$this->registry_cache = null;
    }

    /**
     * Factory function get a new addon class
     * 
     * @return  \FoFoBec\FoFo_Bec_Addon  The new addon
     * @since   1.4.0 
     */
    public function get_new_addon() {

        return new \FoFoBec\FoFo_Bec_Addon();
    }

    /**
     * Check to see if an addon exists in the registry
     * 
     * @param   string  $addon_name The add on name
     * @since   1.4.0
     */
    public function exists( $addon_name ) {

        $registry = $this->get_registry();
        $addon_name = $this->sanitize_addon_name( $addon_name );
        return array_key_exists( $addon_name, $registry );
    }

    /**
     * Update an add on if the version number has changed.
     * 
     * @param   array {
     *      @type   string  $key    The header item key
     *      @type   string  $value  The header item value
     * }
     * 
     * @return  void
     * @since   1.4.0
     */
    public function update( $header ) {

        $name = $this->sanitize_addon_name( $header[ FOFO_BEC_ADDON_NAME_KEY ] );
        $version = $header[ FOFO_BEC_ADDON_VERSION_KEY ];
        $addon = $this->get_addon( $name );
        if( $addon->version !== $version ) {

            $addon->version = $version;
            $addon->name = $name;
            $addon->display_name = $header[ FOFO_BEC_ADDON_NAME_KEY ];
            $addon->description = $header[ FOFO_BEC_ADDON_DESCRIPTION_KEY ];

            $registry = $this->get_registry();
            $registry[ $name ] = $addon;
            $this->save( $registry );
        }
    }

    /**
     * Add a new add on to the registry.
     * 
     * @param   array {
     *      @type   string  $key    The header item key
     *      @type   string  $value  The header item value
     * }
     * 
     * @param   string  $file   The file location of the header file
     * @since   1.4.0
     */
    public function add( $header, $file ) {

        $addon = $this->get_new_addon();
        $addon->name = $this->sanitize_addon_name( $header[ FOFO_BEC_ADDON_NAME_KEY ] );
        $addon->display_name = $header[ FOFO_BEC_ADDON_NAME_KEY ];
        $addon->description = $header[ FOFO_BEC_ADDON_DESCRIPTION_KEY ];
        $addon->version = $header[ FOFO_BEC_ADDON_VERSION_KEY ];
        $addon->file_location = $file;
        $addon->activated = FOFO_BEC_ADDON_DEACTIVATED_STATE;

        $registry = $this->get_registry();
        $registry[ $addon->name ] = $addon;

        $this->save( $registry );
    }

    /**
     * Sanitize the addon name in a consistent manner
     * 
     * @param   string  $name   The addon name
     * 
     * @return  string  The sanitized addon name
     * @since 1.4.0
     */
    private function sanitize_addon_name( $name ) {

        return strtolower( sanitize_file_name( $name ) );
    }

    /**
     * Get an adddon
     * 
     * @param   string  $addon_name The name the add on was registered with
     * 
     * @return  \FoFoBec\FoFo_Bec_Addon
     * @since   1.4.0
     */
    public function get_addon( $addon_name ) {

        $registry = $this->get_registry();
        if( array_key_exists( $addon_name, $registry ) ) {

            return $registry[ $addon_name ];
        }

        throw new \Exception('add on '.$addon_name.' could not be found'); 
    }

    /**
     * Update an addon.
     * 
     * This differs from update in that update works based on the header information
     * whereas this functions updates the addon instance.
     * 
     * @return void
     * @since 1.4.0
     */
    public function update_addon( $addon ) {

        $registry = $this->get_registry();
        $registry[ $addon->name ] = $addon;
        $this->save( $registry );
    }

    /**
     * Save updates to the registry.
     * 
     * @param   array {
     *      @type   string  $name
     *      @type   \FoFoBec\FoFo_Bec_Addon Instance of addd on class
     * }
     * @since 1.4.0
     */
    private function save( $registry ) {

        $this->dal->set_addons( $registry );
    }

    /**
     * Get the list of add ons registered.
     * 
     * @return array {
     *      @type       string                  $key        The addon name
     *      @type       \FoFoBec\FoFo_Bec_Addon $addon      Instance of addd on class
     * }
     * @since   1.4.0
     */
    public function list_addons() {

        return $this->get_registry();
    }

    /**
     * Get the registry of add ons
     * 
     * @return array {
     *      @type       string                  $key        The addon name
     *      @type       \FoFoBec\FoFo_Bec_Addon $addon      Instance of addd on class
     * }
     * @since   1.4.0
     */
    private function get_registry() {

        return $this->dal->get_addons();
    }

    /**
     * Clear the registry down
     * 
     * @return void
     * @since 1.4.0
     */
    public function clear_registry() {

        $this->save([]);
    }

    /**
     * Load addons
     * 
     * Load and rn anyy addons which have been successffuully activated
     * 
     * @return  void
     * @since   1.4.0
     */
    public function load_addons() {

        $addons = $this->get_registry();
        foreach( $addons as $key => $addon ) {

            if( FOFO_BEC_ADDON_ACTIVATED_STATE === $addon->activated ) {

                include_once( $addon->file_location );
            }
        }        

    }
}