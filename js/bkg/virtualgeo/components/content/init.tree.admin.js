var idFormLayer = '#layerForm_Name';

/**
 * Dokument fertig geladen
 */
$j(document).ready(function(){
	// Erzeuge Select-Header für JsTree
	$j.each($j('#contentlayer_form input[type="checkbox"]'), function(){
		var name  = $j(this).attr('id');
 		var label = $j("label[for='" + name + "']").html();

		var head = $j('<div />', {
			'id'   : 'header-' + name,
			'class': 'tree-head',
			'html' : label.substring(0, 1),
			'title': label
		});

		$j('#jstree-info').append(head);
	});
});

/**
 * JS-Aktion zum neuladen des gefilterten Inhals für Componenten-Inhalt
 */
function refeshComponentContent()
{
	var cat_id = $j('#component_content_category').val();
	$j.ajax({
		'url' : url_for_refresh + 'id/' + cat_id,
		'type': 'GET',
		'beforeSend': function() {
			// Aktionen vor dem Absenden
		}
	})
	.done(function(data){
		$j(idFormLayer).html( data );
	})
	.fail(function(jqXHR, textStatus){
		alert( "Request failed: " + textStatus );
	});
}

/**
 * neues Element / neue Elemente in den JS-Tree einfügen
 */
function addLayer() {
	var form_data = {};
	form_data['checked'] = $j('#layerForm_Name_is_checked').is(':checked');
	form_data['readonly'] = $j('#layerForm_Name_is_readonly').is(':checked');

    var layers = $j(idFormLayer);
    var selected = layers.find('option:selected');
	selected.each(function(){
        nodeOptions.addPage($j(this).val(), $j(this).text(), form_data);
    });

	// Auswahl zurücksetzen
	resetFormFields('#contentlayer_form');
}

