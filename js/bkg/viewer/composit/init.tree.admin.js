function addPages() {
	var form_data = {};

	form_data['is_checked'] = $j('#layerForm_Name_is_checked').is(':checked');
	form_data['is_readonly'] = $j('#layerForm_Name_is_readonly').is(':checked');


	form_data['permanent'] = $j('#permanent').is(':checked');
    form_data['is_checked'] = $j('#is_checked').is(':checked');
    //form_data['entity_layer'] = $j('#entity_layer').is(':checked');
    form_data['visual_pos'] = $j('#visual_pos').val();
    form_data['title'] = $j('#layer_title').val();

    var service_layers = $j('#service_layers');
    var selected = service_layers.find('option:selected');
	selected.each(function(){
		form_data['layer_name'] = $j(this).text();
        nodeOptions.addPage($j(this).val(),$j('#layer_title').val(),form_data);
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
	    "types",  "dnd"
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
		nodeOptions.reorder('j1_1',0);
	}
});

$j('#jstree_layer').on("ready.jstree", function (e, data) {
	init_db_nodes();
});




var nodeOptions = {
		div_id : "#hidden_navi_menu",
		PostDataId : 'node_options',
		PostDataName : 'node_options',
		tree : $j("#jstree_layer"),

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
			var data = this.getPostData(node.data.number);
			data['title'] = $text;
			this.setPostData(data);

//			var elem = $j("#node_options_" + node.data.number + "_name");
//			if(elem){
//				elem.val($text);
//			}
//			if(node.data.type = 'page'){
//				var elem = $j("#node_options_" + node.data.number + "_title");
//				node.text = node.text + " ("+elem.val()+")";
//				var ref = this.tree.jstree(true);
//				ref.redraw(true);
//			}
		},
		move : function(node, pos) {
			if(node) {
				var ref = this.tree.jstree(true);
				var parent = ref.get_node(node.parent);
				//var pos = 0;
				for(var childId in parent.children){
					var child = ref.get_node(parent.children[childId]);
					if(child) {
						var data = this.getPostData(child.data.number);
	                   	if(parent.data != null)
	                   	{
	                   		child.data.parent_number = parent.data.number;
	                   		data['parent_number'] = parent.data.number;
	                   	}
	                   	else{
                            child.data.parent_number = 0;
                            data['parent_number'] = 0;
						}
						child.data.pos = pos;

						this.setPostData(data);
					}
				}
			}
		},
		reorder : function(nodeId, pos)
		{
			pos++;
	        var ref = this.tree.jstree(true);
	        var node = ref.get_node(nodeId);
	        if(node.data != null) {
	            node.data.pos = pos;
	            var data = this.getPostData(node.data.number);
	            data['pos'] = pos;
				this.setPostData(data);
	        }
	        for(var childId in node.children){

	        	var child = ref.get_node(node.children[childId]);
	        	if(child){
	        		pos = this.reorder(node.children[childId], pos);
	        	}
	        }
			return pos;
		},

		add: function(data, sel) {
				var ref = this.tree.jstree(true);
				var edit = false;

				this.itemCount++;
				if(!sel) {
					var	sel = ref.get_selected();
					if(!sel.length) {
						//alert( element_not_selected );
						//return false;
						sel =  ref.get_node('j1_1');
					}else {
						sel = sel[0];
						ref.open_node(sel);
						edit = true;
					}
				}
				else if(sel == 'root') {
					sel =  ref.get_node('j1_1');
				}

				if(!data){
					var data = new Object();
					data.name = 'default';
					data.layer_label = element_default_title;
					data.type = "default"
				}
				data.number = this.itemCount;

				sel = this.createTextNode(sel,data);
				if(sel && edit) {
					ref.edit(sel);
				}

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
			data.type = 'page';

			data.serviceLayer = id;
			data.title = label;
			data.visual_pos = input_data.visual_pos;
			data.layer_name = input_data.layer_name;
			data.permanent = input_data.permanent;
			data.is_checked = input_data.is_checked;

			sel = this.createTextNode(sel, data);


			var node = ref.get_node(sel);
			this.move(node, this.itemCount);
			this.reorder('j1_1',0);
            this.open_all();
			return node.id;

		},
		createTextNode: function(parent,data)
		{
			var ref = this.tree.jstree(true);
			var text = data.title;
			if(data.type == 'page'){

				text += '<div class="tree-options">';
				text += '<div class="inline-tree-cell option-tree-name">'+ data.layer_name+'</div>';
				text += '<div class="inline-tree-cell option-tree-position">'+ data.visual_pos+'</div>';
				text += '<div class="inline-tree-cell option-tree-' + (data.permanent ? 'true' : 'false') + ' option-readonly"></div>';
				text += '<div class="inline-tree-cell option-tree-' + (data.is_checked ? 'true' : 'false') + ' option-checked"></div>';
				text += '</div>';
				//text = text + "<span style=\"text-align:right;\" ><span>  | " + data.layer_name + " | "+data.visual_pos+"</span></span>" ;
			}
			data['parent_number'] = 0;
			data['deleted'] = false;
			if(parent.data != null)
			{
				data['parent_number'] = parent.data.number;
			}
			var sel = ref.create_node(parent,  {"type":data.type,"data":data, "text" : text});
			this.setPostData(data);
			return sel;
		},
		setPostData:function (nodeData)
	    {
	        var input = $j('#'+ this.PostDataId+'_' + nodeData.number);
	        if(input.length > 0)
	        {
	        	input.val(JSON.stringify(nodeData));
	        }
	        else
	        {
				var inputField = $j('<input />', {
		            'id'   : this.PostDataId+'_' + nodeData.number,
		            'name' : this.PostDataName+'[' + nodeData.number + ']',
		            'value': JSON.stringify(nodeData),
		            'type' : 'hidden',
		            'width' : '600px'
		        });
		        $j('#jstree-data').append(inputField);
	        }
	    },
		getPostData:function (number)
		{
			var data = JSON.parse($j('#'+this.PostDataId+'_' + number).val());
			return data;
		},
		remove: function(data) {
				//this.hideAll();
				var ref = this.tree.jstree(true);
				var	sel = ref.get_selected();
				if(!sel.length) {
					alert(node_element_is_null);
					return false;
				}
				var node = ref.get_node(sel);

				//Delete Flag setzten
		        var data = this.getPostData(node.data.number);
		        data['deleted'] = true;
		        this.setPostData(data);

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
					//var node = ref.get_node(sel);
					//var elem = $j("#node_options_" + node.data.number + "_name");
					//node.text = elem.val();
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
