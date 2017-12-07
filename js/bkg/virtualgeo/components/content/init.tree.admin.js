function addLayer() {
	var form_data = {};
	form_data['checked'] = $j('#layerForm_Name_is_checked').is(':checked');
	form_data['readonly'] = $j('#layerForm_Name_is_readonly').is(':checked');
	
    var layers = $j('#layerForm_Name');
    var selected = layers.find('option:selected');
	selected.each(function(){
        nodeOptions.addPage($j(this).val(),$j(this).text(),form_data);
    });
}

function isEmptyElement(val) {
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

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
	});

$j('#jstree_layer').on("changed.jstree", function (e, data) {
	if(data.selected.length) {
		nodeOptions.show(data.instance.get_node(data.selected[0]));
	}
});
$j('#jstree_layer').on("rename_node.jstree", function (e, data) {
	if(data.node) {
		nodeOptions.rename(data.node,data.text);
	}
});
$j('#jstree_layer').on("move_node.jstree", function (e, data) {
	if(data.node) {
		nodeOptions.move(data.node, data.position);
	}
});
$j('#jstree_layer').on("ready.jstree", function (e, data) {
	init_db_nodes();
});






var nodeTemplate = '<div style="display:none" id="content_layer_options_{{number}}" class="hor-scroll">' +
				'<input type="hidden" id="content_layer_options_{{number}}_is_delete" name="product[content_layer_options][{{number}}][is_delete]" value="" />'+
				'<input type="hidden" name="product[content_layer_options][{{number}}][id]" value="{{id}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_name" name="product[content_layer_options][{{number}}][label]" value="{{label}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_number" name="product[content_layer_options][{{number}}][number]" value="{{number}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_parent" name="product[content_layer_options][{{number}}][parent]" value="{{parent}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_pos" name="product[content_layer_options][{{number}}][pos]" value="{{pos}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_visual_pos" name="product[content_layer_options][{{number}}][visual_pos]" value="{{visual_pos}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_type" name="product[content_layer_options][{{number}}][type]" value="{{type}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_entity_id" name="product[content_layer_options][{{number}}][entity_id]" value="{{entity_id}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_checked" name="product[content_layer_options][{{number}}][checked]" value="{{checked}}" />'+
				'<input type="hidden" id="content_layer_options_{{number}}_readonly" name="product[content_layer_options][{{number}}][readonly]" value="{{readonly}}" />'+
				'</div>';



				
var nodeOptions = {
		div_id : "#hidden_content_layer",
		tree : $j("#jstree_layer"),
		templateSyntax : /(^|.|\r|\n)({{(\w+)}})/,
		templateText : nodeTemplate,
		itemCount : 0,
		pos : 0,
		kategories : [],
		getDiv : function(){
			
			return $j(this.div_id);
		},
		show : function(node) {
			//this.hideAll();
			if(node.data){
				var elem = $j("#content_layer_options_"+node.data.number);
				if(elem){
					//elem.show();
				}
			}
			//Element.insert(this.div, {'':this.template.evaluate(data)});
		},
		hideAll : function(){
			for (var i = 1; i <= this.itemCount; i++){
					var elem = $j("#content_layer_options_"+i);
					if(elem.length != 0)
					{
						elem.hide();
					}
			}
		},
		rename : function(node, $text) {
			var elem = $j("#content_layer_options_" + node.data.number + "_name");
			if(elem){
				elem.val($text);
			}
			if(node.data.type = 'page'){
				var elem = $j("#content_layer_options_" + node.data.number + "_title");
				node.text = node.text + " ("+elem.val()+")";
				var ref = this.tree.jstree(true);
				ref.redraw(true);
			}
		},
		move : function(node, pos) {
			if(node)
			{
				var ref = this.tree.jstree(true);
				var parent = ref.get_node(node.parent);
				var elem = $j("#content_layer_options_" + node.data.number + "_parent");
				if(parent.data){
					elem.val(parent.data.number);
				}else{
					elem.val('0');
				}
				var pos = 0;
				for(var childId in parent.children)
				{
					var child = ref.get_node(parent.children[childId]);
					if(child){
						var elem = $j("#content_layer_options_" + child.data.number + "_pos");
						elem.val(pos);
						pos++;
					}
				}
			}
		},
		
		add: function(data, sel) {
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
				var text = data.title;
				if(data.type == 'page'){
					text = text + "<span style=\"text-align:right;\" ><span>  | " + data.service_title + " | "+data.visual_pos+"</span></span>" ;
				}
				sel = this.createTextNode(sel,data);//ref.create_node(sel,  {"type":data.type,"data":data, "text" : text});
				if(sel && edit) {
					ref.edit(sel);
				}
				this.template = new Template(this.templateText, this.templateSyntax);
				var content = this.template.evaluate(data);
				var html = this.getDiv().html();
				this.getDiv().html( this.getDiv().html() + content);
				
				var node = ref.get_node(sel);
				this.move(node, this.itemCount);
					
				
				return node.id;
			
		},
		addPage: function(id, label, input_data) {
			var ref = this.tree.jstree(true);
			this.itemCount++;
			var	sel = ref.get_selected();
			if(!sel.length) { 
				alert( element_not_selected );
				return false; 
			}

			sel = sel[0];
			ref.open_node(sel);
			var data = new Object();
			data.number = this.itemCount;
			data.type = 'default';
			data.title = label;
			data.visual_pos = input_data.visual_pos;
			data.readonly = input_data.readonly;
			data.checked = input_data.checked;
			data.entity_id = id;
			sel = this.createTextNode(sel, data);
			this.template = new Template(this.templateText, this.templateSyntax);
			var content = this.template.evaluate(data);
			var html = this.getDiv().html();
			this.getDiv().html( this.getDiv().html() + content);
			
			var node = ref.get_node(sel);
			this.move(node, this.itemCount);
				
			
			return node.id;
			
		},
		createTextNode: function(parent,data)
		{
			var ref = this.tree.jstree(true);
			var text = data.title;
			var ro = data.readonly? "readonly" : "";
			var ch = data.checked? "checked" : "";
			text = text + "<span style=\"text-align:right;\" ><span> " + ro + " " + ch + "</span></span>" ;

			var sel = ref.create_node(parent,  {"type":data.type,"data":data, "text" : text});
			return sel;
		},
		remove: function(data) {
				this.hideAll();
				var ref = this.tree.jstree(true);
				var	sel = ref.get_selected();
				if(!sel.length) {
					alert(node_element_is_null);
					return false;
				}
				var node = ref.get_node(sel);
				var elem = $j("#content_layer_options_" + node.data.number + "_is_delete");
				elem.val(1);
				ref.delete_node(sel);
		},

		edit: function(data) {
            //if ( isEmptyElement(data) == false ) {
            	var ref = this.tree.jstree(true);
            	var	sel = ref.get_selected();
            	if(!sel.length) {
            		alert( node_element_not_selected );
            		return false;
            	}
				sel = sel[0];
				var node = ref.get_node(sel);
				if(node.data.type = 'layer'){
					var node = ref.get_node(sel);
					var elem = $j("#content_layer_options_" + node.data.number + "_name");
					node.text = elem.val();
				}
				ref.edit(sel);
		},
		open_all: function() {
			var ref = this.tree.jstree(true);
			ref.open_all('j1_1');
		},
		set_div: function(data) {
			this.div = data;
		}
}