function isEmptyElement(val) {
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

/**
 * Alle FormFelder in ein JSON-Array schreiben und für Speicherung einfügen
 *
 * @param    string    ID des Form-Elements mit den einzelnen Optionen
 * @param    array     Originale Daten aus dem JS-Tree
 * @return   array     JSON-String mit Array-Daten
 */
function getFormData(elementID, data)
{
	// alle diese IDs werden beim hinzufügen zum DatenArray ausgelassen
	//var exclude = ['copy_values', 'component_content_category'];

	// Wenn das Array mit Elementen gefüllt ist, wird dies zu durchsuchen benutzt
	//var idArray    = [];
	//var searchFor  = '';
	var dataOption = new Array();
	var tmp = {};

	tmp.name = data.entity_id;
	tmp.is_checked = $j('#layerForm_Name_is_checked').is(':checked');
	tmp.is_readonly = $j('#layerForm_Name_is_readonly').is(':checked');

	if ( data.checked != null ) {
		tmp.is_checked = data.checked;
	}
	if ( data.readonly != null ) {
		tmp.is_readonly = data.readonly;
	}

	dataOption.push(tmp);

/*
	if ( idArray.length ) {
		searchFor = idArray;
	}
	else {
		searchFor = $j(elementID + ' :input');
	}

	$j.each(searchFor, function() {
		var element = $j(this).attr('name');
		var value   = ( $j(this).val() == null || $j(this).val() == '' ? '0' : $j(this).val() );
		var multi   = $j(this).attr('multiple');

		// Element ist eine Checkbox => Status ermitteln
		if ( $j(this).attr('type') == 'checkbox' ) {
			value = $j(this).is(':checked');
		}

		// End-String ermitteln und Wert aus dem Array setzen
		var ending = element.slice(-7);
		if ( ending == 'checked' || ending == 'eadonly' ) {
			if ( ending == 'checked' && data.checked != null ) {
				value = data.checked;
			}
			if ( ending == 'eadonly' && data.readonly != null ) {
				value = data.readonly;
			}
		}

		// Splitt für MultiSelect
		if (multi && multi !== false) {
			// Daten aus dem JS-Tree nutzen
			value = data.entity_id;
		}

		// Prüfen, ob Element in der Ausschluss-Liste enthalten ist
		if ( $j.inArray($j(this).attr('id'), exclude) == -1 ) {
			var arrayKey = $j(this).attr('name');
			var tmp = {};
			tmp[arrayKey] = value;
			dataOption.push(tmp);
		}
	});
*/

	// JSON-Array zurückgeben
	return dataOption;
}

/**
 * die Auswahl von allen Formular-Elementen entfernen
 *
 * @param    string    ID des Form-Elements mit den einzelnen Optionen
 */
function resetFormFields(elementID)
{
	// alle diese IDs werden beim zurücksetzen ausgelassen
	var exclude = ['copy_values', 'component_content_category'];

	$j.each($j(elementID + ' :input'), function() {
		// Prüfen, ob Element in der Ausschluss-Liste enthalten ist
		if ( $j.inArray($j(this).attr('id'), exclude) == -1 ) {
			// Element ist eine Checkbox
			if ( $j(this).attr('type') == 'checkbox' ) {
				$j(this).removeAttr('checked');
			}
			// Element ist Multi-Select
			if ( $j(this).attr('multiple') !== false ) {
				$j(this).val(null);
			}
		}
	});
}

/**
 * Anlegen eines HiddenFields zur Übermittlung des Formulars
 *
 * @param    integer     Nummer der anzulegenden Elements
 * @param    array       JSON-Daten
 */
function appendJsonField(itemID, nodeData)
{
	var inputField = $j('<input />', {
		'id'   : 'virtualgeo_content_layer_options_' + itemID,
		'name' : 'product[content_layer_options][' + itemID + ']',
		'value': JSON.stringify(nodeData),
		'type' : 'hidden'
	});
	$j('#jstree-data').append(inputField);
}

/**
 * JSON-Feld aus dem Formular löschen, da der knoten im JS-Tree entfernt wurde
 *
 * @param  integer   ID des zu löschenden Feldes
 */
function removeJsonField(itemID)
{
	var objData = $j('#virtualgeo_content_layer_options_' + itemID).val();
	var oldData = $j('#virtualgeo_content_layer_deleted').val();
	var newData = '';

	var arrayData = $j.parseJSON(objData);

	if ( oldData.length ) {
		newData = oldData + ',' + $j(arrayData).get(-1).id;
	}
	else {
		newData = $j(arrayData).get(-1).id;
	}

	$j('#virtualgeo_content_layer_deleted').val(newData);
	$j('#virtualgeo_content_layer_options_' + itemID).remove();
}

/**
 * JS-Tree-Element initialisieren
 */
$j('#jstree_layer').jstree({
	"core" : {
		"animation" : 0,
		"check_callback" : true,
		"themes" : { "stripes" : true },
		'data' :[
			{ "text" : root_node_title}
		]
	},
	"types" : {
		"#" : {
			"max_children" : 10,
			"max_depth" : 4,
			"valid_children" : ["root"]
		},
		"root" : {
			"xicon" : "/static/3.3.2/assets/images/tree_icon.png",
			"valid_children" : ["default","page"]
		},
		"default" : {
			"valid_children" : ["default","page"]
		},
		"page" : {
			"icon" : "jstree-file",
			"valid_children" : []
		},
	},
	"plugins" : [
		"types"
	]
})
.on("changed.jstree", function (event, data) {
	if(data.selected.length) {
		nodeOptions.show(data.instance.get_node(data.selected[0]));
	}
})
.on("move_node.jstree", function (event, data) {
	if(data.node) {
		nodeOptions.move(data.node, data.position);
	}
})
.on("ready.jstree", function (event, data) {
	init_db_nodes();
});


/**
 * Knoten-Objekt erzeugen
 */
var nodeOptions = {
	'tree'           : $j("#jstree_layer"),
	'itemCount'      : 0,
	'pos'            : 0,
	'kategories'     : [],

	'show' : function(node) {
		if(node.data) {
			var elem = $j("#content_layer_options_"+node.data.number);
		}
	},
	'hideAll' : function() {
		for (var i = 1; i <= this.itemCount; i++){
			var elem = $j("#content_layer_options_" + i);
			if(elem.length != 0) {
				elem.hide();
			}
		}
	},
	'move' : function(node, pos) {
		if(node) {
			var ref = this.tree.jstree(true);
			var parent = ref.get_node(node.parent);
			var pos = 0;
			for(var childId in parent.children){
				var child = ref.get_node(parent.children[childId]);
				if(child) {
					pos++;
				}
			}
		}
	},
	'add': function(data, sel) {
		var ref = this.tree.jstree(true);
		var edit = false;

		this.itemCount++;
		if(!sel) {
			var	sel = ref.get_selected();
			if(!sel.length) {
				alert( element_not_selected );
				return false;
			}
			sel = sel[0];
			ref.open_node(sel);
			edit = true;
		}
		else if(sel == 'root') {
			sel =  ref.get_node('j1_1');
		}

		if(!data){
			var data = new Object();

			data.name = 'default';
			data.label = element_default_title;
			data.type = "default"
		}
		data.number = this.itemCount;

		sel = this.createTextNode(sel,data);
		if(sel && edit) {
			ref.edit(sel);
		}

		var nodeData = getFormData('#contentlayer_form', data);
		nodeData.push({'old': data});
		appendJsonField(this.itemCount, nodeData);

		var node = ref.get_node(sel);
		this.move(node, this.itemCount);
		this.open_all();

		return node.id;
	},
	'addPage': function(id, label, input_data) {
		var ref = this.tree.jstree(true);
		this.itemCount++;
		var	sel = ref.get_selected();
		if(!sel.length) {
			alert( node_not_selected + ': <' + label + '>' );
			return false;
		}

		sel = sel[0];
		ref.open_node(sel);

		var data = new Object();
		data.number = this.itemCount;
		data.type = 'default';
		data.label = label;
		data.visual_pos = input_data.visual_pos;
		data.readonly = input_data.readonly;
		data.checked = input_data.checked;
		data.entity_id = id;
		sel = this.createTextNode(sel, data);

		var nodeData = getFormData('#contentlayer_form', data);
		nodeData.push({'old': data});
		appendJsonField(this.itemCount, nodeData);

		var node = ref.get_node(sel);
		this.move(node, this.itemCount);
		this.open_all();

		return node.id;
	},
	'createTextNode': function(parent, data)
	{
		var ref = this.tree.jstree(true);
		var text = data.label;

		text += '<div class="tree-options">';
		text += '<div class="inline-tree-cell option-tree-' + (data.readonly ? 'true' : 'false') + ' option-readonly"></div>';
		text += '<div class="inline-tree-cell option-tree-' + (data.checked ? 'true' : 'false')  + ' option-checked"></div>';
		text += '</div>';

		var sel = ref.create_node(parent, {"type":data.type,"data":data, "text" : text});
		return sel;
	},
	'remove': function(data) {
		this.hideAll();
		var ref = this.tree.jstree(true);
		var	sel = ref.get_selected();
		if(!sel.length) {
			alert(node_element_is_null);
			return false;
		}
		var node = ref.get_node(sel);

		// das zugehörige JSON-Feld löschen
        removeJsonField(node.data.number);

		//elem.val(1);
		ref.delete_node(sel);
	},

	'open_all': function() {
		var ref = this.tree.jstree(true);
		ref.open_all('j1_1');
	},
	'set_div': function(data) {
		this.div = data;
	}
}
