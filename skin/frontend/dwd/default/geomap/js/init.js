(function($, window, document) {
	if (typeof jsonUrl !== 'undefined') {
		$j('#map').geomap({
			'markerBig' : marker_gross,
			'markerSmall' : marker_klein,
			'jsonUrl' : jsonUrl,
			'extent' : [ 5, 56, 16, 47 ]
		});
	}
})(jQuery, window, document);