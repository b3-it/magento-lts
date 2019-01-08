
function ajaxLoader(extent, resolution, projection) {
	// store there
	src = this;
	url = this.getUrl();
	// check if it is url function
	url = url === 'function' ? url(extent, resolution, projection) : url;
	
	// TODO try to make ajax abortable

	jQuery.ajax(url, {
		beforeSend: incLoading,
		complete: decLoading,
		success: function( data ) {
			// explicit readProjection extra
			srcProjection = ol.proj.get(src.getFormat().readProjection(data));
			features = src.getFormat().readFeatures(data, {dataProjection: projection, featureProjection: srcProjection});
			src.addFeatures(features);
		}
	});
}

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
