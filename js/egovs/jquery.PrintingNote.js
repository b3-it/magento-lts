/**
 * Ermittelt, ob ein übergebener Wert ein JSON-String ist
 * 
 * @param    misc
 * @return   bool
 */
function checkJSON(m) {

   if (typeof m == 'object') { 
      try{
          m = JSON.stringify(m);
      }
      catch(err) {
          return false;
      }
   }

   if (typeof m == 'string') {
      try{
          m = JSON.parse(m);
      }
      catch (err) {
          return false;
      }
   }

   if (typeof m != 'object') {
       return false;
   }
   
   return true;
}


/**
 * - Anzeigen oder verbergen der Lademaske
 * - Deckkraft der Hauptseite anpassen
 * 
 * @param   bool
 */
function toggleLoading(show = false)
{
	if ( show == true ) {
		// Seite "abdunkeln"
	    $j('.wrapper').css('opacity', '0.5');
	    
	    // Lade-Maske anzeigen
	    $j('#loading-mask').toggle();
	}
	else {
		// Seite "normal"
	    $j('.wrapper').css('opacity', '1');
	    
	    if ( $j('#loading-mask').css('display') == 'block' ) {
	    	// Lage-Maske verbergen
	    	$j('#loading-mask').toggle();
	    }
	}
}


/**
 * Abspeichern der Drucknotitzen über einen AJAX-Request
 */
function submitPrintingNote() {
	var NoteForm = $j('#printing_note');

	// Ajax-Request auslösen
	$j.ajax({
		'url'       : NoteForm.attr('action') + '?isAjax=true',
		'type'      : 'post',
		'data'      : NoteForm.serialize() + '&form_key=' + FORM_KEY,
        'context'   : document.body,
        'statusCode': {
	        //200: function() { alert( msg_print_data_200 ); },
            401: function() { alert( msg_print_data_401 ); },
	        403: function() { alert( msg_print_data_403 ); },
        	404: function() { alert( msg_print_data_404 ); }
        },
        'beforeSend': function(){
            // vor absenden...
        	toggleLoading(true);        	
        }
    })
	.done(function(data){
		// Request wurde abgesetzt und eine Antwort ist gekommen
		if ( data.length ) {
			if ( checkJSON(data) == true ) {
				// Es ist ein Fehler aufgetreten
				var result = jQuery.parseJSON(data);
				
				if ( result.error == true ) {
					// Fehlermeldung aus dem Request anzeigen
					alert( result.message );
				}
				else {
					// Inhalt direkt ausgeben
					alert( data );
				}
			}
			else {
				// Inhalt direkt ausgeben
				alert( data );
			}
		}
		else {
			// Leere Antwort => eventuell kein Fehler
			alert( msg_print_data_200 + "\n" + msg_print_data_saved );
		}

		// Lade-Anpassungen zurücksetzen
		toggleLoading(false);
	})
	.fail(function(){
		// etwas ist schief gegangen
		alert( msg_print_data_fail );

		// Lade-Anpassungen zurücksetzen
		toggleLoading(false);
	});
}


/**
 * Wenn das Dokument fertig geladen ist, die Ajax-Aktion zum Button hinzufügen
 */
$j(document).ready(function(){
	$j('#submit_printingnote_button').click(function(){
		submitPrintingNote();
	});
})