$j(document).ready(function(){
    $j('#context-help').css('display', 'inline-block');
});

/**
 * Popup für eine Anzeige vorbereiten
 */
function resetPopup()
{
    $j(popupBodyId).html('');
    hidePopup();
}

/**
 * Popup ausblenden
 */
function hidePopup()
{
    $j('#context-help-popup').css({
        'z-index': hideLevel,
        'left'   : '-100000px'
    });
}

/**
 * Popup anzeigen
 */
function viewPopup()
{
    $j('#context-help-popup').css({
        'z-index': showLevel,
        'left'   : '20%'
    });
}

/**
 * Scrollbar innerhalb des sichtbaren Popup neu zeichnen
 */
function updatePopupScrollBar()
{
    // Funktion in js/egovs/jquery.nicescroll.init.js
    updateScrollbar(popupBodyId);

    // Resize-Event der Content-Box
    $j(popupBodyId).resize(function(){
        $j(popupBodyId).getNiceScroll().resize();
    });
}
