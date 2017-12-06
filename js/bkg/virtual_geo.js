$j(document).ready(function(){
    scanForActiveOptions();

    $j('#virtualgeo').accordion({
        'heightStyle': 'content',
        'autoHeight' : false,
        'icons'      : {
            'header'      : 'ui-icon-plus',
            'activeHeader': 'ui-icon-minus'
        },
        'activate': function(event, ui) {
            // wird aktiviert
        }
    });

    $j('#virtualgeo input[type="radio"]').on('click', function(event){
        setOptionForTitle( $j(this) );
    });
});

/**
 * Alle vorausgewählten Options-Felder suchen
 * Funktion wird ausgeführt, wenn die Seite komplett geladen wurde
 */
function scanForActiveOptions()
{
    $j('#virtualgeo input:checked').each(function(index, element){
        setOptionForTitle( $j(element) );
    });
}

/**
 * Titel des Accordions mit der gewählten Option ergänzen
 * @param   element   Sender, welcher ausgewählt wurde
 */
function setOptionForTitle(sender)
{
    if ( sender.attr('data-shortname').length ) {
        var _append = ' (' + sender.attr('data-shortname') + ')';
    }
    else {
        var _append = '';
    }

    $j('#title-' + sender.attr('data-id') ).html(
        strPrefixSelected + ' ' + sender.attr('data-name') + _append
    );
}
