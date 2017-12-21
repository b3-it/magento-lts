var _accordionElement = 'div#virtualgeo';  // Element, welches das Accordion representiert
var _map = null;
var _overview = null;
var _epsg = null;

var kachelSource = null;
var kachelVector = null;
var _select = null;

var tools = null;
var selections = null;

var _kachelFinalSource = null;

var myDrawSource = new ol.source.Vector({wrapX: false});
var ol3Parser = new jsts.io.OL3Parser();

/**
* check whether the supplied polygons have any spatial interaction
* @{ol.geometry.Polygon} polygeomA 
* @{ol.geometry.Polygon} polygeomB 
* @returns {Boolean} true||false
*/
function polyIntersectsPoly(polygeomA, polygeomB) {
	var geomA = ol3Parser.read(polygeomA);
	var geomB = ol3Parser.read(polygeomB);
	return geomA.intersects(geomB);
};

function makeview(epsg) {
	pro = ol.proj.get("EPSG:"+ epsg);
	return new ol.View({
	     center: ol.proj.fromLonLat([13.73836, 51.049259], pro),
	     projection: pro,
	     maxZoom: 10,
	     zoom: 6,
	     minZoom: 2
   });
}

function updateKachel(layers)
{
	_kachelFunc(function(k) {
		layers.push(k);
		var selectStyle = new ol.style.Style({
			fill: new ol.style.Fill({
				color: "yellow",
			}),
			stroke: new ol.style.Stroke({
				color: "yellow",
				width: 1
			})
		});
		
		var _kachelFinalCollection = new ol.Collection();
		_kachelFinalSource = new ol.source.Vector({
			features: _kachelFinalCollection
		});

		layers.push(new ol.layer.Vector({
			source: _kachelFinalSource,
			zIndex: k.getZIndex() + 1,
			style: selectStyle
		}));
		
		selections['radio-grid'] = new ol.interaction.Select({
			addCondition: function(e) { return $j("#radio-plus:checked").length > 0;},
			removeCondition: function(e) { return $j("#radio-minus:checked").length > 0;},
			layers: [k],
			features: _kachelFinalCollection,
			style: selectStyle,
			multi: true
		});
		// set default select there
		if (_select === null) {
			_select = selections['radio-grid'];
			_map.addInteraction(_select);
		}
		
	});	
}

function makeSelection(tools) {
	var selections = {};
	var vgidx = 1;
	tools.getLayers().forEach(function (f) {
    	var t = f.get('title');
    	selections['vg_vg' + vgidx]=new ol.interaction.Select({
			addCondition: function(e) { return $j("#radio-plus:checked").length > 0;},
			removeCondition: function(e) { return $j("#radio-minus:checked").length > 0;},
			layers: [f],
			multi: true
		});;
    	vgidx += 1;
    });

	selections['radio-poly'] = new ol.interaction.Draw({
		source: myDrawSource,
		type: "Polygon",
	});
	
	selections['radio-rect'] = new ol.interaction.Draw({
		source: myDrawSource,
		type: "Circle",
		geometryFunction: ol.interaction.Draw.createBox()
	});
	
	[selections['radio-poly'], selections['radio-rect']].forEach(function(draw) {
		draw.on('drawend',function(e){
			var geomA = e.feature.getGeometry();
			var extent = geomA.getExtent();
			var grids = [];
			kachelSource.forEachFeatureInExtent(extent,function(aa){
				if (polyIntersectsPoly(geomA, aa.getGeometry()) === true){
					//names.push(aa.get("GEN"));
					if(grids.indexOf(aa) === -1) {
						//gridsNames.push(aa.get("ID"));
						grids.push(aa);
					}
				}
			});
			var changed = false;
			if (jQuery('#radio-plus:checked').length > 0) {
				grids.forEach(function(grid) {
					if (_kachelFinalSource.getFeatures().indexOf(grid) === -1) {
						_kachelFinalSource.addFeature(grid);
						changed = true;
					}
				});
			} else if (jQuery('#radio-minus:checked').length > 0) {
				grids.forEach(function(grid) {
					if (_kachelFinalSource.getFeatures().indexOf(grid) !== -1) {
						_kachelFinalSource.removeFeature(grid);
						changed = true;
					}
				});
			}
			if (changed) {
			//	_kachelFinalSource.changed();
			}
		});
	});
	return selections;
}

