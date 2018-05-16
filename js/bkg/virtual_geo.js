var _accordionElement = 'div#virtualgeo';  // Element, welches das Accordion representiert
var _map = null;
var _overview = null;
var _epsg = null;

var kachelSource = null;
var kachelVector = null;
var _select = null;

var tools = null;
var shapes = null;
var selections = null;

var _kachelFinalSource = null;

var selectionCtrl = null;

var intersectionCache = {};

var myDrawSource = new ol.source.Vector({wrapX: false});
var ol3Parser = new jsts.io.OL3Parser();

var ol3DrawGeo = null;

var finalDrawFeature = null; 
var finalDrawSource = null;

// fix for the animation thing
var mapClosed = true;
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


//Testing API for Virtual Geo

/**
 * List of Tiles that can be selected 
 * @returns Array.<ol.Feature>
 */
function getAvailableTiles() {
    return kachelSource === null ? [] : kachelSource.getFeatures();
}

/**
 * List of Tiles that are selected
 * @returns Array.<ol.Feature>
 */
function getSelectedTiles() {
    return _kachelFinalSource === null ? [] : _kachelFinalSource.getFeatures();
}

/**
 * Select the tiles with the given ids
 * @param Array.<id>
 */
function selectTiles(ids) {
	addGridSelection(ids);
}

/**
 * Unselect the tiles with the given ids
 * @param Array.<id>
 */
function removeTiles(ids) {
	removeGridSelection(ids);
}



/**
 * Returns list of Layer that can be used as Tools
 * @returns Array.<ol.layer.Vector>
 */
function getAvailableTools() {
    return tools == null ? [] : tools.getLayers().getArray();
}

/**
 * Returns array of Features for the given ToolLayer
 * @param ol.layer.Vector toolLayer
 * @returns Array.<ol.Feature>
 */
function getFeaturesByTool(toolLayer) {
	return toolLayer == null ? [] : toolLayer.getSource().getFeatures();
}

/**
 * Selects Tiles with using the features of the given Tool Layer
 * @param ol.layer.Vector toolLayer
 * @param Array.<ol.Feature> features
 */
function selectWithTool(toolLayer, features) {
	getIntersectionTool(toolLayer, features, addGridSelection);
}
/**
 * Unselects Tiles with using the features of the given Tool Layer
 * @param ol.layer.Vector toolLayer
 * @param Array.<ol.Feature> features
 */
function removeWithTool(toolLayer, features) {
	getIntersectionTool(toolLayer, features, removeGridSelection);
}

function incLoading(e) {
	// map is not visible, don't show loading overlay
	if (!$j('#virtualgeo-openlayer').is(":visible") || mapClosed) {
		return;
	}
	//console.log("incLoading");
	$j('#virtualgeo-openlayer').LoadingOverlay("show");
}

function decLoading() {
	//console.log("decLoading");
	$j('#virtualgeo-openlayer').LoadingOverlay("hide");
}

function stopLoading() {
	//console.log("stopLoading");
	$j('#virtualgeo-openlayer').LoadingOverlay("hide", true);
}

function cleanupMap() {
	if (_map === null) {
		return false;
	}
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

	// disable selectmenu selected
	$j('.toogleSelectCtrl > select').val('').selectmenu( "refresh" );
	$j('.toogleSelectCtrl > .ui-selectmenu-button').removeClass('ui-state-active');
	
	//_map.setView(null);
}
function makeDrawLayer() {
	finalDrawFeature = new ol.Feature(); 
	finalDrawSource = new ol.source.Vector({
		features: [finalDrawFeature],
		wrapX: false
	});
	return new ol.layer.Vector({
		source: finalDrawSource,
		zIndex: kachelZIndex + 2,
		style: selectStyle
	});
}

function updateHiddenKachel() {
	if (kachelSource == null || _kachelFinalSource == null) {
		return;
	}
	d=[];
	_kachelFinalSource.forEachFeature(function(f) {
		d.push(f.getId());
	});
	$j('#hiddenkachel').val(d.join());
}

function updateKachel(layers)
{
	_kachelFunc(function(k) {
		layers.push(k);
		
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

		selections['radio-grid'].on('select', function(e) {
			updateHiddenKachel();
		});

		// set default select there
		if (_select === null) {
			_select = selections['radio-grid'];
			_map.addInteraction(_select);
		}
		
	});	
}

