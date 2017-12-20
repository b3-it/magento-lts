var _accordionElement = 'div#virtualgeo';  // Element, welches das Accordion representiert
var _map = null;
var _overview = null;
var _epsg = null;
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
        				layers = _layerFunc.call(_epsg);
        				//console.log(layers);
        				view = makeview(_epsg);
        				_map = new ol.Map({
        			        layers: layers,
        			        controls: ol.control.defaults(),
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
        				//_map.addControl(new ol.control.ScaleLine());
        			} else {
            			//alert("rebuild map");
        				view = makeview(_epsg);
            			_map.setView(view);
            			// need to update view on overview map
            			_overview.getOverviewMap().setView(makeview(_epsg));

            			layers = _layerFunc.call(_epsg);
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
