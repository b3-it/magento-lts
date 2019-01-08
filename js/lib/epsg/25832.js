proj4.defs("EPSG:25832","+proj=utm +zone=32 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
//proj4 doesn't detect the parts before
proj4.defs("urn:x-ogc:def:crs:EPSG:25832",proj4.defs("EPSG:25832"));
proj4.defs("urn:ogc:def:crs:EPSG:6.9:25832",proj4.defs("EPSG:25832"));
