(function($, window, document) {
	var instanceName = "geomap";

	/**
	 * Plugin bei jQuery registrieren
	 */
	$.fn.geomap = function(options) {
		var container = $(this);

		if (!container.data(instanceName)) {
			options = $.extend({}, $.fn.geomap.options, options);
			var instance = new geomap(container, options);
			container.data(instanceName, instance);
			return instance;
		}

		return container.data(instanceName);
	}

	/**
	 * Optionen setzen
	 */
	$.fn.geomap.options = {
		'markerBig' : SKIN_PATH + 'geomap/images/map2_point4.png',
		'markerSmall' : SKIN_PATH + 'geomap/images/map2_point4.gif',
		'jsonUrl' : '',
		'tileUrl' : 'https://{a-c}.tile.openstreetmap.org/{z}/{x}/{y}.png',
		'extent' : [],
		'mapProjection' : 'EPSG:900913',
		'cordProjection' : 'EPSG:4326',
		'zoomThreadhold' : 8,
		'overlayDataLink' : 'Station auswählen',
		'overlayDataTitle' : 'Station: <span></span>',
		'overlayData' : '<div class="olPopupContent"><div class="olLayerGeoRSSTitle"></div><div class="olLayerGeoRSSDescription"><span class="olMapClickLink"></span></div></div>'

	}

	var geomap = function(container, options) {
		/**
		 * Initialisierung aller Eigenschaften
		 */
		this.options = options;
		this.container = container;

		this.styleImageBig = new ol.style.Style({
			'image' : new ol.style.Icon({
				'src' : options.markerBig
			})
		});
		this.styleImageSmall = new ol.style.Style({
			'image' : new ol.style.Icon({
				'src' : options.markerSmall
			})
		});
		plugin = this;
		this.jsonStyleFunction = function(feature, resolution) {
			zoom = plugin.map.getView().getZoom();
			threadhold = plugin.options.zoomThreadhold;

			return zoom <= threadhold ? plugin.styleImageSmall
					: plugin.styleImageBig;
		};

		this._init();
	};

	geomap.prototype = {
		/**
		 * Initial-Funktion
		 */
		'_init' : function() {
			plugin = this;
			controls = ol.control.defaults({
				zoom : false
			}).extend([ new olpz.control.PanZoom({
				imgPath : SKIN_PATH + 'geomap/js/img',
				slider : true
			// enables the slider
			}), new ol.control.MousePosition({
				coordinateFormat : ol.coordinate.createStringXY(4),
				projection : this.options.cordProjection
			}), new ol.control.ScaleLine ]);

			this.mapLayer = new ol.layer.Tile({
				source : new ol.source.OSM({
					attributions : [ ol.source.OSM.ATTRIBUTION ],
					url : this.options.tileUrl
				})
			});
			
			this.jsonLayer = new ol.layer.Vector({
				source : jsonSource = new ol.source.Vector({
					url : this.options.jsonUrl,
					format : new ol.format.GeoJSON()
				}),
				style : this.jsonStyleFunction
			});

			// after loading of the GeoJSON, set the extent of the map to the extent of the sources
			// currently with 1% of the Height Buffer
			this.jsonLayer.once("change", function(e) {
				var oldExtent = e.target.getSource().getExtent();
				var buffer = ol.extent.getHeight(oldExtent) / 100;
				var newExtent = ol.extent.buffer(oldExtent, buffer);
				plugin.mapLayer.setExtent(newExtent);
			});

			this.jsonOverlay = new ol.Overlay.Popup();

			this.map = new ol.Map({
				target : this.container.get(0),
				controls : controls,
				layers : [ this.mapLayer, this.jsonLayer ],
				overlays : [ this.jsonOverlay ],
				view : new ol.View({
					maxZoom : 14,
					projection : this.options.mapProjection,
					center : ol.proj.transform([ 10.44, 51.01 ],
							this.options.cordProjection,
							this.options.mapProjection),
					zoom : 6.5,
					minZoom : 6,
				// extent : extent
				})
			});

			this.select = new ol.interaction.Select({
				layers : [ this.jsonLayer ],
				toggleCondition : ol.events.condition.never,
				multi : false
			});

			this.select.on('select', function(e) {
				features = e.target.getFeatures();
				if (features.getLength() <= 0) {
					return;
				}
				feature = features.item(0);

				element = $j(plugin.options.overlayData);
				element.find(".olLayerGeoRSSTitle").html(
						plugin.options.overlayDataTitle);
				element.find(".olLayerGeoRSSTitle > span").html(
						feature.get("name"));
				element.find(".olMapClickLink").attr("onclick",
						"selectMapStation(" + feature.get("id") + ");").html(
						plugin.options.overlayDataLink);

				plugin.jsonOverlay.show(feature.getGeometry()
						.getFirstCoordinate(), element.html());
			});

			this.map.addInteraction(this.select);

			this.map.on('pointermove', function(e) {
				if (e.dragging) {
					// $j(e).popover('destroy');
					return;
				}
				var pixel = plugin.map.getEventPixel(e.originalEvent);
				var hit = plugin.map.hasFeatureAtPixel(pixel);
				plugin.map.getTarget().style.cursor = hit ? 'pointer' : '';
			});
			
			this.jsonOverlay.closer.addEventListener('click', function(evt) {
				plugin.select.getFeatures().clear();
			});
			
			//'ol-popup-closer'
		},
		'overlayClose' : function() {
			this.jsonOverlay.hide();
			this.select.getFeatures().clear();
			return false;
		}
	};
	window.geomap = geomap;

})(jQuery, window, document);