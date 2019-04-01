
let color_element  = "";
let color_proberty = "";
let scroll_element = "";

function updateScrollbar(localScrollElement)
{
    if ( detectIE() != false || is_touch_device() != false ) {
        return;
    }
    $j(localScrollElement).niceScroll({
        "cursorcolor"       : $j(color_element).css(color_proberty),
        "cursorwidth"       : "15px",
        "cursorborderradius": "3px",
        "horizrailenabled"  : false,
        "autohidemode"      : true,
        "bouncescroll"      : false,
        "smoothscroll"      : true,
        "touchbehavior"     : false,
        "zindex"            : 999
    }).resize();
}

(function($){
    $(document).ready(function() {
        if ( typeof(isDWD) !== "undefined" ) {
            color_element  = "#top-row";
            color_proberty = "background-color";
            scroll_element = "body";
        }
        else {
            color_element  = ".page-title h1";
            color_proberty = "color";
            scroll_element = "body";
        }

        if ( detectIE() == false && is_touch_device() == false ) {
            updateScrollbar(scroll_element);
        }
    });
})(jQuery);