function buildSelectionCtrl(lools, shapes) {

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
    if (shapes.getLayers().getLength() > 0) {
    	var sidx = 1;
	    var shapes_fields = { '' : "Shapes" }; 
	    shapes.getLayers().forEach(function (f) {
	    	var t = f.get('title');
	    	shapes_fields['shape' + sidx]=t;
	    	sidx += 1;
	    });
    	fields['shapes'] = shapes_fields;
    }
    fields['poly'] = "Poly";
    fields['rect'] = "Rect";
	//'own': { '': "Meine Gebiete", 'own1': "Demo1", 'own2': "Demo2" }
    
    return new toogleModeCtrl({
    	inputName: 'radio-toogleSelect',
    	className: 'toogleSelectCtrl',
    	fields: fields
    });
}

function removeGridSelection(gids) {
	if (!kachelSource || !_kachelFinalSource) {
		return;
	}
	var removeGrids = [];
	gids.forEach(function(gid) {
		g = kachelSource.getFeatureById(gid);
		if(g !== null && removeGrids.indexOf(g) === -1) {
			removeGrids.push(g);
		}
	});

	removeGrids.forEach(function(grid) {
		if (_kachelFinalSource.getFeatures().indexOf(grid) !== -1) {
			_kachelFinalSource.removeFeature(grid);
		}
	});
}

function addGridSelection(gids) {
	if (!kachelSource || !_kachelFinalSource) {
		return;
	}
	addGrids = [];
	gids.forEach(function(gid) {
		g = kachelSource.getFeatureById(gid);
		if(g !== null && addGrids.indexOf(g) === -1) {
			addGrids.push(g);
		}
	});

	if ($j('#radio-plus:checked').length > 0) {
		// doesn't crash if ti has id
		_kachelFinalSource.addFeatures(addGrids);
	} else if ($j('#radio-minus:checked').length > 0) {
		addGrids.forEach(function(grid) {
			if (_kachelFinalSource.getFeatures().indexOf(grid) !== -1) {
				_kachelFinalSource.removeFeature(grid);
			}
		});
	}
}

function getIntersectionTool(t, v, func) {
	// prevent from crashing
	if (!kachelSource || !_kachelFinalSource || !kachelVector) {
		handleGeometry(v.getGeometry());
		return;
	}
	var lid = t.get('layer_id');
	var kid = kachelVector.get('layer_id');
	
	// FIXME use epsg for now
	var sid = $j("input:checked[data-id='virtualgeo-components-georef']").attr('data-epsg');
	var vid = v.getId();
	
	// some layer use attribute code, this might not be used as ID because not uniqness,
	// for this need to check if the source has a attribute name to use
	var an = t.getSource().get('attributeName');
	if (an !== undefined) {
		vid = v.get(an);
	}
	

	var cachekey = 'layer'+ lid + "_" + kid + "_" + sid + "_" + vid;
	
	if (intersectionCache[cachekey] !== undefined) {
		func.call(null, intersectionCache[cachekey]);
		return;
	}
	
	url = baseUrl + "index.php/virtualgeo/map/intersectGeometry/select/" + lid + "/target/" + kid + "/srs/" + sid + "/id/" + vid;
	$j.ajax(url, {
		beforeSend: incLoading,
		complete: decLoading,
		success: function(data) {
			if (vid !== undefined) {
				intersectionCache[cachekey] = data;
			}
			func.call(null, data);
		}
	});
}

function getIntersectionShape(t, v, func) {

	var lid = t.get('layer_id');
	var kid = kachelVector.get('layer_id');
	
	// TODO there add JS cache?
	var cachekey = 'shape'+ lid + "_" + kid;

	if (intersectionCache[cachekey] !== undefined) {
		func.call(null, intersectionCache[cachekey]);
		return;
	}

	url = baseUrl + "index.php/shapefile/file/shapeIntersection/id/" + lid + "/layer/" + kid;
	$j.ajax(url, {
		success: function(data) {
			func.call(null, data[v.getId()]);
		}
	});
	
}

