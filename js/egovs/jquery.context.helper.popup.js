var readyToShow = false;                               // Kann das Popup angezeigt werden (Inhalt?)
var elementId = "#context-help-popup";                 // Rumpf-Element
var popupBodyId = "#context-help-popup-body";          // ID des Scroll-Containers
var hideLevel = "-1";                                  // Level, bei welchem das Popup unsichtbar ist
var showLevel = "900";                                 // Level, bei welchem das Popup sichtbar ist
var ajaxUrls = [];

$j(document).ready(function(){
    $j("#context-help").css("display", "inline-block");
});

/**
 * Popup ausblenden
 */
function hidePopup()
{
    $j(elementId).css({
        "z-index": hideLevel,
        "left"   : "-100000px"
    });
}

/**
 * Popup anzeigen
 */
function viewPopup()
{
    $j(elementId).css({
        "z-index": showLevel,
        "left"   : "20%"
    });
}

/**
 * Inhalt des Popup neu laden
 */
function showPopup()
{
    if ( readyToShow == false ) {
        resetPopup();

        $j.each(ajaxUrls, function(index, currUrl) {
            loadFromUrls(currUrl);
        });

        readyToShow = true;
    }
    viewPopup();
    updatePopupScrollBar();
}

/**
 * alle URLs abarbeiten und Inhalte laden
 * @param    string    ajaxUrl
 */
function loadFromUrls(ajaxUrl)
{
    $j.ajax({
        "url"       : ajaxUrl,
        "dataType"  : "json",
        "async"     : false,
        "beforeSend": function() {},
    })
    .done(function(data) {
        $j(popupBodyId).append(data.html);
        $j("#showBlocks").val(data.blocks);
    })
    .fail(function(jqXHR, status){
        alert( "Request failed: " + status );
    });
}

/**
 * Popup für eine Anzeige vorbereiten
 */
function resetPopup()
{
    $j(popupBodyId).html("");
    hidePopup();
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
