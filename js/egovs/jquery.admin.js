var jq_version    = '1.10.2';
var jq_subpath    = 'lib/jquery/';
var jq_noconflict = 'noconflict.js';
var showStatusMsg = false;

/**
 * Nachladen von beliebigen JS-Dateien
 *
 * @param    string       vollstündige URL zum JavaScript
 * @param    function     Callback-Funktion, welche im Anschluss ausgeführt werden soll
 * 
 * https://www.nczonline.net/blog/2009/07/28/the-best-way-to-load-external-javascript/
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
	var jq_main = JS_URL + jq_subpath + 'jquery-' + jq_version + '.min.js';
	var jq_conf = JS_URL + jq_subpath + jq_noconflict;
	
    loadScript(jq_main, function() {
        if ( showStatusMsg == true ) {
        	alert('jQuery fertig geladen!');
        }
    });

	// 0,5 Sekunde warten
	setTimeout(function(){
    	// Magento-eigenes noConflict laden
    	loadScript(jq_conf, function() {
            if ( showStatusMsg == true ) {
            	alert('jQuery-noConflict fertig geladen!');
            }
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
	        if ( showStatusMsg == true ) {
	        	alert("jQuery nicht geladen!\n\n" + jq_main + "\n" + jq_conf);
	        }
        }
	}, 1000);
}
