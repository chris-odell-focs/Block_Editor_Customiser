(function($){

    /**
     * Set up the UI context with the abastract jQuery selectors
     * 
     * @since   1.0.0
     */
    let uictx = {
        disabledCoreBlocksTableBody: { selector : '#disable-core-blocks-list tbody' },
        disabledCoreBlocksTable: { selector : '#disable-core-blocks-list' },
        selectedItemsArea : { selector : '#fofo-bec-dcb-selected-items' },
        disabledCheckBox: { selector : '.fofo-bec-dcb-disabled' },
        showwDisabledOnlyCB : { selector: '#fofo-bec-dcb-show-disabled' }
    };

    try{
        //this will error but will still initialize
        //the editor so that getBlockTypes will work
        wp.editPost.initializeEditor();
    } catch(exception) {
        //swallow it
    }

    /**
     * Resolve store functions before trying to use them
     * @param   resolver    an instance of wp.data.select
     * 
     * @return  store function or nuull if doesn't exist
     * @since   1.0.0 
     */
    const getStoreFunction = function(resolver) {

        if(resolver !== undefined) {

            const storeFunction = resolver( "core/blocks" );
            if( storeFunction !== undefined ) {
                return storeFunction;
            }
        }

        return null;
    };

    let sf = getStoreFunction(wp.data.select);
    let blockTypes = sf.getBlockTypes();

    /**
     * Pass in the data and build the data table, refreshing the
     * attaching of any events.
     * 
     * @param   boolean isNew   Flag indicating if this is he first refresh
     * @param   object  data    The data used to build the table
     * 
     * @return  void
     * @since   1.0.0
     */
    const refreshTable = function(isNew, data) {

        $(uictx.disabledCoreBlocksTableBody.selector).empty();
        $(uictx.selectedItemsArea.selector).empty();
        let table = $(uictx.disabledCoreBlocksTable.selector).DataTable();
        table.clear();

        data.forEach(blockType => {

            let cbElement = '<span>' +
                '<input type="checkbox" data-block-name="' + blockType.name + '" class="fofo-bec-dcb-disabled" ' + (blockType.disabled ? 'checked' : '') + ' value="disabled"/>' +
                '</span>';
            
            let cbElementName = 'fofobecdcb[' + blockType.name + ']';
            $(uictx.selectedItemsArea.selector).append('<input type="hidden" name="' + cbElementName + '" value="' + (blockType.disabled ? 'disabled' : 'enabled' ) + '" />');

            table.row.add([
                cbElement,
                blockType.name,
                blockType.title,
                blockType.description
            ]);
        });

        table.on('draw', function () {

            $(uictx.disabledCheckBox.selector).click(function(e){

                let selectedBlockName = e.target.getAttribute('data-block-name');
                let selectedBlockTypes = blockTypes.filter((blockType) => blockType.name === selectedBlockName);
                if(selectedBlockTypes.length > 0) {
                    selectedBlockTypes[0].disabled = e.target.checked;
                }

                let cbElementName = 'fofobecdcb[' + selectedBlockName + ']';
                if(e.target.checked){
                    $(uictx.selectedItemsArea.selector + ' input[name="' + cbElementName + '"]').val('disabled');
                } else {
                    $(uictx.selectedItemsArea.selector + ' input[name="' + cbElementName + '"]').val('enabled');
                }

            });
        });

        table.draw();

        if(isNew) {
            
            $(uictx.disabledCoreBlocksTable.selector + '_filter').prepend('<span id="fofo-bec-dcb-show-disabled-wrap"><label>Show disabled only</label><input id="fofo-bec-dcb-show-disabled" type="checkbox" /></span>');    
        }
    }

    /**
     * Get the list of disable blocks and then build the datatable
     * using the list and the values from the getBlockTypes api call.
     * 
     * @since   1.0.0
     */
    $.post(fofobec_dcb_js.ajaxurl, { action: "fofo_bec_dcb_disabled_blocks" }).done(function(response){

        let disabledList = JSON.parse( response );
        blockTypes.forEach((blockType) => blockType.disabled = disabledList.includes(blockType.name) );
        refreshTable(true, blockTypes);
    
        $(uictx.showwDisabledOnlyCB.selector).click(function(e){
            let data = blockTypes;
            if(e.target.checked) {
                data = data.filter(item => item.disabled);
            }
    
            refreshTable(false, data);
        });

    }).fail(function(error){
        console.log(error);
    });

})(jQuery);