function baseSelection(lay, func) {
	var sel = new ol.interaction.Select({
		// dont use Condition there, need to differ in the select event
		/*
		addCondition: function(e) { return $j("#radio-plus:checked").length > 0;},
		removeCondition: function(e) { return $j("#radio-minus:checked").length > 0;},
		//*/
		layers: [lay],
		multi: true
	});
	sel.on('select', function(e) {
		var removeGrids = [];
		var addGrids = [];

		e.deselected.forEach(function(vec) {
			func.call(null, lay, vec, removeGridSelection);
		});

		e.selected.forEach(function(vec) {
			func.call(null, lay, vec, addGridSelection);
		});

		e.target.getFeatures().clear();
		updateHiddenKachel();
	});
	return sel;
}

function updateHiddenGeometry() {
	var wkt = new jsts.io.WKTWriter();
	$j('#hiddenwkt').val(wkt.write(ol3DrawGeo));
}
//
function handleGeometry(geomA) {
	//finalDrawSource.clear();
	
	// Currently it does crash on Self Intersecting geometries and i can't check that
	
	if ($j('#radio-plus:checked').length > 0) {
		var geoRead = ol3Parser.read(geomA);
		ol3DrawGeo = ol3DrawGeo == null ? geoRead : ol3DrawGeo.union(geoRead);
		finalDrawFeature.setGeometry(ol3Parser.write(ol3DrawGeo));
		updateHiddenGeometry();
	} else if ($j('#radio-minus:checked').length > 0) {
		if (ol3DrawGeo != null) {
			var geoRead = ol3Parser.read(geomA);
			ol3DrawGeo = ol3DrawGeo.difference(geoRead);
			finalDrawFeature.setGeometry(ol3Parser.write(ol3DrawGeo));
			updateHiddenGeometry();
		}
	}
}

