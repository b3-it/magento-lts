$j(document).ready(function(){
	$j('#stationenListe').selectmenu({
		'change': function() {
			$j('#suggest #quicksearch').val( $j("select#stationenListe option:selected").text() );
		}
	});
});

/**
 * aus der per RSS-Feet gefüllten Karte eine Statuion wählen und
 * diese in die Select-Box und das Suggest-Feld eintragen
 * 
 * @param    integer   ID der gewählten Station in der Karte
 */
function selectStation(id)
{
	var $el = $j('select#stationenListe > option[value="'+ id +'"]');
    $j($el).attr('selected','selected');

    $j( "select#stationenListe" ).selectmenu( "refresh" );
    $j('#suggest #quicksearch').val( $j("select#stationenListe option:selected").text() );
}
