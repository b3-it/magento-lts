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

(function($){
    $(document).ready(function() {
        if ( detectIE() == false ) {
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

            $(scroll_element).niceScroll({
                cursorcolor:   $(color_element).css(color_proberty),
                cursorwidth:   "15px",
                autohidemode:  true,
                bouncescroll:  false,
                smoothscroll:  true,
                touchbehavior: false,
                zindex:        999
            }).resize();
        }
    });
})(jQuery);
