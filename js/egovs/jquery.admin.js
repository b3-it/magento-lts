var jq_version = '1.10.2';
var jq_subpath = 'lib/jquery/';

/**
 * Nachladen von beliebigen JS-Dateien
 *
 * @param    string       vollstündige URL zum JavaScript
 * @param    function     Callback-Funktion, welche im Anschluss ausgeführt werden soll
 */
function loadScript(url, callback) {
    var script = document.createElement("script");
	script.type = "text/javascript";
	
	if(script.readyState) {
		script.onreadystatechange = function() {
			if ( script.readyState === "loaded" || script.readyState === "complete" ) {
				script.onreadystatechange = null;
				callback();
			}
		}
	}
	else {
		script.onload = function() {
			callback();
		}
	}
	
	script.src = url;
	document.getElementsByTagName("head")[0].appendChild(script);
}

// Prüfen, ob jQuery geladen worden ist
if ( typeof $j == 'undefined' ) {
    // jQuery nicht geladen
    
    // jQuery-LIB laden
    loadScript(JS_URL + jq_subpath + 'jquery-' + jq_version + '.min.js', function() {
        //alert('JQ ready!');
    });

	// 0,5 Sekunde warten
	setTimeout(function(){
    	// Magento-eigenes noConflict laden
    	loadScript(JS_URL + jq_subpath + 'noconflict.js', function() {
            //alert('JQ-NC ready!');
        });
	}, 500);	
	
	// weitere 0,5 Sekunden (Insgesamt also 1 Sekunde) warten
	setTimeout(function(){	
	    // Dummy-Funktion, die rein garnichts macht
	    // Sie wird aber benötigt, da die Objekt-Abfrage sonst fehlschlägt
	    for (var i = 0; i < 10; i++) {
            var k = i;
        }
        
        if ( typeof $j == 'undefined' || typeof jQuery == 'undefined' ) {
	        alert('jQuery nicht geladen!');
        }
	}, 1000);
}
