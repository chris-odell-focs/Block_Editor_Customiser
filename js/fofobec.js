
//todo-look into using compose
const fofobecCoreEditPostStore = function(select, dispatch) {

    const getStoreFunction = function(resolver) {

        if(resolver !== undefined) {

            const storeFunction = resolver( "core/edit-post" );
            if( storeFunction !== undefined ) {
                return storeFunction;
            }
        }

        return null;
    };

    const ceDispatch = getStoreFunction(dispatch);
    const ceSelect = getStoreFunction(select);

    const wpRemoveEditorPanel = function( panelName ) {

        if( null !== ceDispatch && undefined !== ceDispatch ) {
            const { removeEditorPanel } = ceDispatch;
            if(removeEditorPanel) { 
                removeEditorPanel( panelName ); 
            }           
        }
    };

    const wpToggleFeature = function(featureName, state) {
        
        if( null !== ceSelect && null !== ceDispatch ) {
            
            const { isFeatureActive } = ceSelect; 
            if( isFeatureActive ) {
            
                const { toggleFeature } = ceDispatch;
                if( toggleFeature ) {

                    if( isFeatureActive( featureName ) && state.toLowerCase() === 'off' ) {
                        toggleFeature( featureName );
                    };

                    if( !isFeatureActive( featureName ) && state.toLowerCase() === 'on' ) {
                        toggleFeature( featureName );
                    };
                }
            }
        }
    };

    return {
        doRemovePanel: ( panelName ) => wpRemoveEditorPanel( panelName ),
        doToggleFeature: ( featureName, state ) => wpToggleFeature( featureName, state )
    };
};

const fofo_bec_dom = function($) {

    const doRemove = function(selector) {

        setTimeout(function() {

            $(selector).remove();

            if($('.block-editor').length === 0) {
                doRemove();
            }

        }, 100);
    };

    return {
        removeElement: function(selector) {
            $(document).ready(function(){ doRemove( selector ); });
        }
    }
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

        let dispatcher = fofobec_function_dispatcher(wp.data);
        for(key in dispatcher) {
            dispatcher[ key ]();
        }
    }
};

/**
 * Call the run dispatcher to execute
 * the javascript to modify the block editor
 * 
 * @return void
 * @since 1.1.0
 */
fofobec_run_dispatcher(window.wp);