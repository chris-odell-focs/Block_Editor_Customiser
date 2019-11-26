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

    // /**
    //  * Scan for addons
    //  * 
    //  * During the scan the addon header is checked, and if the 
    //  * addon is not in the registry, or if the version number has changed
    //  * attempt reactivation.
    //  *  
    //  * @return  void
    //  * @since   1.4.0
    //  */
    // public function scan_for_addons() {

    //     $dirs = array_filter( glob(FOFO_BEC_ADDON_REPO_DIR.'/*'), 'is_dir' );
    //     foreach( $dirs as $dir ) {

    //         $files = array_filter( glob($dir.'/*'), 'is_file' );

    //         foreach( $files as $file ) {

    //             $expected_headers = [ 
    //                 FOFO_BEC_EXTENSION_DESCRIPTION_KEY => FOFO_BEC_EXTENSION_DESCRIPTION_KEY, 
    //                 FOFO_BEC_EXTENSION_NAME_KEY => FOFO_BEC_EXTENSION_NAME_KEY, 
    //                 FOFO_BEC_EXTENSION_VERSION_KEY => FOFO_BEC_EXTENSION_VERSION_KEY 
    //             ];

    //             $header = array_change_key_case( $this->get_file_data( $file, $expected_headers ) );
    //             if( $this->header_validates( $header ) ){

    //                 if( $this->addon_registry->exists( $header[ 'name' ] ) ) {

    //                     $this->addon_registry->update( $header );

    //                 } else {

    //                     $this->addon_registry->add( $header, $file );
    //                 }
    //             }
    //         }
    //     }
    // }

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

    // /**
    //  * Retrieve metadata from a file.
    //  *
    //  * Searches for metadata in the first 8 KB of a file, such as a plugin or theme.
    //  * Each piece of metadata must be on its own line. Fields can not span multiple
    //  * lines, the value will get cut at the end of the first line.
    //  *
    //  * If the file data is not within that first 8 KB, then the author should correct
    //  * their plugin file and move the data headers to the top.
    //  * 
    //  * This is a modified version of the 'get_file_data' function found in .\wp-includes\functions.php from WordPress core
    //  *
    //  * @link https://codex.wordpress.org/File_Header
    //  *
    //  * @since 1.4.0
    //  *
    //  * @param string $file              Absolute path to the file.
    //  * @param array  $headers           List of headers, in the format `array( 'HeaderKey' => 'Header Name' )`.
    //  *                                  Default empty.
    //  * @return array Array of file headers in `HeaderKey => Header Value` format.
    //  */
    // private function get_file_data( $file, $headers ) {
    //     // We don't need to write to the file, so just open for reading.
    //     $fp = fopen( $file, 'r' );

    //     // Pull only the first 8 KB of the file in.
    //     $file_data = fread( $fp, 8 * KB_IN_BYTES );

    //     // PHP will close file handle, but we are good citizens.
    //     fclose( $fp );

    //     // Make sure we catch CR-only line endings.
    //     $file_data = str_replace( "\r", "\n", $file_data );

    //     foreach ( $headers as $field => $regex ) {
    //         if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ) {
    //             $headers[ $field ] = _cleanup_header_comment( $match[1] );
    //         } else {
    //             $headers[ $field ] = '';
    //         }
    //     }

    //     return $headers;
    // }

    // /**
    //  * Check if a header validates.
    //  * 
    //  * For a header to validate it has to contain the expected keys.
    //  * 
    //  * @param   array   Array of file headers in `HeaderKey => Header Value` format.
    //  * 
    //  * @return  boolean true on success
    //  * @since   1.4.0
    //  */
    // private function header_validates( $header ) {
        
    //     if( 0 !== count( $header ) ) {

    //         return array_key_exists( FOFO_BEC_EXTENSION_DESCRIPTION_KEY, $header ) &&
    //             array_key_exists( FOFO_BEC_EXTENSION_NAME_KEY, $header ) &&
    //             array_key_exists( FOFO_BEC_EXTENSION_VERSION_KEY, $header );
    //     }

    //     return false;
    // }

    // /**
    //  * Activate the addon in a 'sandbox' by calling this function through an 
    //  * ajax action.
    //  * 
    //  * @param   string  $addon_name The name of the addon to activate
    //  * 
    //  * @return  string  'success' if there were no errors activating the addon
    //  */
    // public function toggle_addon( $addon_name ) {

    //     $addon = $this->addon_registry->get_addon( $addon_name );

    //     if( $addon->activated === FOFO_BEC_ADDON_DEACTIVATED_STATE ) {

    //         include_once( $addon->file_location );

    //         $addon->activated = FOFO_BEC_ADDON_ACTIVATED_STATE;

    //         do_action( FOFO_BEC_ADDON_AFTER_ACTIVATE, $addon_name );
           
    //     } else {

    //         $addon->activated = FOFO_BEC_ADDON_DEACTIVATED_STATE;
    //         do_action( FOFO_BEC_ADDON_AFTER_DEACTIVATE, $addon_name );
    //     }

    //     $this->addon_registry->update_addon( $addon );
        
    //     //If we get this far there hasn't been an error activating the 
    //     //addon so we can send the success value back. 
    //     return 'success';
    // }
}