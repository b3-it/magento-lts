if (!window.Quick)
    var Quick = new Object();

Quick.searchForm = Class.create();
Quick.searchForm.prototype = {
    initialize : function(form, field, emptyText){
        this.form   = $(form);
        this.field  = $(field);
        this.emptyText = emptyText;

        Event.observe(this.form,  'submit', this.submit.bind(this));
        Event.observe(this.field, 'focus' , this.focus.bind(this));
        Event.observe(this.field, 'blur'  , this.blur.bind(this));
        Event.observe(this.field, 'keyup' , this.onkeyup.bind(this));
        this.blur();
    },

    submit : function(event){
        if (this.field.value == this.emptyText || this.field.value == ''){
            Event.stop(event);
            return false;
        }
        return true;
    },

    focus : function(event){
        if(this.field.value==this.emptyText){
            this.field.value='';
        }

    },

    blur : function(event){
        if(this.field.value=='') {
            this.field.value=this.emptyText;
        }
    },

    onkeyup : function(event) {
    	if($('quick_autocomplete') != null) {
    		//$('quick_autocomplete').descendants().remove();
            $('quick_autocomplete').hide();
    	}

        if(this.field.value=='') {
            this.field.value=this.emptyText;
            $('_quicksuggest_id').value = 0;
        }
        else {
            var n = 0;
            var found = new Array();
            for(i=0; i < products.length; i++) {
                if((products[i].sku.toLowerCase().indexOf(this.field.value.toLowerCase())==0) || (products[i].name.toLowerCase().match(this.field.value.toLowerCase())))
                {
                	found[n] = products[i];
                	n++; 
                }
            }

            if(found.length == 1) {
            	this.field.value = found[0].name;
                $('_quicksuggest_id').value = found[0].id;
            }
            else if (found.length > 1) {
            	//Element.replace('quick_autocomplete', '<p>Bar</p>')
            	var content ="<ul id=\"slpb-suggest\">";
            	for(i=0; i < found.length; i++)
            	{
                	if(i%2==0) classname = 'even';
                	else classname = 'odd';
            		content = content + '<li id=\"'+found[i].id+'\" class=\"'+classname+'\" title=\"'+found[i].name+'\" onclick=\"_selectAutocompleteItem(this);\">' +
            		                    '<div class=\"sku\">'+found[i].sku+'</div>'+found[i].name+'</li>';
            	}
            	content += "</ul>";
                $('quick_autocomplete').update(content);
                $('quick_autocomplete').show();
            }
        }
    }
}

function _selectAutocompleteItem(element) {
  	$('_quicksuggest_id').value = 0;
   	$('quick_autocomplete').hide();
    if(element.title){
       	$('quicksearch').value = element.title;
        $('_quicksuggest_id').value = element.id;
    }
    $('quicksearch').focus();
    //this.form.submit();
}

function addCart() {
	$j('#loading').toggle();
	new Ajax.Updater('quick.card',addCartUrl,{parameters:{id: $('_quicksuggest_id').value}});
	$('quicksearch').value = '';
	
	// 2 Sekunden warten
	setTimeout(function(){
		// Sterne im Warenkorb ausrechnen
		calcStars();
	}, 2000);
	
	
	return false;
}