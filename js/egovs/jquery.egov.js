function is_touch_device() {
    return 'ontouchstart' in window           // works on most browsers
           || 'onmsgesturechange' in window;  // works on ie10
}

(function($j){
    $j.eGovMenu = function(element, options){

        /*
         * Plugin default options
         */
        var defaults = {
            SearchElement: 'UL',                     // DOM-Tag welcher durchsucht werden soll (Großbuchstaben)
            DOMElement   : 'ul',                     // DOM-Tag welcher durchsucht werden soll (Kleinbuchstaben)
            RecordSpacer : ';',                      // Trennzeichen zwischen den einzelnen Einträgen des DOM
            RecordCombine: ':',                      // Trennzeichen zwischen DOM-ID und Element-Status
            CookiePostfix: '_status',                // Zeichenkette, welche zusätzlich als Cookie-Bezeichner verwendet wird
            ExpireDate   : 1 * 1000 * 60 * 60 * 24   // This time is for One Day Means 24 hour 1=day 1000=1sec 60*60=1hour 24=no of hour.
        };

        this.settings = {}
        this.settings = $j.extend({}, defaults, options);

        var elem = $j(element), element = element;
        var from = $j(element).attr('id');

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
                    changeGrafic ( $j(this) );
// Hier muß eine Klasse rein, welche den Pfeil nach unten dreht!
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
        changeGrafic = function(target) {
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
                $j('#' + sub[0]).css('display', sub[1]);
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
})(jQuery);