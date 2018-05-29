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

function updateScrollbar(localScrollElement)
{
    $j(localScrollElement).niceScroll({
        'cursorcolor'       : $j(color_element).css(color_proberty),
        'cursorwidth'       : '15px',
        'cursorborderradius': '3px',
        'horizrailenabled'  : false
    }).resize();
}

var color_element  = '';
var color_proberty = '';
var scroll_element = '';

$j(document).ready(function () {
	if ( typeof(isDWD) !== 'undefined' ) {
		color_element  = '#top-row';
		color_proberty = 'background-color';
		scroll_element = 'body';
	}
	else {
		color_element  = '.page-title h1';
		color_proberty = 'color';
		scroll_element = 'body';
	}

	if ( detectIE() == false ) {
        updateScrollbar(scroll_element);
	}
});
