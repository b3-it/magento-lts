$j(document).ready(function(){
    // Button "umwidmen", da JS aktiv ist
    $j('#update_total button').attr({
        'type'   : 'button',
        'title'  : btnUpdateTitle,
        'value'  : btnUpdateCaption,
        'onclick': 'coShippingMethodFormSubmit();'
    })
    .html(btnUpdateCaption);

    // Pflichtfeld für PLZ setzen
    var selectCountry = $j('#country').val();
    var optionalZip = jQuery.inArray(selectCountry, countriesWithOptionalZip);

    if ( optionalZip < 0 ) {
        // nicht im Array vorhanden
        $j('#label-postcode').addClass('required').prepend('<span class="required">*</span>');
        $j('#postcode').addClass('required-entry');
    }
});

function coShippingMethodFormSubmit()
{
    toggleLoadingMask();

    new Ajax.Request(urlEstimate, {
        parameters: Form.serialize('shipping-zip-form'),
        onSuccess: function(response) {
            $('estimateRate').update(response.responseText);

            new Ajax.Request(urlTotals, {
                parameters: Form.serialize('shipping-zip-form'),
                onSuccess: function(response) {
                    $('shopping-cart-totals-table').update(response.responseText);
                }
            });
            toggleLoadingMask();
        }
    });
}
