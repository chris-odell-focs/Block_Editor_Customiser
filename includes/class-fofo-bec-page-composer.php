<?php

namespace FoFoBec;

/**
 * Provides functions which alloww the settings page to be composed
 * 
 * When a settings page is composed it will be made up of elements from the 
 * theme settings and general gloabl settings e.g. selected theme
 */
class FoFo_Bec_Page_Composer {

    /**
     * The nonce key to use when rendering the form fo the settings page
     * 
     * @var string  $nonce_key
     * 
     * @since 1.2.0
     */
    private $nonce_key = '';

    /**
     * Set of functions to call to set a property in the injected theme
     * 
     * @var array   {
     *      @type   string      $key        The feature slug/name
     *      @type   callable    $callable   The function to call to set the value on the property
     * }
     * 
     * @since   1.2.0
     */
    private $update_functions;

    /**
     * The data access layer. Used to abstract out options API
     * 
     * @var FoFoBec\FoFo_Bec_Dal  $dal
     * 
     * @since 1.2.0
     */
    private $dal;

    /**
     * The theme registry
     * 
     * @var     FoFo_Bec_Theme_Registry     $theme_registry
     */
    private $theme_registry;

    /**
     * The addon registry
     * 
     * @var     \FoFoBec\FoFo_Bec_Addon_Registry     $addon_registry
     */
    private $addon_registry;

    /**
     * Initialisation
     * 
     * Set up the member fields fo use in other methods
     * 
     * @since   1.2.0
     */
    public function __construct( $injectables ) {

        $this->nonce_key = 'fofo-bec-customiser-updates';
        $this->dal = $injectables[ 'dal' ];
        $this->theme_registry = isset( $injectables[ 'theme_registry' ] ) ? $injectables[ 'theme_registry' ] : null;
        $this->addon_registry = isset( $injectables[ 'addon_registry' ] ) ? $injectables[ 'addon_registry' ] : null;
        $this->build_update_functions();
    }

    /**
     * Build the list of functions which will be used to update the
     * general settings in a page.
     * 
     * @return  void
     * @since   1.2.0 
     */
    private function build_update_functions() {

        $this->update_functions = [
            FOFO_BEC_SELECTED_THEME_NAME => function( $theme_name ){ $this->set_current_theme( $theme_name ); },
        ];
    }

    /**
     * Build the html for the settings page
     * 
     * @param   string  $theme_name         The name of the current theme
     * @param   string  $theme_page_part    The html from the theme settings
     * 
     * @return  string  The HTML of the settings page
     * @since 1.2.0
     */
    public function build_page( $theme_name, $theme_page_part ) {

        $page = '
            <div class="wrap">
                <h1>Foxdell Folio Block Editor Customiser</h1>
                <h2>Settings for theme : '.$theme_name.'</h2>
                <form method="post" action="admin.php?page=fofo_bec_plugin_page" novalidate="novalidate">
                    '.wp_nonce_field( $this->nonce_key, '_wpnonce', true, false ).
                    $theme_page_part.
                    '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
                </form>
            </div>
        ';

        return $page;
    }

    /**
     * Build the theme page.
     * 
     * @return  string  The HTML for the theme page
     * @since 1.4.0
     */
    public function build_theme_page() {

        $page = '
            <div class="wrap">
                <h1>Foxdell Folio Block Editor Customiser</h1>
                <form method="post" action="admin.php?page=fofo_bec_plugin_page_themes" novalidate="novalidate">
                    '.wp_nonce_field( $this->nonce_key, '_wpnonce', true, false ).
                    $this->get_theme_selector().
                    '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
                </form>
            </div>
        ';

        return $page;
    }

    /**
     * Apply any general settings updates
     * 
     * @param   array   {
     *      @type   string  $key    The name of the value in the $_REQUEST server variable
     *      @type   any     $value  The value in the $_REQUEST server variable associated wwith $key 
     * }    The request data from the post back
     * 
     * @return  void
     * @since   1.2.0
     */
    public function apply_ui_updates( $request ) {

        $updates = isset( $request[ FOFO_BEC_REQUEST_KEY ] ) ? $request[ FOFO_BEC_REQUEST_KEY ] : null;

        if( null !== $updates ) {

            foreach( $updates as $feature => $update ) {

                if( array_key_exists( $feature, $this->update_functions ) ) {

                    $this->update_functions[ $feature ]( $update );          
                }  
            }
        }
    }

