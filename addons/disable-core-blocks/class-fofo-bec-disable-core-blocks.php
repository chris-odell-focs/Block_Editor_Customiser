<?php

/**
 * The main entry point for the diable core blocks addon
 * 
 * @since 1.0.0
 */
class FoFo_Bec_Disable_Core_Blocks {
    
    /**
     * Template for the JS to add to the core BEC JS
     * 
     * @var     string      $front_end_js_template
     * @since 1.0.0
     */
    private $front_end_js_template = "
const dcbFunctions = function(wpDataStore) {

    const getDCBStoreFunction = function(wpData) {

        if( wpData !== undefined ) {
    
            if( wpData.dispatch !== undefined && wpData.dispatch('core/edit-post') !== undefined ) {
    
                return wpData.dispatch('core/edit-post');
            }
    
            return null;
        }
    
        return null;
    };

    return {
        hideBlocks : function(blockTypes){

            let storeFunction = getDCBStoreFunction(wpDataStore);
            if(storeFunction !== null && blockTypes.length > 0){
    
                storeFunction.hideBlockTypes(blockTypes);
            }
        },
        showBlocks : function(blockTypes){
        
            let storeFunction = getDCBStoreFunction(wpDataStore);
            if(storeFunction !== null && blockTypes.length > 0){
    
                storeFunction.showBlockTypes(blockTypes);
            }
        },
    };
};
    ";

    /**
     * Initiallisation logic for the addon
     * 
     * @return  void
     * @since 1.0.0
     */
    public function attach() {

        $this->do_hooks();
        $this->do_defines();
        add_action( 'fofo_bec_after_load_menus', [ $this, 'add_menu' ] );
    }

    /**
     * Add the menu option for the addon.
     * 
     * @param   string      $top_level_menu_slug    The top level BEC slug
     * 
     * @return  void
     * @since   1.0.0
     */
    public function add_menu( $top_level_menu_slug ) {

        add_submenu_page(
            $top_level_menu_slug, 
            "Disable Core Blocks", 
            "Disable Core Blocks", 
            'manage_options', 
            "fofo_bec_disable_core_blocks", 
            [ $this, 'show_page' ]
        );
    }

    /**
     * Render the HTML for the addon page
     * 
     * @return  void
     * @since   1.0.0
     */
    public function show_page() {

        $this->update_disabled_blocks( $_POST );

        $page = '
            <div class="wrap">
                <h1>Disable Core Blocks</h1>
                <form method="post" action="admin.php?page=fofo_bec_disable_core_blocks" novalidate="novalidate">
                    '.wp_nonce_field( 'dcb-block-list', '_wpnonce', true, false ).
                    '<div class="tablenav-pages fofo-bec-dcb-paging"></div>
                    <table id="disable-core-blocks-list" class="wp-list-table widefat">
                        <thead>
                        <tr>
                            <th class="manage-column column-cb column-primary" style="width: 85px; text-align: center;">Disabled</th>
                            <th class="manage-column column-name">Name</th>
                            <th class="manage-column column-title">Title</th>
                            <th class="manage-column column-description">Description</th>
                        </tr>
                        </thead>
                        <tbody><td>Loading...</td></tbody>
                    </table>
                    <div class="tablenav-pages fofo-bec-dcb-paging"></div>
                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
                    <div style="" id="fofo-bec-dcb-selected-items"></div>
                </form>
            </div>
        ';

        echo $page;
    }

