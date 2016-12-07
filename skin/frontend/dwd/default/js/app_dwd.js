var toggleBlocks = new Array();

//Definieren der Break-Points für JavaScript-Aktionen
var egov_break = {
    lngSwitch: 760,    // Store-Language Switcher
    welcome  : 785,    // Welcome
    navbar   : 785,    // Navigation
    rightCol : 1000,   // Rechte Maginal-Spalte
    topSearch: 911     // Suchen-Leiste im Header
};

// Allgemeine JS-Funktionen
$j(document).ready(function(){
    // Custom-Scrollbar im Skin-Design
    $j('body').niceScroll({
        'cursorcolor'       : '#2D4B9B',
        'cursorwidth'       : '15px',
        'cursorborderradius': '3px'
    });

    $j('#mobile-cart > a').attr('data-target-element', '#mobile-header-cart');
    $j('#mobile-cart > a').attr('id', 'mobile-cart-menu');
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

	// Artikel-Namen und Artikel-Nummern abkürzen
	cutAllArticleTitleLine();
	
    // Benutzer-Navigation für Mobil
    checkMobileCustomerNavigation();
	
	// Auf Größen-Anpassung des Fensters reagieren
	$j(window).resize(function() {
		// Artikel-Namen und Artikel-Nummern abkürzen
		cutAllArticleTitleLine();
		
		// Benutzer-Navigation für Mobil
		checkMobileCustomerNavigation()
	});

	// jQuery-UI für DropDown-Boxen
	$j("select").selectmenu();
	
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