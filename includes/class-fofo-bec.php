<?php
namespace FoFoBec;

/**
 * The core class the is repsonsible for turning the feature on and off
 * console
 * This class provides the following features:-
 * 
 *  1. Initialises the hooks for do_action to turn features on and off
 *  2. Adds the admin screen so features can be turned on/off interactively
 *  3. Captures the post back variables from the admin screen
 * 
 * Available block editor features for disabling are :-
 * 
 *  The 'Category Panel' on the settings sidebar [use feature name 'category_panel']
 *  The 'Tag Panel' on the settings sidebar [use feature name 'tag_panel']
 *  The 'Featured Image Panel' on the settings sidebar [use feature name 'featured_image_panel']
 *  The 'Excerpt Panel' on the settings sidebar [use feature name 'excerpt_panel']
 *  The 'Discussion Panel' on the settings sidebar [use feature name 'discussion_panel']
 *  The 'Permalink Panel' on the settings sidebar [use feature name 'permalink_panel']
 * 
 * @since 1.0.0
 */
class FoFo_Bec {

    /**
     * The default options when first running the plugin
     * 
     * @var array   $option_defaults {
     *      @type   string    $key    The feature name e.g. category_panel
     *      @type   string    $state  The state (onn/off) of the feature
     * }
     * 
     * @since 1.0.0
     */
    private $option_defaults = [];

    /**
     * The names of the features as they appear on the settings page
     * 
     * @var array   $option_feature_names {
     *      @type   string  $key    The feature name e.g. category_panel
     *      @type   string  $name   The name of the feature as it appears on the settings page
     * }
     * 
     * @since 1.0.0
     */
    private $option_feature_names = [];

    /**
     * A cached version of the current set of options and there state
     * for use when rendering the options page.
     * 
     * @see $option_defaults
     * 
     * @var array   $current_options {
     *      @type   string    $key    The feature name e.g. category_panel
     *      @type   string    $state  The state (onn/off) of the feature
     * }
     * 
     * @since 1.0.0
     */
    private $current_options = null;

    /**
     * The current Bloc Editor Customiser theme
     * 
     * @var FoFoBec\FoFo_Bec_Theme  $current_bec_theme
     * 
     * @since 1.1.0
     */
    private $current_bec_theme;

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
     * Initialise the plugin
     * 
     * @return  void
     * @since   1.0.0
     */
    public function attach() {

        \FoFoBec\FoFo_Bec_Shared::set_defines();

        $this->do_wp_hooks();
        $this->do_our_hooks();

        $this->dal = new \FoFoBec\FoFo_Bec_Dal();
        $this->theme_registry = new \FoFoBec\FoFo_Bec_Theme_Registry( $this->dal );

        $options = $this->dal->get_v1_options();
        if( '' !== $options ) {
            $this->convert_to_theme( $options );
        }

        $this->current_bec_theme = $this->theme_registry->get_current_theme();
        $this->current_bec_theme = \FoFoBec\FoFo_Bec_Upgrader::theme_v100_v110( $this->current_bec_theme );
        $this->current_bec_theme = \FoFoBec\FoFo_Bec_Upgrader::theme_v110_v120( $this->current_bec_theme );
        $this->theme_registry->scan_for_themes();
    }

    /**
     * Convert the options from the pevious version to a BEC theme
     * 
     * @param   array   $options {
     *      @type   string  $key
     *      @type   string  $value
     * }
     * 
     * @return  void
     * @since 1.1.0
     */
    private function convert_to_theme( $options ) {

        $converted_theme = new \FoFoBec\FoFo_Bec_Theme();

        $converted_theme->category_panel = $options[ 'category_panel' ];
        $converted_theme->tag_panel = $options[ 'tag_panel' ];
        $converted_theme->featured_image_panel = $options[ 'featured_image_panel' ];
        $converted_theme->excerpt_panel = $options[ 'excerpt_panel' ];
        $converted_theme->discussion_panel = $options[ 'discussion_panel' ];
        $converted_theme->permalink_panel = $options[ 'permalink_panel' ];

        //update the options
        $this->theme_registry->set_current_theme( $converted_theme );
        $this->dal->set_v1_options( '' );
    }

