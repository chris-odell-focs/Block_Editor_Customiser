<?php

namespace FoFoBec;

/**
 * Represents the concept of a registry of themes, and provides methods for
 * accessing the themes within the registry and to manipulate the registry.
 * 
 * @since   1.2.0
 */
class FoFo_Bec_Theme_Registry {

    /**
     * @var     array   {
     *      @type   string  $name           The name of the theme,
     *      @type   \FoFoBec\FoFo_Bec_Theme The theme to register
     * }
     * 
     * @since 1.2.0
     */
    private $themes;

    /**
     * @var     array(
     *      @type   string  $key                The key to the theme in the cache
     *      @type   \FoFoBec\FoFo_Bec_Theme     The theme
     * )
     * @since       1.4.0
     */
    private $theme_cache;

    /**
     * The data access layer. Used to abstract out options API
     * 
     * @var FoFoBec\FoFo_Bec_Dal  $dal
     * 
     * @since 1.1.0
     */
    private $dal;

    /**
     * Initialisation
     * 
     * @param   FoFoBec\FoFo_Bec_Dal    $dal    Injected data access layer instance.
     * 
     * @return void
     * @since 1.2.0
     */
    public function __construct( $dal ) {

        $this->dal = $dal;
    }

    /**
     * Register a theme in the theme registry.
     * 
     * Typically called when scanning for themes
     * 
     * @param   \FoFoBec\FoFo_Bec_Theme $theme  The theme to register
     * 
     * @return  void
     * @since   1.2.0
     */
    public function register_theme( $theme ) {

        $theme = $this->ensure_theme_version( $theme );
        $this->themes[ $theme->name ] = $theme;
    }

    /**
     * Factory method to create a new theme
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme
     * @since 1.2.0
     */
    public function get_new_theme() {

        return new \FoFoBec\FoFo_Bec_Theme();
    }

    /**
     * After a scan update the themes registered in the database
     * 
     * @return      void
     * @since        1.4.0 
     */
    public function commit_registered_theme_changes() {

        $this->dal->set_registered_themes( $this->themes );
    }

    /**
     * Check to see if a theme exists
     * 
     * @param   string  $theme_name The name of the theme to check exists in the registry.
     * 
     * @return void
     * @since 1.2.0
     */
    public function theme_exists( $theme_name ) {

        $registered_themes = $this->get_theme_cache();

        if( $registered_themes === null ) {
            return false;
        }

        return array_key_exists( $theme_name, $registered_themes );
    }

    /**
     * Get a theme from the registry.
     * 
     * @param   string  $theme_name The name of the theme. This will be the key of the theme within the registry.
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme
     * @since 1.3.0
     */
    public function get_theme( $theme_name ) {

        $registered_themes = $this->get_theme_cache();
        return $registered_themes[ $theme_name ];
    }

    /**
     * Get the currently active theme.
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme
     * @since 1.3.0
     */
    public function get_current_theme() {

        $current_theme = $this->dal->get_current_theme();
        $current_theme = $this->ensure_have_theme( $current_theme );
        $current_theme = $this->ensure_theme_version( $current_theme );

        return $current_theme;
    }

    /**
     * Set the currently active theme.
     * 
     * @param   \FoFoBec\FoFo_Bec_Theme The theme to make the currently active one.
     * 
     * @return  void
     * @since   1.3.0
     */
    public function set_current_theme( $theme ) {

        $theme = $this->ensure_theme_version( $theme );

        $this->dal->set_current_theme( $theme );
        $theme_cache = $this->get_theme_cache();
        $theme_cache[ $theme->name ] = $theme;
        $this->dal->set_registered_themes( $theme_cache );
    }

    /**
     * List the themes which are registered
     * 
     * @return  array   {
     *      @type   \FoFoBec\FoFo_Bec_Theme
     * }
     * 
     * @since 1.5.0
     */
    public function list_themes() {

        return $this->dal->get_registered_themes();
    }

    /**
     * Get the cache of registered themes
     * 
     * @return     array(
     *      @type   string  $key                The key to the theme in the cache
     *      @type   \FoFoBec\FoFo_Bec_Theme     The theme
     * )
     * @since   1.4.0
     */
    private function get_theme_cache() {

        if( null === $this->theme_cache ) {
            
            $this->theme_cache = $this->dal->get_registered_themes();
        }
        
        return $this->theme_cache;
    }

    /**
     * Clear the theme registry
     * 
     * @return  void
     * @since 1.5.0
     */
    public function clear_themes() {

        $this->dal->set_registered_themes([]);
    }

    /**
     * Ensure a theme is at the latest version
     * 
     * @return  void
     * @since   1.5.0 
     */
    private function ensure_theme_version( $theme ) {

        $theme = \FoFoBec\FoFo_Bec_Upgrader::theme_to_v130( $theme );
        return $theme;
    }

    /**
     * Check if a theme exists in the registry of if the theme is
     * empty and return the default theme if it is.
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme
     * @since   1.5.0
     */
    private function ensure_have_theme( $theme ) {

        $return_default = $theme == null;
        $return_default = !$return_default ? !$this->theme_exists( $theme->name ) : true;

        if( $return_default ) {

            $default = $this->get_theme( 'default' );
            return $default;
        }

        return $theme;
    }
}