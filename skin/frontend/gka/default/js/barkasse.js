var alertClass = 'required';

$j(document).ready(function(){
	var endSaldo   = parseFloat( $j('#opening').val() ) + parseFloat( $j('#saldo').val() );

	// Default-Values
	$j('#endsaldo').val( endSaldo.toFixed(2) );
	$j('#balance').html('0.00 ' + currency);

	// Kassenbuch-Journal
	$j('#withdrawal').bind('keyup', function() {
		setDiffPrice($j('#opening').val(), $j('#withdrawal').val(), '#balance', true);
	});

	// Checkout => Bestellübersicht
	$j('#givenamount').bind('keyup', function() {
		setDiffPrice(price, $j('#givenamount').val(), '#balance', true);
	});
});

/*
 * Errechnet aus 2 Übergebenen Werten die Differenz und setzt das Ergebnis
 * in ein übergebenes HTML-Element
 * 
 * @param    float     Gesamtsumme
 * @param    float     Differenzbetrag
 * @param    string    ID des Ziel-Elementes (mit '#')
 * @param    bool      Negative Beträge hervorheben
 */
function setDiffPrice(total, giff, element, highlight)
{
	var givenamount = parseFloat( giff );
	var totalprice  = parseFloat( total );
	var diff        = givenamount - totalprice;
	
	// Wenn es keine Zahl ist, dann 0 ausgeben
	if ( isNaN(diff) ) {
		diff = 0;
	}
	
	$j(element).html( diff.toFixed(2) + ' ' + currency );
	
	if ( highlight == true ) {
		highlightLowerCash(diff, element);
	}
}

/*
 * Hervorhebung je nach Differenz-Betrag, um negative Beträge sichtbar zu
 * gestalten
 * 
 * @param    float     Differenz-Betrag
 * @param    string    ID des Ziel-Elementes (mit '#')
 */
function highlightLowerCash(diff, element)
{
	if ( diff < 0 ) {
		$j(element).addClass(alertClass);
	}
	else {
		if ( $j(element).hasClass(alertClass) ) {
			$j(element).removeClass(alertClass);
		}
	}
}