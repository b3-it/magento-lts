var toggleBlocks = new Array();

// Allgemeine JS-Funktionen
$j(document).ready(function(){
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
	if ( $j('#map').length ) {
		$j('#grouped-product-avalible-moved').html( $j('.availability').html() )
                                             .removeClass('no-display')
                                             .css('display', 'block');
        $j('.availability').html('')
                           .addClass('no-display')
                           .css('display', 'none');
	}
	
	// Auf Größen-Anpassung des Fensters reagieren
	$j(window).resize(function() {
		// Artikel-Namen und Artikel-Nummern abkürzen
		cutAllArticleTitleLine();
	});
	
	// Artikel-Namen und Artikel-Nummern abkürzen
	cutAllArticleTitleLine();
});

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