function makeSelection(tools, shapes) {
	var selections = {};
	var vgidx = 1;
	tools.getLayers().forEach(function (f) {
    	selections['vg_vg' + vgidx]= baseSelection(f, getIntersectionTool);
    	vgidx += 1;
    });
	var sidx = 1;
	if (shapes != null) {
		shapes.getLayers().forEach(function (f) {
	    	selections['shapes_shape' + sidx]= baseSelection(f, getIntersectionShape);
	    	sidx += 1;
	    });
	}

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
			
			if (kachelSource == null) {
				//console.log(geomA);
				handleGeometry(geomA);
				
				return;
			}
			
			// TODO add what to do when kachelSource is null
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
			if ($j('#radio-plus:checked').length > 0) {
				// Crasht nicht mehr?
				_kachelFinalSource.addFeatures(grids);
				/*
				 grids.forEach(function(grid) {
					if (_kachelFinalSource.getFeatures().indexOf(grid) === -1) {
						_kachelFinalSource.addFeature(grid);
						changed = true;
					}
				});
				//*/
			} else if ($j('#radio-minus:checked').length > 0) {
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
			updateHiddenKachel();
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
					_epsg = $j("input:checked[data-id='virtualgeo-components-georef']").attr("data-epsg");
					//_epsg = "3857";
					//console.log(_epsg);
        			if (_map == null) {
        				//alert("create map");
        				var layers = _layerFunc.call(null, _epsg);
        				tools = toolsfunc.call(null, _epsg);
        				shapes = shapesfunc.call(null, _epsg);
        			    selections = makeSelection(tools, shapes);
        			    
        			    updateKachel(layers);

        				layers.push(tools);
        				layers.push(shapes);

        				layers.push(makeDrawLayer());
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
        			    
        			    selectionCtrl = buildSelectionCtrl(tools, shapes);
        			    
        			    _map.addControl(selectionCtrl);
        			    
        			    $j('input[name=radio-toogleMode]').on('change', function(evt) {
        			    	id = evt.target.id;

        			    	//hotfix
        			    	$j('.toogleModeCtrl > label.ui-button').removeClass('ui-state-active');
        			    	$j('label[for='+id+']').addClass('ui-state-active');
        			    });
        			    
        				//_map.addControl(new ol.control.ScaleLine());
        			    $j('#virtualgeo-openlayer').on('change', 'input[name=radio-toogleSelect]', function(evt) {
        			    	// disable selectmenu selected
    			    		$j('.toogleSelectCtrl > select').val('').selectmenu( "refresh" );
    			    		$j('.toogleSelectCtrl > .ui-selectmenu-button').removeClass('ui-state-active');
        			    	// only one tool is visible
        			    	tools.getLayers().forEach(function(f) {f.setVisible(false);});

        			    	id = evt.target.id;
        			    	console.log(id);
        			    	
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
        			    
        			    $j('#virtualgeo-openlayer').on("selectmenuchange", '#select-shapes', function( event, ui ) {
        			    	id = ui.item.element.attr('id');
        			    	tools.getLayers().forEach(function(f) {f.setVisible(false);});
        			    	if (shapes != null) {
        			    		shapes.getLayers().forEach(function(f) {f.setVisible(false);});
        			    	}
        			    	if (id !== undefined) {
        			    		idx = id.slice(12);
        			    		var t = shapes.getLayers().item(idx-1);
        			    		t.setVisible(true);

        			    		$j('input[name=radio-toogleSelect]').prop( "checked", false ).checkboxradio( "refresh" );
        			    		$j('.toogleSelectCtrl > .ui-selectmenu-button').removeClass('ui-state-active');
        			    		
        			    		$j('.toogleSelectCtrl > select[id!=select-shapes]').val('').selectmenu( "refresh" );
        			    		
        			    		$j('#select-shapes-button').addClass('ui-state-active');
	        			    	sel = selections[id];
	    			    		if (sel !== undefined) {
	    			    			_map.removeInteraction(_select);
	    			    			_select = sel;
	    			    			_map.addInteraction(sel);
	    			    		}
        			    	}
        			    	console.log("selectmenuchange:  " + id);
        			    });
        			    
        			    $j('#virtualgeo-openlayer').on( "selectmenuchange", '#select-vg', function( event, ui ) {
        			    	id = ui.item.element.attr('id');
        			    	// only one tool is visible, or no one
        			    	tools.getLayers().forEach(function(f) {f.setVisible(false);});
        			    	if (shapes != null) {
        			    		shapes.getLayers().forEach(function(f) {f.setVisible(false);});
        			    	}
        			    	
        			    	//intersection = null;
        			    	
        			    	if (id !== undefined) {
        			    		idx = id.slice(5);
        			    		var t = tools.getLayers().item(idx-1);
        			    		t.setVisible(true);
            			    	
        			    		var lid = t.get('layer_id');
        			    		var kid = kachelVector.get('layer_id');
        			    		var sid = $j("input:checked[data-id='virtualgeo-components-georef']").val();
        			    		
        			    		$j('input[name=radio-toogleSelect]').prop( "checked", false ).checkboxradio( "refresh" );
        			    		$j('.toogleSelectCtrl > .ui-selectmenu-button').removeClass('ui-state-active');
        			    		
        			    		$j('.toogleSelectCtrl > select[id!=select-vg]').val('').selectmenu( "refresh" );
        			    		
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

            			var layers = _layerFunc.call(null, _epsg);

        				tools = toolsfunc.call(null, _epsg);
        				shapes = shapesfunc.call(null, _epsg);
        				// TODO need to update the shape selection
        			    selections = makeSelection(tools, shapes);
        			    
        			    if (selectionCtrl != null) {
        			    	_map.removeControl(selectionCtrl);
        			    }
        			    
        			    selectionCtrl = buildSelectionCtrl(tools, shapes);
        			    _map.addControl(selectionCtrl);
        			    
        			    updateKachel(layers);
            			
        				layers.push(tools);
        				layers.push(shapes);

        				layers.push(makeDrawLayer());
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
        	if (ui.oldPanel.length > 0) {
        		if (ui.oldPanel.is('#virtualgeo-openlayer')) {
        			mapClosed = true;
        			stopLoading();
        			cleanupMap();
        		}
        	}
        	if (ui.newPanel.length > 0) {
        		if (ui.newPanel.is('#virtualgeo-openlayer')) {
        			cleanupMap();
        			mapClosed = false;
        		}
        	}
        }
    });

    $j(_accordionElement + ' input[type="radio"]').on('click', function(event){
        setOptionForTitle( $j(this) );
    });
    
    $j(_accordionElement + " input[data-id='virtualgeo-components-structure']").on('change', function(event){
    	// the structure doesn't want to show map
    	// add state disabled to the h3 to disable the tab
    	// disabled tabs can't open so no need to capture beforeActivate
    	$j('#virtualgeo-openlayer').prev("h3").toggleClass('ui-state-disabled', $j(event.target).attr("data-show-map") === '0');
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
