function selectStation(id)
{
	var $el = $j('select#stationenListe > option[value="'+ id +'"]');
    $j($el).attr('selected','selected');

    $j( "select#stationenListe" ).selectmenu( "refresh" );
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