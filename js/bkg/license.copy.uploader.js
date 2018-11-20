LicenseCopy = function(elementId) {
       
        this.elementId = elementId;
        var instance = this;
       
       // this.defaults = $j.extend({}, element, options);

       

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
        	var row = $j('#row-'+this.elementId+'-'+id);
        	$j('#file-deleted-'+id).val(1);
        	row.hide();
        }
        
      
        
        this.processTemplate = function(template,data)
        {
        	$j.each(data, function(key,value){
        		template = template.replace(new RegExp("{{"+key+"}}", 'g'), value);
        	});
        	
        	return template;
        }
        
        this.appendRow = function(response) {
            response.elementId = this.elementId;
            var newTableRow = this.processTemplate(this.getTemplate(),response);
          
            $j('#table-'+this.elementId+'_grid').append(newTableRow);
        }

        this.getTemplate = function() {
            return $j("#"+this.elementId+"_template").html();
        }

        
    };

    
