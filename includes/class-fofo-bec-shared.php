<?php

namespace FoFoBec;

/**
 * Provide services which pertain to cross cuutting concerns
 * 
 * @since 1.2.0
 */
class FoFo_Bec_Shared {

    /**
     * Set the standard definitions used throghout the plugin
     * 
     * @return  void
     * @since 1.2.0
     */
    public static function set_defines() {

        self::define_general();
        self::define_hooks();
        self::define_states();;
        self::define_feature_names();
        self::defines_for_themes();
        self::defines_for_addons();
    }

    /**
     * Define general definitons
     * 
     * @return void
     * @since 1.2.0
     */
    private static function define_general() {

        if( !defined( 'FOFO_BEC_OPTIONS_KEY' ) ) {
            define( 'FOFO_BEC_OPTIONS_KEY', 'FOFO_BEC_OPTIONS_KEY' );
        }

        if( !defined( 'FOFO_BEC_JS_KEY' ) ) {
            define( 'FOFO_BEC_JS_KEY', 'FOFO_BEC_JS_KEY' );
        }

        if( !defined( 'FOFO_BEC_REQUEST_KEY' ) ) {
            define( 'FOFO_BEC_REQUEST_KEY', 'fofo_bec' );
        }

        if( !defined( 'FOFO_BEC_EXTENSION_VERSION_KEY' ) ) {
            define( 'FOFO_BEC_EXTENSION_VERSION_KEY', 'version' );
        }

        if( !defined( 'FOFO_BEC_EXTENSION_NAME_KEY' ) ) {
            define( 'FOFO_BEC_EXTENSION_NAME_KEY', 'name' );
        }

        if( !defined( 'FOFO_BEC_EXTENSION_DESCRIPTION_KEY' ) ) {
            define( 'FOFO_BEC_EXTENSION_DESCRIPTION_KEY', 'description' );
        }
    }

    /**
     * Defines related to add ons
     * 
     * @return  void
     * @since   1.4.0
     */
    private static function defines_for_addons() {

        if( !defined( 'FOFO_BEC_ADDON_REGISTER' ) ) {
            define( 'FOFO_BEC_ADDON_REGISTER', 'FOFO_BEC_ADDON_REGISTER' );
        }

        if( !defined( 'FOFO_BEC_ADDON_REPO_DIR' ) ) {
            define( 'FOFO_BEC_ADDON_REPO_DIR', dirname( __FILE__ ).'/../addons' );
        }

        if( !defined( 'FOFO_BEC_ADDON_DISPLAY_NAME_KEY' ) ) {
            define( 'FOFO_BEC_ADDON_DISPLAY_NAME_KEY', 'display_name' );
        }

        if( !defined( 'FOFO_BEC_ADDON_SCHEMA_VERSION' ) ) {
            define( 'FOFO_BEC_ADDON_SCHEMA_VERSION', 'schema_version' );
        }

        if( !defined( 'FOFO_BEC_ADDON_FILE_LOCATION_KEY' ) ) {
            define( 'FOFO_BEC_ADDON_FILE_LOCATION_KEY', 'file_location' );
        }

        if( !defined( 'FOFO_BEC_ADDON_ACTIVATED_KEY' ) ) {
            define( 'FOFO_BEC_ADDON_ACTIVATED_KEY', 'activated' );
        }

        if( !defined( 'FOFO_BEC_ADDON_ACTIVATED_STATE' ) ) {
            define( 'FOFO_BEC_ADDON_ACTIVATED_STATE', 'yes' );
        }

        if( !defined( 'FOFO_BEC_ADDON_DEACTIVATED_STATE' ) ) {
            define( 'FOFO_BEC_ADDON_DEACTIVATED_STATE', 'no' );
        }

        if( !defined( 'FOFO_BEC_REGISTER_ADDON' ) ) {
            define( 'FOFO_BEC_REGISTER_ADDON', 'fofo_bec_register_addon' );
        }
    }

