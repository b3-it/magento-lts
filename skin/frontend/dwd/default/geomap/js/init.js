OpenLayers.Lang.setCode('de');

var map, zoom, georss, layer, marker_aktuell, arrayOSM;

arrayOSM = [
            "http://a.tile.openstreetmap.org/${z}/${x}/${y}.png",
            "http://b.tile.openstreetmap.org/${z}/${x}/${y}.png",
            "http://c.tile.openstreetmap.org/${z}/${x}/${y}.png"
           ];

var proj4326  = new OpenLayers.Projection("EPSG:4326");
var projmerc  = new OpenLayers.Projection("EPSG:900913");
var extentGer = new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34);

var size_1 = new OpenLayers.Size(10, 10);
var size_2 = new OpenLayers.Size(22, 22);

var lon = 10.1279688;
var lat = 51.5077286;

var marker_1 = new OpenLayers.Icon(marker_klein, size_1);
var marker_2 = new OpenLayers.Icon(marker_gross, size_2);

zoom = 6;

marker_aktuell = marker_klein;

map = new OpenLayers.Map('map', {
          controls : [
                       new OpenLayers.Control.KeyboardDefaults(),
                       new OpenLayers.Control.PanZoomBar(),
                       new OpenLayers.Control.MousePosition(),
                       new OpenLayers.Control.Attribution(),
                       new OpenLayers.Control.Navigation(),
                       new OpenLayers.Control.ScaleLine()
                     ],
          maxExtent        : extentGer,
          maxResolution    : 156543,
          units            : 'meters',
          projection       : projmerc,
          displayProjection: proj4326
      });

//layer = new OpenLayers.Layer.OSM.Mapnik('Mapnik');
layer = new OpenLayers.Layer.OSM("MapQuest-OSM Tiles", arrayOSM);

georss = new OpenLayers.Layer.GeoRSS( 'GeoRSS',
		                              rssUrl,
                                      {
                                        'projection'         : proj4326,
                                        'internalProjection' : proj4326,
                                        'externalProjection' : proj4326,
                                        'visibility'         : true,
                                        'icon'               : marker_1
                                      }
                                    );

map.addLayers([layer, georss]);
map.events.register( 'moveend', map, handleZoom );

setCenter( lon, lat, zoom );