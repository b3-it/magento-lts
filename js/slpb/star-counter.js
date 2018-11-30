function calcStars()
{
	// alle Sterne im Warenkorb zählen
	if( $j('#shopping-cart-table').length ) {
		var starCNT = 0;
		$j('span.stars').each(function(index){
			starCNT += $j(this).text().length;
		});
		$j('#star-cnt').html(starCNT);
	}
}

$j(document).ready(function(){
	calcStars();
});