    /**
     * Get the html for the theme selector
     * 
     * @return  void
     * @since   1.2.0
     */
    private function get_theme_selector() {

        $registered_themes = $this->dal->get_registered_themes();
        $page = '
            <label>Selected Theme</label>
            <select name="'.esc_attr( FOFO_BEC_REQUEST_KEY.'['.FOFO_BEC_SELECTED_THEME_NAME.']').'">';

        $current_theme = $this->theme_registry->get_current_theme();
        
        foreach( $registered_themes as $key => $theme ) {

            $selected = $current_theme->name === $theme->name ? 'selected' : '' ;
            $page .= '<option '.$selected.' value="'.esc_attr( $theme->name ).'">'.$theme->display_name.'</option>';
        }

        $page .= '</select>';
        return $page;
    }

    /**
     * Set the current theme name from the postback value
     * 
     * @param   string  $value  The selected theme name
     * 
     * @return  void
     * @since 1.2.0
     */
    private function set_current_theme( $theme_name ) {

        if( $this->theme_registry->theme_exists( $theme_name ) ) {

            $selected_theme = $this->theme_registry->get_theme( $theme_name );
            $this->theme_registry->set_current_theme( $selected_theme );
        }
    }

    /**
     * Build the addon page view.
     * 
     * @param   string  $alert_message  The message to show as an alert on the addon page
     * 
     * @return  void
     * @since   1.4.0
     */
    public function build_addon_page( $activate_result ) {

        $alert_message = '';
        if( 'problem_activating_addon' === $activate_result ) {
            $alert_message = 'There was an problem activating the addon.';
        }

        $addons = $this->addon_registry->list_addons();
        $table_body = '';
        foreach($addons as $key => $addon) {

            $table_body .= '<tr>';
            $activate_nonce = wp_create_nonce('fofo_bec_'.$addon->name);
            $activate_link = admin_url('admin-ajax.php?action=fofo_bec_activate_addon&nonce='.$activate_nonce.'&addon_name='.$addon->name);
            $deactivate_link = '';
            $basefile = basename( $addon->file_location );
            $value = basename( str_replace( '/'.$basefile, '', $addon->file_location ) ).DIRECTORY_SEPARATOR.$basefile;
            $table_body = '<th>
                <input type="hidden" name="'.esc_attr( FOFO_BEC_REQUEST_KEY.'['.$addon->name.']' ).'" value="">
                <input type="checkbox" name="'.esc_attr( FOFO_BEC_REQUEST_KEY.'['.$addon->name.']' ).'" value="'.esc_attr( $value ).'">
            </th>
            <td class="plugin-title column-primary">
                '.$addon->display_name.'
                <div class="row-actions visible toggle-addon" data-addon_name="'.$addon->name.'" data-nonce="'.$activate_nonce.'">
                    '.($addon->activated !== FOFO_BEC_ADDON_ACTIVATED_STATE ? '<a href="'.$activate_link.'" class="edit">Activate</a>' : '<a href="'.$deactivate_link.'" class="edit">Deactivate</a>' ).'
                </div>
            </td>
            <td class="manage-column column-description">'.$addon->description.'</td>';

            $table_body .= '</tr>';
        }

        $error_class = $alert_message === '' ? '' : 'error';

        $page = '
            <div class="wrap">
                <h1>Foxdell Folio Block Editor Customiser Add Ons</h1>
                <div class="'.$error_class.'">'.$alert_message.'</div>
                <form method="post" action="admin.php?page=fofo_bec_plugin_page_addons" novalidate="novalidate">
                    '.wp_nonce_field( $this->nonce_key, '_wpnonce', true, false ).
                    '<table class="wp-list-table widefat">
                        <thead>
                        <tr>
                            <th class="manage-column column-cb check-column"></th>
                            <th class="manage-column column-name column-primary">Name</th>
                            <th class="manage-column column-description">Description</th>
                        </tr>
                        </thead>
                        <tbody>'.$table_body.'</tbody>
                    </table>
                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
                </form>
            </div>
        ';

        return $page;
    }
}