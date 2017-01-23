var toggleBlocks = new Array();

//Definieren der Break-Points für JavaScript-Aktionen
var egov_break = {
    //lngSwitch: 760,    // Store-Language Switcher
    //welcome  : 785,    // Welcome
    navbar   : 800,    // Navigation
    //rightCol : 1000,   // Rechte Maginal-Spalte
    //topSearch: 911     // Suchen-Leiste im Header
};

// Allgemeine JS-Funktionen
$j(document).ready(function(){
    // Custom-Scrollbar im Skin-Design
    $j('body').niceScroll({
        'cursorcolor'       : $j('#top-row').css('background-color'),
        'cursorwidth'       : '15px',
        'cursorborderradius': '3px'
    });

    $j('#mobile-cart > a').attr({
    	'id'                 : 'mobile-cart-menu',
    	'data-target-element': '#mobile-header-cart'
    });
    $j('#mobile-cart > div').attr('id', 'mobile-header-cart');

	if ( $j('body').hasClass('cms-index-index') ) {
		$j('#welcome-msg').html( $j('#welcome-hidden').html() );
	}

	if ( $j('#grouped-product-avalible').length ) {
		$j('#grouped-product-avalible-moved').html( $j('#grouped-product-avalible').html() )
		                                     .removeClass('no-display')
		                                     .css('display', 'block');
		$j('#grouped-product-avalible').html('')
		                               .addClass('no-display')
		                               .css('display', 'none');
	}

	if ( $j('#map').length || $j('#product_addtocart_form > .availability') ) {
		$j('#grouped-product-avalible-moved').html( $j('.availability').html() )
                                             .removeClass('no-display')
                                             .css('display', 'block');
        $j('.availability').html('')
                           .addClass('no-display')
                           .css('display', 'none');
	}

	if ( $j('#product_addtocart_form > p.delivery-time').length ) {
		$j('#grouped-product-avalible-moved').html( $j('#product_addtocart_form > p.delivery-time').html() )
                                             .removeClass('no-display')
                                             .css('display', 'block');
        $j('#product_addtocart_form > p.delivery-time').html('')
                                                     .addClass('no-display')
                                                     .css('display', 'none');
	}
	
	if ( $j('.add-to-cart').length ) {
		// Default-Funtion
		var defaultFkt = 'syncSelectedQty(this.value)';
		
		// Produktansicht gewählt => Button kopieren
		$j('#add-to-cart-top').html( $j('.add-to-cart').html() );
		
		// ID und Events setzen, damit die Felder korrekt funktionieren
		$j('#add-to-cart-top input[type="tel"]').attr({'id': 'qty-top', 'name': 'qty-top', 'onBlure': defaultFkt, 'onKeyUp': defaultFkt});
		$j('#add-to-cart-top label').attr('for', 'qty-top');
		$j('.add-to-cart input[type="tel"]').attr({'id': 'qty-bottom', 'name': 'qty-bottom', 'onBlure': defaultFkt, 'onKeyUp': defaultFkt});
		$j('.add-to-cart label').attr('for', 'qty-bottom');
		
		// verstecktes Formularfeld erzeugen
		var input = $j('<input />', {
			'type'     : 'hidden',
			'id'       : 'qty',
			'name'     : 'qty',
			'data-egov': 'automatic',
			'value'    : $j('#qty-top').val()
		});
		$j('#product_addtocart_form div.no-display').before( input );
	}

    // Umlegen der Shop-Navigation
    if ( $j('.col-left').length > 0 && $j('.page-header-container').length > 0 ) {
    	enquire.register('screen and (max-width: ' + egov_break.navbar + 'px)', {
            match: function() {
                // in Mobil-Container schieben
                $j('.nav-primary').appendTo( $j('#header-nav') );

                // Damit die Navigation funktioniert, müssen die
                // Container 'egov-nav' und 'header-nav' "umbenannt" werden
                $j('#egov-nav').attr('id', 'egov-nav_old');
                $j('#header-nav').attr('id', 'mobile-nav');
                $j('.skip-nav').attr('href', '#egov-nav');
            },
            unmatch: function() {
                // zurück an Ursprung
                $j('.nav-primary').appendTo( $j('#egov-nav_old') );

                // Ursprüngliche Benennung wieder herstellen
                $j('#mobile-nav').attr('id', 'header-nav');
                $j('#egov-nav_old').attr('id', 'egov-nav');
                $j('.skip-nav').attr('href', '#header-nav');
            }
        });
    }
    
    // Benutzer-Konto kopieren
    if ( $j('#customer-account-menu').length > 0 ) {
    	$j('#mobile-header-account li.first').append( '<ul id="mobile-customer-account-navigation" class="level1">' + $j('#customer-account-navigation').html() + '</ul>' );
    }

	// Artikel-Namen und Artikel-Nummern abkürzen
	//cutAllArticleTitleLine();
	
    // Benutzer-Navigation für Mobil
    checkMobileCustomerNavigation();
	
	// Auf Größen-Anpassung des Fensters reagieren
	$j(window).resize(function() {
		// Artikel-Namen und Artikel-Nummern abkürzen
		//cutAllArticleTitleLine();
		
		// Benutzer-Navigation für Mobil
		checkMobileCustomerNavigation()
	});

	// jQuery-UI für DropDown-Boxen
	$j("select").selectmenu({
		'change': function( event, ui ) {
			// need to get the real elements parent to trigger change event
			$j(ui.item.element).parent().trigger("change");
		}
	});
	
	// Grafischer Language-Switcher
	$j('#select-language').touchSelect({
		'elementClass' : '',
		'elementParent': 'top-row-content-list',
		'elementInsert': '<li />',
		'uiFindElement': true
	});
});

