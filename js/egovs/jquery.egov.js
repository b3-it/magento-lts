function is_touch_device() {
    return 'ontouchstart' in window           // works on most browsers
           || 'onmsgesturechange' in window;  // works on ie10
}

function toggleLoadingMask()
{
    $j('#loading-mask').toggle();
}

function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // Edge (IE 12+) => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

function addJsToHeader($scriptPath)
{
    if ( $scriptPath.length ) {
        $j('<script />').attr('type', 'text/javascript')
                        .attr('src', $scriptPath)
                        .appendTo('head');
    }
}

$j(document).ready(function () {
    if ( detectIE() == false ) {
        addJsToHeader(baseUrl + 'js/egovs/jquery.nicescroll.min.js');
        addJsToHeader(baseUrl + 'js/egovs/jquery.nicescroll.init.js');
    }
});

(function($j){
    $j.eGovMenu = function(element, options){

        /*
         * Plugin default options
         */
        var defaults = {
            SearchElement: 'UL',                 // DOM-Tag welcher durchsucht werden soll (Großbuchstaben)
            DOMElement   : 'ul',                 // DOM-Tag welcher durchsucht werden soll (Kleinbuchstaben)
            RecordSpacer : ';',                  // Trennzeichen zwischen den einzelnen Einträgen des DOM
            RecordCombine: ':',                  // Trennzeichen zwischen DOM-ID und Element-Status
            CookiePostfix: '_status',            // Zeichenkette, welche zusätzlich als Cookie-Bezeichner verwendet wird
            ExpireDate   : 1000 * 60 * 60 * 24   // This time is for One Day Means 24 hour 1=day 1000=1sec 60*60=1hour 24=no of hour.
        };

        this.settings = {}
        this.settings = $j.extend({}, defaults, options);

        var elem = $j(element), element = element;
        var from = $j(element).attr('id');

        var cssClasses = ["main-open", "main-closed", "sub-open", "sub-closed"];
        var oldClass = '';

        /*
         * Initial-Function
         *
         * - Einlesen des Cookies
         * - Verhindern, das Links anklickbar sind
         * - Menü-Status ändern
         * - Cookie abspeichern
         */
        init = function() {
            getCookie(from);

            $j('#' + from + ' li > a').click(function(e) {
                e.preventDefault();
                if( $j(this).parent().find(defaults.DOMElement).length > 0 ) {
                    toggleMenu( $j(this).next() );
                    changeGrafic( $j(this), $j(this).next() );
                    getStatus(from);
                }
                else {
                    openURL( $j(this).attr('href') );
                }
            });
        }

        /*
         *  Menü-Punk bekommt eine zusätzliche Klasse
         */
        changeGrafic = function(target, element) {
            var status = element.css('display');
            removeClass(target);
            var alt = oldClass.split('-');

            if ( status == 'block' ) {
                target.addClass('egov-arrow-' + alt[2] + '-open');
            }
            else {
                target.addClass('egov-arrow-' + alt[2] + '-closed');
            }
        }

        /*
         *  Entfernen der entsprechenden Klassen-Namen
         */
        removeClass = function(target) {
            var name = '';

            // "undefined"-Klassen entfernen falls vorhanden -- woher die kommen ist bisher unbekannt
            if ( target.hasClass('egov-arrow-undefined-open') ) {
                target.removeClass('egov-arrow-undefined-open');
            }
            if ( target.hasClass('egov-arrow-undefined-closed') ) {
                target.removeClass('egov-arrow-undefined-closed');
            }

            $j.each(cssClasses, function(key, value){
                name = 'egov-arrow-' + value;
                if ( target.hasClass(name) ) {
                    target.removeClass(name);
                    oldClass = name;
                }
            });
        }

        /*
         *  Menü-Status ändern
         */
        toggleMenu = function(target) {
            target.toggle();
        }

        /*
         *  URL öffnen
         */
        openURL = function(url) {
            window.location.href = url;
        }

        /*
         *  Menü-Status abfragen und zum abspeichern vorbereiten
         */
        getStatus = function(nav) {
            var res = [];
            $j('#' + nav).find('*').each(function(){
                // Grep Status from all Sub-Lists
                if ( this.tagName == defaults.SearchElement ) {
                    res.push( $j(this).attr('id') + defaults.RecordCombine + $j(this).css('display') );
                }
            });
            setCookie(nav, res.join(defaults.RecordSpacer));
        }

        /*
         *  Menü-Status wiederherstellen
         */
        setStatus = function(stat) {
            var arr = stat.split(defaults.RecordSpacer);
            var anz = arr.length;

            for ( var i = 0; i < anz; i++ ) {
                var sub = arr[i].split(defaults.RecordCombine);

                if ( sub[0] != 'undefined' ) {
                    $j('#' + sub[0]).css('display', sub[1]);
                    changeGrafic( $j('#' + sub[0]).prev(), $j('#' + sub[0]) );
                }
            }
        }

        /*
         *  Menü-Status in Cookie abspeichern
         */
        setCookie = function(elem, val) {
            var toDay = new Date();
            toDay.setTime(toDay.getTime());

            var expiress = defaults.ExpireDate;
            var expires_date = new Date(toDay.getTime()+(expiress));

            Mage.Cookies.domain  = window.location.hostname;
            Mage.Cookies.expires = expires_date;
            Mage.Cookies.set(elem + defaults.CookiePostfix, val);
        }

        /*
         *  Menü-Status aus Cookie auslesen und auf menü anwenden
         */
        getCookie = function(elem) {
            var val = Mage.Cookies.get(elem + defaults.CookiePostfix);

            if ( val !== null ) {
                setStatus(val);
            }
        }

        init();
    };

    /*
     *  eGovMenu-Objekt als Plugin Registrieren und starten
     */
    $j.fn.eGovMenu = function(options) {
        return this.each(function() {
            if (undefined == $j(this).data('eGovMenu')) {
                var plugin = new $j.eGovMenu(this, options);
                $j(this).data('eGovMenu', plugin);
            }
        });
    }

    $j(document).ready(function(){
    	//cloneNavigation();

    	var setDefaultToggle = false;

    	// Prüfen, ob die Array-Variable gesetzt ist
    	if ( typeof toggleBlocks == 'undefined' ) {
    		setDefaultToggle = true;
    	}

        // Default-Klapp-Funktion für Warenkorb, Suchwolke, Nachbestellung
    	if ( setDefaultToggle == true ) {
        	toggleBlockContent('block-cart');
        	toggleBlockContent('block-tags');
        	toggleBlockContent('block-reorder');
        }
        else {
        	if ( toggleBlocks.length > 0 ) {
        		// Alle Elemente im Array mit der Klapp-Funktion versehen
        		$j(toggleBlocks).each(function(){
	        		toggleBlockContent(this);
	        	});
        	}
        }

    });

    function cloneNavigation()
    {
    	// Inhalt in Mobile Navigation kopieren
    	// Funktion der Navigation herstellen
    	$j('#header-nav').html( $j('#egov-nav').html() ).eGovMenu();
    }

    function toggleBlockContent(classElement)
    {
    	$j('.' + classElement).on('click', function(){
    		$j('.' + classElement + ' > div.block-content').toggle();
    	});
    }
})(jQuery);
