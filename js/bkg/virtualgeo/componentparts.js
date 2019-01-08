ComponentParts = function(elementId,name) {
       
        this.elementId = elementId;
        this.inputName = name;
        var instance = this;
        this.my_id = 0;
        
        
        this.processTemplate = function(template,data)
        {
        	$j.each(data, function(key,value){
        		template = template.replace(new RegExp("{{"+key+"}}", 'g'), value);
        	});
        	
        	return template;
        }
        
        this.toogleUpDownButtons = function()
        {
           var firstVisibleRow = '';
            var lastVisibleRow  = '';

            var anzahlZeilenSichtbar = 0;
            $j('#table-' +this.elementId+ '_grid tbody tr').each(function(){
            	//erstmal einschalten
            	$j(this).find('button.position-up').removeAttr('disabled');
            	$j(this).find('button.position-down').removeAttr('disabled');
            });
            $j('#table-' +this.elementId+ '_grid tbody tr').each(function(){
            	
            	if( $j(this).css('display') != 'none' ) {
                    anzahlZeilenSichtbar ++;

                    if ( firstVisibleRow.length ) {
                        // erste sichtbare Zeile ist gesetzt => muss also die letzte sein
                        lastVisibleRow  = $j(this).attr('id');
                    }

                    if ( firstVisibleRow == '' ) {
                        // erste sichtbare Zeile setzen
                        firstVisibleRow = $j(this).attr('id');
                    }
                }
            });

            if ( (anzahlZeilenSichtbar == 1) && firstVisibleRow.length ) {
                // nur eine Zeile
                $j('#' + firstVisibleRow + ' button.position-up').attr('disabled', 'disabled');
                $j('#' + firstVisibleRow + ' button.position-down').attr('disabled', 'disabled');
            }
            else {
                if ( firstVisibleRow.length && lastVisibleRow.length ) {
                    $j('#' + firstVisibleRow + ' button.position-up').attr('disabled', 'disabled');
                    $j('#' + lastVisibleRow  + ' button.position-down').attr('disabled', 'disabled');
                }
            }
        	
        	
        }
        this.removeRow = function(_id)
        {
        	var row = $j('#row-'+this.elementId+'-'+_id);
            $j('#deleted-'+this.elementId+'-'+_id).val(1);
            row.hide();
            this.toogleUpDownButtons();
          
        }
        this.moveDown = function(_id)
        {
        	var row = $j('#row-'+this.elementId+'-'+_id);
            row.insertAfter( row.next() );
            this.setPosition();
            this.toogleUpDownButtons();
        }
        	  
        this.moveUp = function(_id)
        {
              	var row = $j('#row-'+this.elementId+'-'+_id);
                
              	row.insertBefore( row.prev() );
              	this.setPosition();
              	 this.toogleUpDownButtons();
        }        
        this.setPosition = function()
        {
        	var pos = 0;
        	$j('#table-' +this.elementId+ '_grid tbody tr').each(function(){
        		pos++;
        		var _id = $j(this).attr('data-id');
                $j('#pos-' +instance.elementId+ '-'+_id).val(pos);
            });
        }
        
        this.addRow = function()
        {
        	var data = {};
        	data.id = "";
        	data.label = $j('#table-'+this.elementId+'-select option:selected').text();
        	data.entity_id = $j('#table-'+this.elementId+'-select option:selected').val();
        	this.appendRow(data);
        }
        
        this.appendRow = function(data) {
        	this.my_id++;
            data.elementId = this.elementId;
            data.my_id = this.my_id;
            data.inputname = this.inputName;
            data.default_is_checked = "";
            data.admin_is_checked = "";
            if(data.is_visible_only_in_admin == 1){
            	 data.admin_is_checked = "checked='checked'";
            }
            if(data.is_default == 1){
           	 data.default_is_checked = "checked='checked'";
           }
            
            var newTableRow = this.processTemplate(this.getTemplate(),data);
            
            
          
            $j('#table-'+this.elementId+'_grid tbody').append(newTableRow);
            this.setPosition();
            this.toogleUpDownButtons();
        }

        this.getTemplate = function() {
            return $j("#"+this.elementId+"_template").html();
        }

        
}










/**
 * Benutzer klickt auf einen beliebigen Button
 */
