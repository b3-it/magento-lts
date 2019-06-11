// =============================================
// Definieren der Break-Points für JavaScript-Aktionen
// =============================================
var egov_break = {
    lngSwitch: 760,    // Store-Language Switcher
    welcome  : 785,    // Welcome
    navbar   : 785,    // Navigation
    rightCol : 1000,   // Rechte Maginal-Spalte
    topSearch: 911     // Suchen-Leiste im Header
};

// =============================================
// Allgemeine JS-Funktionen
// =============================================
function setTabIndex(arr)
{
    $j.each(arr, function(element, tabindex){
        $j("#" + element).attr("tabindex", tabindex);
    });
}

// =============================================
// Rechten Abstand in der Seite ermitteln
// =============================================
$j.fn.right = function() {
	return $j(document).width() - (this.offset().left + this.outerWidth());
}

jQuery(document).ready(function ($j) {
	// Fixed HTML-Scroll-Bug für IE ab Version 8
	$j("html").css({"overflow-y": "", "-ms-overflow-y": ""});

    // Dynamische Skallierung der Welcome-Schrift
    var resizeText = function() {
        // aktuelle Breite des Containers
        var pageContainer = $j('.page-header-container').width();
        // Maximale Schriftgröße in Prozent
        var preferredFont = 300;
        // Maximale Breite des Inhalts in Pixel
        var pageFullSize = 960;
        // Skalierungs-Faktor
        var scaleFactor = Math.sqrt(pageContainer) / Math.sqrt(pageFullSize);
        // Berechnete Schrift-Größe
        var newSize = (preferredFont * scaleFactor) - 50;

        $j(".header-position").css("font-size", newSize + "%");
    };

    // Grafischer Language-Switcher hinzufügen
    if ( $j("#select-language").length ) {
        $j("#select-language").touchSelect({
            "useMulti"     : true,                                    // Popup erzeugen
            "elementInsert": "#store-view-switcher",                  // Quell-Element angeben
            "elementClass" : "skip-link skip-switch-language",        // CSS-Klassen für Schalter engeben
            "elementImage" : SKIN_PATH + "images/icon-language.svg",  // Bild als Titel verwenden
            "uiFindElement": true
    	});
    }

    // Dynamisch die Position des Benutzer-Menüs berechnen,
    // damit das DropDown an der korrekten Stelle angezeigt wird
    // siehe scss/module/_skip-links-link
    var addjustUserMenu = function() {
        var posRight = 0;  // Start-Position (Offset)

        if ( $j(".skip-switch-language").length ) {
            posRight += $j(".store-language-container").width() + 2;
        }
        posRight += $j(".skip-search").width();
        posRight += $j(".skip-cart").width() + 6;

        $j("#header-account").css("right", posRight + "px");
    };
    addjustUserMenu();

    $j(window).bind("resize", function(){
        //resizeText();
    }).trigger("resize");

    // Rest-Verfügbarkeit in rechte Spalte (über Cart-Button) einfügen
    if ( $j(".availability-only").length ) {
        $j(".availability-only").detach().appendTo(".extra-info");
    }

    // Rechte Seitenspalte im 3-Spalten-Layout
/*
    if ($j('.main-container.col3-layout').length > 0) {
        enquire.register('screen and (max-width: ' + egov_break.rightCol + 'px)', {
            match: function () {
                var rightColumn = $j('.col-right');
                var colWrapper = $j('.col-main');

                rightColumn.appendTo(colWrapper);
            },
            unmatch: function () {
                var rightColumn = $j('.col-right');
                var main = $j('.col-main');

                rightColumn.prependTo(main);
            }
        });
    }
*/
    // Language-Switcher umlegen
/*
    if ($j('#big-view-switcher').length > 0) {
        $j('#big-view-switcher').appendTo( $j('.page-header-container') );

        enquire.register('screen and (max-width: ' + egov_break.lngSwitch + 'px)', {
            match: function() {
                $j('#big-view-switcher').css('display', 'none');
                $j('#small-view-switcher').css('display', 'block');
            },
            unmatch: function() {
                $j('#big-view-switcher').css('display', 'block');
                $j('#small-view-switcher').css('display', 'none');
            }
        });
    }
*/
    // Umlegen des Welcome-Header
/*
    if ($j('.page-header-container').length > 0) {
        enquire.register('screen and (max-width: ' + egov_break.welcome + 'px)', {
            match: function() {
                // eine Ebene nach oben schieben
                $j('.welcome-header').appendTo( $j('.page-header-container') );
            },
            unmatch: function() {
                // zurück zu den Skip-Links (Ursprung)
                $j('.welcome-header').appendTo( $j('.skip-links') );
            }
        });
    }
*/
    // Umlegen der Shop-Navigation
/*
    if ( $j('.col-left').length > 0 && $j('.page-header-container').length > 0 ) {
    	enquire.register('screen and (max-width: ' + egov_break.navbar + 'px)', {
            match: function() {
                // in Mobil-Container schieben
                $j('.nav-primary').appendTo( $j('#header-nav') );

                // Damit die Navigation funktioniert, müssen die
                // Container 'egov-nav' und 'header-nav' "umbenannt" werden
                $j('#egov-nav').attr('id', 'egov-nav_old');
                $j('#header-nav').attr('id', 'egov-nav');
                $j('.skip-nav').attr('href', '#egov-nav');
            },
            unmatch: function() {
                // zurück an Ursprung
                $j('.nav-primary').appendTo( $j('#egov-nav_old') );

                // Ursprüngliche Benennung wieder herstellen
                $j('#egov-nav').attr('id', 'header-nav');
                $j('#egov-nav_old').attr('id', 'egov-nav');
                $j('.skip-nav').attr('href', '#header-nav');
            }
        });
    }
*/
    // Umlegen des Suchen-Buttons
/*
    if ( $j('.skip-search').length > 0 ) {
        enquire.register('screen and (max-width: ' + egov_break.topSearch + 'px)', {
            match: function() {
                $j('.skip-search').prependTo( $j('.account-cart-wrapper') );
            },
            unmatch: function() {
                $j('.skip-search').appendTo( $j('.skip-links') );
            }
        });
    }
*/
});
