var scrollMin = 100;  // Mindestwert von oben, ab welchem der Button sichtbar wird
var maxBottom = 0;    // Maximaler Abstand des Buttons von unten
var viewHeight = 0;   // Höhe des sichtbaren Fensters
var docHeight = 0;    // Höhe des gesamten Dokumentes
var fromTop = 0;      // Abstand nach oben
var spaceBottom = 0;  // Restabstand nach unten
var newBottom = 0;    // Neuer "von Unten" Wert für den Button

// Array mit Hintergrundgrafiken erzeugen
var backgrounds = ['bg2.jpg', 'bg3.jpg', 'bg4.jpg', 'bg5.jpg', 'bg7.jpg', 'bg8.jpg', 'bg9.jpg'];

$j(document).ready(function () {
    // Scroll Top
    addScrollTop();
    
    // Zufälliges Hintergrundbild einblenden
    randomBackground();
});

/**
 * Zufälliges Hintergrundbild setzen
 * Wenn der Bildname "undefined" ist, wird der CSS-Default belassen
 */
function randomBackground()
{
    var index = randomNumber(0, backgrounds.length - 1);
    var image = backgrounds[ index ];

    if ( image != 'undefined' ) {
        var newImage = SKIN_PATH + 'images/' + image;
        
        $j('#background-image').css({'background-image': 'url("' + newImage + '")'}).fadeIn(1000);
        //$j('.page').css({'background-color': 'transparent', 'background': 'transparent'});
    	//$j('.wrapper .page').css({'background-image': 'url("' + newImage + '")'});
    }
}

/**
 * Erzeugen einer zufälligen Zahl zwischen 2 Werten
 *
 * @param    integer     Startwert als ganze Zahl
 * @param    integer     Endwert als ganze Zahl
 * @return   integer     Zufallszahl als ganze Zahl
 */
function randomNumber(min, max)
{
    if ( max > min ) {
        return Math.floor(Math.random()*(max - min + 1) + min);
    }
    else {
        return 0;
    }
}

/**
 * Einüfgen des "Nach oben" Buttons in die Seite
 * Hinzufügen des Verhaltens direkt auf der Seite
 * Einblenden, wenn der Abstand nach oben min. 100 Pixel beträgt
 * Sanften Scroll-Lauf hinzufügen
 * Der Button bleibt immer oberhalb des Footers
 */
function addScrollTop()
{
    // Scroll-Top-Div hinzufügen
    var topDiv = $j('<div />',{
        'id': 'to-top'
    });

    // Pfeil in den DIV setzen und mit Funktion belegen
    var topLink = $j('<a />',{
        'href' : 'javascript:void(0);',
        'class': 'fa fa-arrow-up'
    });

    $j('body').prepend(topDiv);
    $j('#to-top').prepend(topLink);
    $j("#to-top").hide();

    // #to-top anzeigen
		$j(window).scroll(function () {
		    fromTop = $j(this).scrollTop();                      // Wie weit wurde gescrollt
            viewHeight = $j(window).innerHeight();               // Wie groß ist das Browser-Fenster
            docHeight = $j(document).height();                   // Wie groß ist das Dokument
            maxBottom = $j('.footer-container').height() + 12;   // Ausrechnen, wie hoch der Footer ist

		    spaceBottom = docHeight - viewHeight - fromTop;      // Wieviel Rest ist noch Platz
		    newBottom = maxBottom - spaceBottom;                 // neuen Bottom-Wert ermitteln

		    // Button positionieren
		    if ( spaceBottom >= maxBottom ) {
		        $j('#to-top').css('bottom', '30px');
		    }
		    else {
		        $j('#to-top').css('bottom', newBottom + 'px');
		    }

		    // ein-/ausblenden des Buttons
		    if (fromTop > scrollMin) {
		        $j('#to-top').fadeIn();
		    } else {
		        $j('#to-top').fadeOut();
		    }
		});

		// beim Klick nach oben Scrollen
		$j('#to-top a').click(function () {
		    $j('body,html').animate({
		        'scrollTop': 0
		    }, 800);
		    return false;
		});
}
