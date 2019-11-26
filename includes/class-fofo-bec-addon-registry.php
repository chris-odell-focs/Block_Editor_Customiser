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
     * The registry of addons
     * 
     * @var array {
     *      @type   string  $key    The name off the addon
     *      @type   \FoFoBec\FoFo_Bec_Addon $addon  An addon instance
     * }
     * 
     * @since 1.6.0
     */
    private $registry;

    /**
     * Initialisation
     * 
     * @param   FoFoBec\FoFo_Bec_Dal    $dal    Injected data access layer instance.
     * 
     * @since   1.4.0
     */
    public function __construct( $dal ) {

        $this->dal = $dal;
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

        $this->ensure_registry();
        $addon_name = $this->sanitize_addon_name( $addon_name );
        return array_key_exists( $addon_name, $this->registry );
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
        $addon->name = $this->sanitize_addon_name( $header[ FOFO_BEC_EXTENSION_NAME_KEY ] );
        $addon->display_name = $header[ FOFO_BEC_EXTENSION_NAME_KEY ];
        $addon->description = $header[ FOFO_BEC_EXTENSION_DESCRIPTION_KEY ];
        $addon->version = $header[ FOFO_BEC_EXTENSION_VERSION_KEY ];
        $addon->file_location = $file;
        $addon->activated = FOFO_BEC_ADDON_DEACTIVATED_STATE;

        $this->ensure_registry();
        $this->registry[ $addon->name ] = $addon;
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

        $this->ensure_registry();
        if( array_key_exists( $addon_name, $this->registry ) ) {

            return $this->registry[ $addon_name ];
        }

        throw new \Exception('add on '.$addon_name.' could not be found'); 
    }

    /**
     * Commit updates to the registry.
     * 
     * @param   array {
     *      @type   string  $name
     *      @type   \FoFoBec\FoFo_Bec_Addon Instance of addd on class
     * }
     * @since 1.4.0
     */
    public function commit_addon_changes() {

        $this->dal->set_addons( $this->registry );
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

        $this->ensure_registry();
        return $this->registry;
    }

    /**
     * Ensure the registry instance is populated
     * 
     * @return  void
     * @since   1.6.0
     */
    private function ensure_registry() {

        if( $this->registry === null ) {

            $this->registry = $this->dal->get_addons();
        }
    }

    /**
     * Clear the registry down
     * 
     * @return void
     * @since 1.4.0
     */
    public function clear_registry() {

        $this->registry = [];
        $this->commit_addon_changes();
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

        $this->ensure_registry();

        foreach( $this->registry as $key => $addon ) {

            if( FOFO_BEC_ADDON_ACTIVATED_STATE === $addon->activated ) {

                include_once( $addon->file_location );
            }
        }
    }
}