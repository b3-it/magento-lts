var ulIDforSuggest = 'suggest-station-list';

$j(document).ready(function(){
	fillSuggestList();
	resetStatusForSuggest();
	
	$j('input#quicksearch').on('keyup', function(event){
		resetStatusForSuggest();
		var suchText = $j('input#quicksearch').val().toLowerCase();
		var anzTreffer = 0;

		$j('#' + ulIDforSuggest + ' li').each(function(index){
			if ( $j(this).attr('data-name').indexOf(suchText) != -1 ) {
				$j(this).toggle();
				anzTreffer++;
			}
		});

		// Nur Anzeigen, wenn es min. 1 Treffer gibt und der Suchbegriff min. 1 Zeichen hat
        if ( anzTreffer > 0 && suchText.length > 0 ) {
        	// Sichtbarkeit nur umschalten, wenn noch ausgeblendet
        	if ( $j('#quick_autocomplete').css('display') == 'none' ) {
				$j('#quick_autocomplete').toggle();
			}
		}
	});
});

/**
 * Aus dem vorhandenen Stations-Array eine UL-Liste erzeugen und diese in die Suggest-Box einfügen
 */
function fillSuggestList()
{
	// UL erzeugen
	$j('#quick_autocomplete').append('<ul id="' + ulIDforSuggest + '"></ul>');
	
	var suggestList = $j('#' + ulIDforSuggest);

	// Alle Stationen in die UL eintragen
	$j.each(stationen, function(id, station){
		var listItem = $j('<li />')
		               .attr('id', station['id'])
		               .attr('title', station['name'])
		               .attr('data-name', station['name'].toLowerCase())
		               .attr('onclick', 'selectSuggestStation($j(this));')
		               .text(station['name'])
		               .appendTo(suggestList);
	});
}

/**
 * Des Sichtbarkeits-Status aller Stationen zurücksetzen
 */
function resetStatusForSuggest()
{
	$j('#' + ulIDforSuggest + ' li').css('display', 'none');
}

/**
 * Wenn eine Station ausgewählt/angeklickt wird, so müssen die betroffenen Elemente
 * den aktuellen wert zugewiesen bekommen.
 * Danach muss die Sichtbarkeit der Suggest-Box zurückgesetzt werden
 */
function selectSuggestStation(element){
    $j('select#stationenListe > option[value="'+ element.attr('id') +'"]').attr('selected', 'selected');    
    $j('select#stationenListe').selectmenu("refresh");
	
	$j('#suggest #quicksearch').val( element.attr('title') );
	
	resetStatusForSuggest();
	$j('#suggest #quick_autocomplete').toggle();
}