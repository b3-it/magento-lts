LicenseCopy = function(element, options = {}) {
        var defaults = {
            containerId : '',
            template    : '',
            templateId  : '',
            newRowId    : '',
            curRowCount : 0
        };

        var instance = this;
       
        this.defaults = $j.extend({}, element, options);

       

        this.UploadComplete = function(files) {
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

                instance.appendRow(response);
            });
        }

        this.deleteRow = function(id)
        {
        	var row = $j('#row-'+this.defaults.containerId+'-'+id);
        	$j('#file-deleted-'+id).val(1);
        	row.hide();
        }
        
        this.replaceAll = function (str, find, replace) {
            return str.replace(new RegExp(find, 'g'), replace);
        }
        
        this.appendRow = function(response) {
            if ( !this.defaults.template ) {
                this.getTemplate();
            }

            var newTableCells = this.defaults.template;
            newTableCells = newTableCells.replace("__filename__" , response.filename)
                                         .replace("__created__"  , response.created)
                                         .replace("__download__" , response.download);
            newTableCells = this.replaceAll(newTableCells,"__id__", response.db_id)
            var newTableRow = $j('<tr />', {
                'id'        : 'row-' + this.defaults.newRowId + '-' + response.db_id,
                'data-id'   : this.defaults.curRowCount,
                'data-table': this.defaults.newRowId
            });
            newTableRow.append(newTableCells);
          
            $j('#table-'+this.defaults.containerId+'_grid').append(newTableRow);
        }

        this.getTemplate = function() {
            this.defaults.template = $j(this.defaults.templateId).html();
        }

        
    };

    
