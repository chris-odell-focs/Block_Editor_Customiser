<?php

namespace FoFoBec;

/**
 * Scan the themes folder to pick up what themes are available to use
 * an store them for access.
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
     * @return  void
     * @since   1.2.0
     */
    public function register_theme( $theme ) {

        $this->themes[ $theme->name ] = $theme;
    }

    /**
     * factory method to create a new theme
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

            include_once $dir.'/init.php';
        }

        do_action( FOFO_BEC_REGISTER_THEME, $this );
        $this->dal->set_registered_themes( $this->themes );
    }

    /**
     * Check to see if a theme exists
     * 
     * @return void
     * @since 1.2.0
     */
    public function theme_exists( $theme_name ) {

        $registered_themes = $this->dal->get_registered_themes();
        return array_key_exists( $theme_name, $registered_themes );
    }
}