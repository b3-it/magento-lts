//Definieren der Break-Points für JavaScript-Aktionen
var egov_break = {
    navbar   : 599,    // Navigation
};

// Allgemeine JS-Funktionen
function removeZoom()
{
    setTimeout(function(){
        $j('div.zoomContainer').remove();
    }, 200);
}

function setTabIndex(arr)
{
    $j.each(arr, function(element, tabindex){
        $j('#' + element).attr('tabindex', tabindex);
    });
}

/**
 * Verlegt ein HTML-Element von einer Position an eine andere
 */
function moveElement(oldElement, newElement)
{
	if ( $j(oldElement).length ) {
		$j(newElement).html( $j(oldElement).html() );
		$j(oldElement).html('');
	}
}

/**
 * Prüfen, ob man sich im Benutzerkonto befindet und bei Bedarf die
 * Benutzer-Navigation umkopieren
 */
function checkMobileCustomerNavigation()
{
	if ( $j('#customer-account-menu').length > 0 && $j('#header-account').length ) {
    	if( $j('#header-account li.first ul.level1').length < 1 ) {
    		$j('#header-account li.first').append(
                '<ul id="mobile-customer-account-navigation" class="level1">' +
                $j('#customer-account-navigation').html() +
                '</ul>'
            );
    	}
    }
}

(function($) {
    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

    $.fn.attrchange = function(callback) {
        if (MutationObserver) {
            var options = {
                subtree: false,
                attributes: true
            };

            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(e) {
                    callback.call(e.target, e.attributeName);
                });
            });

            return this.each(function() {
                observer.observe(this, options);
            });

        }
    }
})(jQuery);

$j(document).ready(function(){
    // Alt-Attribut in die Copyright-Box schreiben
    $j('.thumb-link').click(function(){
    	$j('.image-copyright-box span').html( $j(this).attr('title') );
    });

	removeZoom();

	checkMobileCustomerNavigation();

    $j('a.egov-product-image').click(function(){
        removeZoom();
    });

    // mobilen Warenkorb erzeugen
    $j('#mobile-header-minicart > a').attr({
    	'id'                 : 'mobile-cart-menu',
    	'data-target-element': '#mobile-header-cart'
    });
    $j('#mobile-header-minicart > div').attr('id', 'mobile-header-cart');

    // Umlegen der Shop-Navigation
    if ( $j('.col-left').length > 0 && $j('.page-header-container').length > 0 ) {
    	enquire.register('screen and (max-width: ' + egov_break.navbar + 'px)', {
            match: function() {
                // in Mobil-Container schieben
                $j('.nav-primary').appendTo( $j('#header-nav') );

                // Damit die Navigation funktioniert, müssen die
                // Container 'egov-nav' und 'header-nav' "umbenannt" werden
                $j('#egov-nav').attr('id', 'egov-nav_old');
                $j('#header-nav').attr('id', 'mobile-nav');
                $j('.skip-nav').attr('href', '#egov-nav');
            },
            unmatch: function() {
                // zurück an Ursprung
                $j('.nav-primary').appendTo( $j('#egov-nav_old') );

                // Ursprüngliche Benennung wieder herstellen
                $j('#mobile-nav').attr('id', 'header-nav');
                $j('#egov-nav_old').attr('id', 'egov-nav');
                $j('.skip-nav').attr('href', '#header-nav');
            }
        });
    }

    $j("#checkoutSteps li.section").attrchange(function(attrName) {
        if ( $j(this).hasClass("active") ) {
            updateScrollbar(scroll_element);
        }
    });

    $j('div.minicart-wrapper a.skip-link-close').on('click', function(){
        $j('a.skip-cart, div.block-cart').toggleClass('skip-active');
    });

    // Ajax-Suche umlegen
    enquire.register('screen and (max-width: ' + egov_break.navbar + 'px)', {
    	match: function() {
    		// in Mobil-Container schieben
    		moveElement('#full-search', '#mobile-header-search');
    	},
    	unmatch: function() {
    		// zurück an Ursprung
    		moveElement('#mobile-header-search', '#full-search');
    	}
    });

    if ( $j('#small-view-switcher').length && $j('#big-view-switcher').length ) {
    	var inhalt = $j('#small-view-switcher').html();
    	if( inhalt.length == 0 ) {
    		$j('#small-view-switcher').html( $j('#big-view-switcher').html() );
    	}
    }
});
