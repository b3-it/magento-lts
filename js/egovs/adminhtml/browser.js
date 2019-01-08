Mediabrowser.prototype.insert = Mediabrowser.prototype.insert.wrap(function(insertOrg, event){
    var div;
    if (event != undefined) {
        div = Event.findElement(event, 'DIV');
    } else {
        $$('div.selected').each(function (e) {
            div = $(e.id);
        });
    }
    if ($(div.id) == undefined) {
        return false;
    }
    var targetEl = this.getTargetElement();
    if (! targetEl) {
        alert("Target element not found for content update");
        Windows.close('browser_window');
        return;
    }

    var params = {filename:div.id, node:this.currentNode.id, store:this.storeId};

    if (targetEl.tagName.toLowerCase() == 'textarea') {
        params.as_is = 1;
    }

    new Ajax.Request(this.onInsertUrl, {
        parameters: params,
        onSuccess: function(transport) {
            try {
                this.onAjaxSuccess(transport);
                if (this.getMediaBrowserOpener()) {
                    self.blur();
                }
                Windows.close('browser_window');
                if (targetEl.tagName.toLowerCase() == 'input') {
                    targetEl.value = transport.responseText;
                    $j(targetEl).trigger('change');
                    if (targetEl.value) {
                        window.open(targetEl.value, '_blank');
                    }
                } else {
                    updateElementAtCursor(targetEl, transport.responseText);
                    if (varienGlobalEvents) {
                        varienGlobalEvents.fireEvent('tinymceChange');
                    }
                }
            } catch (e) {
                alert(e.message);
            }
        }.bind(this)
    });
});