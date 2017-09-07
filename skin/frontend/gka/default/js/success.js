$j(document).ready(function() {
	if (ChangeAmountView == 1) {
		$j('#my-orders-table > tfoot tr:last')
			.before('<tr><td colspan="3" class="a-right">' + ChangeAmountTitle +
					'</td><td class="last a-right">' + ChangeAmountValue + '</td></tr>');
	}
	$j('.tax-totals').css('display', 'none');
});