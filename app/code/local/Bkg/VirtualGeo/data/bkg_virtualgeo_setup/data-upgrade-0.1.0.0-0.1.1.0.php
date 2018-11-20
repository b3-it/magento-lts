<?php
/**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

/** @var $this Bkg_VirtualGeo_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();





$storeId_EN = 2;

$data = array();
//"0 BESCHREIBUNG_DEU","1 HINWEIS_DEU","2 BESCHREIBUNG_ENG","3 HINWEIS_ENG","4 EPSG",5 "CODE","6 POSITION","7 KUERZEL_DEU","8 KUERZEL_ENG", 9 Proj4);
$data[] = array("Dummy","","dummy","","","EE","1","EE","EE");
$data[] = array(
    "Gauß-Krüger-Abbildung im 2. Meridianstreifen<br>(Mittelmeridian 6°)<br>Ellipsoid Bessel, Datum Potsdam",
    "Ehemaliges Standardsystem der deutschen Landesvermessung. Besonders geeignet für blattschnittfreie Daten im Westen Deutschlands.",
    "Gauss Kruger Projection in the 2nd longitude zone<br>(Central Meridian 6°)<br>Ellipsoid Bessel, Datum Potsdam",
    "especially suited for data without sheet line system in the West of Germany",
    "31466","gk2","2","GK2","GK2", "+proj=tmerc +axis=neu +lat_0=0 +lon_0=6 +k=1 +x_0=2500000 +y_0=0 +ellps=bessel +towgs84=598.1,73.7,418.2,0.202,0.045,-2.455,6.7 +units=m +no_defs");
$data[] = array(
    "Gauß-Krüger-Abbildung im 3. Meridianstreifen<br>(Mittelmeridian 9°)<br>Ellipsoid Bessel, Datum Potsdam",
    "Ehemaliges Standardsystem der deutschen Landesvermessung. <br> Der 3. Streifen wurde oft auch für die Darstellung von deutschlandweiten Datensätzen verwendet.",
    "Gauss Kruger Projection in the 3rd longitude zone<br>(Central Meridian 9°)<br>Ellipsoid Bessel, Datum Potsdam",
    "common standard for Germany-wide data without sheet line system in the Gauss Kruger system",
    "31467","gk3","3","GK3","GK3", "+proj=tmerc +axis=neu +lat_0=0 +lon_0=9 +k=1 +x_0=3500000 +y_0=0 +ellps=bessel +towgs84=598.1,73.7,418.2,0.202,0.045,-2.455,6.7 +units=m +no_defs");
$data[] = array(
    "Gauß-Krüger-Abbildung im 4. Meridianstreifen<br>(Mittelmeridian 12°)<br>Ellipsoid Bessel, Datum Potsdam",
    "Ehemaliges Standardsystem der deutschen Landesvermessung. <br> Besonders geeignet für blattschnittfreie Daten im Osten Deutschlands.",
    "Gauss Kruger Projection in the 4th longitude zone<br>(Central Meridian 12°)<br>Ellipsoid Bessel, Datum Potsdam",
    "especially suited for data without sheet line system in the East of Germany",
    "31468","gk4","4","GK4","GK4", "+proj=tmerc +axis=neu +lat_0=0 +lon_0=12 +k=1 +x_0=4500000 +y_0=0 +ellps=bessel +towgs84=598.1,73.7,418.2,0.202,0.045,-2.455,6.7 +units=m +no_defs");
$data[] = array(
    "Gauß-Krüger-Abbildung im 5. Meridianstreifen<br>(Mittelmeridian 15°)<br>Ellipsoid Bessel, Datum Potsdam",
    "Ehemaliges Standardsystem der deutschen Landesvermessung. <br> Besonders geeignet für blattschnittfreie Daten im äußersten Osten Deutschlands.",
    "Gauss Kruger Projection in the 5th longitude zone<br>(Central Meridian 15°)<br>Ellipsoid Bessel, Datum Potsdam",
    "especially suited for data without sheet line system in the extreme East of Germany",
    "31469","gk5","5","GK5","GK5", "+proj=tmerc +axis=neu +lat_0=0 +lon_0=15 +k=1 +x_0=5500000 +y_0=0 +ellps=bessel +towgs84=598.1,73.7,418.2,0.202,0.045,-2.455,6.7 +units=m +no_defs");
$data[] = array(
    "Lambert-Abbildung (winkeltreu)<br> längentreue Breitenkreise: 48°40' und 53°40'<br> Bezugsmittelpunkt: 10°30' ö.L., 51°00' n.B.<br> Ellipsoid GRS80, Datum ETRS89",
    "besonders geeignet für deutschlandweite blattschnittfreie Daten bei möglichst geringen Verzerrungen",
    "Lambert Projection (conformal)<br>isometric parallels of latitude: 48°40' and 53°40'<br>centre of reference: 10°30' EL, 51°00' NL<br>Ellipsoid GRS80, Datum ETRS89",
    "especially suited for Germany-wide data without sheet line system with as little distortions as possible",
    "5243","lamge","6","LAMGe","LAMGe", "+proj=lcc +lat_1=48.66666666666666 +lat_2=53.66666666666666 +lat_0=51 +lon_0=10.5 +x_0=0 +y_0=0 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");

// no extra ESPG for lamgw because of Ellipsoid WGS84?
$data[] = array(
    "Lambert-Abbildung (winkeltreu)<br> längentreue Breitenkreise: 48°40' und 53°40'<br> Bezugsmittelpunkt: 10°30' ö.L., 51°00' n.B.<br> Ellipsoid WGS84, Datum WGS84",
    "besonders geeignet für deutschlandweite blattschnittfreie Daten bei möglichst geringen Verzerrungen",
    "Lambert Projection (conformal)<br>isometric parallels of latitude: 48°40' and 53°40'<br>centre of reference: 10°30' EL, 51°00' NL<br>Ellipsoid WGS84, Datum WGS84",
    "especially suited for Germany-wide data without sheet line system with as little distortions as possible",
    "","lamgw","7","LAMGw","LAMGw" ,"");

$data[] = array(
    "UTM-Abbildung in der Zone 32<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Sie unterscheidet sich von utm32w <br> durch ihren geodätischen Bezug.",
    "UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89","",
    "4647","utm32e","8","UTM32e","UTM32e", "+proj=tmerc +lat_0=0 +lon_0=9 +k=0.9996 +x_0=32500000 +y_0=0 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
$data[] = array(
    "UTM-Abbildung in der Zone 33<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   15°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Sie unterscheidet sich von utm33w durch ihren geodätischen Bezug.",
    "UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  GRS80,  Datum ETRS89","",
    "5650","utm33e","9","UTM33e","UTM33e", "+proj=tmerc +lat_0=0 +lon_0=15 +k=0.9996 +x_0=33500000 +y_0=0 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
$data[] = array(
    "UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "Standardsystem der deutschen Landesvermessung und international eingesetztes UTM-Systems. <br>Die Zone 32 wird oft auch für die Darstellung von deutschlandweiten Datensätzen verwendet.",
    "UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89",
    "common standard for Germany-wide data without sheet line system in the UTM system",
    "25832","utm32s","10","UTM32s","UTM32s", "+proj=utm +zone=32 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
$data[] = array(
    "UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   15°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "Standardsystem der deutschen Landesvermessung und international eingesetztes UTM-Systems.",
    "UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  GRS80,  Datum ETRS89",
    "especially suited for data without sheet line system in the East of Germany",
    "25833","utm33s","11","UTM33s","UTM33s", "+proj=utm +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
// no extra ESPG for lamgw because of Ellipsoid WGS84?
$data[] = array(
    "UTM-Abbildung in der Zone 32<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid WGS84, Datum WGS84)",
    "Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Deutschland liegt überwiegend in der Zone 32, so dass diese auch für deutschlandweite blattschnittfreie Daten im UTM-System sehr geeignet ist.",
    "UTM Projection in zone 32<br>(Centre 9°)<br> Ellipsoid WGS84, Datum WGS84 ",
    "With zone indication at the beginning in the easting this georeferencing corresponds to a common form in Germany. Germany is mostly situated in the zone 32 so that this is very appropriate also for Germany-wide data without sheet line system in the UTM system.",
    "","utm32w","12","UTM32w","UTM32w", "");
$data[] = array(
    "UTM-Abbildung in der Zone 33<br>mit führender Zonenangabe im Rechtswert <br>(Mittelmeridian   15°)<br>Ellipsoid WGS84, Datum WGS84",
    "Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Besonders geeignet für blattschnittfreie Daten im Osten Deutschlands.",
    "UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  WGS84, Datum WGS84 ",
    "especially suited for data without sheet line system in the East of Germany",
    "","utm33w","13","UTM33w","UTM33w", "");
$data[] = array(
    "Geographische Koordinaten in Dezimalgrad <br> (Ellipsoid GRS80, Datum ETRS89)",
    "",
    "Geographical coordinates in decimal degrees <br>  (Ellipsoid GRS80, Datum ETRS89)",
    "",
    "4258","geo89","14","GEO89","GEO89", "+proj=longlat +axis=neu +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +no_defs");
// already known by proj4 
$data[] = array(
    "Geographische Koordinaten in Dezimalgrad<br> Ellipsoid WGS84, Datum WGS84",
    "",
    "Geographical coordinates in decimal degrees <br> (Ellipsoid WGS84, Datum WGS84)",
    "",
    "4326","geo84","15","GEO84","GEO84", "");
$data[] = array(
    "UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "",
    "UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "",
    "3044","tm32","16","TM32","TM32", "+proj=utm +axis=neu +zone=32 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
$data[] = array(
    "UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "",
    "UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)",
    "",
    "3045","tm33","17","TM33","TM33", "+proj=utm +axis=neu +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
// already known by proj4 
$data[] = array(
    "Pseudo-Mercator<br>(Ellipsoid WGS84, Datum WGS84)",
    "Sphärische Mercator-Projektion <br> Standardsystem für weltweite Webdienste z.B. von Google oder OpenStreetMap",
    "Pseudo-Mercator<br>(Ellipsoid WGS84, Datum WGS84)",
    "Standardsystem für Webdienste von Google oder OpenStreetMap",
    "3857","psmerc","18","PSEUDO_MERCATOR","PSEUDO_MERCATOR", "");


foreach($data as $row)
{

    /**
     * @var Bkg_VirtualGeo_Model_Components_Georef $object
     */
	$object = Mage::getModel('virtualgeo/components_georef');
	$object->setCode($this->getRowValue($row,5))
	->setEpsgCode($this->getRowValue($row,4))
	->setName($this->getRowValue($row,0))
	->setShortname($this->getRowValue($row,7))
	->setDescription($this->getRowValue($row,1))
	->setPos(intval($this->getRowValue($row,6)))
	->setProj4($this->getRowValue($row, 9))
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,8))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$data = array();
//"0 BESCHREIBUNG_DEU","1 HINWEIS_DEU","2 BESCHREIBUNG_ENG","3 HINWEIS_ENG","4 CODE","5 POSITION","6 KUERZEL_DEU","7 KUERZEL_ENG");
$data[] = array("Dummy","Dummy","Dummy","Dummy","EE","1","Dummy","Dummy");
$data[] = array("ArcInfo-GRID","farbcodierte Darstellung, internes Format des Geoinformationssystems ArcInfo","ArcInfo-GRID","color-coded representation, internal format of the Geographic Information System ArcInfo","grid","10","ArcInfo-GRID","ArcInfo-GRID");
$data[] = array("(1)ASCII (B,L,H)<br>(2)Binäres Format<br>(3)Trimble-Format<br>(4)LEICA-Format<br>(5)TOPCON-Format<br>(6)SurvCE-Format<br>(7)JAVAD-Format","(1) Ascii-Datei. Enthält je Rasterpunkt einen Datensatz der Form x-Koordinate y-Koordinate Geoidundulation<br>(2) Header zur Beschreibung des Rasters, danach Folge von 4-Byte-Werten mit Geoidundulationen<br>(3) spezielles Datenformat zur Einbindung in die Trimble Geomatics Office bzw. Trimble Business Center Software<br>(4) spezielles Datenformat zur Einbindung in LEICA Geo Office Software <br>(5) spezielles Datenformat zur Einbindung in TOPCON-Software <br> (6) spezielles Datenformat zur Einbindung in SurvCE-Software <br> (7) spezielles Datenformat zur Einbindung in JAVAD-Geräte","(1)ASCII (B,L,H)<br>(2)Binäres Format<br>(3)Trimble-Format<br>(4)LEICA-Format<br>(5)TOPCON-Format<br>(6)SurvCE-Format<br>(7)JAVAD-Format","(1) Ascii-Datei. Enthält je Rasterpunkt einen Datensatz der Form x-Koordinate y-Koordinate Geoidundulation<br>(2) Header zur Beschreibung des Rasters, danach Folge von 4-Byte-Werten mit Geoidundulationen<br>(3) spezielles Datenformat zur Einbindung in die Trimble Geomatics Office bzw. Trimble Business Center Software<br>(4) spezielles Datenformat zur Einbindung in LEICA Geo Office Software <br>(5) spezielles Datenformat zur Einbindung in SurvCE-Software (SOKKIA)","geoid","12","7 FORMATE","7 FORMATE");
$data[] = array("CSV","Textdatei in UTF8-Zeichenkodierung.<br> Enthält zeilenweise Lagegeometrie und Attribute mit Semikolon als Trennzeichen.","CSV","Text file in UTF8 character coding.<br> Contains line-by-line position geometry and attributes with semicolon as separator.","csv","13","CSV","CSV");
$data[] = array("TIFF-GROUP4","Schwarz-Weiß-Darstellung, TIFF mit Komprimierung CCITT-GROUP4","TIFF-GROUP4","Black-and-white representation, TIFF with compression CCITT-GROUP4","tif-g4","14","TIFF-GROUP4","TIFF-GROUP4");
$data[] = array("JPEG","JPEG","JPEG","JPEG","jpeg","15","JPEG","JPEG");
$data[] = array("TIFF","TIFF unkomprimiert, 24-Bit Farbtiefe","TIFF","TIFF unpacked, 24-Bit colour depth","tif","16","TIFF","TIFF");
$data[] = array("TIFF-K","TIFF komprimiert, 24-Bit Farbtiefe","TIFF-K","TIFF packed, 24-Bit colour depth","tif-k","17","TIFF-K","TIFF-K");
$data[] = array("PNG+WLD","Ein Grafikformat für Rastergrafiken mit verlustfreier Kompression, hier mit Angabe eines World-Files.","PNG+WLD","Ein Grafikformat für Rastergrafiken mit verlustfreier Kompression, hier mit World-File.","png+wld","18","PNG+WLD","PNG+WLD");
$data[] = array("TileCache PNG","Dieses Format ist gut geeignet für dateibasierte Caches mit sehr vielen Dateien. Die maximale Datei-/Ordneranzahl pro Verzeichnis ist 1000 und kann damit von jedem System gut verarbeitet werden. ","TileCache PNG","Dieses Format ist gut geeignet für dateibasierte Caches mit sehr vielen Dateien. Die maximale Datei-/Ordneranzahl pro Verzeichnis ist 1000 und kann damit von jedem System gut verarbeitet werden. ","tilecache","19","TileCache","TileCache");
$data[] = array("TIFF-LZW","farbcodierte Darstellung,GeoTIFF mit Komprimierung LZW, 8-Bit, Palettenfarben","TIFF-LZW","color-coded representation, GeoTIFF with compression LZW, 8-Bit, palette colors","tif-lzw","2","TIFF-LZW","TIFF-LZW");
$data[] = array("ESRI fGDB ","ESRI file geodatabase ","ESRI fGDB ","ESRI file geodatabase","fgdb","20","ESRI-fGDB ","ESRI-fGDB ");
$data[] = array("ESRI Exploded PNG","Rasterkachelarchiv mit PNG-Kacheln.Dieses Format eignet sich für den Einsatz mit ESRI-Produkten. Es müssen aber zusätzlich entsprechende Konfigurationsdateien bereitgestellt werden, damit das Verzeichnis als MapCache von ArcGIS erkannt wird. ","ESRI Exploded PNG","Rasterkachelarchiv mit PNG-Kacheln.Dieses Format eignet sich für den Einsatz mit ESRI-Produkten. Es müssen aber zusätzlich entsprechende Konfigurationsdateien bereitgestellt werden, damit das Verzeichnis als MapCache von ArcGIS erkannt wird. ","ee-png","21","ESRI-Exploded-PNG","ESRI-Exploded-PNG");
$data[] = array("ESRI Compact PNG","Rasterkachelarchiv mit PNG-Kacheln. Gruppiert einzelne PNGs/Tiles zu bundle-Dateien - ein Bundle kann bis zu 16.000 Tiles beinhalten. Eignet sich für den Einsatz mit ESRI-Produkten oder MapProxy.","ESRI Compact PNG","Rasterkachelarchiv mit PNG-Kacheln. Gruppiert einzelne PNGs/Tiles zu bundle-Dateien - ein Bundle kann bis zu 16.000 Tiles beinhalten. Eignet sich für den Einsatz mit ESRI-Produkten oder MapProxy.","ec-png","22","ESRI-Compact-PNG","ESRI-Compact-PNG");
$data[] = array("SDE-Ablageformat","SDE-Ablageformat","SDE filing format","SDE filing format","sde","23","SDE","SDE");
$data[] = array("GEOGRID","spezielles Format des Geogrid-Viewers","GEOGRID","spezielles Format des Geogrid-Viewers","geogrid","24","GEOGRID","GEOGRID");
$data[] = array("SQLITE MBTILE","Jede Zoomstufe wird in einer separaten SQLite-Datenbank gespeichert. Der Dateiname der Datenbank ist die Zoomstufe (ohne führende Null). Der Dateiname der Datenbank besitzt die Dateierweiterung mbtiles. ","SQLITE MBTILE","Jede Zoomstufe wird in einer separaten SQLite-Datenbank gespeichert. Der Dateiname der Datenbank ist die Zoomstufe (ohne führende Null). Der Dateiname der Datenbank besitzt die Dateierweiterung mbtiles. ","sqlite","25","SQLITE","SQLITE");
$data[] = array("Scalable Vector Graphics","SVG ist die vom World Wide Web Consortium (W3C) empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken","Scalable Vector Graphics","SVG is a family of specifications of an XML-based file format for describing two-dimensional vector graphics","svg","26","SVG","SVG");
$data[] = array("ASCII-Text","ASCII-Textdatei","ASCII text","ASCII-Textdatei","text","27","ASCII-Text","ASCII-Text");
$data[] = array("DXF","Verbreitetes CAD-Datenformat, das nach wie vor von vielen Geoinformationssystemen unterstützt wird. In der Regel gehen beim Einsatz von DXF bestimmte Informationen der Ausgangsdaten verloren. Attributive Informationen werden häufig in einem gewissen Umfang über beigestellte ASCII-Dateien transportiert.","DXF","Widely spread CAD data format, that is still supported by many GI Systems. As a rule by using DXF certain informations get lost","dxf","28","DXF","DXF");
$data[] = array("Standardabgabeformat für 3D-Gebäudemodelle","Format entsprechend dem AdV-CityGML-Profil","Standardabgabeformat für 3D-Gebäudemodelle","CityGML-Format entsprechend dem AdV-CityGML-Profil","citygml","29","CITYGML","CITYGML");
$data[] = array("TIFF-JPEG","GeoTIFF mit Komprimierung JPEG","TIFF-JPEG","GeoTIFF with compression JPEG","tif-jpeg","3","TIFF-JPEG","TIFF-JPEG");
$data[] = array("Portable Document Format","PDF is a file format created by Adobe Systems","Portable Document Format","PDF is a file format created by Adobe Systems","pdf","30","PDF","PDF");
$data[] = array("TIFF-DER","um WEB-Darstellung zu erzeugen","TIFF-DER","to be generated for WEB presentation","tif-der","4","TIFF-DER","TIFF-DER");
$data[] = array("ArcInfo-SHAPE","Offen gelegtes Austauschformat, das von vielen Geoinformationssystemen unterstützt wird.","ArcInfo-SHAPE","Open Exchange format, that is supported by many GI Systems","shape","5","SHAPE","SHAPE");
$data[] = array("NAS - normbasierte Austauschschnittstelle","Normbasierte Austauschschnittstelle. Datenaustauschformat des AAA-Modells ","NAS - norm-based data exchange interface","Norm-based data exchange interface. Data exchange format of the AAA model","nas_nba","6","NAS-NBA","NAS-NBA");
$data[] = array("NAS - normbasierte Austauschschnittstelle","Normbasierte Austauschschnittstelle. Datenaustauschformat des AAA-Modells ","NAS - norm-based data exchange interface","Norm-based data exchange interface. Data exchange format of the AAA model","nas_bda","7","NAS-BDA","NAS-BDA");
$data[] = array("XYZ-ASCII","ASCII-Datei. Enthält zeilenweise einen Höhenpunkt mit Lagekoordinate und Höhe:<br> x_koordinate y_koordinate höhenwert","XYZ-ASCII","ASCII file. Contains per spot height a data set of the form: x_koordinate,y_koordinate,höhenwert (x_coordinate,y_coordinate,elevation) ","ascii","8","XYZ-ASCII","XYZ-ASCII");
$data[] = array("GRID-ASCII","ASCII-Datei. Von ArcInfo unterstütztes ASCII-Format, das nach Angaben zur Berechnung der Gitterpunkte eine Matrix mit Höhenwerten enthält.","GRID-ASCII","ASCII file. ASCII format supported by ArcInfo that contains after data for the computation of the grid points a matrix with elevations. ","grida","9","GRID-ASCII","GRID-ASCII");


