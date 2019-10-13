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
     * Scan the themes folder for available themes.
     * 
     * Scans the theme folder and looks for an init.php. The init.php should
     * have a call to the fofo_bec_register_theme action hook, which in turn
     * calls the callable to perform the theme registration
     * 
     * @return  void
     * @since 1.2.0
     */
    public function scan_for_themes() {

        $dirs = array_filter( glob(FOFO_BEC_THEME_REPO_DIR.'/*'), 'is_dir' );
        foreach( $dirs as $dir ) {

            if( !$this->includes_existing_register_function( $dir.'/init.php' ) ) {

                include_once $dir.'/init.php';
            }
        }

        do_action( FOFO_BEC_REGISTER_THEME, $this );

        $this->dal->set_registered_themes( $this->themes );
    }

    /**
     * Check to see if the callable to register the theme in the theme init file
     * already exists.
     * 
     * @param   string  $init_location  The file location of the theme init file.
     * 
     * @return  bool    True if callable already exists.
     * @since   1.3.0
     */
    private function includes_existing_register_function( $init_location ) {
        
        $init_file = file_get_contents( $init_location );
        $matches = [];
        preg_match_all( '/add_action.*,(.*)\)/', $init_file, $matches );

        if( isset( $matches[1][0] ) ) {

            $register_function_name = str_replace( "'", '', $matches[1][0] );
            $register_function_name = trim( str_replace( '"', '', $register_function_name ) );
            return function_exists( $register_function_name );
        }

        return false;
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

        $registered_themes = $this->dal->get_registered_themes();
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

        $registered_themes = $this->dal->get_registered_themes();
        return $registered_themes[ $theme_name ];
    }

    /**
     * Get the currently active theme.
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme
     * @since 1.3.0
     */
    public function get_current_theme() {

        return $this->dal->get_current_theme();
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

        $this->dal->set_current_theme( $theme );
    }
}