function selectStation(id)
{
    $$('select#stationenListe option').each(function(o) {
        if(o.readAttribute('value') == id) {
	        o.selected = true;
	        if($('quicksearch')) {$('quicksearch').value = '';}
	            throw $break;
	        }
	});
}

function selectStationSuggest(id)
{
    $$('select#stationenListe option').each(function(o) {
        if(o.readAttribute('value') == id) {
	        o.selected = true;
	    	throw $break;
	    }
   	});
}