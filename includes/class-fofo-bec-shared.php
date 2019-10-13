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

        if( !defined( 'FOFO_BEC_CURRENT_THEME' ) ) {
            define( 'FOFO_BEC_CURRENT_THEME', 'FOFO_BEC_CURRENT_THEME' );
        }

        if( !defined( 'FOFO_BEC_JS_KEY' ) ) {
            define( 'FOFO_BEC_JS_KEY', 'FOFO_BEC_JS_KEY' );
        }

        if( !defined( 'FOFO_BEC_THEME_REPO_DIR' ) ) {
            define( 'FOFO_BEC_THEME_REPO_DIR', dirname( __FILE__ ).'/../themes' );
        }

        if( !defined( 'FOFO_BEC_THEME_REPO_URL' ) ) {
            define( 'FOFO_BEC_THEME_REPO_URL', str_replace( 'includes', 'themes', plugin_dir_url( __FILE__ ) ) );
        }

        if( !defined( 'FOFO_BEC_REQUEST_KEY' ) ) {
            define( 'FOFO_BEC_REQUEST_KEY', 'fofo_bec' );
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