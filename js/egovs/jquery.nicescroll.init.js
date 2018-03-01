function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // Edge (IE 12+) => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

function resizeOnOpc()
{
	if ( detectIE() == false ) {
		setTimeout(function(){
			$j(scroll_element).getNiceScroll().resize();
			resizeOnOpc();
		}, 1000);
	}
}

$j(document).ready(function () {
	if ( typeof(isDWD) !== 'undefined' ) {
		var color_element  = '#top-row';
		var color_proberty = 'background-color';
		var scroll_element = 'body';
	}
	else {
		var color_element  = '.page-title h1';
		var color_proberty = 'color';
		var scroll_element = 'body';
	}

	if ( detectIE() == false ) {
		$j(scroll_element).niceScroll({
	        'cursorcolor'       : $j(color_element).css(color_proberty),
	        'cursorwidth'       : '15px',
	        'cursorborderradius': '3px',
	        'horizrailenabled'  : false
	    });
		
		$j(scroll_element).getNiceScroll().resize();
	}

	if ( $j('#checkoutSteps').length ) {
		// NiceScroll-Fix für OPC
		resizeOnOpc();
	}
});
