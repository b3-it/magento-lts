document.observe("dom:loaded", function() {
	changeArt(1);
});

function resetData() {
    setDefault();
    changeArt(1);
}

function setPeriodeTierPrice(data) {
	  for(var i =0; i < data.length; i++)
	  {
	      AboTierPriceControl.addItem(data[i][0], data[i][1]);
	  }
}

function getPeriodeTierPrice() {
	  $c   = 10;  //max tierPriceControl.itemsCount;
	  $res = new Array($c);
	  for($i=0; $i<$c; $i++)
	  {
	  	  idx = 'periode_tier_price_row_'+$i+'_price';
	  	  e = $(idx);
	  	  if (($(idx)) && (! $(idx).hasAttribute('disabled'))) {
	  	      $res[$i] =  new Array($F('periode_tier_price_row_'+$i+'_qty'),$F('periode_tier_price_row_'+$i+'_price'));
	  	  }
	  }

	  return Object.toJSON($res);
}

function selectRow(ID) {
    var rowData = JSON.parse( $F('rowData' + ID).replace(/'/g, "\"") );

    // Select-Box setzen
    changeArt(rowData["type"]);

    $('periode_id').value       = rowData['entity_id'];
    $('periode_type').value     = rowData["type"];
    $('periode_label').value    = rowData["label"];
    $('periode_from').value     = rowData["from"];
    $('periode_to') .value      = rowData["to"];
    $('periode_duration').value = rowData["duration"];
    $('periode_price').value    = rowData["price"];
    $('periode_unit').value		  = rowData["unit"];

    if ($('cancelation_period')) {
        $('cancelation_period').value = rowData["cancelation_period"];
    }

    var liste = rowData["tierprices"];
    for ( var i = 0; i < liste.length; i++ ) {
        var paar = liste[i];
        if ( paar[0] != '' && paar[1] != '' ) {
            AboTierPriceControl.addItem(paar[0], paar[1]);
            delete(paar);
        }
    }

    if (typeof button_save_update != 'undefined') {
        $('add_periode_row_button').innerHTML = button_save_update;
    }
}

function setError(elem) {
    if ( $('validation-fail-' + elem.id) == undefined ) {
        var msg = fail_message.replace(/{{index}}/g, elem.id);
        elem.addClassName(valid_fail_class);

        if ( $('note_' +  elem.id) ) {
            $('note_' + elem.id).insert({after: msg});
        }
        else {
            elem.insert({after: msg});
        }

    }
}

function saveLine(selectIndex) {
    var haveError = false;

    var periode_name  = $('periode_label');
    var periode_preis = $('periode_price');

    var periode_von     = $('periode_from');
    var periode_bis     = $('periode_to');
    var periode_dauer   = $('periode_duration');
    var periode_abgabe  = $('periode_unit');
    var periode_staffel = $('period_tier_price_table');

    if ( periode_name.value == '' ) {
        setError(periode_name);
        haveError = true;
    }

    if ( periode_preis.value == '' ) {
        setError(periode_preis);
        haveError = true;
    }

    switch (selectIndex) {
      case "1": // Dauer
          if ( periode_dauer.value == '' ) {
              setError(periode_dauer);
              haveError = true;
          }
          break;
      case "2": // Zeitspanne
          if ( periode_von.value == '' ) {
              setError(periode_von);
              haveError = true;
          }
          if ( periode_bis.value == '' ) {
              setError(periode_bis);
              haveError = true;
          }
          break;
      case "3": // Abo
          if ( periode_dauer.value == '' ) {
              setError(periode_dauer);
              haveError = true;
          }
          if ( $('cancelation_period') && $('cancelation_period').value == '' ) {
              setError($('cancelation_period'));
              haveError = true;
          }
          break;
    }

    return haveError;
}

function changeArt(selectIndex) {
    //toggle(bool) ist erst ab prototype 1.7.1 verfügbar

    setDefault();

    $('periode_type').selectedIndex = selectIndex - 1;

    switch (selectIndex) {
      case "1": // Dauer
    	    $('periode_from').up('tr').toggle();
          $('periode_to').up('tr').toggle();
          if ($('cancelation_period')) {
          	  $('cancelation_period').up('tr').toggle();
          }
          if ($('periode_tier_price_container')) {
          	  $('periode_tier_price_container').up('tr').toggle();
          }
		      break;
      case "2": // Zeitspanne
          $('periode_duration').up('tr').toggle();
          $('periode_unit').up('tr').toggle();
          if ($('cancelation_period')) {
        	    $('cancelation_period').up('tr').toggle();
          }
		  if ($('periode_tier_price_container')) {
        	    $('periode_tier_price_container').up('tr').toggle();
          }
          break;
      case "3": // Abo
          $('periode_from').up('tr').toggle();
          $('periode_to').up('tr').toggle();
          break;
      default :
    	    //Init Dauer soll angezeigt werden
    	    $('periode_from').up('tr').toggle();
	  	    $('periode_to').up('tr').toggle();
	  	    if ($('cancelation_period')) {
	  		      $('cancelation_period').up('tr').toggle();
	  	    }
	  	    if ($('periode_tier_price_container')) {
	  		      $('periode_tier_price_container').up('tr').toggle();
	  	    }
          break;
    }
}

function setDefault() {
    if ( $('validation-fail-periode_label') ) {
        $('validation-fail-periode_label').remove();
    }
    if ( $('validation-fail-periode_from') ) {
        $('validation-fail-periode_from').remove();
    }
    if ( $('validation-fail-periode_to') ) {
        $('validation-fail-periode_to').remove();
    }
    if ( $('validation-fail-periode_duration') ) {
        $('validation-fail-periode_duration').remove();
    }
    if ( $('validation-fail-periode_price') ) {
        $('validation-fail-periode_price').remove();
    }
    if ( $('validation-fail-cancelation_period') ) {
        $('validation-fail-cancelation_period').remove();
    }

    $('periode_label').value    = '';
    $('periode_from').value     = '';
    $('periode_to').value       = '';
    $('periode_duration').value = '';
    $('periode_price').value    = '0.0';

    if ($('cancelation_period')) {
    	  $('cancelation_period').value = '';
    }

    $('periode_id').value           = 0;
    $('periode_type').selectedIndex = 0;

    if (typeof button_default != 'undefined') {
    	  $('add_periode_row_button').innerHTML = button_default;
    }

    if ($('periode_tier_price_container')) {
	      while($('periode_tier_price_container').rows.length > 0) {
		        $('periode_tier_price_container').deleteRow(0);
	      }
    }

    $('periode_from').up('tr').show();
    $('periode_to').up('tr').show();
	  $('periode_duration').up('tr').show();
    $('periode_unit').up('tr').show();
    if ($('cancelation_period')) {
    	  $('cancelation_period').up('tr').show();
    }
    if ($('periode_tier_price_container')) {
    	  $('periode_tier_price_container').up('tr').show();
    }
}