    /**
     * Defines related to themes
     * 
     * @return  void
     * @since   1.4.0
     */
    private static function defines_for_themes() {

        if( !defined( 'FOFO_BEC_CURRENT_THEME' ) ) {
            define( 'FOFO_BEC_CURRENT_THEME', 'FOFO_BEC_CURRENT_THEME' );
        }

        if( !defined( 'FOFO_BEC_THEME_REPO_DIR' ) ) {
            define( 'FOFO_BEC_THEME_REPO_DIR', dirname( __FILE__ ).'/../themes' );
        }

        if( !defined( 'FOFO_BEC_THEME_REPO_URL' ) ) {
            define( 'FOFO_BEC_THEME_REPO_URL', str_replace( 'includes', 'themes', plugin_dir_url( __FILE__ ) ) );
        }

        if( !defined( 'FOFO_BEC_SELECTED_THEME_NAME' ) ) {
            define( 'FOFO_BEC_SELECTED_THEME_NAME', 'selected-theme' );
        }

        if( !defined( 'FOFO_BEC_THEME_REGISTER' ) ) {
            define( 'FOFO_BEC_THEME_REGISTER', 'FOFO_BEC_THEME_REGISTER' );
        }
    }

    /**
     * Define the names of hooks
     * 
     * @return void
     * @since 1.2.0
     */
    private static function define_hooks() {

        if( !defined( 'FOFO_BEC_FEATURE_ON' ) ) {
            define( 'FOFO_BEC_FEATURE_ON', 'fofo_bec_feature_on' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_OFF' ) ) {
            define( 'FOFO_BEC_FEATURE_OFF', 'fofo_bec_feature_off' );
        }

        if( !defined( 'FOFO_BEC_REGISTER_THEME' ) ) {
            define( 'FOFO_BEC_REGISTER_THEME', 'fofo_bec_register_theme' );
        }

        if( !defined( 'FOFO_BEC_BEFORE_COMPOSE_JS' ) ) {
            define( 'FOFO_BEC_BEFORE_COMPOSE_JS', 'fofo_bec_before_compose_js' );
        }

        if( !defined( 'FOFO_BEC_AFTER_LOAD_MENUS' ) ) {
            define( 'FOFO_BEC_AFTER_LOAD_MENUS', 'fofo_bec_after_load_menus' );
        }

        if( !defined( 'FOFO_BEC_ADDON_APPLY_CHANGES' ) ) {
            define( 'FOFO_BEC_ADDON_APPLY_CHANGES', 'fofo_bec_addon_apply_changes' );
        }

        if( !defined( 'FOFO_BEC_ADDON_AFTER_ACTIVATE' ) ) {
            define( 'FOFO_BEC_ADDON_AFTER_ACTIVATE', 'fofo_bec_addon_after_activate' );
        }

        if( !defined( 'FOFO_BEC_ADDON_AFTER_DEACTIVATE' ) ) {
            define( 'FOFO_BEC_ADDON_AFTER_DEACTIVATE', 'fofo_bec_addon_after_deactivate' );
        }
    }

    /**
     * Define any 'states' that a feature can be in
     * 
     * @return void
     * @since 1.2.0 
     */
    private static function define_states() {

        if( !defined( 'FOFO_BEC_PANEL_ON' ) ) {
            define( 'FOFO_BEC_PANEL_ON', 'on' );
        }

        if( !defined( 'FOFO_BEC_PANEL_OFF' ) ) {
            define( 'FOFO_BEC_PANEL_OFF', 'off' );
        }
    }

    /**
     * Define all feature names of properties/features
     * of the block editor which can be manipulated
     * 
     * @return void
     * @since 1.2.0
     */
    private static function define_feature_names() {

        if( !defined( 'FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY' ) ) {
            define( 'FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY', 'category_panel' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_DOC_PANEL_TAG' ) ) {
            define( 'FOFO_BEC_FEATURE_DOC_PANEL_TAG', 'tag_panel' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE' ) ) {
            define( 'FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE', 'featured_image_panel' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT' ) ) {
            define( 'FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT', 'excerpt_panel' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION' ) ) {
            define( 'FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION', 'discussion_panel' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK' ) ) {
            define( 'FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK', 'permalink_panel' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_TOP_TOOLBAR' ) ) {
            define( 'FOFO_BEC_FEATURE_TOP_TOOLBAR', 'top_toolbar' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_SPOTLIGHT_MODE' ) ) {
            define( 'FOFO_BEC_FEATURE_SPOTLIGHT_MODE', 'spotlight_mode' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_FULLSCREEN' ) ) {
            define( 'FOFO_BEC_FEATURE_FULLSCREEN', 'fullscreen' );
        }

        if( !defined( 'FOFO_BEC_FEATURE_MORE_OPTIONS_MENU' ) ) {
            define( 'FOFO_BEC_FEATURE_MORE_OPTIONS_MENU', 'edit_post_more_menu' );
        }
    }
}