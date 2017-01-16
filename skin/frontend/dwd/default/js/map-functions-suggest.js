$j(document).ready(function(){
	alert(stationen.length);
	
	var suggest = $j('input#quicksearch');
	
	suggest.on('keyup', function(event){
		resetStatusForSuggest();
		var suchText = suggest.val();
	});
});

function resetStatusForSuggest()
{
	$j('#quick_autocomplete ul li').css('display', 'none');
}



var Station = Class.create();
Station.prototype = {
  initialize: function(id, name) {
    this.id = id;
    this.name = name;
  }
};

if (!window.Quick)
{
    var Quick = new Object();
}

Quick.searchForm = Class.create();
Quick.searchForm.prototype = {
    initialize : function(field, emptyText){

        this.field  = $(field);
        this.emptyText = emptyText;


        Event.observe(this.field, 'focus', this.focus.bind(this));
        Event.observe(this.field, 'blur', this.blur.bind(this));
        Event.observe(this.field, 'keyup', this.onkeyup.bind(this));
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
        if(this.field.value==''){
            this.field.value=this.emptyText;
        }
    },

    onkeyup : function(event){

    	if($('quick_autocomplete') != null)
    	{
    		 $('quick_autocomplete').hide();
    	}

        if(this.field.value==''){
            this.field.value=this.emptyText;
            //selectStationSuggest(0);

        }else
        {

            var n = 0;
            var found = new Array();
            for(i=0; i < stationen.length; i++)
            {
                var such = this.field.value.toLowerCase();
                if(stationen[i].name.toLowerCase().match(such))
                {
                	found[n]=stationen[i];
                	n++;
                }
            }

            if(found.length == 1)
            {
            	this.field.value=found[0].name;
            	//selectStationSuggest(found[0].id);

            }
            else if (found.length > 1)
            {
            	var content ="<ul>";
            	for(i=0; i < found.length; i++)
            	{
            		content += '<li id=\"'+found[i].id+'\" title=\"'+found[i].name+'\" onclick="_selectAutocompleteItem($j(this));">'+found[i].name+'</li>';
            	}
            	content += "</ul>";
                $('quick_autocomplete').update(content);
                $('quick_autocomplete').show();
            }
        }
    }
}

function _selectAutocompleteItem(element){
    var selectID = element.attr('id');

    $j('select#stationenListe > option[value="'+ selectID +'"]').attr('selected', 'selected');    
    $j('select#stationenListe').selectmenu("refresh");
	
	$j('#suggest #quicksearch').val( element.attr('title') );
	$j('#suggest #quick_autocomplete').toggle();
}