/**
 * Absenden-Button deaktivieren
 */
function disableSubmitButton()
{
    // disable Submit
    $j("#captcha-holder").closest("form")
                         .find("input[type=\"submit\"], button[type=\"submit\"]")
                         .attr("onclick", "return false;")
                         .addClass("disabled");
}

/**
 * Absenden-Button aktivieren
 */
function enableSubmitButton()
{
    // enable Submit
    $j("#captcha-holder").closest("form")
                         .find("input[type=\"submit\"], button[type=\"submit\"]")
                         .attr("onclick", "")
                         .removeClass("disabled");
}

$j(document).ready(function(){
    if( $j("#google-recaptcha").length || $j("#captcha-holder").length ) {
        if (typeof idName !== 'undefined') {
            $j("#" + idName).removeClass("validate-email")
                .removeClass("required-entry")
                .css("display", "none");
        }
        disableSubmitButton();
    }
});