function setTabIndex(arr)
{
    $j.each(arr, function(element, tabindex){
        $j('#' + element).attr('tabindex', tabindex);
    });
}

/**
 * Wenn in der Artikelansicht die Anzahl der Artikel geändert wird,
 * so muss das FORM-Field aktualisiert werden und danach dieser Wert
 * in beide Eingabefelder kopiert werden
 */
function syncSelectedQty(newValue)
{
	// neue Bestellmenge in eine Zahl umwandeln
	var neu = parseInt(newValue);

	if ( $j.isNumeric(neu) ) {
		// alles korrekt => Wert setzen
		$j('#qty').val( neu );
	}
	
	// gesetzten Wert in die Eingabefelder schreiben
	$j('#qty-top').val( $j('#qty').val() );
	$j('#qty-bottom').val( $j('#qty').val() );
}

/**
 * Prüfen, ob man sich im Benutzerkonto befindet und bei Bedarf die
 * Benutzer-Navigation umkopieren
 */
function checkMobileCustomerNavigation()
{
	if ( $j('body').hasClass('customer-account') ) {
    	if( ($j('.col-left').css('display') == 'none') && ( $j('#mobile-header #header-account li.first ul.level1').length < 1 ) ) {
    		$j('#mobile-header #header-account li.first').append( '<ul class="level1">' + $j('#customer-account-navigation').html() + '</ul>' );
    	}
    }
}

/**
 * Alle Artikel-Namen und Artikel-Nummern so abschneiden,
 * das sie nicht abrupt aufhören können
 */
function cutAllArticleTitleLine()
{
	if ( $j('.products-list').length ) {
		var breite = $j('.products-list h2.product-name').innerWidth();
		// alle untergeordneten Elemente ermitteln (Name steht im Link)
		$j('.products-list h2.product-name a').each(function(){
			// Alle Artikel-Namen abschneiden
		    if ( $j(this).width() > breite ) {
		    	cutString($j(this).html().trim(), $j(this), breite);
    		}
		});

		var breite = $j('.products-list div.product_sku').innerWidth();
		// alle untergeordneten Elemente ermitteln (SKU steht im Span)
		$j('.products-list div.product_sku span').each(function(){
			// Alle Artikel-Nummern abschneiden
			if ( $j(this).width() > breite ) {
				cutString($j(this).html().trim(), $j(this), breite);
    		}
		});

		var breite = $j('.products-list h2.mobile-product-name').innerWidth();
		// alle untergeordneten Elemente ermitteln (Name steht im Link)
		$j('.products-list h2.mobile-product-name a').each(function(){
			// Alle Artikel-Namen abschneiden
		    if ( $j(this).width() > breite ) {
		    	cutString($j(this).html().trim(), $j(this), breite);
    		}
		});
	}
}

/**
 * einen vorhandenen String so weit einkürzen, bis er in das Element passt ohne abgeschnitten zu werden
 * 
 * @param      string       Inhalt, welcher angepasst werden soll
 * @param      element      Element, welches den String enthalten soll
 * @param      integer      Maximale Breite welche angezeigt werden kann
 */
function cutString(string, element, maximum)
{
	var parse = '...';
	var tmp = string;
	var trim = '';

	while( element.width() > maximum ) {
		tmp = tmp.substring(0, tmp.length - 1);
		trim = tmp + parse;
		element.html( tmp + parse );
	}
}