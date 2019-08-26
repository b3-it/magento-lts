function addPages() {
    //var pages = $j('#cms_pages').val() || [];
    var cms_pages = $j('#cms_pages');
    var selected = cms_pages.find('option:selected');
	selected.each(function(){
        nodeOptions.addPage($j(this).val(),$j(this).text());
    });
    nodeOptions.open_all();
}

function isEmptyElement(val) {
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

$j('#jstree_demo').jstree({
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

$j('#jstree_demo').on("changed.jstree", function (e, data) {
	if(data.selected.length) {
		nodeOptions.show(data.instance.get_node(data.selected[0]));
	}
});
$j('#jstree_demo').on("rename_node.jstree", function (e, data) {
	if(data.node) {
		nodeOptions.rename(data.node,data.text);
	}
});
$j('#jstree_demo').on("move_node.jstree", function (e, data) {
	if(data.node) {
		nodeOptions.move(data.node, data.position);
	}
});
$j('#jstree_demo').on("ready.jstree", function (e, data) {
	init_db_nodes();
});






var nodeTemplate = '<div style="display:none" id="node_options_{{number}}" class="hor-scroll">' +
				'<input type="hidden" id="node_options_{{number}}_is_delete" name="node_options[{{number}}][is_delete]" value="" />'+
				'<input type="hidden" name="node_options[{{number}}][id]" value="{{id}}" />'+
				'<input type="hidden" id="node_options_{{number}}_name" name="node_options[{{number}}][label]" value="{{label}}" />'+
				'<input type="hidden" id="node_options_{{number}}_number" name="node_options[{{number}}][number]" value="{{number}}" />'+
				'<input type="hidden" id="node_options_{{number}}_parent" name="node_options[{{number}}][parent]" value="{{parent}}" />'+
				'<input type="hidden" id="node_options_{{number}}_pos" name="node_options[{{number}}][pos]" value="{{pos}}" />'+
				'<input type="hidden" id="node_options_{{number}}_type" name="node_options[{{number}}][type]" value="{{type}}" />'+
				'<input type="hidden" id="node_options_{{number}}_page_id" name="node_options[{{number}}][page_id]" value="{{page_id}}" />'+
				'<input type="hidden" id="node_options_{{number}}_title" name="node_options[{{number}}][title]" value="{{title}}" />'+
				'</div>';



				
var nodeOptions = {
		div_id : "#hidden_navi_menu",
		tree : $j("#jstree_demo"),
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
				var elem = $j("#node_options_"+node.data.number);
				if(elem){
					//elem.show();
				}
			}
			//Element.insert(this.div, {'':this.template.evaluate(data)});
		},
		hideAll : function(){
			for (var i = 1; i <= this.itemCount; i++){
					var elem = $j("#node_options_"+i);
					if(elem.length != 0)
					{
						elem.hide();
					}
			}
		},
		rename : function(node, $text) {
			var elem = $j("#node_options_" + node.data.number + "_name");
			if(elem){
				elem.val($text);
			}
			if(node.data.type = 'page'){
				var elem = $j("#node_options_" + node.data.number + "_title");
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
				var elem = $j("#node_options_" + node.data.number + "_parent");
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
						var elem = $j("#node_options_" + child.data.number + "_pos");
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
				var text = data.label;
				if(data.type == 'page'){
					text = text + " (" + data.title + ")";
				}
				sel = ref.create_node(sel,  {"type":data.type,"data":data, "text" : text});
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
		addPage: function(id, label) {
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
			data.type = 'page';
			data.label = label;
			data.page_id = id;
			data.title = label;
			sel = ref.create_node(sel,  {"type":"page","data":data, "text" : data.label});
			
			this.template = new Template(this.templateText, this.templateSyntax);
			var content = this.template.evaluate(data);
			var html = this.getDiv().html();
			this.getDiv().html( this.getDiv().html() + content);
			
			var node = ref.get_node(sel);
			this.move(node, this.itemCount);
				
			
			return node.id;
			
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
				var elem = $j("#node_options_" + node.data.number + "_is_delete");
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
				if(node.data.type = 'page'){
					var node = ref.get_node(sel);
					var elem = $j("#node_options_" + node.data.number + "_name");
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