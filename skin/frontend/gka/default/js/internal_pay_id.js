function setPrice(amount)
{
	amount = (typeof amount !== 'undefined') ?  amount : false;
	
	if(amount === false ) {
		amount = $j('#amount').val();
	}
    optionsPrice.changePrice('config', {'price': amount, 'oldPrice': 0});
    optionsPrice.reload();
}
	
function validateAmount()
{
	var amount  = $j('#amount').val();
	var amount2 = $j('#confirmation').val();
	if(amount != amount2){
		//alert(diff_price_msg);
		setPrice(0);
	}else{
		setPrice();
	}		
}

$j(document).ready(function(){
	Validation.add('validate-both-amounts', validator_msg, function(v, input) {
        var dependentInput = $(input.form[input.name == 'amount' ? 'confirmation' : 'amount']),
            isEqualValues  = input.value == dependentInput.value;

        if (isEqualValues && dependentInput.hasClassName('validation-failed')) {
            Validation.test(this.className, dependentInput);
        }
        return dependentInput.value == '' || isEqualValues;
    });
});
