function setCenter(lo, la, zoom)
{
    var lonLat = new OpenLayers.LonLat(lo, la).transform(proj4326, map.getProjectionObject());
    map.setCenter(lonLat, zoom);
}

function handleZoom(event) {
    var akt_zoom = map.getZoom();

    if (akt_zoom <= 9) {
        if ( marker_aktuell != marker_klein ) {
            marker_aktuell = marker_klein;
            setOverlayIcons(marker_klein, size_1);
        }
    } else {
        if ( marker_aktuell != marker_gross ) {
            marker_aktuell = marker_gross;
            setOverlayIcons(marker_gross, size_2);
        }
    }
}

function setOverlayIcons(grafik, size)
{
    var rss_data = georss.features;
    var anzahl   = rss_data.length;

    for (var i = 0; i < anzahl; i++) {
        var feature = rss_data[i];
        var newdata = feature.data;

        // Unbedingt einen neuen Icon erstellen, da der vom
        // vorigen Schleifendurchlauf sonst verschwindet!!
        var icon = new OpenLayers.Icon(grafik, size);

        newdata.icon = icon;

        var newfeature = new OpenLayers.Feature(georss, feature.lonlat, newdata);

        georss.features[i] = newfeature;

        var marker = newfeature.createMarker();

        marker.events.register('click'     , newfeature, georss.markerClick);

        georss.removeMarker(feature.marker);
        georss.addMarker(marker);
    }
}