    /**
     * Hook into the WP actions
     * 
     * This method hooks into the functions for loading the admin scripts
     * and adding a settings page.
     * 
     * @return  void
     * @since   1.0.0
     */
    private function do_wp_hooks() {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'load_scripts' ] );
        add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
        add_action( 'admin_head', [ $this, 'write_js' ] );
    }

    /**
     * Localise and load the JS script for turning Block Editor
     * features on/off.
     * 
     * @return  void
     * @since   1.0.0
     */
    public function load_scripts() {

        wp_register_script( 
            'fofobec-js', 
            plugin_dir_url( __FILE__ ) . '../js/fofobec.js', 
            ['jquery', 'wp-editor'],
            '1.0.2', 
            true 
        );
        wp_localize_script(
            'fofobec-js', 
            'fofobec',
            []
        );

        wp_enqueue_script( 'fofobec-js' );

        $dal = new \FoFoBec\FoFo_Bec_Dal();
        $theme_registry = new \FoFoBec\FoFo_Bec_Theme_Registry( $dal );

        $bec_theme = $theme_registry->get_current_theme();
        if( function_exists( 'get_current_screen' ) ) {

            $current_screen = get_current_screen();
            if( 'post' === $current_screen->id ) {

                if( '' !== $bec_theme->css ) {

                    $theme_style_slug = 'fofobec-themcss-'.$bec_theme->name;
                    $theme_css_url = FOFO_BEC_THEME_REPO_URL.$bec_theme->name.'/'.$bec_theme->css.'.css';

                    wp_register_style( $theme_style_slug, $theme_css_url, false, '1.0.0' );
                    wp_enqueue_style( $theme_style_slug );
                }
            }
        }
    }

    /**
     * Add a settings page for interactive use
     * 
     * This adds a settings page so that features can be turned on/off
     * interactively. If the settings page is never to be used and
     * features will be turned on/off using the hooks only then
     * the FOFO_BEC_SHOW_SETTINGS define can be used to hide the
     * settings page 
     * 
     * @return  void
     * @since   1.0.0
     */
    public function add_plugin_page() {

        if( FOFO_BEC_SHOW_SETTINGS ) {

            add_menu_page(
                'FoFo Block Editor Customiser',
                'Block Editor Customiser',
                'manage_options',
                'fofo_bec_plugin_page',
                [ $this, 'show_page' ],
                'dashicons-list-view',
                '63.05'
            );
        }
    }

    /**
     * Callback for add_menu_page
     * 
     * This is the callback for add_menu_page which builds the HTML to 
     * show on the settings page.
     * 
     * @return  void
     * @since   1.0.0
     */
    public function show_page() {

        $this->apply_ui_updates();

        $page_builder = new \FoFoBec\FoFo_Bec_Page_Builder( $this->current_bec_theme );
        $theme_transform = new \FoFoBec\FoFo_Bec_Theme_Transform( $this->current_bec_theme );
        $theme_settings = $theme_transform->to_ui( $page_builder );

        $composer = new \FoFoBec\FoFo_Bec_Page_Composer( $this->dal, $this->theme_registry );

        echo $composer->build_page( $theme_settings );
    }

    /**
     * Write the generated javascript into the header
     * 
     * @access internal
     * @return void
     * @since 1.1.0 
     */
    public function write_js() {

        $js = $this->dal->get_generated_js();
        $js = '<script type="text/javascript">'.$js.'</script>';

        echo $js;
    }

    /**
     * Hook into external code calling this plugins hooks
     * 
     * Initialise the hooks that external libraries and other
     * themes/plugins can call using do_action 
     * 
     * @return  void
     * @since   1.0.0
     */
    private function do_our_hooks() {

        /**
         * Hook for the action 'FOFO_BEC_feature_on' to turn a feature on
         * 
         * @see Available block editor features
         * 
         * @param   string  $feature    The name of the feature to turn on
         * @since   1.0.0
         */
        add_action( FOFO_BEC_FEATURE_ON, [ $this, 'turn_feature_on'] , 1, 10 );

        /**
         * Hook for the action 'FOFO_BEC_feature_off' to turn a feature on
         * 
         * @see Available block editor features
         * 
         * @param   string  $feature    The name of the feature to turn on
         * @since   1.0.0
         */
        add_action( FOFO_BEC_FEATURE_OFF, [ $this, 'turn_feature_off' ], 1, 10 );
    }

    /**
     * Callback for hook to turn feature on
     * 
     * @see     toggle_feature
     * 
     * @access  internal
     * @param   string  $feature    The name of the feature to turn on. Has no effect if feature already on
     * @return  void
     * @since   1.0.0
     */
    public function turn_feature_on( $feature ) {

        $this->toggle_feature( $feature, FOFO_BEC_PANEL_ON );
    } 

    /**
     * Callback for hook to turn feature off
     * 
     * @see     toggle_feature
     * 
     * @access  internal
     * @param   string  $feature    The name of the feature to turn off. Has no effect if feature already off
     * @return  void
     * @since   1.0.0
     */
    public function turn_feature_off( $feature ) {

        $this->toggle_feature( $feature, FOFO_BEC_PANEL_OFF );
    } 

    /**
     * Toggle a feature on/off.
     * 
     * Helper function to update the option to toggle a feature on
     * or off.
     * 
     * @see     turn_feature_on
     * @see     turn_feature_off
     * 
     * @return  void
     * @since   1.0.0
     */
    private function toggle_feature( $key, $value ) {

        $this->current_bec_theme->{ $key } = $value;        
        $this->theme_registry->set_current_theme( $this->current_bec_theme );

        $customiser = new \FoFoBec\FoFo_Bec_Customiser( $this->current_bec_theme, $this->dal );
        $customiser->apply_changes();
        $customiser->commit_changes();
    }

    /**
     * Capture updates from the settings screen
     * 
     * @return  void
     * @since   1.0.0
     */
    private function apply_ui_updates() {
       
        $theme_transform = new \FoFoBec\FoFo_Bec_Theme_Transform( $this->current_bec_theme);
        $this->current_bec_theme = $theme_transform->from_ui( $_REQUEST );
        $this->theme_registry->set_current_theme( $this->current_bec_theme );

        $composer = new \FoFoBec\FoFo_Bec_Page_Composer( $this->dal, $this->theme_registry );
        $composer->apply_ui_updates( $_REQUEST );

        $customiser = new \FoFoBec\FoFo_Bec_Customiser( $this->current_bec_theme, $this->dal );
        $customiser->apply_changes();
        $customiser->commit_changes();
    }
}