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
/**
 * Get the removeEditorPanel if it is available
 * 
 * @return  function/null   The removeEdditorPanel function from dispatch or null if not available
 * @since 1.1.0
 */
const fofobec_get_removeEditorPanel = (dispatch) => {  

    if( undefined !== dispatch( "core/edit-post" ) ) {
        const { removeEditorPanel } = dispatch( "core/edit-post" );
        return removeEditorPanel;
    }

    return null; 
};

/**
 * Abstract the Block editor functions to call
 * 
 * This abstracts the block editor functions to call to enable/disable features
 * using a strategy pattern approach. aka higher order component.
 * 
 * @return  array {
 *      @type   string      $key        The feature to turn on/off
 *      @type   function    $function   The function which calls the Block editor API to disable a Block edditor element
 * }
 * @since   1.0.0
 */
const fofobec_function_dispatcher = (dispatch)  => {

    const removeEditorPanel = fofobec_get_removeEditorPanel(dispatch);

    return {
        {[function_list]}
    };
};

/**
 * IIFE to loop through the list of disable features
 * 
 * This function is passed the global wp javascript variable
 * to have access to the Block editor functions and then loops
 * through the disabled features expressed in the fofogutentog
 * variable defined as part of the script localisastion.
 * 
 * @param   object  wp  Gloabl WordPress object
 * @since   1.0.0
 */
const fofobec_run_dispatcher = function (wp) {

    if(wp.data !== null && wp.data !== undefined) {

        let dispatcher = fofobec_function_dispatcher(wp.data.dispatch);
        for(key in dispatcher) {
            dispatcher[ key ]();
        }
    }
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
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_CATEGORY."' : function() { if( removeEditorPanel ) { removeEditorPanel( 'taxonomy-panel-category' ); } }";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_TAG ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_TAG."' : function() { if( removeEditorPanel ) { removeEditorPanel( 'taxonomy-panel-post_tag' ); } }";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_FEATURED_IMAGE."' : function() { if( removeEditorPanel ) { removeEditorPanel( 'featured-image' ); } }";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_EXCERPT."' : function() { if( removeEditorPanel ) { removeEditorPanel( 'post-excerpt' ); } }";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_DISCUSSION."' : function() { if( removeEditorPanel ) { removeEditorPanel( 'discussion-panel' ); } }";
        $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_PEMALINK ] = "'".FOFO_BEC_FEATURE_DOC_PANEL_PEMALINK."' : function() { if( removeEditorPanel ) { removeEditorPanel( 'post-link' ); } }";
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
        if( FOFO_BEC_PANEL_OFF === $this->bec_theme->permalink_panel ) { $this->add_js_function( $this->function_registery[ FOFO_BEC_FEATURE_DOC_PANEL_PEMALINK ] ); }
    }

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