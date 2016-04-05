var maxBottom = 220;  // Maximaler Abstand des Buttons von unten
var scrollMin = 100;  // Mindestwert von oben, ab welchem der Button sichtbar wird
var viewHeight = 0;   // Höhe des sichtbaren Fensters
var docHeight = 0;    // Höhe des gesamten Dokumentes
var fromTop = 0;      // Abstand nach oben
var spaceBottom = 0;  // Restabstand nach unten
var newBottom = 0;    // Neuer "von Unten" Wert für den Button

var backgrounds = ['bg2.jpg', 'bg3.jpg', 'bg4.jpg', 'bg5.jpg', 'bg7.jpg', 'bg8.jpg', 'bg9.jpg'];

$j(document).ready(function () {
    // Start-Werte ermitteln
    viewHeight = $j(window).innerHeight();
    docHeight = $j(document).height();

    // Header-Welle hinzufügen
    var headerWave = $j('<div />',{
        'id'   : 'top-wave',
        'class': 'top-wave'
    });
    $j('.page').prepend(headerWave);

    // Scroll Top
    addScrollTop();
    var image = backgrounds[ randomNumber(0, backgrounds.length) ];
    $j('.wrapper .page').css('background-image', 'url("' + SKIN_PATH + '/images/' + image + '")');
    //alert( randomNumber(0, 10) );
});

function addScrollTop()
{
    var topDiv = $j('<div />',{
        'id': 'to-top'
    });

    var topLink = $j('<a />',{
        'href' : 'javascript:void(0);',
        'class': 'fa fa-arrow-up'
    });

    $j('body').prepend(topDiv);
    $j('#to-top').prepend(topLink);
    $j("#to-top").hide();

    // #to-top anzeigen
		$j(window).scroll(function () {
		    fromTop = $j(this).scrollTop();                  // Wie weit wurde gescrollt
		    spaceBottom = docHeight - viewHeight - fromTop;  // Wievile Rest ist noch Platz
		    newBottom = maxBottom - spaceBottom;             // neuen Bottom-Wert ermitteln

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

function randomNumber(min, max)
{
    if ( max > min ) {
        return Math.floor(Math.random()*(max - min + 1) + min);
    }
    else {
        return 0;
    }
}