    /**
     * Update changes to the selected disabled core blocks.
     * 
     * @param   array {
     *      @type   string      $key        The key to the vaue in the $_POST server variable
     *      @tyype  string      $value      The value in the $_POST server variable
     * }
     * 
     * @return  void
     * @since   1.0.0
     */
    private function update_disabled_blocks( $post ) {

        $nonce = isset( $post['_wpnonce'] ) ? $post['_wpnonce'] : null;

        if( null !== $nonce ) {

            if ( !wp_verify_nonce( $nonce, "dcb-block-list" ) ) {
                exit("Cannot verify request");
            }

            $updates = isset( $post[ FOFO_BEC_DCB_REQUEST_KEY ] ) ? $post[ FOFO_BEC_DCB_REQUEST_KEY ] : null;

            if( null !== $updates ) {

                $updates = array_filter( $updates, 
                    function( $item ){ 
                        return false !== strpos($item, 'core') && false !== strpos($item, '/'); 
                    },
                    ARRAY_FILTER_USE_KEY 
                );

                update_option( FOFO_BEC_DCB_OPTION_KEY, $updates );
                do_action( 'fofo_bec_addon_apply_changes' );
            }
        }
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
    private function do_hooks() {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'load_scripts' ] );
        add_action( 'fofo_bec_addon_after_deactivate', [ $this, 'after_deactivate' ], 10, 1 );
        add_filter( 'fofo_bec_before_compose_js', [ $this, 'get_js' ] );
    }

    /**
     * Define any constants for this addon
     * 
     * @return  void
     * @since   1.0.0
     */
    private function  do_defines() {

        if( !defined('FOFO_BEC_DCB_SLUG') ) {
            define( 'FOFO_BEC_DCB_SLUG', 'disable-core-blocks' );
        }

        if( !defined('FOFO_BEC_DCB_OPTION_KEY') ) {
            define( 'FOFO_BEC_DCB_OPTION_KEY', 'FOFO_BEC_DCB_OPTION_KEY' );
        }

        if( !defined('FOFO_BEC_DCB_REQUEST_KEY') ) {
            define( 'FOFO_BEC_DCB_REQUEST_KEY', 'fofobecdcb' );
        }

        if( !defined('FOFO_BEC_DCB_ENABLED_STATE') ) {
            define( 'FOFO_BEC_DCB_ENABLED_STATE', 'enabled' );
        }

        if( !defined('FOFO_BEC_DCB_DISABLED_STATE') ) {
            define( 'FOFO_BEC_DCB_DISABLED_STATE', 'disabled' );
        }
    }

    /**
     * Load scripts, JS and CSS
     * 
     * @return  void
     * @since   1.0.0
     */
    public function load_scripts() {

        if( function_exists( 'get_current_screen' ) ) {

            $current_screen = get_current_screen();
            if( 'post' !== $current_screen->id && 'page' !== $current_screen->id ) {

                wp_enqueue_script( 'fofobec-dcb-dt-js', plugin_dir_url( __FILE__ ) . 'vendor/datatables/datatables.min.js', [ 'jquery' ], '1.0.1', true );

                wp_register_script( 
                    'fofobec-dcb-js', 
                    plugin_dir_url( __FILE__ ) . FOFO_BEC_DCB_SLUG.'.js', 
                    ['jquery', 'wp-editor', 'wp-edit-post', 'fofobec-dcb-dt-js' ],
                    '1.0.1', 
                    true 
                );
        
                wp_localize_script(
                    'fofobec-dcb-js', 
                    'fofobec_dcb_js',
                    [ 'ajaxurl'  => admin_url( 'admin-ajax.php' ) ]
                );
        
                wp_enqueue_script( 'fofobec-dcb-js' );
                wp_enqueue_style( 'fofofbec-dcb-css', plugin_dir_url( __FILE__ ) . FOFO_BEC_DCB_SLUG.'.css' );
                wp_enqueue_style( 'fofofbec-dcb-dt-css', plugin_dir_url( __FILE__ ) . 'vendor/datatables/datatables.min.css' );
            }
        }        
    }

    /**
     * List the block types hich have been marked as disabled
     * 
     * @return  array {
     *      @type       string  The block type e.g. core/paragraph
     * }
     * 
     * @since   1.0.0
     */
    public function list_disabled_blocks() {

        $block_states = get_option( FOFO_BEC_DCB_OPTION_KEY, [] );
        $disabled_blocks = array_filter( $block_states, function( $item ){ return $item === FOFO_BEC_DCB_DISABLED_STATE; } );

        return array_keys( $disabled_blocks );
    }

    /**
     * List the bock types wwhich have not been disabled.
     * 
     * @return  array {
     *      @type       string  The block type e.g. core/paragraph
     * }
     * 
     * @since   1.0.0
     */
    public function list_enabled_blocks() {

        $block_states = get_option( FOFO_BEC_DCB_OPTION_KEY, [] );
        $enabled_blocks = array_filter( $block_states, function( $item ){ return $item === FOFO_BEC_DCB_ENABLED_STATE; } );

        return array_keys( $enabled_blocks );
    }

    /**
     * Callback from core to allow DCB to add any JS.
     * 
     * @param   array   {
     *      @type   string  $key    Either 'body' or 'functions' for the two areas of JS to modify
     *      @type   string  $value  The JS to render on the Block Editor page
     * }
     * 
     * @return   array   {
     *      @type   string  $key    Either 'body' or 'functions' for the two areas of JS to modify
     *      @type   string  $value  The JS to render on the Block Editor page
     * }
     * 
     * @since   1.0.0
     */
    public function get_js( $js_parts ) {

        $disabled_block_types = $this->list_disabled_blocks();
        $enabled_blocks = $this->list_enabled_blocks();
        $js_parts[ 'body' ] .= PHP_EOL.$this->front_end_js_template;
        $js_parts[ 'functions' ][] = "'dcbHideBlockTypes' : () => dcbFunctions(window.wp.data).hideBlocks(['".implode( "','", $disabled_block_types )."'])";
        $js_parts[ 'functions' ][] = "'dcbShowBlockTypes' : () => dcbFunctions(window.wp.data).showBlocks(['".implode( "','", $enabled_blocks )."'])";

        return $js_parts;
    }

    /**
     * Action hook to perform any deactivation cleanup.
     * 
     * @param   string  $addon_name     The name of the addon being deactivated
     * 
     * @return  void
     * @since   1.0.0
     */
    public function after_deactivate( $addon_name ) {

        if( FOFO_BEC_DCB_SLUG === $addon_name ) {

            update_option( FOFO_BEC_DCB_OPTION_KEY, [] );
            do_action( 'fofo_bec_addon_apply_changes' );
        }
    }
}

