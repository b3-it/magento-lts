var tableID;                   // Wird dynamisch bei jeder Aktion neu ermittelt
var tabelPrefix = 'table-';    // Prefix der Tabell-ID
var highlightClass = 'move-row-highlight'; // CSS-Klasse zum hervorheben des bewegten Elementes

$j(document).ready(function(){
    // Button-Clock im System anmelden
    registerClickEvent();

    // alle Data-Tables suchen
    $j('table.data').each(function(){
        var tmpID = $j(this).attr('id');

        if ( tmpID.indexOf(tabelPrefix) !== -1 ) {
            // Unbenutzbare Buttons setzen
            deactivateUnlogicalButtons(tmpID);
        }
    });
});

/**
 * Benutzer klickt auf einen beliebigen Button
 */
function registerClickEvent()
{
    $j('table.data td.position-sorting button').on('click', function(){
        // Tabell-Zeile
        var row = $j(this).parents("tr:first");

        // Tabell-ID setzen
        tableID = row.attr('data-table');

        // alles aktivieren
        activateAllButtons();
        
        // alle HighLights entfernen
        $j('#' + tabelPrefix + tableID + ' tbody tr').removeClass(highlightClass);

        if ( $j(this).is('.position-up') ) {
            row.insertBefore( row.prev() );

            // Positionen neu setzen
            setNewPositions();
            
            // Hervorhebung der aktuellen Zeile
            row.addClass(highlightClass);
        }
        else if ( $j(this).is('.position-down') ) {
            row.insertAfter( row.next() );

            // Positionen neu setzen
            setNewPositions();
            
            // Hervorhebung der aktuellen Zeile
            row.addClass(highlightClass);
        }
        else if ( $j(this).is('.position-delete') ) {
            row.css('display', 'none');
            $j('input#delete-' + row.attr('data-table') + '-' + row.attr('data-id')).attr('value', 1);
        }

        // Unbenutzbare Buttons setzen
        deactivateUnlogicalButtons('');
    });
}

/**
 * eine neue Zeile an eine vorhandene Tabelle anhängen
 */
function addTableRow(element)
{
    var type          = 'hidden';       // als was sollen die Inputfelder hinzugefügt werden
    var foundItems    = new Array();    // Hilfsvariable für Auswahl
    var noItemSelect  = '0';            // Welcher Wert bei SelectBoxen soll nicht benutzt werden
    var itemSeparator = ': ';           // Text-Verbinder für die Darstellung der Auswahl
    var lastIdValue   = '';             // ID der letzten vorhandenen Select-Box

    $j( element.parents('div.entry-edit').first().find('select') ).each(function(){
        if ( $j(this).val() != noItemSelect ) {
            foundItems.push( $j(this).find('option:selected').text() );
            lastIdValue = $j(this).val();
        }
    });

    if ( foundItems.length == 0 ) {
        alert( messageNoItemSelected );
        return;
    }

    var destTable    = element.parents('table').next('table').attr('id');
    var firstIdValue = element.parents('div.entry-edit').first().find('option:selected').val();

    var newItem = foundItems.join(itemSeparator);
    var newId   = lastIdValue;
    var table   = destTable.replace(tabelPrefix, '');
    var nextID  = parseInt( $j('#' + destTable + ' tbody tr:last').index() ) + 1;

    var cellName = $j('<td />', {
        'text': newItem
    });

    var inputValue = $j('<input />', {
        'id'   : 'value-' + table + '-' + nextID,
        'name' : table + '[value][]',
        'value': newId,
        'type' : type
    });
    var inputPosition = $j('<input />', {
        'id'   : 'pos-' + table + '-' + nextID,
        'name' : table + '[pos][]',
        'value': nextID,
        'type' : type
    });
    var inputDelete = $j('<input />', {
        'id'   : 'delete-' + table + '-' + nextID,
        'name' : table + '[delete][]',
        'value': 0,
        'type' : type
    });
    cellName.append(inputValue).append(inputPosition).append(inputDelete);

    if ( $j('#' + destTable + ' tbody').attr('data-up-down') == 0 ) {
        var tplButtons = templateUpDownButtons + templateDelButton;
    }
    else {
        var tplButtons = templateDelButton;
    }

    var cellFunction = $j('<td />', {
        'class': 'position-sorting',
        //'html' : $j('#' + destTable + ' tbody tr:first td:last').html()
        'html' : tplButtons
    });

    var newRow = $j('<tr />', {
        'id'        : 'row-' + table + '-' + nextID,
        'data-id'   : nextID,
        'data-table': table
    });
    newRow.append(cellName).append(cellFunction);

    $j('#' + destTable + ' tbody').append(newRow);

    tableID = table;
    activateAllButtons();
    registerClickEvent();
    setNewPositions();
    deactivateUnlogicalButtons(destTable);
}

/**
 * bei allen Buttons das Attribut "deaktiviert" entfernen
 */
function activateAllButtons()
{
    $j('#' + tabelPrefix + tableID + ' tbody button').removeAttr('disabled');
}

/**
 * in der ersten Zeile den Button "up" deaktivieren
 * in der letzten Zeile den Button "down" deaktivieren
 */
function deactivateUnlogicalButtons(destTable)
{
    if ( destTable.indexOf(tabelPrefix) !== -1 ) {
        var thisTable = destTable;
    }
    else {
        var thisTable = tabelPrefix + tableID;
    }

    var firstVisibleRow = '';
    var lastVisibleRow  = '';

    var anzahlZeilenSichtbar = 0;
    $j('#' + thisTable + ' tbody tr').each(function(){
        if( $j(this).css('display') != 'none' ) {
            anzahlZeilenSichtbar ++;

            if ( firstVisibleRow.length ) {
                // erste sichtbare Zeile ist gesetzt => muss also die letzte sein
                lastVisibleRow  = $j(this).attr('id');
            }

            if ( firstVisibleRow == '' ) {
                // erste sichtbare Zeile setzen
                firstVisibleRow = $j(this).attr('id');
            }
        }
    });

    if ( (anzahlZeilenSichtbar == 1) && firstVisibleRow.length ) {
        // nur eine Zeile
        $j('#' + firstVisibleRow + ' button.position-up').attr('disabled', 'disabled');
        $j('#' + firstVisibleRow + ' button.position-down').attr('disabled', 'disabled');
    }
    else {
        if ( firstVisibleRow.length && lastVisibleRow.length ) {
            $j('#' + firstVisibleRow + ' button.position-up').attr('disabled', 'disabled');
            $j('#' + lastVisibleRow  + ' button.position-down').attr('disabled', 'disabled');
        }
    }
}

/**
 * Alle Positionen der Zeilen neu setzen
 */
function setNewPositions()
{
    $j('#' + tabelPrefix + tableID + ' tbody input.position').each(function(index){
        $j(this).val(index + 1);
    });
}
