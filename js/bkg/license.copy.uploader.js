(function($j){
    $j.LicenseCopy = function(element, options) {
        var defaults = {
            containerId : '',
            template    : '',
            templateId  : '',
            newRowId    : ''
        };

        this.settings = {}
        this.settings = $j.extend({}, defaults, options);

        init = function() {
            defaults.containerId = element;
            defaults.templateId  = options.templateId;
            defaults.newRowId    = options.newRowId;

            document.on('uploader:fileSuccess', function(event) {
                var memo = event.memo;
                UploadComplete([{response: memo.response}]);
            });
        }

        UploadComplete = function(files) {
            $j.each(files, function(index, item){
                var response = $j.parseJSON(item.response);
                if ( !response ) {
                    try {
                        console.log(item, response);
                    }
                    catch(e) {
                        alert(response);
                    }
                }

                if (response.error) {
                    return;
                }

                if ( !defaults.template ) {
                    getTemplate();
                }

                var nextId = getNextId();

                var newTableCells = defaults.template;
                newTableCells = newTableCells.replace("__id__"       , nextId)
                                             .replace("__filename__" , response.filename)
                                             .replace("__created__"  , response.created)
                                             .replace("__download__" , response.download)
                                             .replace("__delete__"   , response.delete);

                var newTableRow = $j('<tr />', {
                    'id'        : 'row-' + defaults.newRowId + '-' + nextId,
                    'data-id'   : nextId,
                    'data-table': defaults.newRowId
                });
                newTableRow.append(newTableCells);
                $j(defaults.containerId).append(newTableRow);
            });
        }

        getTemplate = function() {
            defaults.template = $j(defaults.templateId).html();
        }

        getNextId = function() {
            var currId = 0;

            $j('#' + defaults.containerId.id + ' tr').each(function(){
                currId = parseInt( $j(this).attr('data-id') );
            });
            return currId + 1;
        }

        init();
    };

    $j.fn.LicenseCopy = function(options) {
        return this.each(function() {
            if (undefined == $j(this).data('LicenseCopy')) {
                var plugin = new $j.LicenseCopy(this, options);
                $j(this).data('LicenseCopy', plugin);
            }
        });
    }
})(jQuery);
