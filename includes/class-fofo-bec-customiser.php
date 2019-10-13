<?php

namespace FoFoBec;

/**
 * Provide a set of commands that can be used to customise the block editor
 * 
 * This class provides a domain specific language for customising the block editor. 
 * Commands can be run which will either call block specific PHP functions
 * in WordPress core, or will modify the JS that is created to call 
 * appropriate JS block methodds in the front end
 * 
 * @since 1.1.0
 */
class FoFo_Bec_Customiser {

    /**
     * @var string  $js_template    The javascript which will be output to the block editor
     * 
     * @since 1.1.0
     */
    private $js_template = '

const fofobec_function_dispatcher = ( wpStore )  => {

    const store = fofobecCoreEditPostStore(wpStore.select, wpStore.dispatch);
    const doRemovePanel = store.doRemovePanel;
    const doToggleFeature = store.doToggleFeature;
    const removeElement = fofo_bec_dom(jQuery).removeElement;

    return {
        {[function_list]}
    };
};
    ';

    /**
     * The list of JS functions added to as commands are run.
     * 
     * @var string  $function_list
     * 
     * @since 1.1.0
     */
    private $function_list;

    /**
     * The function list delimeter
     * 
     * @var string  $list_delim
     */
    private $list_delim = '';

    /**
     * Registry of functions which can be called to customise the block editor
     * 
     * @var array {
     *      @type   string  $key
     *      @type   string  js function
     * } 
     * 
     * @since 1.1.0
     */
    private $function_registery;

    /**
     * The BEC theme containing the settings to apply
     * 
     * @param   FoFoBec\FoFo_Bec_Theme  $theme  The theme values to set
     * @since 1.1.0
     */
    private $bec_theme;

    /**
     * The data access layer. Used to abstract out options API
     * 
     * @var FoFoBec\FoFo_Bec_Dal  $dal
     * 
     * @since 1.2.0
     */
    private $dal;

    /**
     * Constructor - initialisation
     * 
     * @param   FoFoBec\FoFo_Bec_Theme  $theme  The theme values to set
     * 
     * @return void
     * @since 1.1.0
     */
    public function __construct( $bec_theme, $dal ) {

        $this->create_registry();

        $this->bec_theme = $bec_theme;
        $this->dal = $dal;
    }

    /**
     * Create the regisry of js functions
     * 
     * @return void
     * @since 1.1.0
     */
    private function create_registry() {

        $this->function_registery = [];
        $this->function_registery[ 'default' ] = "default : function() {}";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY."' : () => doRemovePanel( 'taxonomy-panel-category' )";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_TAG ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_TAG."' : () => doRemovePanel( 'taxonomy-panel-post_tag' )";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE."' : () => doRemovePanel( 'featured-image' )";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT."' : () => doRemovePanel( 'post-excerpt' )";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION."' : () => doRemovePanel( 'discussion-panel' )";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK."' : () => doRemovePanel( 'post-link' )";
        $this->function_registery[ FOFO_BEC_FEATURE_TOP_TOOLBAR ] = "'".FOFO_BEC_FEATURE_TOP_TOOLBAR."' : () => doToggleFeature( 'fixedToolbar', '[{state}]' )";
        $this->function_registery[ FOFO_BEC_FEATURE_SPOTLIGHT_MODE ] = "'".FOFO_BEC_FEATURE_SPOTLIGHT_MODE."' : () => doToggleFeature( 'focusMode', '[{state}]' )";
        $this->function_registery[ FOFO_BEC_FEATURE_FULLSCREEN ] = "'".FOFO_BEC_FEATURE_FULLSCREEN."' : () => doToggleFeature( 'fullscreenMode', '[{state}]' )";
        $this->function_registery[ FOFO_BEC_FEATURE_MORE_OPTIONS_MENU ] = "'".FOFO_BEC_FEATURE_MORE_OPTIONS_MENU."' : () => removeElement( '.edit-post-more-menu' )";
    }

    /**
     * Update the JS template with the vales in the contained theme
     * 
     * @return void
     * @since 1.1.0
     */
    public function apply_changes() {

        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->category_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY ] ); }
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->tag_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_TAG ] ); }
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->featured_image_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE ] ); }
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->excerpt_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT ] ); }
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->discussion_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION ] ); }
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->permalink_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK ] ); }

        $this->add_js_function( str_replace( '[{state}]', strtolower( $this->bec_theme->top_toolbar ), $this->function_registery[ FOFO_BEC_FEATURE_TOP_TOOLBAR ] ) );
        $this->add_js_function( str_replace( '[{state}]', strtolower( $this->bec_theme->spotlight_mode ), $this->function_registery[ FOFO_BEC_FEATURE_SPOTLIGHT_MODE ] ) );
        $this->add_js_function( str_replace( '[{state}]', strtolower( $this->bec_theme->fullscreen ), $this->function_registery[ FOFO_BEC_FEATURE_FULLSCREEN ] ) );
        
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->edit_post_more_menu ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_MORE_OPTIONS_MENU ] ); }    }

    /**
     * Commit the changes after applying the changes from a theme
     * 
     * After a set of values from the contained theme have been applied the commit
     * command saves any javascript related changes to the database, and runs any
     * commands which call block functions in core.
     * 
     * @return  void
     * @since 1.1.0
     */
    public function commit_changes() {

        $js = str_replace( '{[function_list]}', $this->function_list, $this->js_template );
        $this->dal->set_generated_js( $js );
    }

    /**
     * Get the javascript generated.
     * 
     * Gets the javascript generated after any BEC commands have been run
     * which cause the javascript to be modified.
     * 
     * @return  string  The javascript
     * @since   1.1.0
     */
    public function get_javascript() {

        $js = $this->dal->get_generated_js();
        if( '' === $js ) {
            $js = str_replace( '{[function_list]}', $this->function_registery[ 'default' ], $this->js_template );
        }

        return $js;
    }

    /**
     * Add a js function to the function list
     * 
     * @param   $text   The text string of the js function to add
     * 
     * @return  void
     * @since   1.1.0
     */
    private function add_js_function( $text ) {

        $this->function_list .= $this->list_delim.$text;

        if( '' === $this->list_delim ) {
            $this->list_delim = ','.PHP_EOL;
        }
    }
}