$j(document).ready(function(){
    scanForActiveOptions();

    $j(_accordionElement).accordion({
        'heightStyle': 'content',
        'autoHeight' : false,
        'icons'      : {
            'header'      : 'ui-icon-plus',
            'activeHeader': 'ui-icon-minus'
        },
        'activate': function(event, ui) {
        	if (ui.newPanel.length > 0) {

				if (ui.newPanel.is('#virtualgeo-openlayer')) {
					_epsg = $j("input:checked[name='virtualgeo-components-georef[]']").attr("data-epsg");
					//_epsg = "3857";
					//console.log(_epsg);
        			if (_map == null) {
        				//alert("create map");
        				var layers = _layerFunc.call(_epsg);
        				tools = toolsfunc.call(_epsg);
        			    selections = makeSelection(tools);
        			    
        			    updateKachel(layers, selections);

        				layers.push(tools);
        				//console.log(layers);
        				view = makeview(_epsg);
        				_map = new ol.Map({
        			        layers: layers,
        			        controls: ol.control.defaults({attribution: false}),
        			        target: document.getElementById('virtualgeo-openlayer'),
        			        view: view
        			      })
        				
        				_overview = new ol.control.OverviewMap({view:  makeview(_epsg)});
        				_map.addControl(_overview); // TODO lol? 
        				_map.addControl(new ol.control.ZoomSlider());
        				_layerSwitcher = new ol.control.LayerSwitcher(); 
        			    _map.addControl(_layerSwitcher);
        			    
        			    _map.addControl(new toogleModeCtrl({
        		    		inputName: 'radio-toogleMode',
        		    		className: 'toogleModeCtrl',
        		    		fields: {
        		    			'plus': "+",
        		    			'minus': "-"
        		    		}
        		    	}));
        			    
        			    
        			    fields = {
    			    		'grid': "Grid",
    			    	}
        			    if (tools.getLayers().getLength() > 0) {
            			    var vgidx = 1;
            			    var vgs = { '' : "Tools" }; 
            			    tools.getLayers().forEach(function (f) {
            			    	var t = f.get('title');
            			    	vgs['vg' + vgidx]=t;
            			    	vgidx += 1;
            			    });
            			    fields['vg'] = vgs;
        			    }
        			    fields['poly'] = "Poly";
        			    fields['rect'] = "Rect";
			    		//'own': { '': "Meine Gebiete", 'own1': "Demo1", 'own2': "Demo2" }
        			    
        			    _map.addControl(new toogleModeCtrl({
        			    	inputName: 'radio-toogleSelect',
        			    	className: 'toogleSelectCtrl',
        			    	fields: fields
        			    }));
        			    
        			    $j('input[name=radio-toogleMode]').on('change', function(evt) {
        			    	id = evt.target.id;

        			    	//hotfix
        			    	$j('.toogleModeCtrl > label.ui-button').removeClass('ui-state-active');
        			    	$j('label[for='+id+']').addClass('ui-state-active');
        			    });
        			    
        				//_map.addControl(new ol.control.ScaleLine());
        			    $j('input[name=radio-toogleSelect]').on('change', function(evt) {
        			    	// disable Vg selected
        			    	$j('#select-vg').val('').selectmenu( "refresh" );
        			    	$j('#select-vg-button').removeClass('ui-state-active');
        			    	// only one tool is visible
        			    	tools.getLayers().forEach(function(f) {f.setVisible(false);});

        			    	id = evt.target.id;
        			    	
        			    	//hotfix
        			    	$j('.toogleSelectCtrl > label.ui-button').removeClass('ui-state-active');
        			    	$j('label[for='+id+']').addClass('ui-state-active');
        			    	
        			    	sel = selections[id];
    			    		if (sel !== undefined) {
    			    			_map.removeInteraction(_select);
    			    			_select = sel;
    			    			_map.addInteraction(sel);
    			    		}
        			    	console.log("radio-toogleSelect:  " + id);
        			    });
        			    
        			    
        			    $j('#select-vg').on( "selectmenuchange", function( event, ui ) {
        			    	id = ui.item.element.attr('id');
        			    	idx = id.slice(5);
        			    	
        			    	// only one tool is visible
        			    	tools.getLayers().forEach(function(f) {f.setVisible(false);});
        			    	tools.getLayers().item(idx-1).setVisible(true);
        			    	
        			    	if (id !== undefined) {
        			    		$j('input[name=radio-toogleSelect]').prop( "checked", false ).checkboxradio( "refresh" );
        			    		$j('#select-vg-button').addClass('ui-state-active');
        			    		sel = selections[id];
        			    		if (sel !== undefined) {
        			    			_map.removeInteraction(_select);
        			    			_select = sel;
        			    			_map.addInteraction(sel);
        			    		}
        			    	}
        			    	console.log("selectmenuchange:  " + id);
        			    });
        			} else {
            			//alert("rebuild map");
        				view = makeview(_epsg);
            			_map.setView(view);
            			// need to update view on overview map
            			_overview.getOverviewMap().setView(makeview(_epsg));

            			var layers = _layerFunc.call(_epsg);

        				var tools = toolsfunc.call(_epsg);
        			    selections = makeSelection(tools);
        			    
        			    updateKachel(layers);
            			
        				layers.push(tools);
            			// use this to add new Layers
            			_map.getLayerGroup().setLayers(layers);
        			}
        			//console.log(_map.getView().getProjection());
        		}
    		}

        	//console.log(ui);
            // wird aktiviert
        },
        'beforeActivate': function(event, ui) {
        	if (ui.newPanel.length > 0) {
        		if (ui.newPanel.is('#virtualgeo-openlayer') && _map != null) {
        			//clean map of layers
        			//_layerSwitcher.setMap(null);
        			_map.getLayers().clear();
        			if (_kachelFinalSource !== null) {
            			_kachelFinalSource.clear();        				
        			}
        			if (_select !== null) {
        				_map.removeInteraction(_select);        				
        			}
        			_select = null;
        			//alert("clean map");
        			
        			//_map.setView(null);
        		}
        	}
        }
    });

    $j(_accordionElement + ' input[type="radio"]').on('click', function(event){
        setOptionForTitle( $j(this) );
    });
});

/**
 * Alle vorausgewählten Options-Felder suchen
 * Funktion wird ausgeführt, wenn die Seite komplett geladen wurde
 */
function scanForActiveOptions()
{
    $j(_accordionElement + ' input:checked').each(function(index, element){
        setOptionForTitle( $j(element) );
    });
}

/**
 * Titel des Accordions mit der gewählten Option ergänzen
 * @param   element   Sender, welcher ausgewählt wurde
 */
function setOptionForTitle(sender)
{
    if ( sender.attr('data-shortname').length ) {
        var _append = ' (' + sender.attr('data-shortname') + ')';
    }
    else {
        var _append = '';
    }

    $j('#title-' + sender.attr('data-id') ).html(
        strPrefixSelected + ' ' + sender.attr('data-name') + _append
    );
}