foreach($data as $row)
{

	$object = Mage::getModel('virtualgeo/components_format');
	$object->setCode($this->getRowValue($row,4))
	->setHasResolution(1)
	->setName($this->getRowValue($row,0))
	->setShortname($this->getRowValue($row,6))
	->setDescription($this->getRowValue($row,1))
	->setPos($this->getRowValue($row,5) * 100)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,7))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$data = array();

//"0 EBENEN_DEU","1 EBENEN_NAME_DEU","2 EBENEN_ENG","3 EBENEN_NAME_ENG","4 KATEGORIE","5 CODE","6 POSITION","7 KUERZEL_DEU","8 KUERZEL_ENG");
$data[] = array("Alle Ebenen","","All levels","","Allgemein","AlleEbenen","1","Alle Ebenen","All levels");
$data[] = array("Alle Layer","","all layers","","Allgemein","AlleLayer","2","Alle Layer","all layers");
$data[] = array("Ebenen","","Layers","","Allgemein","Ebenen","3","Ebenen","Layers");
$data[] = array("Einzelebenen","","single layers","","Allgemein","Einzelebenen","4","Einzelebenen","single layers");
$data[] = array("Einzellayer","( Layer 1 - Layer 9 )","layer","( Layer 1 - Layer 9 )","Allgemein","Einzellayer","5","Einzellayer","layer");
$data[] = array("Gesamt","","all","","Allgemein","Gesamt","6","Gesamt","all");
$data[] = array("Gesamtinhalt","","Total content","","Allgemein","Gesamtinhalt","7","Gesamtinhalt","Total content");
$data[] = array("Layer","","single layers","","Allgemein","Layer","8","Layer","single layers");
$data[] = array("Objektbereiche","","Objektbereiche","","Allgemein","Objektbereiche","9","Objektbereiche","Objektbereiche");
$data[] = array("Bahnübergänge","","Bahnübergänge","","DB","Bahnuebergaenge","1","Bahnübergänge","Bahnübergänge");
$data[] = array("Tunnel","","Tunnel","","DB","Tunnel","10","Tunnel","Tunnel");
$data[] = array("Betriebsstellen","","Betriebsstellen","","DB","Betriebsstellen","2","Betriebsstellen","Betriebsstellen");
$data[] = array("Brücken","","Brücken","","DB","Bruecken","3","Brücken","Brücken");
$data[] = array("Kilometerpunkte","","Kilometerpunkte","","DB","Kilometerpunkte","4","Kilometerpunkte","Kilometerpunkte");
$data[] = array("Kilometrierungssprünge","","Kilometrierungssprünge","","DB","Kilometrierungsspruenge","5","Kilometrierungssprünge","Kilometrierungssprünge");
$data[] = array("Schutzwände","","Schutzwände","","DB","Schutzwaende","6","Schutzwände","Schutzwände");
$data[] = array("Schutzwandtüren","","Schutzwandtüren","","DB","Schutzwandtueren","7","Schutzwandtüren","Schutzwandtüren");
$data[] = array("Straßenüberführungen","","Straßenüberführungen","","DB","Straßenueberfuehrungen","8","Straßenüberführungen","Straßenüberführungen");
$data[] = array("Streckennetz","","Streckennetz","","DB","Streckennetz","9","Streckennetz","Streckennetz");
$data[] = array("Gebiete","","regions","","DLM","Gebiete","1","Gebiete","regions");
$data[] = array("GEW01-Gewässer","","GEW01-water bodies","","DLM","GEW01","10","GEW01","GEW01");
$data[] = array("41003","AX_Halde","41003","AX_Dump","DLM","41003","101","41003 AX_Halde","41003 AX_Dump");
$data[] = array("41004","AX_Bergbaubetrieb","41004","AX_MiningWorks","DLM","41004","102","41004 AX_Bergbaubetrieb","41004 AX_MiningWorks");
$data[] = array("41005","AX_TagebauGrubeSteinbruch","41005","AX_OpenPitMineQuarry","DLM","41005","103","41005 AX_TagebauGrubeSteinbruch","41005 AX_OpenPitMineQuarry");
$data[] = array("41006","AX_FlaecheGemischterNutzung","41006","AX_AreaOfMixedUse","DLM","41006","105","41006 AX_FlaecheGemischterNutzung","41006 AX_AreaOfMixedUse");
$data[] = array("41007","AX_FlaecheBesondererFunktionalerPraegung","41007","AX_AreaWithSpecialFunctionalCharacter","DLM","41007","106","41007 AX_FlaecheBesondererFunktionalerPraegung","41007 AX_AreaWithSpecialFunctionalCharacter");
$data[] = array("41008","AX_SportFreizeitUndErholungsflaeche","41008","AX_SportsLeisureAndRecreationalArea","DLM","41008","107","41008 AX_SportFreizeitUndErholungsflaeche","41008 AX_SportsLeisureAndRecreationalArea");
$data[] = array("41009","AX_Friedhof","41009","AX_Cemetery","DLM","41009","108","41009 AX_Friedhof","41009 AX_Cemetery");
$data[] = array("41010","AX_Siedlungsflaeche","41010","AX_Siedlungsflaeche","DLM","41010","109","41010 AX_Siedlungsflaeche","41010 AX_Siedlungsflaeche");
$data[] = array("GEW01-Gewässer und Bauwerke an Gewässern","","GEW01-Water bodies and buildings on water bodies","","DLM","GEW01","11","GEW01","GEW01");
$data[] = array("411","Sümpfe ","411","Sümpfe ","DLM","411","110","411 Sümpfe ","411 Sümpfe ");
$data[] = array("412","Torfmoore ","412","Torfmoore ","DLM","412","111","412 Torfmoore ","412 Torfmoore ");
$data[] = array("42000","Tatsaechliche Nutzung - Verkehr","42000","Tatsaechliche Nutzung - Verkehr","DLM","42000","112","42000 Tatsaechliche Nutzung - Verkehr","42000 Tatsaechliche Nutzung - Verkehr");
$data[] = array("42001","AX_Strassenverkehr","42001","AX_RoadTraffic","DLM","42001","113","42001 AX_Strassenverkehr","42001 AX_RoadTraffic");
$data[] = array("42002","AX_Strasse","42002","AX_Road","DLM","42002","114","42002 AX_Strasse","42002 AX_Road");
$data[] = array("42003","AX_Strassenachse","42003","AX_RoadAxis","DLM","42003","115","42003 AX_Strassenachse","42003 AX_RoadAxis");
$data[] = array("42005","AX_Fahrbahnachse","42005","AX_RoadAxis","DLM","42005","116","42005 AX_Fahrbahnachse","42005 AX_RoadAxis");
$data[] = array("42008","AX_Fahrwegachse","42008","AX_DrivewayAxis","DLM","42008","117","42008 AX_Fahrwegachse","42008 AX_DrivewayAxis");
$data[] = array("42009","AX_Platz","42009","AX_Place","DLM","42009","118","42009 AX_Platz","42009 AX_Place");
$data[] = array("42010","AX_Bahnverkehr","42010","AX_railway traffic","DLM","42010","119","42010 AX_Bahnverkehr","42010 AX_railway traffic");
$data[] = array("GEW02-Besondere Gewässermerkmale","","GEW02-Special water body features","","DLM","GEW02","12","GEW02","GEW02");
$data[] = array("42014","AX_Bahnstrecke","42014","AX_railway line","DLM","42014","120","42014 AX_Bahnstrecke","42014 AX_railway line");
$data[] = array("42015","AX_Flugverkehr","42015","AX_AirTraffic","DLM","42015","121","42015 AX_Flugverkehr","42015 AX_AirTraffic");
$data[] = array("42016","AX_Schiffsverkehr","42016","AX_ShippingTraffic","DLM","42016","122","42016 AX_Schiffsverkehr","42016 AX_ShippingTraffic");
$data[] = array("421","Salzwiesen ","421","Salzwiesen ","DLM","421","123","421 Salzwiesen ","421 Salzwiesen ");
$data[] = array("422","Salinen ","422","Salinen ","DLM","422","124","422 Salinen ","422 Salinen ");
$data[] = array("423","In der Gezeitenzone liegende Flächen ","423","In der Gezeitenzone liegende Flächen ","DLM","423","125","423 In der Gezeitenzone liegende Flächen ","423 In der Gezeitenzone liegende Flächen ");
$data[] = array("43000","Tatsaechliche Nutzung - Vegetation","43000","Tatsaechliche Nutzung - Vegetation","DLM","43000","126","43000 Tatsaechliche Nutzung - Vegetation","43000 Tatsaechliche Nutzung - Vegetation");
$data[] = array("43001","AX_Landwirtschaft","43001","AX_Agriculture","DLM","43001","127","43001 AX_Landwirtschaft","43001 AX_Agriculture");
$data[] = array("43002","AX_Wald","43002","AX_Forest","DLM","43002","128","43002 AX_Wald","43002 AX_Forest");
$data[] = array("43003","AX_Gehoelz","43003","AX_Grove","DLM","43003","129","43003 AX_Gehoelz","43003 AX_Grove");
$data[] = array("GEW03-Gewässerachse","","GEW03-Water axes","","DLM","GEW03","13","GEW03","GEW03");
$data[] = array("43004","AX_Heide","43004","AX_Heathland","DLM","43004","130","43004 AX_Heide","43004 AX_Heathland");
$data[] = array("43005","AX_Moor","43005","AX_Swamp","DLM","43005","131","43005 AX_Moor","43005 AX_Swamp");
$data[] = array("43006","AX_Sumpf","43006","AX_Bog","DLM","43006","132","43006 AX_Sumpf","43006 AX_Bog");
$data[] = array("43007","AX_UnlandVegetationsloseFlaeche","43007","AX_WasteLandAreaWithoutVegetation","DLM","43007","133","43007 AX_UnlandVegetationsloseFlaeche","43007 AX_WasteLandAreaWithoutVegetation");
$data[] = array("43008","AX_FlaecheZurZeitUnbestimmbar","43008","AX_AreaPresentlyUndeterminable","DLM","43008","134","43008 AX_FlaecheZurZeitUnbestimmbar","43008 AX_AreaPresentlyUndeterminable");
$data[] = array("44000","Tatsaechliche Nutzung - Gewaesser","44000","Tatsaechliche Nutzung - Gewaesser","DLM","44000","135","44000 Tatsaechliche Nutzung - Gewaesser","44000 Tatsaechliche Nutzung - Gewaesser");
$data[] = array("44001","AX_Fliessgewaesser","44001","AX_Watercourse","DLM","44001","136","44001 AX_Fliessgewaesser","44001 AX_Watercourse");
$data[] = array("44002","AX_Wasserlauf","44002","AX_WaterCourse","DLM","44002","137","44002 AX_Wasserlauf","44002 AX_WaterCourse");
$data[] = array("44003","AX_Kanal","44003","AX_Canal","DLM","44003","138","44003 AX_Kanal","44003 AX_Canal");
$data[] = array("44004","AX_Gewaesserachse","44004","AX_WaterAxis","DLM","44004","139","44004 AX_Gewaesserachse","44004 AX_WaterAxis");
$data[] = array("HDU01-Referenzen","","HDU01-References","","DLM","HDU01","14","HDU01","HDU01");
$data[] = array("44005","AX_Hafenbecken","44005","AX_InnerHarbour","DLM","44005","140","44005 AX_Hafenbecken","44005 AX_InnerHarbour");
$data[] = array("44006","AX_StehendesGewaesser","44006","AX_StandingWaterBody","DLM","44006","141","44006 AX_StehendesGewaesser","44006 AX_StandingWaterBody");
$data[] = array("44007","AX_Meer","44007","AX_Sea","DLM","44007","142","44007 AX_Meer","44007 AX_Sea");
$data[] = array("51000","Bauwerke und Einrichtungen in Siedlungsflaechen","51000","constructions and facilities in settlement areas","DLM","51000","143","51000 Bauwerke und Einrichtungen in Siedlungsflaechen","51000 constructions and facilities in settlement areas");
$data[] = array("51001","AX_Turm","51001","AX_Tower","DLM","51001","144","51001 AX_Turm","51001 AX_Tower");
$data[] = array("51002","AX_BauwerkOderAnlageFuerIndustrieUndGewerbe","51002","AX_BuildingOrFacilitiesForIndustryAndBusiness","DLM","51002","145","51002 AX_BauwerkOderAnlageFuerIndustrieUndGewerbe","51002 AX_BuildingOrFacilitiesForIndustryAndBusiness");
$data[] = array("51003","AX_VorratsbehaelterSpeicherbauwerk","51003","AX_ReservoirStorageStructure","DLM","51003","146","51003 AX_VorratsbehaelterSpeicherbauwerk","51003 AX_ReservoirStorageStructure");
$data[] = array("51004","AX_Transportanlage","51004","AX_Conveyor","DLM","51004","147","51004 AX_Transportanlage","51004 AX_Conveyor");
$data[] = array("51005","AX_Leitung","51005","AX_Line","DLM","51005","148","51005 AX_Leitung","51005 AX_Line");
$data[] = array("51006","AX_BauwerkOderAnlageFuerSportFreizeitUndErholung","51006","AX_BuildingOrFacilitiesForSportsLeisureTimeAndRecreation","DLM","51006","149","51006 AX_BauwerkOderAnlageFuerSportFreizeitUndErholung","51006 AX_BuildingOrFacilitiesForSportsLeisureTimeAndRecreation");
$data[] = array("REL01-Reliefformen","","REL01-Relief forms","","DLM","REL01","15","REL01","REL01");
$data[] = array("51007","AX_HistorischesBauwerkOderHistorischeEinrichtung","51007","AX_HistoricalBuildingOrHistoricalConstruction","DLM","51007","150","51007 AX_HistorischesBauwerkOderHistorischeEinrichtung","51007 AX_HistoricalBuildingOrHistoricalConstruction");
$data[] = array("51008","AX_HeilquelleGasquelle","51008","AX_HeilquelleGasquelle","DLM","51008","151","51008 AX_HeilquelleGasquelle","51008 AX_HeilquelleGasquelle");
$data[] = array("51009","AX_SonstigesBauwerkOderSonstigeEinrichtung","51009","AX_OtherBuildingsOrOther Facilities","DLM","51009","152","51009 AX_SonstigesBauwerkOderSonstigeEinrichtung","51009 AX_OtherBuildingsOrOther Facilities");
$data[] = array("51010","AX_EinrichtungInOeffentlichenBereichen","51010","AX_FacilitiesInPublicAreas","DLM","51010","153","51010 AX_EinrichtungInOeffentlichenBereichen","51010 AX_FacilitiesInPublicAreas");
$data[] = array("511","Gewässerläufe ","511","Gewässerläufe ","DLM","511","154","511 Gewässerläufe ","511 Gewässerläufe ");
$data[] = array("512","Wasserflächen ","512","Wasserflächen ","DLM","512","155","512 Wasserflächen ","512 Wasserflächen ");
$data[] = array("52000","Besondere Anlagen auf Siedlungsflaechen","52000","Special facilities on settlement areas","DLM","52000","156","52000 Besondere Anlagen auf Siedlungsflaechen","52000 Special facilities on settlement areas");
$data[] = array("52001","AX_Ortslage","52001","AX_Site","DLM","52001","157","52001 AX_Ortslage","52001 AX_Site");
$data[] = array("52002","AX_Hafen","52002","AX_Harbour","DLM","52002","158","52002 AX_Hafen","52002 AX_Harbour");
$data[] = array("52003","AX_Schleuse","52003","AX_Sluice","DLM","52003","159","52003 AX_Schleuse","52003 AX_Sluice");
$data[] = array("SIE01-Ortslage","","SIE01-Sites","","DLM","SIE01","16","SIE01","SIE01");
$data[] = array("52004","AX_Grenzuebergang","52004","AX_BorderCrossing","DLM","52004","160","52004 AX_Grenzuebergang","52004 AX_BorderCrossing");
$data[] = array("52005","AX_Testgelaende","52005","AX_TestGround","DLM","52005","161","52005 AX_Testgelaende","52005 AX_TestGround");
$data[] = array("521","Lagunen ","521","Lagunen ","DLM","521","162","521 Lagunen ","521 Lagunen ");
$data[] = array("522","Mündungsgebiete ","522","Mündungsgebiete ","DLM","522","163","522 Mündungsgebiete ","522 Mündungsgebiete ");
$data[] = array("523","Meere und Ozeane ","523","Meere und Ozeane ","DLM","523","164","523 Meere und Ozeane ","523 Meere und Ozeane ");
$data[] = array("53000","Bauwerke, Anlagen und Einrichtungen für den Verkehr","53000","constructions, facilities and equipment for traffic","DLM","53000","165","53000 Bauwerke, Anlagen und Einrichtungen für den Verkehr","53000 constructions, facilities and equipment for traffic");
$data[] = array("53001","AX_BauwerkImVerkehrsbereich","53001","AX_BuildingInTrafficArea","DLM","53001","166","53001 AX_BauwerkImVerkehrsbereich","53001 AX_BuildingInTrafficArea");
$data[] = array("53002","AX_Strassenverkehrsanlage","53002","AX_RoadTrafficFacilities","DLM","53002","167","53002 AX_Strassenverkehrsanlage","53002 AX_RoadTrafficFacilities");
$data[] = array("53003","AX_WegPfadSteig","53003","AX_WayPathSteepTrack","DLM","53003","168","53003 AX_WegPfadSteig","53003 AX_WayPathSteepTrack");
$data[] = array("53004","AX_Bahnverkehrsanlage","53004","AX_railway traffic facilities","DLM","53004","169","53004 AX_Bahnverkehrsanlage","53004 AX_railway traffic facilities");
$data[] = array("SIE02-Baulich geprägte Flächen","","SIE02-Constructionally characterized areas","","DLM","SIE02","17","SIE02","SIE02");
$data[] = array("53005","AX_SeilbahnSchwebebahn","53005","AX_CableCarSuspensionRailway","DLM","53005","170","53005 AX_SeilbahnSchwebebahn","53005 AX_CableCarSuspensionRailway");
$data[] = array("53006","AX_Gleis","53006","AX_RailTrack","DLM","53006","171","53006 AX_Gleis","53006 AX_RailTrack");
$data[] = array("53007","AX_Flugverkehrsanlage","53007","AX_AirTrafficFacilities","DLM","53007","172","53007 AX_Flugverkehrsanlage","53007 AX_AirTrafficFacilities");
$data[] = array("53008","AX_EinrichtungenFuerDenSchiffsverkehr","53008","AX_FacilitiesForShippingTraffic","DLM","53008","173","53008 AX_EinrichtungenFuerDenSchiffsverkehr","53008 AX_FacilitiesForShippingTraffic");
$data[] = array("53009","AX_BauwerkImGewaesserbereich","53009","AX_BuildingInWaterBodyArea","DLM","53009","174","53009 AX_BauwerkImGewaesserbereich","53009 AX_BuildingInWaterBodyArea");
$data[] = array("54000","Besondere Vegetationsmerkmale","54000","Special vegetation features","DLM","54000","175","54000 Besondere Vegetationsmerkmale","54000 Special vegetation features");
$data[] = array("54001","AX_Vegetationsmerkmal","54001","AX_VegetationFeature","DLM","54001","176","54001 AX_Vegetationsmerkmal","54001 AX_VegetationFeature");
$data[] = array("55000","Besondere Eigenschaften von Gewässern","55000","Special characteristics of water bodies","DLM","55000","177","55000 Besondere Eigenschaften von Gewässern","55000 Special characteristics of water bodies");
$data[] = array("55001","AX_Gewaessermerkmal","55001","AX_WaterCharacteristic","DLM","55001","178","55001 AX_Gewaessermerkmal","55001 AX_WaterCharacteristic");
$data[] = array("55002","AX_UntergeordnetesGewaesser","55002","AX_UntergeordnetesGewaesser","DLM","55002","179","55002 AX_UntergeordnetesGewaesser","55002 AX_UntergeordnetesGewaesser");
$data[] = array("SIE03-Bauwerke und sonstige Einrichtungen","","SIE03-Buildings and other facilities","","DLM","SIE03","18","SIE03","SIE03");
$data[] = array("55003","AX_Polder","55003","AX_Polder","DLM","55003","180","55003 AX_Polder","55003 AX_Polder");
$data[] = array("56000","Besondere Angaben zum Verkehr","56000","Specific information on the traffic","DLM","56000","181","56000 Besondere Angaben zum Verkehr","56000 Specific information on the traffic");
$data[] = array("56001","AX_Netzknoten","56001","AX_NetworkNode","DLM","56001","182","56001 AX_Netzknoten","56001 AX_NetworkNode");
$data[] = array("56002","AX_Nullpunkt","56002","AX_DatumPoint","DLM","56002","183","56002 AX_Nullpunkt","56002 AX_DatumPoint");
$data[] = array("56003","AX_Abschnitt","56003","AX_section","DLM","56003","184","56003 AX_Abschnitt","56003 AX_section");
$data[] = array("56004","AX_Ast","56004","AX_Ast","DLM","56004","185","56004 AX_Ast","56004 AX_Ast");
$data[] = array("57000","Besondere Angaben zum Gewässer","57000","Specific information on the water body","DLM","57000","186","57000 Besondere Angaben zum Gewässer","57000 Specific information on the water body");
$data[] = array("57001","AX_Wasserspiegelhoehe","57001","AX_WaterSurfaceLevel","DLM","57001","187","57001 AX_Wasserspiegelhoehe","57001 AX_WaterSurfaceLevel");
$data[] = array("57002","AX_SchifffahrtslinieFaehrverkehr","57002","AX_ShippingLineFerryTraffic","DLM","57002","188","57002 AX_SchifffahrtslinieFaehrverkehr","57002 AX_ShippingLineFerryTraffic");
$data[] = array("57003","AX_Gewaesserstationierungsachse","57003","AX_WaterStationingAxis","DLM","57003","189","57003 AX_Gewaesserstationierungsachse","57003 AX_WaterStationingAxis");
$data[] = array("SIE04-Besondere Anlagen auf Siedlungsflächen","","SIE04-Special facilities on settlement areas","","DLM","SIE04","19","SIE04","SIE04");
$data[] = array("57004","AX_Sickerstrecke","57004","AX_SeepageCourse","DLM","57004","190","57004 AX_Sickerstrecke","57004 AX_SeepageCourse");
$data[] = array("61000","Reliefformen","61000","Relief forms","DLM","61000","191","61000 Reliefformen","61000 Relief forms");
$data[] = array("61001","AX_BoeschungKliff","61001","AX_SlopeCliff","DLM","61001","192","61001 AX_BoeschungKliff","61001 AX_SlopeCliff");
$data[] = array("61002","AX_Boeschungsflaeche","61002","AX_Breakline","DLM","61002","193","61002 AX_Boeschungsflaeche","61002 AX_Breakline");
$data[] = array("61003","AX_DammWallDeich","61003","AX_DamRampartDike","DLM","61003","194","61003 AX_DammWallDeich","61003 AX_DamRampartDike");
$data[] = array("61004","AX_Einschnitt","61004","AX_Cutting","DLM","61004","195","61004 AX_Einschnitt","61004 AX_Cutting");
$data[] = array("61005","AX_Hoehleneingang","61005","AX_CaveEntrance","DLM","61005","196","61005 AX_Hoehleneingang","61005 AX_CaveEntrance");
$data[] = array("61006","AX_FelsenFelsblockFelsnadel","61006","AX_RockBoulderRockspire","DLM","61006","197","61006 AX_FelsenFelsblockFelsnadel","61006 AX_RockBoulderRockspire");
$data[] = array("61007","AX_Duene","61007","AX_Dune","DLM","61007","198","61007 AX_Duene","61007 AX_Dune");
$data[] = array("61008","AX_Hoehenlinie","61008","AX_Contour","DLM","61008","199","61008 AX_Hoehenlinie","61008 AX_Contour");
$data[] = array("Gewässer","","water bodies","","DLM","Gewaesser","2","Gewässer","water bodies");
$data[] = array("SIE05-Gebäude","","SIE05-building","","DLM","SIE05","20","SIE05","SIE05");
$data[] = array("62000","Primäres DGM","62000","Primäres DGM","DLM","62000","200","62000 Primäres DGM","62000 Primäres DGM");
$data[] = array("62040","AX_Gelaendekante","62040","AX_Breakline","DLM","62040","201","62040 AX_Gelaendekante","62040 AX_Breakline");
$data[] = array("71000","Öffentlich-rechtliche und sonstige Festlegungen","71000","Öffentlich-rechtliche und sonstige Festlegungen","DLM","71000","202","71000 Öffentlich-rechtliche und sonstige Festlegungen","71000 Öffentlich-rechtliche und sonstige Festlegungen");
$data[] = array("71004","AX_AndereFestlegungNachWasserrecht","71004","AX_OtherSpecificationAccordingToWaterRight","DLM","71004","203","71004 AX_AndereFestlegungNachWasserrecht","71004 AX_OtherSpecificationAccordingToWaterRight");
$data[] = array("71005","AX_SchutzgebietNachWasserrecht","71005","AX_ProtectedAreaAccordingToWaterLaw","DLM","71005","204","71005 AX_SchutzgebietNachWasserrecht","71005 AX_ProtectedAreaAccordingToWaterLaw");
$data[] = array("71006","AX_NaturUmweltOderBodenschutzrecht","71006","AX_ConservationEnvironmentalOrSoilProtectionLaw","DLM","71006","205","71006 AX_NaturUmweltOderBodenschutzrecht","71006 AX_ConservationEnvironmentalOrSoilProtectionLaw");
$data[] = array("71007","AX_SchutzgebietNachNaturUmweltOderBodenschutzrecht","71007","AX_ProtectedAreaAccordingToConservationEnvironmentalOrSoilProtectionLaw","DLM","71007","206","71007 AX_SchutzgebietNachNaturUmweltOderBodenschutzrecht","71007 AX_ProtectedAreaAccordingToConservationEnvironmentalOrSoilProtectionLaw");
$data[] = array("71009","AX_Denkmalschutzrecht","71009","AX_MonumentProtectionLaw","DLM","71009","207","71009 AX_Denkmalschutzrecht","71009 AX_MonumentProtectionLaw");
$data[] = array("71011","AX_SonstigesRecht","71011","AX_OtherLaw","DLM","71011","208","71011 AX_SonstigesRecht","71011 AX_OtherLaw");
$data[] = array("71012","AX_Schutzzone","71012","AX_ProtectionArea","DLM","71012","209","71012 AX_Schutzzone","71012 AX_ProtectionArea");
$data[] = array("VEG01-Landwirtschaftliche Nutzfläche","","VEG01-Farmland","","DLM","VEG01","21","VEG01","VEG01");
$data[] = array("73000","Kataloge","73000","Kataloge","DLM","73000","210","73000 Kataloge","73000 Kataloge");
$data[] = array("73001","AX_Nationalstaat","73001","AX_Nationalstaat","DLM","73001","211","73001 AX_Nationalstaat","73001 AX_Nationalstaat");
$data[] = array("73002","AX_Bundesland","73002","AX_FederalState","DLM","73002","212","73002 AX_Bundesland","73002 AX_FederalState");
$data[] = array("73003","AX_Regierungsbezirk","73003","AX_AdministrativeDistrict","DLM","73003","213","73003 AX_Regierungsbezirk","73003 AX_AdministrativeDistrict");
$data[] = array("73004","AX_KreisRegion","73004","AX_DistrictRegion","DLM","73004","214","73004 AX_KreisRegion","73004 AX_DistrictRegion");
$data[] = array("73005","AX_Gemeinde","73005","AX_Municipality","DLM","73005","215","73005 AX_Gemeinde","73005 AX_Municipality");
$data[] = array("73006","AX_Gemeindeteil","73006","AX_Gemeindeteil","DLM","73006","216","73006 AX_Gemeindeteil","73006 AX_Gemeindeteil");
$data[] = array("73009","AX_Verwaltungsgemeinschaft","73009","AX_Verwaltungsgemeinschaft","DLM","73009","217","73009 AX_Verwaltungsgemeinschaft","73009 AX_Verwaltungsgemeinschaft");
$data[] = array("73013","AX_LagebezeichnungKatalogeintrag","73013","AX_PlaceNameCatalogEntry","DLM","73013","218","73013 AX_LagebezeichnungKatalogeintrag","73013 AX_PlaceNameCatalogEntry");
$data[] = array("73014","AX_Gemeindekennzeichen","73014","AX_Gemeindekennzeichen","DLM","73014","219","73014 AX_Gemeindekennzeichen","73014 AX_Gemeindekennzeichen");
$data[] = array("VEG02-Forstwirtschaftliche Nutzfläche","","VEG02-Woodland","","DLM","VEG02","22","VEG02","VEG02");
$data[] = array("73015","AX_Katalogeintrag","73015","AX_Katalogeintrag","DLM","73015","220","73015 AX_Katalogeintrag","73015 AX_Katalogeintrag");
$data[] = array("73018","AX_Bundesland_Schluessel","73018","AX_Bundesland_Schluessel","DLM","73018","221","73018 AX_Bundesland_Schluessel","73018 AX_Bundesland_Schluessel");
$data[] = array("73021","AX_Regierungsbezirk_Schluessel","73021","AX_Regierungsbezirk_Schluessel","DLM","73021","222","73021 AX_Regierungsbezirk_Schluessel","73021 AX_Regierungsbezirk_Schluessel");
$data[] = array("73022","AX_Kreis_Schluessel","73022","AX_Kreis_Schluessel","DLM","73022","223","73022 AX_Kreis_Schluessel","73022 AX_Kreis_Schluessel");
$data[] = array("73023","AX_VerschluesselteLagebezeichnung","73023","AX_VerschluesselteLagebezeichnung","DLM","73023","224","73023 AX_VerschluesselteLagebezeichnung","73023 AX_VerschluesselteLagebezeichnung");
$data[] = array("73024","AX_Verwaltungsgemeinschaft_Schluessel","73024","AX_Verwaltungsgemeinschaft_Schluessel","DLM","73024","225","73024 AX_Verwaltungsgemeinschaft_Schluessel","73024 AX_Verwaltungsgemeinschaft_Schluessel");
$data[] = array("73025","AX_Verwaltungsgemeinschaft_ATKIS","73025","AX_Verwaltungsgemeinschaft_ATKIS","DLM","73025","226","73025 AX_Verwaltungsgemeinschaft_ATKIS","73025 AX_Verwaltungsgemeinschaft_ATKIS");
$data[] = array("74000","Geographische Gebietseinheiten","74000","Geographische Gebietseinheiten","DLM","74000","227","74000 Geographische Gebietseinheiten","74000 Geographische Gebietseinheiten");
$data[] = array("74001","AX_Landschaft","74001","AX_Landscape","DLM","74001","228","74001 AX_Landschaft","74001 AX_Landscape");
$data[] = array("74002","AX_KleinraeumigerLandschaftsteil","74002","AX_SmallScaleLandscapePart","DLM","74002","229","74002 AX_KleinraeumigerLandschaftsteil","74002 AX_SmallScaleLandscapePart");
$data[] = array("VEG03-Vegetationsflächen","","VEG03-Vegetation areas","","DLM","VEG03","23","VEG03","VEG03");
$data[] = array("74003","AX_Gewann","74003","AX_StripField","DLM","74003","230","74003 AX_Gewann","74003 AX_StripField");
$data[] = array("74004","AX_Insel","74004","AX_Island","DLM","74004","231","74004 AX_Insel","74004 AX_Island");
$data[] = array("74005","AX_Wohnplatz","74005","AX_Domicile","DLM","74005","232","74005 AX_Wohnplatz","74005 AX_Domicile");
$data[] = array("75000","Administrative Gebietseinheiten","75000","Administrative areal units","DLM","75000","233","75000 Administrative Gebietseinheiten","75000 Administrative areal units");
$data[] = array("75003","AX_KommunalesGebiet","75003","AX_MunicipalArea","DLM","75003","234","75003 AX_KommunalesGebiet","75003 AX_MunicipalArea");
$data[] = array("75004","AX_Gebiet_Nationalstaat","75004","AX_Region_State","DLM","75004","235","75004 AX_Gebiet_Nationalstaat","75004 AX_Region_State");
$data[] = array("75005","AX_Gebiet_Bundesland","75005","AX_Region_FederalState","DLM","75005","236","75005 AX_Gebiet_Bundesland","75005 AX_Region_FederalState");
$data[] = array("75006","AX_Gebiet_Regierungsbezirk","75006","AX_Region_AdministrativeDistrict","DLM","75006","238","75006 AX_Gebiet_Regierungsbezirk","75006 AX_Region_AdministrativeDistrict");
$data[] = array("75007","AX_Gebiet_Kreis","75007","AX_Region_District","DLM","75007","239","75007 AX_Gebiet_Kreis","75007 AX_Region_District");
$data[] = array("VEG04-Vegetationsmerkmal","","VEG04-Vegetation feature","","DLM","VEG04","24","VEG04","VEG04");
$data[] = array("75008","AX_Kondominium","75008","AX_Condominium","DLM","75008","240","75008 AX_Kondominium","75008 AX_Condominium");
$data[] = array("75009","AX_Gebietsgrenze","75009","AX_RegionalBoundary","DLM","75009","241","75009 AX_Gebietsgrenze","75009 AX_RegionalBoundary");
$data[] = array("75010","AX_Gebiet","75010","AX_Gebiet","DLM","75010","242","75010 AX_Gebiet","75010 AX_Gebiet");
$data[] = array("75011","AX_Gebiet_Verwaltungsgemeinschaft","75011","AX_Gebiet_Verwaltungsgemeinschaft","DLM","75011","243","75011 AX_Gebiet_Verwaltungsgemeinschaft","75011 AX_Gebiet_Verwaltungsgemeinschaft");
$data[] = array("81000","Nutzerprofile","81000","Nutzerprofile","DLM","81000","244","81000 Nutzerprofile","81000 Nutzerprofile");
$data[] = array("81001","AX_Benutzer","81001","AX_Benutzer","DLM","81001","245","81001 AX_Benutzer","81001 AX_Benutzer");
$data[] = array("81002","AX_Benutzergruppe","81002","AX_Benutzergruppe","DLM","81002","246","81002 AX_Benutzergruppe","81002 AX_Benutzergruppe");
$data[] = array("81003","AX_BenutzergruppeMitZugriffskontrolle","81003","AX_BenutzergruppeMitZugriffskontrolle","DLM","81003","247","81003 AX_BenutzergruppeMitZugriffskontrolle","81003 AX_BenutzergruppeMitZugriffskontrolle");
$data[] = array("81004","AX_BenutzergruppeNBA","81004","AX_BenutzergruppeNBA","DLM","81004","248","81004 AX_BenutzergruppeNBA","81004 AX_BenutzergruppeNBA");
$data[] = array("81005","AX_BereichZeitlich","81005","AX_BereichZeitlich","DLM","81005","249","81005 AX_BereichZeitlich","81005 AX_BereichZeitlich");
$data[] = array("VER01-Straßenverkehr","","VER01-road traffic","","DLM","VER01","25","VER01","VER01");
$data[] = array("81006","AX_Empfaenger","81006","AX_Empfaenger","DLM","81006","250","81006 AX_Empfaenger","81006 AX_Empfaenger");
$data[] = array("81007","AX_FOLGEVA","81007","AX_FOLGEVA","DLM","81007","251","81007 AX_FOLGEVA","81007 AX_FOLGEVA");
$data[] = array("997","Platzhalter für Verkehrstrassen (Bahn/Straße)","997","Platzhalter für Verkehrstrassen (Bahn/Straße)","DLM","997","252","997 Platzhalter für Verkehrstrassen (Bahn/Straße)","997 Platzhalter für Verkehrstrassen (Bahn/Straße)");
$data[] = array("998","bildabhängig, vorläufige Zuweisung nicht möglich","998","screen-depending, preliminary assignment not possible","DLM","998","253","998 bildabhängig, vorläufige Zuweisung nicht möglich","998 screen-depending, preliminary assignment not possible");
$data[] = array("99999","UeberfuehrungsUnterfuehrungsreferenz","99999","OverpassUnderpass reference","DLM","99999","254","99999 UeberfuehrungsUnterfuehrungsreferenz","99999 OverpassUnderpass reference");
$data[] = array("VER02-Wege","","VER02-ways","","DLM","VER02","26","VER02","VER02");
$data[] = array("VER03-Bahnverkehr","","VER03-Rail traffic","","DLM","VER03","27","VER03","VER03");
$data[] = array("VER04-Flugverkehr","","VER04-Air traffic","","DLM","VER04","28","VER04","VER04");
$data[] = array("VER05-Schiffsverkehr","","VER05-Shipping traffic","","DLM","VER05","29","VER05","VER05");
$data[] = array("Relief","","relief","","DLM","Relief","3","Relief","relief");
$data[] = array("VER06-Verkehrsbauwerke und -anlagen","","VER06-Traffic infrastructure and facilities","","DLM","VER06","30","VER06","VER06");
$data[] = array("VER07-Angaben zum Straßennetz","","VER07-Information on the road network","","DLM","VER07","31","VER07","VER07");
$data[] = array("Siedlung","","settlement","","DLM","Siedlung","4","Siedlung","settlement");
$data[] = array("02300","AP_GPO","02300","AP_GPO","DLM","02300","41","02300 AP_GPO","02300 AP_GPO");
$data[] = array("02300","AAA_Praesentationsobjekte","02300","AAA_presentation objects","DLM","02300","42","02300 AAA_Praesentationsobjekte","02300 AAA_presentation objects");
$data[] = array("02310","AP_PPO","02310","AP_PPO","DLM","02310","43","02310 AP_PPO","02310 AP_PPO");
$data[] = array("02320","AP_LPO","02320","AP_LPO","DLM","02320","44","02320 AP_LPO","02320 AP_LPO");
$data[] = array("02330","AP_FPO","02330","AP_FPO","DLM","02330","45","02330 AP_FPO","02330 AP_FPO");
$data[] = array("02340","AP_TPO","02340","AP_TPO","DLM","02340","46","02340 AP_TPO","02340 AP_TPO");
$data[] = array("02341","AP_PTO","02341","AP_PTO","DLM","02341","47","02341 AP_PTO","02341 AP_PTO");
$data[] = array("02342","AP_LTO","02342","AP_LTO","DLM","02342","48","02342 AP_LTO","02342 AP_LTO");
$data[] = array("02350","AP_Darstellung","02350","AP_representation","DLM","02350","49","02350 AP_Darstellung","02350 AP_representation");
$data[] = array("Vegetation","","vegetation","","DLM","Vegetation","5","Vegetation","vegetation");
$data[] = array("111","Durchgängig städtische Prägung ","111","Durchgängig städtische Prägung ","DLM","111","50","111 Durchgängig städtische Prägung ","111 Durchgängig städtische Prägung ");
$data[] = array("112","Nicht durchgängig städtische Prägung ","112","Nicht durchgängig städtische Prägung ","DLM","112","51","112 Nicht durchgängig städtische Prägung ","112 Nicht durchgängig städtische Prägung ");
$data[] = array("12000","Angaben zur Lage","12000","Details on the location","DLM","12000","52","12000 Angaben zur Lage","12000 Details on the location");
$data[] = array("12002","AX_LagebezeichnungMitHausnummer","12002","AX_PlaceNameWithHouseNumber","DLM","12002","53","12002 AX_LagebezeichnungMitHausnummer","12002 AX_PlaceNameWithHouseNumber");
$data[] = array("12003","AX_LagebezeichnungMitPseudonummer","12003","AX_PlaceNameWithPseudoNumber","DLM","12003","54","12003 AX_LagebezeichnungMitPseudonummer","12003 AX_PlaceNameWithPseudoNumber");
$data[] = array("12004","AX_Lagebezeichnung","12004","AX_Lagebezeichnung","DLM","12004","55","12004 AX_Lagebezeichnung","12004 AX_Lagebezeichnung");
$data[] = array("12005","AX_Lage","12005","AX_Lage","DLM","12005","56","12005 AX_Lage","12005 AX_Lage");
$data[] = array("12006","AX_GeoreferenzierteGebaeudeadresse","12006","AX_GeoreferenzierteGebaeudeadresse","DLM","12006","57","12006 AX_GeoreferenzierteGebaeudeadresse","12006 AX_GeoreferenzierteGebaeudeadresse");
$data[] = array("12007","AX_Post","12007","AX_Post","DLM","12007","58","12007 AX_Post","12007 AX_Post");
$data[] = array("121","Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","121","Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","DLM","121","59","121 Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","121 Industrie-und Gewerbeflächen, öffentliche Einrichtungen ");
$data[] = array("Verkehr","","traffic","","DLM","Verkehr","6","Verkehr","traffic");
$data[] = array("122","Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","122","Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","DLM","122","60","122 Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","122 Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ");
$data[] = array("123","Hafengebiete ","123","Hafengebiete ","DLM","123","61","123 Hafengebiete ","123 Hafengebiete ");
$data[] = array("124","Flughäfen ","124","Flughäfen ","DLM","124","62","124 Flughäfen ","124 Flughäfen ");
$data[] = array("131","Abbauflächen ","131","extraction sites","DLM","131","63","131 Abbauflächen ","131 extraction sites");
$data[] = array("132","Deponien und Abraumhalden ","132","Deponien und Abraumhalden ","DLM","132","64","132 Deponien und Abraumhalden ","132 Deponien und Abraumhalden ");
$data[] = array("133","Baustellen ","133","construction sites","DLM","133","65","133 Baustellen ","133 construction sites");
$data[] = array("141","Städtische Grünflächen ","141","Städtische Grünflächen ","DLM","141","66","141 Städtische Grünflächen ","141 Städtische Grünflächen ");
$data[] = array("142","Sport-und Freizeitanlagen ","142","Sport-und Freizeitanlagen ","DLM","142","67","142 Sport-und Freizeitanlagen ","142 Sport-und Freizeitanlagen ");
$data[] = array("21000","Personen- und Bestandsdaten","21000","Personen- und Bestandsdaten","DLM","21000","68","21000 Personen- und Bestandsdaten","21000 Personen- und Bestandsdaten");
$data[] = array("21001","AX_Person","21001","AX_Person","DLM","21001","69","21001 AX_Person","21001 AX_Person");
$data[] = array("GEB01-Verwaltungsgebiete","","GEB01-administrative regions","","DLM","GEB01","7","GEB01","GEB01");
$data[] = array("211","Nicht bewässertes Ackerland ","211","Nicht bewässertes Ackerland ","DLM","211","70","211 Nicht bewässertes Ackerland ","211 Nicht bewässertes Ackerland ");
$data[] = array("212","Regelmäßig bewässertes Ackerland ","212","Regelmäßig bewässertes Ackerland ","DLM","212","71","212 Regelmäßig bewässertes Ackerland ","212 Regelmäßig bewässertes Ackerland ");
$data[] = array("213","Reisfelder ","213","Reisfelder ","DLM","213","72","213 Reisfelder ","213 Reisfelder ");
$data[] = array("221","Weinbauflächen ","221","Weinbauflächen ","DLM","221","73","221 Weinbauflächen ","221 Weinbauflächen ");
$data[] = array("222","Obst-und Beerenobstbestände ","222","Obst-und Beerenobstbestände ","DLM","222","74","222 Obst-und Beerenobstbestände ","222 Obst-und Beerenobstbestände ");
$data[] = array("223","Olivenhaine ","223","Olivenhaine ","DLM","223","75","223 Olivenhaine ","223 Olivenhaine ");
$data[] = array("231","Wiesen und Weiden ","231","Wiesen und Weiden ","DLM","231","76","231 Wiesen und Weiden ","231 Wiesen und Weiden ");
$data[] = array("241","Einjährige Kulturen in Verbindung mit Dauerkulturen ","241","Einjährige Kulturen in Verbindung mit Dauerkulturen ","DLM","241","77","241 Einjährige Kulturen in Verbindung mit Dauerkulturen ","241 Einjährige Kulturen in Verbindung mit Dauerkulturen ");
$data[] = array("242","Komplexe Parzellenstrukturen ","242","Komplexe Parzellenstrukturen ","DLM","242","78","242 Komplexe Parzellenstrukturen ","242 Komplexe Parzellenstrukturen ");
$data[] = array("243","Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","243","Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","DLM","243","79","243 Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","243 Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ");
$data[] = array("GEB02-Geographische Gebiete","","GEB02-Geographical areas","","DLM","GEB02","8","GEB02","GEB02");
$data[] = array("244","Land-und forstwirtschaftliche Flächen ","244","Land-und forstwirtschaftliche Flächen ","DLM","244","80","244 Land-und forstwirtschaftliche Flächen ","244 Land-und forstwirtschaftliche Flächen ");
$data[] = array("31000","Angaben zum Gebäude","31000","Details on the building ","DLM","31000","81","31000 Angaben zum Gebäude","31000 Details on the building ");
$data[] = array("31001","AX_Gebaeude","31001","AX_Building","DLM","31001","82","31001 AX_Gebaeude","31001 AX_Building");
$data[] = array("31002","AX_Bauteil","31002","AX_component","DLM","31002","83","31002 AX_Bauteil","31002 AX_component");
$data[] = array("31006","AX_Nutzung_Gebaeude","31006","AX_Nutzung_Gebaeude","DLM","31006","84","31006 AX_Nutzung_Gebaeude","31006 AX_Nutzung_Gebaeude");
$data[] = array("311","Laubwälder ","311","Laubwälder ","DLM","311","85","311 Laubwälder ","311 Laubwälder ");
$data[] = array("312","Nadelwälder ","312","Nadelwälder ","DLM","312","86","312 Nadelwälder ","312 Nadelwälder ");
$data[] = array("313","Mischwälder ","313","Mischwälder ","DLM","313","87","313 Mischwälder ","313 Mischwälder ");
$data[] = array("321","Natürliches Grünland ","321","Natürliches Grünland ","DLM","321","88","321 Natürliches Grünland ","321 Natürliches Grünland ");
$data[] = array("322","Heiden und Moorheiden ","322","Heiden und Moorheiden ","DLM","322","89","322 Heiden und Moorheiden ","322 Heiden und Moorheiden ");
$data[] = array("GEB03-Schutzgebiete","","GEB03-Protected areas","","DLM","GEB03","9","GEB03","GEB03");
$data[] = array("323","Hartlaubbewuchs ","323","Hartlaubbewuchs ","DLM","323","90","323 Hartlaubbewuchs ","323 Hartlaubbewuchs ");
$data[] = array("324","Wald-Strauch-Übergangsstadien ","324","Wald-Strauch-Übergangsstadien ","DLM","324","91","324 Wald-Strauch-Übergangsstadien ","324 Wald-Strauch-Übergangsstadien ");
$data[] = array("331","Strände, Dünen und Sandflächen ","331","Strände, Dünen und Sandflächen ","DLM","331","92","331 Strände, Dünen und Sandflächen ","331 Strände, Dünen und Sandflächen ");
$data[] = array("332","Felsflächen ohne Vegetation ","332","Felsflächen ohne Vegetation ","DLM","332","93","332 Felsflächen ohne Vegetation ","332 Felsflächen ohne Vegetation ");
$data[] = array("333","Flächen mit spärlicher Vegetation ","333","Flächen mit spärlicher Vegetation ","DLM","333","94","333 Flächen mit spärlicher Vegetation ","333 Flächen mit spärlicher Vegetation ");
$data[] = array("334","Brandflächen ","334","Brandflächen ","DLM","334","95","334 Brandflächen ","334 Brandflächen ");
$data[] = array("335","Gletscher und Dauerschneegebiete ","335","Gletscher und Dauerschneegebiete ","DLM","335","96","335 Gletscher und Dauerschneegebiete ","335 Gletscher und Dauerschneegebiete ");
$data[] = array("41000","Tatsaechliche Nutzung - Siedlung","41000","Tatsaechliche Nutzung - Siedlung","DLM","41000","97","41000 Tatsaechliche Nutzung - Siedlung","41000 Tatsaechliche Nutzung - Siedlung");
$data[] = array("41001","AX_Wohnbauflaeche","41001","AX_ResidentialArea","DLM","41001","98","41001 AX_Wohnbauflaeche","41001 AX_ResidentialArea");
$data[] = array("41002","AX_IndustrieUndGewerbeflaeche","41002","AX_IndustrialZone","DLM","41002","99","41002 AX_IndustrieUndGewerbeflaeche","41002 AX_IndustrialZone");
$data[] = array("CIR","3-Kanal-Colorinfrarotbild, sog. Falschfarben (NIR–Rot–Grün)","CIR","3-Kanal-Colorinfrarotbild, sog. Falschfarben (NIR–Rot–Grün)","DOP","cir","1","CIR","CIR");
$data[] = array("IR","1-Kanal-Infrarotbild","IR","1-Kanal-Infrarotbild","DOP","ir","2","IR","IR");
$data[] = array("RGB","3-Kanal-Echtfarbbild (Rot-Grün-Blau)","RGB","3-Kanal-Echtfarbbild (Rot-Grün-Blau)","DOP","rgb","3","RGB","RGB");
$data[] = array("POI","","POI","","POI","POI","1","POI","POI");
$data[] = array("Justizvollzugsanstalten","","Justizvollzugsanstalten","","POI","Justizvollzugsanstalten","10","Justizvollzugsanstalten","Justizvollzugsanstalten");
$data[] = array("Krankenhäuser","","Krankenhäuser","","POI","Krankenhaeuser","11","Krankenhäuser","Krankenhäuser");
$data[] = array("Landespolizei","","Landespolizei","","POI","Landespolizei","12","Landespolizei","Landespolizei");
$data[] = array("Nationale Referenzzentren und Konsiliarlabore","","Nationale Referenzzentren und Konsiliarlabore","","POI","NationaleReferenzzentrenundKonsiliarlabore","13","Nationale Referenzzentren und Konsiliarlabore","Nationale Referenzzentren und Konsiliarlabore");
$data[] = array("Reha-Einrichtungen","","Reha-Einrichtungen","","POI","RehaEinrichtungen","14","Reha-Einrichtungen","Reha-Einrichtungen");
$data[] = array("Staatsanwaltschaften","","Staatsanwaltschaften","","POI","Staatsanwaltschaften","15","Staatsanwaltschaften","Staatsanwaltschaften");
$data[] = array("Technisches Hilfswerk","","Technisches Hilfswerk","","POI","TechnischesHilfswerk","16","Technisches Hilfswerk","Technisches Hilfswerk");
$data[] = array("UN-Organisationen in Deutschland","","UN-Organisationen in Deutschland","","POI","UNOrganisationeninDeutschland","17","UN-Organisationen in Deutschland","UN-Organisationen in Deutschland");
$data[] = array("Zentrales Adress- und Kommunikationsverzeichnis","","Zentrales Adress- und Kommunikationsverzeichnis","","POI","ZentralesAdressundKommunikationsverzeichnis","18","Zentrales Adress- und Kommunikationsverzeichnis","Zentrales Adress- und Kommunikationsverzeichnis");
$data[] = array("Zoll","","Zoll","","POI","Zoll","19","Zoll","Zoll");
$data[] = array("POI-BPol","","POI-BPol","","POI","POIBPol","2","POI-BPol","POI-BPol");
$data[] = array("Berufsfeuerwehren","","Berufsfeuerwehren","","POI","Berufsfeuerwehren","3","Berufsfeuerwehren","Berufsfeuerwehren");
$data[] = array("Botschaften und Konsulate in Deutschland","","Botschaften und Konsulate in Deutschland","","POI","BotschaftenundKonsulateinDeutschland","4","Botschaften und Konsulate in Deutschland","Botschaften und Konsulate in Deutschland");
$data[] = array("Bundesbehörden","","Bundesbehörden","","POI","Bundesbehoerden","5","Bundesbehörden","Bundesbehörden");
$data[] = array("Bundesbehörden und Einrichtungen des Bundes","","Bundesbehörden und Einrichtungen des Bundes","","POI","BundesbehoerdenundEinrichtungendesBundes","6","Bundesbehörden und Einrichtungen des Bundes","Bundesbehörden und Einrichtungen des Bundes");
$data[] = array("Bundespolizei","","Bundespolizei","","POI","Bundespolizei","7","Bundespolizei","Bundespolizei");
$data[] = array("Gerichte","","Gerichte","","POI","Gerichte","8","Gerichte","Gerichte");
$data[] = array("Hochschulen","","Hochschulen","","POI","Hochschulen","9","Hochschulen","Hochschulen");
$data[] = array("Grundriss/Schrift","( Layer 1 + 2 + 7 )","ground plan/lettering","( Layer 1 + 2 + 7 )","Raster","GrundrissSchrift","10","Grundriss/Schrift","ground plan/lettering");
$data[] = array("Grundriss/Schrift","","ground plan/lettering","","Raster","GrundrissSchrift","11","Grundriss/Schrift","ground plan/lettering");
$data[] = array("Grundriss/Schrift","( Layer 1 + 2 + 6 + 7 )","ground plan/lettering","( Layer 1 + 2 + 6 + 7 )","Raster","GrundrissSchrift","12","Grundriss/Schrift","ground plan/lettering");
$data[] = array("Höhenlinien","( Layer 4 + 2 )","relief","( Layer 4 + 2 )","Raster","Hoehenlinien","13","Höhenlinien","relief");
$data[] = array("Höhenlinien","( Layer 4 )","relief","( Layer 4 )","Raster","Hoehenlinien","14","Höhenlinien","relief");
$data[] = array("Höhenschichten","( Layer 9)","contour levels","( Layer 9)","Raster","Hoehenschichten","15","Höhenschichten","contour levels");
$data[] = array("Relief","( Layer 4  + 12 )","relief","( Layer 4  + 12 )","Raster","Relief","16","Relief","relief");
$data[] = array("Schummerung","( Layer 8)","shading","( Layer 8)","Raster","Schummerung","17","Schummerung","shading");
$data[] = array("UTM - Gitter","( Layer 11)","UTM grid","( Layer 11)","Raster","UTMGitter","18","UTM - Gitter","UTM grid");
$data[] = array("Vegetation","( Layer  5 )","vegetation","( Layer  5 )","Raster","Vegetation","19","Vegetation","vegetation");
$data[] = array("Vegetation","( Layer 1 + 5 )","vegetation","( Layer 1 + 5 )","Raster","Vegetation","20","Vegetation","vegetation");
$data[] = array("Verwaltungsgebiete","( Layer 6)","Verwaltungsgebiete","( Layer 6)","Raster","Verwaltungsgebiete","21","Verwaltungsgebiete","Verwaltungsgebiete");
$data[] = array("Layer 1","Straßenänder, Zug, Felse, schwarze Schrift","Layer 1","Straßenänder,Zug,Felse, schwarze Schrift","Raster","schw","22","Layer1","Layer1");
$data[] = array("Layer 2","Schwarze Schrift","Layer 2","Schwarze Schrift","Raster","swtx","23","Layer2","Layer2");
$data[] = array("Layer 3","Hochspannungsleitungen, Sand, Berge, braune Schrift","Layer 3","Hochspannungsleitungen, Sand,Berge, braune Schrift","Raster","grbr","24","Layer3","Layer3");
$data[] = array("Layer 4","Höhenlinien","Layer 4","Höhenlinien","Raster","rebr","25","Layer4","Layer4");
$data[] = array("Layer 5","Gewässerkonturen, blaue Schrift","Layer 5","Gewässerkonturen, blaue Schrift","Raster","babl","26","Layer5","Layer5");
$data[] = array("Layer 6","Baumgrüne Symbole und Schrift","Layer 6","Baumgrüne Symbole und Schrift","Raster","baum","27","Layer6","Layer6");
$data[] = array("Layer 7","Verwaltungsgrenzen","Layer 7","Verwaltungsgrenze","Raster","viol","28","Layer7","Layer7");
$data[] = array("Layer 8","","Layer 8","","Raster","Layer8","29","Layer8","Layer8");
$data[] = array("Layer 9","Gebäude ausserhalb von Siedlungen","Layer 9","Gebäude ausserhalb von Siedlungen","Raster","haus","30","Layer9","Layer9");
$data[] = array("Layer 10","Decker von ungeordn. Straßen, weiße Schrift","Layer 10","Decker von ungeordn. Straßen, weiße Schrift","Raster","weis","31","Layer10","Layer10");
$data[] = array("Layer 11","Gewässer (decker)","Layer 11","Gewässer (decker)","Raster","sebl","32","Layer11","Layer11");
$data[] = array("Layer 12","Siedlungsfläche, offene Bebauung","Layer 12","Siedlungsfläche, offene Bebauung","Raster","hrot","33","Layer12","Layer12");
$data[] = array("Layer 13","Industrie und Gewerbe,Bergbau, Bahnverkehr, Schiffahrtsinfrastruktur","Layer 13","Industrie und Gewerbe,Bergbau, Bahnverkehr, Schiffahrtsinfrastruktur","Raster","grau","34","Layer13","Layer13");
$data[] = array("Layer 14","Weinbau und Hopfenflächen","Layer 14","Weinbau und Hopfenflächen","Raster","acke","35","Layer14","Layer14");
$data[] = array("Layer 15","Klärbecken, Torf, Moor, Sumpf","Layer 15","Klärbecken, Torf, Moor, Sumpf","Raster","brac","36","Layer15","Layer15");
$data[] = array("Layer 16","Forst","Layer 16","Forst","Raster","wald","37","Layer16","Layer16");
$data[] = array("Layer 17","Flughafen, Friedhöfe","Layer 17","Flughafen, Friedhöfe","Raster","wies","38","Layer17","Layer17");
$data[] = array("Layer 18","Sport, Freizeit, Garten und Erholungsflächen","Layer 18","Sport, Freizeit, Garten und Erholungsflächen","Raster","park","39","Layer18","Layer18");
$data[] = array("Summen- und Einzellayer","","combined and single layers","","Raster","SummenundEinzellayer","4","Summen- und Einzellayer","combined and single layers");
$data[] = array("Layer 19","Autobahn und Bundesstraßen (Decker)","Layer 19","Autobahn und Bundesstraßen (Decker)","Raster","stor","40","Layer19","Layer19");
$data[] = array("Layer 20","Staats- und Landesstraßen + Symbole (Decker)","Layer 20","Staats- und Landesstraßen + Symbole (Decker)","Raster","stge","41","Layer20","Layer20");
$data[] = array("Layer 21","Wattflächen","Layer 21","Wattflächen","Raster","watt","42","Layer21","Layer21");
$data[] = array("Layer 22","UTM-Gitter mit Schrift","Layer 22","UTM-Gitter mit Schrift","Raster","utmg","43","Layer22","Layer22");
$data[] = array("Layer 23","Siedlung, geschlossene Bebauung","Layer 23","Siedlung, geschl. Bebauung","Raster","mrot","44","Layer23","Layer23");
$data[] = array("Layer 24","Truppenübungsplatzgrenzen","Layer 24","Truppenübungsplatzgrenzen","Raster","trup","45","Layer24","Layer24");
$data[] = array("Layer 25","Heideflächen","Layer 25","Heideflächen","Raster","heid","46","Layer25","Layer25");
$data[] = array("Summenlayer","","combined layer","","Raster","Summenlayer","5","Summenlayer","combined layer");
$data[] = array("Geo - Netz","( Layer 10)","Geo-network","( Layer 10)","Raster","GeoNetz","7","Geo - Netz","Geo-network");
$data[] = array("Gewässer","","water bodies","( Layer 3  )","Raster","Gewaesser","8","Gewässer","water bodies");
$data[] = array("Gewässer","( Layer 3 )","water bodies","( Layer 3 )","Raster","Gewaesser","9","Gewässer","water bodies");
$data[] = array("NUTS1","","NUTS1","","Sonstiges","NUTS1","1","NUTS1","NUTS1");
$data[] = array("NUTS2","","NUTS2","","Sonstiges","NUTS2","2","NUTS2","NUTS2");
$data[] = array("NUTS3","","NUTS3","","Sonstiges","NUTS3","3","NUTS3","NUTS3");
$data[] = array("Staat","","state","","Verwaltungsgebiet","Staat","1","Staat","state");
$data[] = array("Bundesländer","","Federal States (Bundeslaender)","","Verwaltungsgebiet","Bundeslaender","2","Bundesländer","Federal States (Bundeslaender)");
$data[] = array("Regierungsbezirke","","1st order administrative districts in Germany (Regierungsbezirke)","","Verwaltungsgebiet","Regierungsbezirke","3","Regierungsbezirke","1st order administrative districts in Germany (Regierungsbezirke)");
$data[] = array("Verwaltungsgemeinschaften","","administrative communities","","Verwaltungsgebiet","Verwaltungsgemeinschaften","4","Verwaltungsgemeinschaften","administrative communities");
$data[] = array("Kreise","","2nd order districts in Germany (Kreise)","","Verwaltungsgebiet","Kreise","5","Kreise","2nd order districts in Germany (Kreise)");
$data[] = array("Gemeinden","","communes","","Verwaltungsgebiet","Gemeinden","6","Gemeinden","communes");
//"0 EBENEN_DEU","1 EBENEN_NAME_DEU","2 EBENEN_ENG","3 EBENEN_NAME_ENG","4 KATEGORIE","5 CODE","6 POSITION","7 KUERZEL_DEU","8 KUERZEL_ENG");

