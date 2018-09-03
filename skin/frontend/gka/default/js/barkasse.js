var alertClass = 'required';

$j(document).ready(function(){
	// Kassenbuch-Journal
	$j('#withdrawal').on('keyup change', function(event) {
		setDiffPrice($j('#withdrawal').val(), $j('#endsaldo').val(),  '#balance', true);
	});

	// Checkout => Bestellübersicht
	$j('#givenamount').on('keyup input', function(event) {
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
	
	var givenamount = parseFloat(giff.replace(/,/g , "."));
	var totalprice  = parseFloat(total.replace(/,/g , "."));
	var diff        = givenamount - totalprice;

	// Wenn es keine Zahl ist, dann 0 ausgeben
	if ( isNaN(diff) ) {
		diff = 0;
	}
	diff = diff.toFixed(2).replace(".",",");
	$j(element).html( diff + ' ' + currency );

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
