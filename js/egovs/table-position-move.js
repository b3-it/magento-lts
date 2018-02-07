$j(document).ready(function(){
    $j('td.position-sorting button').on('click', function(){
        // alles aktivieren
        activateAllButtons();

        // Tabell-Zeile
        var row = $j(this).parents("tr:first");

        if ( $j(this).is('.position-up') ) {
            row.insertBefore( row.prev() );
        }
        else if ( $j(this).is('.position-down') ) {
            row.insertAfter( row.next() );
        }
        else if ( $j(this).is('.position-delete') ) {
            // eventuell die gelöschten IDs merken
            row.remove();
        }

        // Positionen neu setzen
        setNewPositions();

        // Unbenutzbare Buttons setzen
        deactivateUnlogicalButtons();
    });

    // Unbenutzbare Buttons setzen
    deactivateUnlogicalButtons();
});

/**
 * bei allen Buttons das Attribut "deaktiviert" entfernen
 */
function activateAllButtons()
{
    $j('table.data tbody button').removeAttr('disabled');
}

/**
 * in der ersten Zeile den Button "up" deaktivieren
 * in der letzten Zeile den Button "down" deaktivieren
 */
function deactivateUnlogicalButtons()
{
    $j('table.data tbody tr:first-child button.position-up').attr('disabled', 'disabled');
    $j('table.data tbody tr:last-child button.position-down').attr('disabled', 'disabled');
}

/**
 * Alle Positionen der Zeilen neu setzen
 */
function setNewPositions()
{
    $j('table.data tbody input.position').each(function(index){
        $j(this).val(index + 1);
    });
}
