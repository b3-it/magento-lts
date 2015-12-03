function toggleFields() {
    if ( $j('#custom-owner').prop('checked') ) {
        $j('#debitor-box').css('width', '48%');
        $j('#custom-accountholder-box').css('width', '48%');
    }
    else {
        $j('#debitor-box').css('width', '100%');
    }
    $j('#custom-accountholder-box').toggle();
}

function opcToggle() {
    // Diese Funktion ist nur zum setzen des Default für das SEPA-Formular
    if ( $j('body').hasClass('checkout-onepage-index') ) {
        // OnePage Checkout
        if ( $j('#opc-payment').hasClass('active') ) {
            if ( $j('#p_method_sepadebitsax').is(":checked") ) {
            }
            else {
                $j('#payment-form-sepadebitsax').css('display', 'none');
            }

            if ( $j('#custom-owner').prop('checked') ) {
                $j('#debitor-box').css('width', '48%');
                $j('#custom-accountholder-box').css('display', 'inline-block');
            }
            else {
                $j('#debitor-box').css('width', '100%');
                $j('#custom-accountholder-box').css('display', 'none');
            }
        }
    }
}

/*
 * http://www.tbg5-finance.org/?ibandocs.shtml
 * http://stackoverflow.com/questions/15027613/magento-prototype-custom-validation
 * http://blog.baobaz.com/en/blog/custom-javascript-form-validators
 * app/design/frontend/base/default/template/egovs/debit/sepa_sax
 */

if(Validation) {
    Validation.addAllThese([
        [
            'validate-debit-bic',
            'BIC must be either 8 or 11 characters long',
            function(v, r) {
        	      return v.length == 8 || v.length == 11 || v.length == 0;
            }
        ],
        [
            'validate-debit-iban',
            'IBAN not valid.',
            function(v, r) {
        	      res = checkibancore(v);
        	      return res == 0 ? false : true;
            }
        ],
        [
            'validate-alphanum_ws',
            'Please use only letters (a-z or A-Z), numbers (0-9) or whitespaces in this field. No other characters are allowed.',
            function(v) {
                return Validation.get('IsEmpty').test(v) ||  /^[a-zA-Z0-9 ]+$/.test(v) /*!/\W/.test(v)*/
            }
        ],
    ]);
}
