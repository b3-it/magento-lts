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
    var formParams = $j('#shipping-zip-form').serialize();

    toggleLoadingMask();
    updateAjax(urlEstimate, formParams, '', '#estimateRate');
    updateAjax(urlTotals, formParams, '#shopping-cart-totals-table', '.cart-totals');
    toggleLoadingMask();
}

function updateAjax(ajaxURL, formParams, removedElement, destinationElement)
{
    $j.ajax({
        'url'     : ajaxURL,
        'method'  : 'POST',
        'data'    : formParams,
        'dataType': 'html'
    })
    .done(function(result) {
        if ( removedElement.length && $j(removedElement).length ) {
            $j(removedElement).remove();
            $j(destinationElement).prepend(result);
        }
        else {
            $j(destinationElement).html(result);
        }
    })
    .fail(function(jqXHR, textStatus) {
        alert('Request failed: ' + textStatus);
    });
}
