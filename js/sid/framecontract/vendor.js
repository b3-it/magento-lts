//This is All Just For Logging:
var debug = true;//true: add debug logs when cloning

var fileChooser = $j("#client_certificate");
addEventListenersTo(fileChooser);
function addEventListenersTo(fileChooser) {
    fileChooser.change(function (event) { console.log("file( #" + event.target.id + " ) : " + event.target.value.split("\\").pop()) });
    fileChooser.click(function (event) { console.log("open( #" + event.target.id + " )") });
}

var clone = {};

// FileClicked()
function fileClicked(event) {
    var fileElement = event.target;
    $j("#use_clientcert_ca").closest('tr').show();
    if (fileElement.value == "") {
        $j("#use_clientcert_ca").prop('disabled', true);
    } else {
        $j("#use_clientcert_ca").prop('disabled', false);
    }
}

// FileChanged()
function fileChanged(event) {
    var fileElement = event.target;
    $j("#use_clientcert_ca").closest('tr').show();
    if (fileElement.value == "") {
        $j("#use_clientcert_ca").prop('disabled', true);
    } else {
        $j("#use_clientcert_ca").prop('disabled', false);
    }
}

function hideUseClientCertCa() {
    var uClientCertCa = $j("#use_clientcert_ca").closest('tr');
    if (typeof uClientCertCa != "undefined") {
        //uClientCertCa.attr('disabled', 'disabled');
        //uClientCertCa.prop('disabled', true);
        uClientCertCa.hide();
    }
}

function canUseClientCertCa(event) {
    var target = event.target;
    if (target.value == 1) {
        $j("#use_clientcert_ca").closest('tr').show();
        $j("#use_clientcert_ca").prop('disabled', true);
    } else {
        hideUseClientCertCa();
    }
    var fileElement = $j("#client_certificate");
    if (fileElement.val() == "") {
        $j("#use_clientcert_ca").prop('disabled', true);
    }
}

$j(document).ready(function() {
    if (debug) {
        console.log('Dom ist bereit zur Manipulation');
    }
    //Elemente werden per Ajax geladen --> ready greift nicht!
});