$cat = null;
foreach($data as $row)
{
    if(($cat == NULL) ||($cat->getLabel() != $this->getRowValue($row,4)))
    {
        $cat = $this->addCategory($this->getRowValue($row,4));
    }


	$object = Mage::getModel('virtualgeo/components_content');
	$object->setCode($this->getRowValue($row,5))
	->setName($this->getRowValue($row,0))
	->setShortname($this->getRowValue($row,7))
	->setDescription($this->getRowValue($row,1))
    ->setCategoryId($cat->getId())
	->setPos($this->getRowValue($row,6)*100)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,8))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$data = array();
//"0 BESCHREIBUNG_DEU","1 HINWEIS_DEU","2 BESCHREIBUNG_ENG","3 HINWEIS_ENG","4 CODE","5 POSITION","6 KUERZEL_DEU","7 KUERZEL_ENG");
$data[] = array("Dummy","","dummy","","EE","1","","");
$data[] = array("Bundesland","Je Bundesland und Layer wird eine Gesamtdatei geliefert.","Federal State","An overall file is delivered per Federal State and layer.","bland","2","Bundesland","Bundesland");
$data[] = array("Bundesland","Je Bundesland werden mehrere Dateien geliefert.","Federal State","Per federal state several files are delivered.","bland","3","Bundesland","Bundesland");
$data[] = array("Bundesland","Je Bundesland wird eine Datei geliefert.","Federal State","Per federal state one file is delivered.","bland","4","Bundesland","Bundesland");
$data[] = array("Einzelblätter 1:25 000","Das gewählte Gebiet wird in Form von Kartenblättern geliefert. <br> An den Grenzen Deutschlands können Kartenblätter auftreten, die nur partiell gefüllt sind.<br>Dateien werden je Layer und Kartenblatt gebildet.","Single sheets 1:25,000","The selected area is delivered as map sheets.On the borders of Germany map sheets are possible that are only partially filled. Files are generated per layer and map sheet.","blatt","5","Blatt 1:25.000","Blatt 1:25.000");
$data[] = array("Einzelblätter 1:50 000","Das gewählte Gebiet wird in Form von Kartenblättern geliefert. <br> An den Grenzen Deutschlands können Kartenblätter auftreten, die nur partiell gefüllt sind.<br>Dateien werden je Layer und Kartenblatt gebildet.","Single sheets 1:50,000","The selected area is delivered as map sheets. On the borders of Germany map sheets are possible that are only partially filled. Files are generated per layer and map sheet.","blatt","6","Blatt 1:50.000","Blatt 1:50.000");
$data[] = array("Einzelblätter 1:100 000","Das gewählte Gebiet wird in Form von Kartenblättern geliefert. <br> An den Grenzen Deutschlands können Kartenblätter auftreten, die nur partiell gefüllt sind.<br>Dateien werden je Layer und Kartenblatt gebildet.","Single sheets 1:100,000","The selected area is delivered as map sheets.On the borders of Germany map sheets are possible that are only partially filled. Files are generated per layer and map sheet.","blatt","7","Blatt 1:100.000","Blatt 1:100.000");
$data[] = array("Einzelblätter 1:200 000","Das gewählte Gebiet wird in Form von Kartenblättern geliefert. <br> An den Grenzen Deutschlands können Kartenblätter auftreten, die nur partiell gefüllt sind.<br>Dateien werden je Layer und Kartenblatt gebildet.","Single sheets 1:200,000","The selected area is delivered as map sheets.On the borders of Germany map sheets are possible that are only partially filled. Files are generated per layer and map sheet.","blatt","8","Blatt 1:200.000","Blatt 1:200.000");
$data[] = array("Einzelblatt 1:500 000","Je Layer wird eine Gesamtdatei für Deutschland geliefert.","Single sheet 1:500,000","An overall file for Germany is delivered per layer.","blatt","9","Blatt 1:500.000","Blatt 1:500.000");
$data[] = array("Einzelblatt 1:1 000 000","Je Layer wird eine Gesamtdatei für Deutschland geliefert.","Single sheet 1:1,000,000","An overall file for Germany is delivered per layer.","blatt","10","Blatt 1:1.000.000","Blatt 1:1.000.000");
$data[] = array("Gesamtdatei Deutschland","Je Layer wird eine Gesamtdatei für Deutschland geliefert.","Total file of Germany","An overall file for Germany is delivered per layer.","datei","11","Datei","Datei");
$data[] = array("Gesamtdatei Deutschland","Je Ebene wird eine Gesamtdatei für Deutschland geliefert.","Total file of Germany","An overall file for Germany is delivered per layer.","datei","12","Datei","Datei");
$data[] = array("Gesamtdatei","Es wird eine Gesamtdatei geliefert.","Complete file","A complete file is delivered","datei","13","Datei","Datei");
$data[] = array("Gesamtdatei ","Je Layer wird eine Gesamtdatei geliefert.","Total file of Germany ","An overall file for Germany is delivered per layer.","datei","14","Datei","Datei");
$data[] = array("Datenbestand RapidEye","Das gewählte Gebiet wird in Form vollständiger Kacheln geliefert.","Data stock RapidEye","The selected area is delivered in form of complete tiles.","datenbestand","20","Datenbestand","Datenbestand");
$data[] = array("Geoid","BRD - gesamtes Geoid","Geoid","Entire geoid","geoid","21","Geoid","Geoid");
$data[] = array("Geoid Küste","Gebiet Meeresgebiet Nord-/Ostsee","Geoid coast","Gebiet Meeresgebiet Nord-/Ostsee","kueste","22","Geoid Küste","Geoid Küste");
$data[] = array("Teilgeoid","BRD - Teilregionen des Geoid","Partial geoid","Partial regions of the geoid","teilgeoid","23","Teilgeoid","Teilgeoid");
$data[] = array("AdV-Kacheln 20km x 20km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,<br>die an den Grenzen Deutschlands nur partiell gefüllt sind. ","Tiles 20km x 20km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","24","AdV-Kacheln 20km","AdV-Kacheln 20km");
$data[] = array("AdV-Kacheln 80km x 80km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,<br>die an den Grenzen Deutschlands nur partiell gefüllt sind. ","Tiles 80km x 80km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","25","AdV-Kacheln 80km","AdV-Kacheln 80km");
$data[] = array("AdV-Kacheln 40km x 40km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,<br>die an den Grenzen Deutschlands nur partiell gefüllt sind. ","Tiles 40km x 40km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","26","AdV-Kacheln 40km","AdV-Kacheln 40km");
$data[] = array("Kacheln 10km x 10km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,die an den Grenzen Deutschlands nur partiell gefüllt sind. Dateien werdenje Layer und Kachel gebildet.","Tiles 10km x 10km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","27","Kacheln 10km","Kacheln 10km");
$data[] = array("Kacheln 20km x 20km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,die an den Grenzen Deutschlands nur partiell gefüllt sind. Dateien werdenje Layer und Kachel gebildet.","Tiles 20km x 20km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","28","Kacheln 20km","Kacheln 20km");
$data[] = array("Kacheln 40km x 40km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,die an den Grenzen Deutschlands nur partiell gefüllt sind. Dateien werdenje Layer und Kachel gebildet.","Tiles 40km x 40km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","29","Kacheln 40km","Kacheln 40km");
$data[] = array("Kacheln 80km x 80km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,die an den Grenzen Deutschlands nur partiell gefüllt sind. Dateien werdenje Layer und Kachel gebildet.","Tiles 80km x 80km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. Files are generated per layer and tile.","kachel","30","Kachel 80km","Kachel 80km");
$data[] = array("Kacheln 2km x 2km bzw. 1km x 1km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,die an den Grenzen Deutschlands teilweise nur partiell gefüllt sind. ","Tiles 2km x 2km or 1km x1km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. ","kachel","31","Kacheln 2km + 1km","Kacheln 2km + 1km");
$data[] = array("Kacheln 1km x 1km","Das gewählte Gebiet wird in Form von quadratischen Kacheln geliefert,die an den Grenzen Deutschlands teilweise nur partiell gefüllt sind. ","Tiles 1km x 1km","The selected area is delivered as quadratic tiles which on the borders of Germany are only filled partially. ","kachel","32","AdV-Kacheln 1km","AdV-Kacheln 1km");
$data[] = array("Rasterkachelarchiv","Das gewählte Gebiet wird in Form einer Sammlung von Bildkacheln einer Karte geliefert, die für fest definierte Maßstabsstufen vorberechnet wurden.","Rasterkachelarchiv","The selected area is delivered in form of a collection of image tiles of a map that were precomputed for fixed scale stages.","kachelarchiv","33","Rasterkachelarchiv","Rasterkachelarchiv");
$data[] = array("Rasterkachelarchiv 2km x 2km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 2km x 2km geliefert.","Rasterkachelarchiv 2km x 2km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","34","Rasterkachelarchiv 2km","Rasterkachelarchiv 2km");
$data[] = array("Rasterkachelarchiv 4km x 4km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 4km x 4km geliefert.","Rasterkachelarchiv 4km x 4km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","35","Rasterkachelarchiv 4km","Rasterkachelarchiv 4km");
$data[] = array("Rasterkachelarchiv 10km x 10km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 10km x 10km geliefert.","Rasterkachelarchiv 10km x 10km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","36","Rasterkachelarchiv 10km","Rasterkachelarchiv 10km");
$data[] = array("Rasterkachelarchiv 20km x 20km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 20km x 20km geliefert.","Rasterkachelarchiv 20km x 20km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","37","Rasterkachelarchiv 20km","Rasterkachelarchiv 20km");
$data[] = array("Rasterkachelarchiv 40km x 40km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 40km x 40km geliefert.","Rasterkachelarchiv 40km x 40km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","38","Rasterkachelarchiv 40km","Rasterkachelarchiv 40km");
$data[] = array("Rasterkachelarchiv 105km x 105km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 105km x 105km geliefert.","Rasterkachelarchiv 105km x 105km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","39","Rasterkachelarchiv 105km","Rasterkachelarchiv 105km");
$data[] = array("Rasterkachelarchiv 120km x 120km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 120km x 120km geliefert.","Rasterkachelarchiv 120km x 120km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","40","Rasterkachelarchiv 120km","Rasterkachelarchiv 120km");
$data[] = array("Rasterkachelarchiv 200km x 200km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 200km x 200km geliefert.","Rasterkachelarchiv 200km x 200km","The selected area is delivered in form of a collection of image tiles of a map that were precomputed for fixed scale stages.","kachelarchiv","41","Rasterkachelarchiv 200km","Rasterkachelarchiv 200km");
$data[] = array("Rasterkachelarchiv 1000km x 1000km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 1000km x 1000km geliefert.","Rasterkachelarchiv 1000km x 1000km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","42","Rasterkachelarchiv 1000km","Rasterkachelarchiv 1000km");
$data[] = array("Kachelliste Geogitter","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln geliefert.","Kachelliste Geogitter","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln geliefert.","kachelarchiv","43","Kachelarchiv GeoGitter","Kachelarchiv GeoGitter");
$data[] = array("Gesamtdatei EBM","Das gewählte Gebiet umfasst alle EBM-Länder als Ganzes.","EBM-Gebiet","The selected area covers all EBM countries as a whole.","europa","44","Datei EBM","Datei EBM");
$data[] = array("Gesamtdatei ERM","Das gewählte Gebiet umfasst alle ERM-Länder als Ganzes.","ERM-Gebiet","The selected area covers all ERM countries as a whole.","europa","45","Datei ERM","Datei ERM");
$data[] = array("Rasterkachelarchiv Europa","Das gewählte Gebiet wird in Form einer Sammlung von Bildkacheln einer Karte geliefert, die für fest definierte Maßstabsstufen vorberechnet wurden.","Rasterkachelarchiv Europa","The selected area is delivered in form of a collection of image tiles of a map that were precomputed for fixed scale stages.","kachelarchiv","46","Rasterkachelarchiv Europa","Rasterkachelarchiv Europa");
$data[] = array("Rasterkachelarchiv Europa 1000km x 1000km","Das gewählte Gebiet wird in Form einer Sammlung von Kacheln der Größe 1000km x 1000km geliefert.","Rasterkachelarchiv Europa 1000km x 1000km","The selected area is delivered in form of a collection of image tiles of a map.","kachelarchiv","47","Rasterkachelarchiv Europa 1000km","Rasterkachelarchiv Europa 1000km");
//"0 BESCHREIBUNG_DEU","1 HINWEIS_DEU","2 BESCHREIBUNG_ENG","3 HINWEIS_ENG","4 CODE","5 POSITION","6 KUERZEL_DEU","7 KUERZEL_ENG");


