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

function disableSubmitButton()
{
    // disable Submit
    $j("#captcha-holder").closest("form")
                                     .find("input[type=\"submit\"], button[type=\"submit\"]")
                                     .attr("onclick", "return false;")
                                     .addClass("disabled");
}

function enableSubmitButton()
{
    // enable Submit
    $j("#captcha-holder").closest("form")
                                     .find("input[type=\"submit\"], button[type=\"submit\"]")
                                     .attr("onclick", "")
                                     .removeClass("disabled");
}