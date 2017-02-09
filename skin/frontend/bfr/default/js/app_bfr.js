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

function moveElement(oldElement, newElement)
{
	if ( $j(oldElement).length ) {
		$j(newElement).html( $j(oldElement).html() );
		$j(oldElement).html('');
	}
}

$j(document).ready(function(){
    // Custom-Scrollbar im Skin-Design
    $j('body').niceScroll({
        'cursorcolor'       : $j('#top-row').css('background-color'),
        'cursorwidth'       : '15px',
        'cursorborderradius': '3px'
    });
	
	removeZoom();

    $j('a.egov-product-image').click(function(){
        removeZoom();
    });
    
    // mobielen Warenkorb erzeugen
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
});
