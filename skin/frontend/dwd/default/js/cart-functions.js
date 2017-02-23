$j(document).ready(function(){
	$j('.mobile-info-block .input-text').on('keyup', function(){
		var dataID = $j(this).attr('data-qty');
		var newQty = parseInt( $j(this).val() );

		$j('#qty-' + dataID).val(newQty);
	});
});