var ulIDforSuggest = 'suggest-station-list';
var divIDSuggest   = 'div#quick_autocomplete';
var inputIDSuggest = 'input#quicksearch';
var selectStation  = 'select#stationenListe';

var fakeSelectStation     = "#stationenListe-button";
var fakeSelectStationText = fakeSelectStation + " > .ui-selectmenu-text";

$j(document).ready(function(){
	if ( $j(divIDSuggest).length ) {
		fillSuggestList();
		resetStatusForSuggest();
	}
	
	$j(selectStation).selectmenu({
		'change': function() {
			changeInputTextFromSelect();
		}
	});
	
	// Mindest-Zeichen-Länge aus dem Element holen und setzen
	var minChar = parseInt( $j('#quicksearch').attr('data-minchar') );
	
	// Prüfen, ob das eine Zahl ist
	if (minChar <= 0) {
		minChar = 3;
	}

	$j(inputIDSuggest).on('keyup', function(event){
		resetStatusForSuggest();
		var suchText   = $j(inputIDSuggest).val().toLowerCase();
		var anzTreffer = 0;

		if ( suchText.length >= minChar ) {
			$j('#' + ulIDforSuggest + ' li').each(function(index){
				if ( $j(this).attr('data-name').indexOf(suchText) != -1 ) {
					$j(this).toggle();
					anzTreffer++;
				}
			});
		}

		// Nur Anzeigen, wenn es min. 1 Treffer gibt und der Suchbegriff min. 1 Zeichen hat
        if ( anzTreffer > 0 && suchText.length > 0 ) {
        	// Sichtbarkeit nur umschalten, wenn noch ausgeblendet
        	if ( $j(divIDSuggest).css('display') == 'none' ) {
				$j(divIDSuggest).toggle();
			}
		}
	});
});

/**
 * aus der per RSS-Feet gefüllten Karte eine Statuion wählen und
 * diese in die Select-Box und das Suggest-Feld eintragen
 * 
 * @param    integer   ID der gewählten Station in der Karte
 */
function selectMapStation(id)
{
	setSelectBox(id);
	$j("#map").geomap().overlayClose();
}

/**
 * Wenn eine Station in der Karte ausgewählt/angeklickt wird, so müssen
 * die betroffenen Elemente die aktuelle Auswahl des Benutzers zugewiesen bekommen.
 * Danach muss die Sichtbarkeit der Suggest-Box zurückgesetzt werden.
 * 
 * @param    element   Eintrag, welcher ausgewählt wurde
 */
function selectSuggestStation(id){
	setSelectBox(id);
	$j(selectStation).selectmenu("refresh");
	resetStatusForSuggest();
	$j(divIDSuggest).toggle();
}

/**
 * Die Auswahl in der SelectBox auf den vom Benutzer gewählten Wert ändern.
 * 
 * @param    integer    ID der ausgewählten Station
 */
function setSelectBox(selectID)
{
	el = $j(selectStation + ' > option[value="'+ selectID +'"]');
	el.attr('selected', 'selected');
	text = el.text();
	if (text != '') {
		$j(inputIDSuggest).val(text);
		// fake the select of the fake select box
		$j(fakeSelectStation).attr('aria-labelledby', el.index() + 2); 
		$j(fakeSelectStationText).text(text);
	}
}

/**
 * Den Inhalt des Suggest-Feldes auf die Auswahl der Select-Box setzen
 */
function changeInputTextFromSelect()
{
	if ( $j(selectStation).val() == '' ) {
		$j(inputIDSuggest).val('');
	}
	else {
		if ( $j(inputIDSuggest).length ) {
			$j(inputIDSuggest).val( $j(selectStation + " option:selected").text() );
		}
	}
}

/**
 * Aus den Optionen vorhandenen Stations-Select-Box eine UL-Liste erzeugen
 * und diese in die Suggest-Box einfügen
 */
function fillSuggestList()
{
	// UL erzeugen
	$j(divIDSuggest).append('<ul id="' + ulIDforSuggest + '"></ul>');
	
	var suggestList = $j('#' + ulIDforSuggest);

	// Alle Stationen in die UL eintragen
	$j(selectStation + ' option').map(function(){
        var StationsID = parseInt( $j(this).val() );
        var StationsName = $j(this).text();
        
		if ( StationsID > 0 ) {
			var listItem = $j('<li />')
                           .attr('id', StationsID)
                           .attr('title', StationsName)
                           .attr('data-name', StationsName.toLowerCase())
                           .attr('onclick', 'selectSuggestStation(' + StationsID + ');')
                           .text(StationsName)
                           .appendTo(suggestList);
		}
	});
}

/**
 * Des Sichtbarkeits-Status aller Stationen zurücksetzen
 */
function resetStatusForSuggest()
{
	$j('#' + ulIDforSuggest + ' li').css('display', 'none');
}
