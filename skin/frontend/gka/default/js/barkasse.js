$j(document).ready(function(){
	var endSaldo   = parseFloat( $j('#opening').val() ) + parseFloat( $j('#saldo').val() );

	$j('#endsaldo').val( endSaldo.toFixed(2) );
	$j('#balance').html('0.00 ' + currency);
	
	$j('#withdrawal').bind('keyup', function() {
		var open       = parseFloat( $j('#opening').val() );
        var withdrawal = parseFloat( $j('#withdrawal').val() );
        var diff       = open - withdrawal;
		$j('#balance').html( diff.toFixed(2) + ' ' + currency );
		
		if ( diff < 0 ) {
			$j('#balance').addClass('required');
		}
		else {
			$j('#balance').removeClass('required');
		}
	});
});