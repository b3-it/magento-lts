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
	form_data['is_checked'] = $j('#layerForm_Name_is_checked').is(':checked');
	form_data['is_readonly'] = $j('#layerForm_Name_is_readonly').is(':checked');

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
            "icon" : "jstree-file",
			"valid_children" : ["default","page"]
		},
		"page" : {
			"icon" : "jstree-file",
			"valid_children" : []
		},
	},
	"plugins" : [
		"types",  "dnd"
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
		nodeOptions.reorder('j1_1',0);
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
			//var pos = 0;
			for(var childId in parent.children){
				var child = ref.get_node(parent.children[childId]);
				if(child) {
                   // pos++;
					child.data.parent_number = parent.data.number;
					child.data.pos = pos;
					this.alterJsonField(child.data);
				}
			}
		}
	},
	'reorder' : function(nodeId, pos)
	{
		pos++;
        var ref = this.tree.jstree(true);
        var node = ref.get_node(nodeId);
        if(node.data != null) {
            node.data.pos = pos;
            this.alterJsonField(node.data);
        }
        for(var childId in node.children){

        	//var child = ref.get_node(node.children[childId]);
        	pos = this.reorder(node.children[childId], pos);
        }
		return pos;

	},
	'add': function(data, sel) {
		var ref = this.tree.jstree(true);
		var edit = false;
		var parentnode = null;
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
            parentnode = ref.get_node(sel);
		}
		else if(sel == 'root') {
			sel =  ref.get_node('j1_1');

		}else{
            parentnode = ref.get_node(sel);
		}

		if(!data){
			var data = new Object();
			data.name = 'default';
			data.label = element_default_title;
			data.type = "default"
		}
        data.deleted = false;
		data.number = this.itemCount;
        data.pos = this.itemCount;


        if(parentnode != null){
            data.parent_number = parentnode.data.number;
		}

		sel = this.createTextNode(sel,data);
		if(sel && edit) {
			ref.edit(sel);
		}
        var node = ref.get_node(sel);

		//this.move(node, this.itemCount);
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
		var parentNode = ref.get_node(sel);
		var data = new Object();
		data.number = this.itemCount;
		data.type = 'default';
		data.label = label;
		data.visual_pos = input_data.visual_pos;
		data.is_readonly = input_data.is_readonly;
		data.is_checked = input_data.is_checked;
		data.entity_id = id;
        data.parent_number = 0;
        data.pos = this.itemCount;
        data.deleted = false;
        data.id = 0;
		if(parentNode != null)
		{
            data.parent_number = parentNode.data.number;
		}

		sel = this.createTextNode(sel, data);

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
		text += '<div class="inline-tree-cell option-tree-' + (data.is_checked ? 'true' : 'false')  + ' option-checked"></div>';
		text += '<div class="inline-tree-cell option-tree-' + (data.is_readonly ? 'true' : 'false') + ' option-readonly"></div>';
		text += '</div>';

		this.appendJsonField(data);

		var sel = ref.create_node(parent, {"type":data.type,"data":data, "text" : text});
		return sel;
	},
	'appendJsonField':function (nodeData)
    {
        var inputField = $j('<input />', {
            'id'   : 'virtualgeo_content_layer_options_' + nodeData.number,
            'name' : 'product[content_layer_options][' + nodeData.number + ']',
            'value': JSON.stringify(nodeData),
            'type' : 'text',
            'width' : '600px'
        });
        $j('#jstree-data').append(inputField);
    },
	'alterJsonField':function (nodeData)
	{
        $j('#virtualgeo_content_layer_options_' + nodeData.number).val(JSON.stringify(nodeData));
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

		//Delete Flag setzten
        var data = JSON.parse($j('#virtualgeo_content_layer_options_' + node.data.number).val());
        data['deleted'] = true;
        $j('#virtualgeo_content_layer_options_' + node.data.number).val(JSON.stringify(data));

        //knoten entfernen
		ref.delete_node(sel);
	},

	'open_all': function() {
		var ref = this.tree.jstree(true);
		ref.open_all('j1_1');
	},

}
