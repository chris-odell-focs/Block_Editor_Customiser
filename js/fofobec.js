
/**
 * Abstract the Block editor functions to call
 * 
 * This abstracts the block editor functions to call to enable/disable features
 * using a strategy pattern approach. aka higgher order component.
 * 
 * @return  array {
 *      @type   string      $key        The feature to turn on/off
 *      @type   function    $function   The function which calls the Block editor API to disable a Block edditor element
 * }
 * @since   1.0.0
 */
const fofobec_function_disabler = (dispatch)  => {
    return {

        'category_panel' : function() { dispatch( 'core/edit-post' ).removeEditorPanel( 'taxonomy-panel-category' ); },
        'tag_panel' : function() { dispatch( 'core/edit-post' ).removeEditorPanel( 'taxonomy-panel-post_tag' ); },
        'featured_image_panel' : function() { dispatch( 'core/edit-post' ).removeEditorPanel( 'featured-image' ); },
        'excerpt_panel' : function() { dispatch( 'core/edit-post' ).removeEditorPanel( 'post-excerpt' ); },
        'discussion_panel' : function() { dispatch( 'core/edit-post' ).removeEditorPanel( 'discussion-panel' ); },
        'permalink_panel' : function() { dispatch( 'core/edit-post' ).removeEditorPanel( 'post-link' ); }
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
(function (wp) {

    if(wp.data !== null && wp.data !== undefined) {

        let disabler = fofobec_function_disabler(wp.data.dispatch);

        fofobec.forEach(element => {
            disabler[ element ]();
        });

    }
})(window.wp);