$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_structure');
	$object
	//->setType($this->getRowValue($row,0))
	->setCode($this->getRowValue($row,4))
	->setName($this->getRowValue($row,0))
	->setShortname($this->getRowValue($row,6))
	->setDescription($this->getRowValue($row,1))
	->setPos($n)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,3))
	->setDescription($this->getRowValue($row,7))
	->save();
}

$installer->endSetup();

$data = array();
//"0 AUFLOESUNG_DEU","1 EINHEIT_DEU","2 AUFLOESUNG_ENG","3 EINHEIT_ENG","4 CODE","5 POSITION","6 KUERZEL_DEU","7 KUERZEL_ENG");
$data[] = array("0","0","0","","0","1","0","0");
$data[] = array("1","","1","","1","2","1 ","1 ");
$data[] = array("60 x 60 ","(in m)","60 x 60 ","(in m)","60x60","10","60x60 m","60x60 m");
$data[] = array("50 x 50 ","(in m)","50 x 50 ","(in m)","50x50","11","50x50 m","50x50 m");
$data[] = array("20 x 20 / 40 x 40","(in m)","20 x 20 / 40 x 40","(in m)","40x40","13","40x40 m","40x40 m");
$data[] = array("25 x 25 ","(in m)","25 x 25 ","(in m)","25x25","14","25x25 m","25x25 m");
$data[] = array("20 x 20","(in m)","20 x 20","(in m)","20x20","15","20x20 m","20x20 m");
$data[] = array("10 x 10 ","(in m)","10 x 10 ","(in m)","10x10","16","10x10 m","10x10 m");
$data[] = array("5 x 5 ","(in m) ","5 x 5 ","(in m)","5x5","17","5x5 m ","5x5 m ");
$data[] = array("5 x 5 ","(in km)","5 x 5 ","(in m)","5x5","18","5x5 km","5x5 km");
$data[] = array("1 x 1","(in km)","1 x 1","(in km)","1x1","19","1x1 km","1x1 km");
$data[] = array("0,5 x 0,5 ","(in km)","0,5 x 0,5 ","(in km)","0.5x0.5","20","0.5x0.5 km","0.5x0.5 km");
$data[] = array("0,25 x 0,25 ","(in km)","0,25 x 0,25 ","(in km)","0.25x0.25","21","0.25x0.25 km","0.25x0.25 km");
$data[] = array("0,1 x 0,1","(in km)","0,1 x 0,1","(in km)","0.1x0.1","22","0.1x0.1 km","0.1x0.1 km");
$data[] = array("ca. 1000 x 1000 ","(in m)","ca. 1000 x 1000 ","(in m)","ca.1000x1000","7","ca.1000x1000 m","ca.1000x1000 m");
$data[] = array("200 x 200 ","(in m)","200 x 200 ","(in m)","200x200","8","200x200 m","200x200 m");
$data[] = array("100 x 100 ","(in m)","100 x 100 ","(in m)","100x100","9","100x100 m","100x100 m");
$data[] = array("160","Pixel/cm","160","Pixel/cm","160","3","160 Pixel/cm","160 Pixel/cm");
$data[] = array("200","Pixel/cm","200","Pixel/cm","200","4","200 Pixel/cm","200 Pixel/cm");
$data[] = array("250","Pixel/cm","250","Pixel/cm","250","5","250 Pixel/cm","250 Pixel/cm");
$data[] = array("320","Pixel/cm","320","Pixel/cm","320","6","320 Pixel/cm","320 Pixel/cm");
$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_resolution');
	$name = trim($this->getRowValue($row,0)." ".$this->getRowValue($row,1));
	$object
	->setCode($this->getRowValue($row,4))
	->setName($name)
	->setShortname($this->getRowValue($row,6))
	//->setDescription($name)
	->setPos($this->getRowValue($row,5)*100)
	->save();
	$name = trim($this->getRowValue($row,2)." ".$this->getRowValue($row,3));
	$object->setStoreId($storeId_EN)
	->setName($name)
	->setShortname($this->getRowValue($row,7))
	//->setDescription($name)
	->save();
}


