<?php

namespace FoFoBec;

/**
 * Manage any exstension to the core product. This includes both
 * themes an adddons.
 * 
 * @todo    Integrate themes
 * 
 * @since   1.4.0 
 */
class FoFo_Bec_Extension_Manager {

    /**
     * An addon registry instance
     * 
     * @var \FoFoBec\FoFo_Bec_Addon $addon_registry
     * @since 1.4.0
     */
    private $addon_registry;

    /**
     * A theme registry instance
     * 
     * @var \FoFoBec\FoFo_Bec_Theme_Registry
     * @since 1.5.0
     */
    private $theme_registry;

    /**
     * Initialisation
     */
    public function __construct( $injectables ) {

        if( !isset( $injectables[ 'addon_registry' ] ) ) {
            throw new \Exception('addon_registry not available in extension manager');
        }

        if( !isset( $injectables[ 'theme_registry' ] ) ) {
            throw new \Exception('theme_registry not available in extension manager');
        }

        $this->addon_registry = $injectables[ 'addon_registry' ];
        $this->theme_registry = $injectables[ 'theme_registry' ];
    }

    /**
     * Scan for addons
     * 
     * During the scan the addon header is checked, and if the 
     * addon is not in the registry, or if the version number has changed
     * attempt reactivation.
     *  
     * @return  void
     * @since   1.4.0
     */
    public function scan_for_addons() {

        $this->addon_registry->clear_registry();
        do_action( FOFO_BEC_REGISTER_ADDON, $this->addon_registry );
        $this->addon_registry->commit_addon_changes();
    }

    /**
     * Scan for themes
     * 
     * Scan for themes which have been added as external plugins
     *  
     * @return  void
     * @since   1.5.0
     */
    public function scan_for_themes() {
        
        include_once( dirname(__FILE__).'/fofo-bec-default-theme.php' );

        do_action( FOFO_BEC_REGISTER_THEME, $this->theme_registry );
        $this->theme_registry->commit_registered_theme_changes();    
    }
}