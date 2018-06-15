
// style for selection Tools
var selectionStyle = new ol.style.Style({
    stroke: new ol.style.Stroke({
    	color: 'red',
    	width: 2
	})
});

// style for shape files
var shapeStyle = new ol.style.Style({
	stroke: new ol.style.Stroke({
		color: 'green',
		width: 2
	})
});

// style for selected objects
var selectStyle = new ol.style.Style({
	fill: new ol.style.Fill({
		color: "yellow",
	}),
	stroke: new ol.style.Stroke({
		color: "red",
		width: 1
	})
});

var kachelZIndex = 300;

//Mapseries colors:

var mapseries_missing = new ol.style.Style({
    stroke: new ol.style.Stroke({
        color: 'rgba(0, 0, 0, 1.0)',
        width: 1
    }),
    fill: new ol.style.Fill({
        color: 'rgba(255, 0, 0, 0.25)',
    }),
});
var mapseries_available = new ol.style.Style({
    stroke: new ol.style.Stroke({
        color: 'rgba(0, 0, 0, 1.0)',
        width: 1
    }),
    fill: new ol.style.Fill({
        color: 'rgba(0, 0, 255, 0.25)',
    }),
});
var mapseries_selected = new ol.style.Style({
    stroke: new ol.style.Stroke({
        color: 'rgba(0, 0, 0, 1.0)',
        width: 1
    }),
    fill: new ol.style.Fill({
        color: 'rgba(0, 255, 0, 0.25)',
    }),
});