function registerClickEvent()
{
    $j('table.data td.position-sorting button').on('click', function(){
        // Tabell-Zeile
        var row = $j(this).parents("tr:first");

        // Tabell-ID setzen
        tableID = row.attr('data-table');

        // alles aktivieren
        activateAllButtons();

        if ( $j(this).is('.position-up') ) {
            row.insertBefore( row.prev() );

            // Positionen neu setzen
            setNewPositions();
        }
        else if ( $j(this).is('.position-down') ) {
            row.insertAfter( row.next() );

            // Positionen neu setzen
            setNewPositions();
        }
        else if ( $j(this).is('.position-delete') ) {
            row.css('display', 'none');
            $j('input#delete-' + row.attr('data-table') + '-' + row.attr('data-id')).attr('value', 1);
        }

        // Unbenutzbare Buttons setzen
        deactivateUnlogicalButtons('');
    });
}

/**
 * eine neue Zeile an eine vorhandene Tabelle anhängen
 */
function addTableRow(element)
{
    var type          = 'hidden';       // als was sollen die Inputfelder hinzugefügt werden
    var foundItems    = new Array();    // Hilfsvariable für Auswahl
    var noItemSelect  = '0';            // Welcher Wert bei SelectBoxen soll nicht benutzt werden
    var itemSeparator = ': ';           // Text-Verbinder für die Darstellung der Auswahl
    var lastIdValue   = '';             // ID der letzten vorhandenen Select-Box

    $j( element.parents('div.entry-edit').first().find('select') ).each(function(){
        if ( $j(this).val() != noItemSelect ) {
            foundItems.push( $j(this).find('option:selected').text() );
            lastIdValue = $j(this).val();
        }
    });

    if ( foundItems.length == 0 ) {
        alert( messageNoItemSelected );
        return;
    }

    var destTable    = element.parents('table').next('table').attr('id');
    var firstIdValue = element.parents('div.entry-edit').first().find('option:selected').val();

    var newItem = foundItems.join(itemSeparator);
    var newId   = lastIdValue;
    var table   = destTable.replace(tabelPrefix, '');
    var nextID  = parseInt( $j('#' + destTable + ' tbody tr:last').index() ) + 1;

    var cellName = $j('<td />', {
        'text': newItem
    });

    var inputValue = $j('<input />', {
        'id'   : 'value-' + table + '-' + nextID,
        'name' : table + '[value][]',
        'value': newId,
        'type' : type
    });
    var inputPosition = $j('<input />', {
        'id'   : 'pos-' + table + '-' + nextID,
        'name' : table + '[pos][]',
        'value': nextID,
        'type' : type
    });
    var inputDelete = $j('<input />', {
        'id'   : 'delete-' + table + '-' + nextID,
        'name' : table + '[delete][]',
        'value': 0,
        'type' : type
    });
    cellName.append(inputValue).append(inputPosition).append(inputDelete);

    if ( $j('#' + destTable + ' tbody').attr('data-up-down') == 0 ) {
        var tplButtons = templateUpDownButtons + templateDelButton;
    }
    else {
        var tplButtons = templateDelButton;
    }

    var cellFunction = $j('<td />', {
        'class': 'position-sorting',
        //'html' : $j('#' + destTable + ' tbody tr:first td:last').html()
        'html' : tplButtons
    });

    var newRow = $j('<tr />', {
        'id'        : 'row-' + table + '-' + nextID,
        'data-id'   : nextID,
        'data-table': table
    });
    newRow.append(cellName).append(cellFunction);

    $j('#' + destTable + ' tbody').append(newRow);

    tableID = table;
    activateAllButtons();
    registerClickEvent();
    setNewPositions();
    deactivateUnlogicalButtons(destTable);
}

/**
 * bei allen Buttons das Attribut "deaktiviert" entfernen
 */
function activateAllButtons()
{
   // $j('#' + tabelPrefix + tableID + ' tbody button').removeAttr('disabled');
}

/**
 * in der ersten Zeile den Button "up" deaktivieren
 * in der letzten Zeile den Button "down" deaktivieren
 */
function deactivateUnlogicalButtons(destTable)
{

}

/**
 * Alle Positionen der Zeilen neu setzen
 */
function setNewPositions()
{
  
}
