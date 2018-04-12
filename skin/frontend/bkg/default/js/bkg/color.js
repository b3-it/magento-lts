
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
		color: "yellow",
		width: 1
	})
});

var kachelZIndex = 300;