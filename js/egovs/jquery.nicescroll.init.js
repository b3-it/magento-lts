
var color_element  = '';
var color_proberty = '';
var scroll_element = '';
function updateScrollbar(localScrollElement)
{
    if ( detectIE() != false ) {
        return;
    }
    $j(localScrollElement).niceScroll({
        'cursorcolor'       : $j(color_element).css(color_proberty),
        'cursorwidth'       : '15px',
        'cursorborderradius': '3px',
        'horizrailenabled'  : false,
        autohidemode:  true,
        bouncescroll:  false,
        smoothscroll:  true,
        touchbehavior: false,
        zindex:        999
    }).resize();
}

(function($){
    $(document).ready(function() {
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
            updateScrollbar(scroll_element);
        }
    });
})(jQuery);
