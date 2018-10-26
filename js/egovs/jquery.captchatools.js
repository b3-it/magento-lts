$j(document).ready(function(){
    if( $j("#google-recaptcha").length || $j("#captcha-holder").length ) {
        $j("#email_address_confirmation").removeClass("validate-email")
                                         .removeClass("required-entry")
                                         .css("display", "none");
        disableSubmitButton();
    }
});

function disableSubmitButton()
{
    // disable Submit
    $j("#email_address_confirmation").closest("form")
                                     .find("input[type=\"submit\"], button[type=\"submit\"]")
                                     .attr("onclick", "return false;")
                                     .addClass("disabled");
}

function enableSubmitButton()
{
    // enable Submit
    $j("#email_address_confirmation").closest("form")
                                     .find("input[type=\"submit\"], button[type=\"submit\"]")
                                     .attr("onclick", "")
                                     .removeClass("disabled");
}