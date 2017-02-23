var panZoom = new ol.control.PanZoom({
  imgPath: SKIN_PATH + 'geomap/js/img',
  slider: true // enables the slider
}); 

var mapLayer = new ol.layer.Tile({
    source: new ol.source.OSM({
      attributions: [
        ol.source.OSM.ATTRIBUTION
      ],
      url: "http://{a-c}.tile.openstreetmap.org/{z}/{x}/{y}.png"
    })
  });

var jsonSource = new ol.source.Vector({
    url: jsonUrl,
    format: new ol.format.GeoJSON()
});

var imageBig   = new ol.style.Style({ 'image' : new ol.style.Icon({'src': marker_gross}) });
var imageSmall = new ol.style.Style({ 'image' : new ol.style.Icon({'src': marker_klein}) });

jsonStyleFunction = function(feature, resolution) {
    zoom = map.getView().getZoom();
    
    return zoom <= 9 ? imageSmall : imageBig;
};

jsonLayer = new ol.layer.Vector({
   source: jsonSource,
   style: jsonStyleFunction
 });
 
 var map = new ol.Map({
    controls: ol.control.defaults({
        zoom: false
    }).extend([
        panZoom,
        new ol.control.MousePosition({
            coordinateFormat: ol.coordinate.createStringXY(4),
            projection: 'EPSG:4326'
        }),
        new ol.control.ScaleLine
    ]),
    layers: [
        mapLayer,
        jsonLayer
     ],
     target: document.getElementById('map'),
     view: new ol.View({
       maxZoom: 14,
       projection: 'EPSG:900913',
       center: ol.proj.transform([10.44, 51.01], 'EPSG:4326', 'EPSG:900913'),
       zoom: 6.5,
       minZoom: 6
     })
   });

 var overlayData = '<div class="olPopupContent"><div class="olLayerGeoRSSClose">[x]</div><div class="olLayerGeoRSSTitle">Station: <b></b></div><div class="olLayerGeoRSSDescription"><span class="olMapClickLink" onclick="">Station auswählen</span></div></div>';

 var jsonOverlay = new ol.Overlay({
   element: $j(overlayData).get(0),
   offset: [10, 0],
   positioning: 'bottom-center'
 });

map.addOverlay(jsonOverlay);


var select = new ol.interaction.Select({
    layers: [jsonLayer],
    toggleCondition: ol.events.condition.never,
    multi: false
 });

select.on('select', function(e) {
    features = e.target.getFeatures();
    if (features.getLength() <= 0) {
        return;
    }
    feature = features.item(0);

    element = $j(jsonOverlay.getElement());
    element.find(".olLayerGeoRSSTitle > b").html(feature.get("name"));
    element.find(".olMapClickLink").attr("onclick", "selectMapStation(" + feature.get("id") + ");");

    jsonOverlay.setPosition(feature.getGeometry().getFirstCoordinate());
 });

map.addInteraction(select);

map.on('pointermove', function(e) {
    if (e.dragging) {
      $(e).popover('destroy');
      return;
    }
    var pixel = map.getEventPixel(e.originalEvent);
    var hit = map.hasFeatureAtPixel(pixel);
    map.getTarget().style.cursor = hit ? 'pointer' : '';
});

overlayClose = function() {
    jsonOverlay.setPosition(undefined);
    select.getFeatures().clear();
    return false;
};

$j("#map .olLayerGeoRSSClose").on("click", overlayClose);