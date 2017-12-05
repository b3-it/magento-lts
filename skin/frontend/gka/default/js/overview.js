var labelElement   = '<span class="required">*</span>';
var validatorClass = 'required-entry';
var failedClass    = 'validation-failed';
var passedClass    = 'validation-passed';


// HTML-Elemente für SimpleProdukt müssen unter Validator-Kontrolle (mit * versehen)
var requiredElements = new Array('name-firstname', 'name-lastname', 'billing-street', 'billing-city', 'billing-zip');

$j(document).ready(function() {
   	$j('.name-middlename').remove();

   	$j('#address').accordion({
        // Simple-Produkt enthalten => Accordion öffnen
       	'active'     : ( isSimpleProduct == 1 ? 0 : false ),
       	'collapsible': true,
       	'heightStyle': 'content',
       	'icons'      : {
   			'header'      : 'ui-icon-circle-plus',
   			'activeHeader': 'ui-icon-circle-minus'
       	},
       	'activate': function(event, ui) {
       		$j('body').getNiceScroll().resize();
       	}
    });

    // alle Inputs im Zahl-Container durchgehen
    $j('.sp-methods input').each(function(){
        if( $j(this).is(":checked") ) {
            switchMethod( $j(this).val() );
            isAjaxSend = true;
        }
    });

    // Checken, ob ein Versand-Produkt im Warenkorb liegt
    if ( isSimpleProduct == 1 ) {
        $j.each(requiredElements, function(index, value) {
            var elementLabel = '.' + value + ' label';
            var elementInput = '.' + value + ' input';

            // Elemente vereinheitlichen
            if ( $j(elementLabel).children('em').length ) {
                $j(elementLabel + ' em').remove();
                $j(elementLabel).prepend(labelElement);
            }

            // Pflicht-Felder hervorheben/setzen
            if ( $j(elementLabel).children('span').length == 0 ) {
                $j(elementLabel).prepend(labelElement);
            }
            if ( !$j(elementInput).hasClass(validatorClass) ) {
                $j(elementInput).addClass(validatorClass);
            }
        });
    }

    // Ergänzen des Magento-Validators
    $j('#form-validate').submit(function(event){
        if (!dataForm.validator.validate()) {
            // Validator-Fehler => Elemente bearbeiten
        	openAccordion();
        }
    });
});

/**
 * Accordion öffnen, falls ein Simple-Produkt im Warenkorb liegt und der
 * Benutzer das Accordion geschlossen hat
 */
function openAccordion()
{
    var active = $j('#address').accordion("option", "active");
    if (active == false) {
        $j('#address').accordion("option", {
            'active'  : 0,
            'activate': function(event, ui) {
                // Accordion war geschlossen, daher funktioniert
                // der Magento-Validator nicht richtig
                highlightHiddenElements();
                // NiceScroll anpassen
                $j('body').getNiceScroll().resize();
            }
        });
    }
}

/**
 * Falls das Accordion geschlossen war, müssen jetzt die Validator-Elemente hinzugefügt werden
 */
function highlightHiddenElements()
{
    $j.each(requiredElements, function(index, value) {
        var inputElem = $j('.' + value + ' input');
        var inputDiv  = inputElem.parent('.input-box');
        var alertElem = $j('<div />', {
                            'class': 'validation-advice',
                            'html' : stringValidateFail,
                            'id'   : 'advice-required-entry-' + inputElem.attr('id')
                        });

        // Elemente ist leer, muss aber Validiert werden
        if ( !inputElem.val().length ) {
            inputElem.removeClass(passedClass).addClass(failedClass);

            if ( inputDiv.children('.validation-advice').length == 0 ) {
                inputDiv.append(alertElem);
            }
        }
    });
}

/**
 * Umschalten der Bezahlmethode
 */
function switchMethod(method)
{
   $j.ajax({
       'url'     : urlBaseAjax + 'method/' + method,
       'type'    : "GET",
       'dataType': "html",
       success: function( data ) {
           $j('#cashpayment').html(data);
       },
       error: function( xhr, status ) {
           alert(stringAjaxError);
       }
   });
}