$data = array();
//"0 BESCHREIBUNG_DEU","1 BESCHREIBUNG_ENG","2 CODE","3 POSITION","4 KUERZEL_DEU","5 KUERZEL_ENG");
$data[] = array("Download","Download","download","1","Download","Download");
$data[] = array("CD-DVD","CD-DVD","cd_dvd","2","CD-DVD","CD-DVD");
$data[] = array("USB-Festplatte","USB-Festplatte","usb_platte","3","USB-Festplatte","USB-Festplatte");
$data[] = array("USB-Stick","USB-Stick","usb_stick","4","USB-Stick","USB-Stick");
$data[] = array("Sonstiges","Sonstiges","sonstiges","5","Sonstiges","Sonstiges");

$n = 0;
foreach($data as $row)
{
    $n += 100;
    $object = Mage::getModel('virtualgeo/components_storage');
    $object
        ->setCode($this->getRowValue($row,2))
        ->setName($this->getRowValue($row,0))
        ->setShortname($this->getRowValue($row,4))
        //->setDescription($this->getRowValue($row,0))
        ->setPos($this->getRowValue($row,3)*100)
        ->save();
    $object->setStoreId($storeId_EN)
        ->setName($this->getRowValue($row,1))
        ->setShortname($this->getRowValue($row,6))
       // ->setDescription($this->getRowValue($row,7))
        ->save();
}