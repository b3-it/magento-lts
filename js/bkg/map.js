(function($, window, document){
	var instanceName = "openLayer";
	
	/**
	 * Plugin bei jQuery registrieren
	 */
	$.fn.openLayer = function(options) {
		var container = $(this);

		if (!container.data(instanceName)) {
			options = $.extend({}, $.fn.openLayer.options, options);
			var instance = new openLayer(container, options);
			container.data(instanceName, instance);
			return instance;
		}

		return container.data(instanceName);
    }

	var openLayer = function(container, options) {
		/**
		 * Initialisierung aller Eigenschaften
		 */
		this.options = options;
		this.container = container;
		
        this._init();
	};
    
	openLayer.prototype = {
	    /**
         * Initial-Funktion
         */
        '_init': function() {
			//console.log(this.container);
			var thisMap = null;
			undefinedHTML = 'outside';
			
			this.mousePosition = new ol.control.MousePosition({
				undefinedHTML: undefinedHTML,
				projection: 'EPSG:4326',
				coordinateFormat: function(coordinate) {
					// get pixel from coordinate
					pixel = thisMap.getPixelFromCoordinate(coordinate);
					
					// pixel is outside, that might happen for controls outside of the map
					if (pixel[0] <= 0 || pixel[1] <= 0) {
						return undefinedHTML;
					}
					coordinate = ol.proj.toLonLat(coordinate);
					return ol.coordinate.format(coordinate, '{x}, {y}', 4);
				}
			});
			
			var controls = ol.control.defaults({attribution: false}).extend([
				new ol.control.ScaleLine(),
				new ol.control.Attribution(),
				this.mousePosition,
				//new ol.control.OverviewMap({
				//	collapsed: false
				//}),,
				//new ol.control.Zoom(),
				new ol.control.ZoomSlider(),
				//new ol.control.ZoomToExtent(),
				//new ol.control.FullScreen()
			]);
			
			proj = this.options.proj || 'EPSG:3857';
			var newProj = ol.proj.get(proj);
		
			this.map = thisMap = new ol.Map({
				target: this.container.get(0),
				controls: controls,
				view: this.__createView(newProj)
			});
			this.mousePosition.setProjection(newProj);
			
			return this.map;
		},
		
		'__createView': function(proj) {
			return new ol.View({
				  center: ol.proj.transform([13.44, 51.01],'EPSG:4326' , proj),
				  //center: [cx, cy],
				  //center: [13.44, 51.01],
				  zoom: 8,
				  projection: proj
			});
		},

		/**
		 * URL öffnen
		 */
		'addVector': function(source, style, visible) {
			
			var vec = new ol.layer.Vector({
				source: source,
				style: style,
				visible: visible == undefined ? true : visible
			});
			this.map.addLayer(vec);
			return vec;
		},
		
		'addTile': function(source, visible) {
			var lay = new ol.layer.Tile({
				source: source,
				visible: visible == undefined ? true : visible
			});
			this.map.addLayer(lay);
			return lay;
		},
		
		'addInteraction': function(inter) {
			this.map.addInteraction(inter);
		},
		'removeInteraction': function(inter) {
			this.map.removeInteraction(inter);
		},
		'addOverlay': function(overlay) {
			this.map.addOverlay(overlay);
		},
		'getOverlays': function() {
			return this.map.getOverlays();
		},
		
		'getMap': function() {
			return this.map;
		},
		'getView': function() {
			return this.map.getView();
		},
		'setView': function(proj) {
			// get Projection object from name
			newProj = ol.proj.get(proj);

			// check if projection is the same as before,
			// if yes no need to update
			if (ol.proj.equivalent(this.map.getView().getProjection(), newProj)) {
				return;
			}
			
			// update view with new projection
			this.map.setView(this.__createView(newProj));
			
			// update projection in the mouse Position control
			// otherwise the coordinates check there does not work anymore
			this.mousePosition.setProjection(newProj);
			
			// update layers
			this.map.getLayers().forEach(function(l) {
				s = l.getSource();
				if (s instanceof ol.source.Vector) {
					// need to clear the vector to cause a reload of the data
					// true param to make it even more faster
					s.clear(true);
				}
			});
		},
		'addControl': function(control) {
			this.map.addControl(control);
		}
	}

	window.openLayer = openLayer;

})(jQuery, window, document);