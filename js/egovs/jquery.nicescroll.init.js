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
        'horizrailenabled'  : false
    }).resize();
}

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
