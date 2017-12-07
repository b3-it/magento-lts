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

$installer = $this;

$installer->startSetup();





$storeId_EN = 2;

$data = array();
//"0 BESCHREIBUNG_DEU ","1 HINWEIS_DEU","2 BESCHREIBUNG_ENG","3 HINWEIS_ENG","4 EPSG","5 KUERZEL","6 CODE","7 POSITION");
$data[] = array("Dummy","","dummy","","-","EE","EE","1");
$data[] = array("Gauß-Krüger-Abbildung im 2. Meridianstreifen<br>(Mittelmeridian 6°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung. Besonders geeignet für blattschnittfreie Daten im Westen Deutschlands.","Gauss Kruger Projection in the 2nd longitude zone<br>(Central Meridian 6°)<br>Ellipsoid Bessel, Datum Potsdam","especially suited for data without sheet line system in the West of Germany","31466","GK2","gk2","2");
$data[] = array("Gauß-Krüger-Abbildung im 3. Meridianstreifen<br>(Mittelmeridian 9°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung. <br> Der 3. Streifen wurde oft auch für die Darstellung von deutschlandweiten Datensätzen verwendet.","Gauss Kruger Projection in the 3rd longitude zone<br>(Central Meridian 9°)<br>Ellipsoid Bessel, Datum Potsdam","common standard for Germany-wide data without sheet line system in the Gauss Kruger system","31467","GK3","gk3","3");
$data[] = array("Gauß-Krüger-Abbildung im 4. Meridianstreifen<br>(Mittelmeridian 12°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung. <br> Besonders geeignet für blattschnittfreie Daten im Osten Deutschlands.","Gauss Kruger Projection in the 4th longitude zone<br>(Central Meridian 12°)<br>Ellipsoid Bessel, Datum Potsdam","especially suited for data without sheet line system in the East of Germany","31468","GK4","gk4","4");
$data[] = array("Gauß-Krüger-Abbildung im 5. Meridianstreifen<br>(Mittelmeridian 15°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung. <br> Besonders geeignet für blattschnittfreie Daten im äußersten Osten Deutschlands.","Gauss Kruger Projection in the 5th longitude zone<br>(Central Meridian 15°)<br>Ellipsoid Bessel, Datum Potsdam","especially suited for data without sheet line system in the extreme East of Germany","31469","GK5","gk5","5");
$data[] = array("Lambert-Abbildung (winkeltreu)<br> längentreue Breitenkreise: 48°40' und 53°40'<br> Bezugsmittelpunkt: 10°30' ö.L., 51°00' n.B.<br> Ellipsoid GRS80, Datum ETRS89","besonders geeignet für deutschlandweite blattschnittfreie Daten bei möglichst geringen Verzerrungen","Lambert Projection (conformal)<br>isometric parallels of latitude: 48°40' and 53°40'<br>centre of reference: 10°30' EL, 51°00' NL<br>Ellipsoid GRS80, Datum ETRS89","especially suited for Germany-wide data without sheet line system with as little distortions as possible","5243","LAMGe","lamge","6");
$data[] = array("Lambert-Abbildung (winkeltreu)<br> längentreue Breitenkreise: 48°40' und 53°40'<br> Bezugsmittelpunkt: 10°30' ö.L., 51°00' n.B.<br> Ellipsoid WGS84, Datum WGS84","besonders geeignet für deutschlandweite blattschnittfreie Daten bei möglichst geringen Verzerrungen","Lambert Projection (conformal)<br>isometric parallels of latitude: 48°40' and 53°40'<br>centre of reference: 10°30' EL, 51°00' NL<br>Ellipsoid WGS84, Datum WGS84","especially suited for Germany-wide data without sheet line system with as little distortions as possible","-","LAMGw","lamgw","7");
$data[] = array("UTM-Abbildung in der Zone 32<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Sie unterscheidet sich von utm32w <br> durch ihren geodätischen Bezug.","UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89","","4647","UTM32e","utm32e","8");
$data[] = array("UTM-Abbildung in der Zone 33<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   15°<br>(Ellipsoid GRS80, Datum ETRS89)","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Sie unterscheidet sich von utm33w durch ihren geodätischen Bezug.","UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  GRS80,  Datum ETRS89","","5650","UTM33e","utm33e","9");
$data[] = array("UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","Standardsystem der deutschen Landesvermessung und international eingesetztes UTM-Systems. <br>Die Zone 32 wird oft auch für die Darstellung von deutschlandweiten Datensätzen verwendet.","UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89","common standard for Germany-wide data without sheet line system in the UTM system","25832","UTM32s","utm32s","10");
$data[] = array("UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   15°<br>(Ellipsoid GRS80, Datum ETRS89)","Standardsystem der deutschen Landesvermessung und international eingesetztes UTM-Systems.","UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  GRS80,  Datum ETRS89","especially suited for data without sheet line system in the East of Germany","25833","UTM33s","utm33s","11");
$data[] = array("UTM-Abbildung in der Zone 32<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid WGS84, Datum WGS84)","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Deutschland liegt überwiegend in der Zone 32, so dass diese auch für deutschlandweite blattschnittfreie Daten im UTM-System sehr geeignet ist.","UTM Projection in zone 32<br>(Centre 9°)<br> Ellipsoid WGS84, Datum WGS84 ","With zone indication at the beginning in the easting this georeferencing corresponds to a common form in Germany. Germany is mostly situated in the zone 32 so that this is very appropriate also for Germany-wide data without sheet line system in the UTM system.","-","UTM32w","utm32w","12");
$data[] = array("UTM-Abbildung in der Zone 33<br>mit führender Zonenangabe im Rechtswert <br>(Mittelmeridian   15°)<br>Ellipsoid WGS84, Datum WGS84","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Besonders geeignet für blattschnittfreie Daten im Osten Deutschlands.","UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  WGS84, Datum WGS84 ","especially suited for data without sheet line system in the East of Germany","-","UTM33w","utm33w","13");
$data[] = array("Geographische Koordinaten in Dezimalgrad <br> (Ellipsoid GRS80, Datum ETRS89)","","Geographical coordinates in decimal degrees <br>  (Ellipsoid GRS80, Datum ETRS89)","","4258","GEO89","geo89","14");
$data[] = array("Geographische Koordinaten in Dezimalgrad<br> Ellipsoid WGS84, Datum WGS84","","Geographical coordinates in decimal degrees <br> (Ellipsoid WGS84, Datum WGS84)","","4326","GEO84","geo84","15");
$data[] = array("UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","","UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","","3044","TM32","tm32","16");
$data[] = array("UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","","UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","","3045","TM33","tm33","17");
$data[] = array("Pseudo-Mercator<br>(Ellipsoid WGS84, Datum WGS84)","Sphärische Mercator-Projektion <br> Standardsystem für weltweite Webdienste z.B. von Google oder OpenStreetMap","Pseudo-Mercator<br>(Ellipsoid WGS84, Datum WGS84)","Standardsystem für Webdienste von Google oder OpenStreetMap","3857","PSEUDO_MERCATOR","psmerc","18");


foreach($data as $row)
{

	$object = Mage::getModel('virtualgeo/components_georef');
	$object->setCode($this->getRowValue($row,6))
	->setEpsgCode($this->getRowValue($row,4))
	->setName($this->getRowValue($row,0))
	->setShortname($this->getRowValue($row,5))
	->setDescription($this->getRowValue($row,1))
	->setPos($this->getRowValue($row,7) * 100)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,5))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$data = array();
//"0 BESCHREIBUNG_DEU","1 HINWEIS_DEU","2 BESCHREIBUNG_ENG","3 HINWEIS_ENG","4 CODE","5 POSITION");
$data[] = array("Dummy","Dummy","Dummy","Dummy","EE","1");
$data[] = array("ArcInfo-GRID","farbcodierte Darstellung, internes Format des Geoinformationssystems ArcInfo","ArcInfo-GRID","color-coded representation, internal format of the Geographic Information System ArcInfo","grid","10");
$data[] = array("(1)ASCII (B,L,H)<br>(2)Binäres Format<br>(3)Trimble-Format<br>(4)LEICA-Format<br>(5)TOPCON-Format<br>(6)SurvCE-Format<br>(7)JAVAD-Format","(1) Ascii-Datei. Enthält je Rasterpunkt einen Datensatz der Form x-Koordinate y-Koordinate Geoidundulation<br>(2) Header zur Beschreibung des Rasters, danach Folge von 4-Byte-Werten mit Geoidundulationen<br>(3) spezielles Datenformat zur Einbindung in die Trimble Geomatics Office bzw. Trimble Business Center Software<br>(4) spezielles Datenformat zur Einbindung in LEICA Geo Office Software <br>(5) spezielles Datenformat zur Einbindung in TOPCON-Software <br> (6) spezielles Datenformat zur Einbindung in SurvCE-Software <br> (7) spezielles Datenformat zur Einbindung in JAVAD-Geräte","(1)ASCII (B,L,H)<br>(2)Binäres Format<br>(3)Trimble-Format<br>(4)LEICA-Format<br>(5)TOPCON-Format<br>(6)SurvCE-Format<br>(7)JAVAD-Format","(1) Ascii-Datei. Enthält je Rasterpunkt einen Datensatz der Form x-Koordinate y-Koordinate Geoidundulation<br>(2) Header zur Beschreibung des Rasters, danach Folge von 4-Byte-Werten mit Geoidundulationen<br>(3) spezielles Datenformat zur Einbindung in die Trimble Geomatics Office bzw. Trimble Business Center Software<br>(4) spezielles Datenformat zur Einbindung in LEICA Geo Office Software <br>(5) spezielles Datenformat zur Einbindung in SurvCE-Software (SOKKIA)","geoid","12");
$data[] = array("CSV","Textdatei in UTF8-Zeichenkodierung.<br> Enthält zeilenweise Lagegeometrie und Attribute mit Semikolon als Trennzeichen.","CSV","Text file in UTF8 character coding.<br> Contains line-by-line position geometry and attributes with semicolon as separator.","csv","13");
$data[] = array("TIFF-GROUP4","Schwarz-Weiß-Darstellung, TIFF mit Komprimierung CCITT-GROUP4","TIFF-GROUP4","Black-and-white representation, TIFF with compression CCITT-GROUP4","tif-g4","14");
$data[] = array("JPEG","JPEG","JPEG","JPEG","jpeg","15");
$data[] = array("TIFF","TIFF unkomprimiert, 24-Bit Farbtiefe","TIFF","TIFF unpacked, 24-Bit colour depth","tif","16");
$data[] = array("TIFF-K","TIFF komprimiert, 24-Bit Farbtiefe","TIFF-K","TIFF packed, 24-Bit colour depth","tif-k","17");
$data[] = array("PNG+WLD","Ein Grafikformat für Rastergrafiken mit verlustfreier Kompression, hier mit Angabe eines World-Files.","PNG+WLD","Ein Grafikformat für Rastergrafiken mit verlustfreier Kompression, hier mit World-File.","png+wld","18");
$data[] = array("TileCache PNG","Dieses Format ist gut geeignet für dateibasierte Caches mit sehr vielen Dateien. Die maximale Datei-/Ordneranzahl pro Verzeichnis ist 1000 und kann damit von jedem System gut verarbeitet werden. ","TileCache PNG","Dieses Format ist gut geeignet für dateibasierte Caches mit sehr vielen Dateien. Die maximale Datei-/Ordneranzahl pro Verzeichnis ist 1000 und kann damit von jedem System gut verarbeitet werden. ","tilecache","19");
$data[] = array("TIFF-LZW","farbcodierte Darstellung,GeoTIFF mit Komprimierung LZW, 8-Bit, Palettenfarben","TIFF-LZW","color-coded representation, GeoTIFF with compression LZW, 8-Bit, palette colors","tif-lzw","2");
$data[] = array("ESRI fGDB ","ESRI file geodatabase ","ESRI fGDB ","ESRI file geodatabase","fgdb","20");
$data[] = array("ESRI Exploded PNG","Rasterkachelarchiv mit PNG-Kacheln.Dieses Format eignet sich für den Einsatz mit ESRI-Produkten. Es müssen aber zusätzlich entsprechende Konfigurationsdateien bereitgestellt werden, damit das Verzeichnis als MapCache von ArcGIS erkannt wird. ","ESRI Exploded PNG","Rasterkachelarchiv mit PNG-Kacheln.Dieses Format eignet sich für den Einsatz mit ESRI-Produkten. Es müssen aber zusätzlich entsprechende Konfigurationsdateien bereitgestellt werden, damit das Verzeichnis als MapCache von ArcGIS erkannt wird. ","ee-png","21");
$data[] = array("ESRI Compact PNG","Rasterkachelarchiv mit PNG-Kacheln. Gruppiert einzelne PNGs/Tiles zu bundle-Dateien - ein Bundle kann bis zu 16.000 Tiles beinhalten. Eignet sich für den Einsatz mit ESRI-Produkten oder MapProxy.","ESRI Compact PNG","Rasterkachelarchiv mit PNG-Kacheln. Gruppiert einzelne PNGs/Tiles zu bundle-Dateien - ein Bundle kann bis zu 16.000 Tiles beinhalten. Eignet sich für den Einsatz mit ESRI-Produkten oder MapProxy.","ec-png","22");
$data[] = array("SDE-Ablageformat","SDE-Ablageformat","SDE filing format","SDE filing format","sde","23");
$data[] = array("GEOGRID","spezielles Format des Geogrid-Viewers","GEOGRID","spezielles Format des Geogrid-Viewers","geogrid","24");
$data[] = array("SQLITE MBTILE","Jede Zoomstufe wird in einer separaten SQLite-Datenbank gespeichert. Der Dateiname der Datenbank ist die Zoomstufe (ohne führende Null). Der Dateiname der Datenbank besitzt die Dateierweiterung mbtiles. ","SQLITE MBTILE","Jede Zoomstufe wird in einer separaten SQLite-Datenbank gespeichert. Der Dateiname der Datenbank ist die Zoomstufe (ohne führende Null). Der Dateiname der Datenbank besitzt die Dateierweiterung mbtiles. ","sqlite","25");
$data[] = array("Scalable Vector Graphics","SVG ist die vom World Wide Web Consortium (W3C) empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken","Scalable Vector Graphics","SVG is a family of specifications of an XML-based file format for describing two-dimensional vector graphics","svg","26");
$data[] = array("ASCII-Text","ASCII-Textdatei","ASCII text","ASCII-Textdatei","text","27");
$data[] = array("DXF","Verbreitetes CAD-Datenformat, das nach wie vor von vielen Geoinformationssystemen unterstützt wird. In der Regel gehen beim Einsatz von DXF bestimmte Informationen der Ausgangsdaten verloren. Attributive Informationen werden häufig in einem gewissen Umfang über beigestellte ASCII-Dateien transportiert.","DXF","Widely spread CAD data format, that is still supported by many GI Systems. As a rule by using DXF certain informations get lost","dxf","28");
$data[] = array("Standardabgabeformat für 3D-Gebäudemodelle","Format entsprechend dem AdV-CityGML-Profil","Standardabgabeformat für 3D-Gebäudemodelle","CityGML-Format entsprechend dem AdV-CityGML-Profil","citygml","29");
$data[] = array("TIFF-JPEG","GeoTIFF mit Komprimierung JPEG","TIFF-JPEG","GeoTIFF with compression JPEG","tif-jpeg","3");
$data[] = array("Portable Document Format","PDF is a file format created by Adobe Systems","Portable Document Format","PDF is a file format created by Adobe Systems","pdf","30");
$data[] = array("TIFF-DER","um WEB-Darstellung zu erzeugen","TIFF-DER","to be generated for WEB presentation","tif-der","4");
$data[] = array("ArcInfo-SHAPE","Offen gelegtes Austauschformat, das von vielen Geoinformationssystemen unterstützt wird.","ArcInfo-SHAPE","Open Exchange format, that is supported by many GI Systems","shape","5");
$data[] = array("NAS - normbasierte Austauschschnittstelle","Normbasierte Austauschschnittstelle. Datenaustauschformat des AAA-Modells ","NAS - norm-based data exchange interface","Norm-based data exchange interface. Data exchange format of the AAA model","nas_nba","6");
$data[] = array("NAS - normbasierte Austauschschnittstelle","Normbasierte Austauschschnittstelle. Datenaustauschformat des AAA-Modells ","NAS - norm-based data exchange interface","Norm-based data exchange interface. Data exchange format of the AAA model","nas_bda","7");
$data[] = array("XYZ-ASCII","ASCII-Datei. Enthält zeilenweise einen Höhenpunkt mit Lagekoordinate und Höhe:<br> x_koordinate y_koordinate höhenwert","XYZ-ASCII","ASCII file. Contains per spot height a data set of the form: x_koordinate,y_koordinate,höhenwert (x_coordinate,y_coordinate,elevation) ","ascii","8");
$data[] = array("GRID-ASCII","ASCII-Datei. Von ArcInfo unterstütztes ASCII-Format, das nach Angaben zur Berechnung der Gitterpunkte eine Matrix mit Höhenwerten enthält.","GRID-ASCII","ASCII file. ASCII format supported by ArcInfo that contains after data for the computation of the grid points a matrix with elevations. ","grida","9");


foreach($data as $row)
{

	$object = Mage::getModel('virtualgeo/components_format');
	$object->setCode($this->getRowValue($row,4))
	->setHasResolution(1)
	->setName($this->getRowValue($row,0))
	->setShortname($this->getRowValue($row,4))
	->setDescription($this->getRowValue($row,1))
	->setPos($this->getRowValue($row,5) * 100)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,4))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$data = array();

//"EBENEN_DEU","EBENEN_NAME_DEU","EBENEN_ENG","EBENEN_NAME_ENG","KATEGORIE","CODE","POSITION");
$data[] = array("Alle Ebenen","","All levels","","Allgemein","AlleEbenen","1");
$data[] = array("Alle Layer","","all layers","","Allgemein","AlleLayer","2");
$data[] = array("Ebenen","","Layers","","Allgemein","Ebenen","3");
$data[] = array("Einzelebenen","","single layers","","Allgemein","Einzelebenen","4");
$data[] = array("Einzellayer","( Layer 1 - Layer 9 )","layer","( Layer 1 - Layer 9 )","Allgemein","Einzellayer","5");
$data[] = array("Gesamt","","all","","Allgemein","Gesamt","6");
$data[] = array("Gesamtinhalt","","Total content","","Allgemein","Gesamtinhalt","7");
$data[] = array("Layer","","single layers","","Allgemein","Layer","8");
$data[] = array("Objektbereiche","","Objektbereiche","","Allgemein","Objektbereiche","9");
$data[] = array("Bahnübergänge","","Bahnübergänge","","db","Bahnuebergaenge","1");
$data[] = array("Tunnel","","Tunnel","","db","Tunnel","10");
$data[] = array("Betriebsstellen","","Betriebsstellen","","db","Betriebsstellen","2");
$data[] = array("Brücken","","Brücken","","db","Bruecken","3");
$data[] = array("Kilometerpunkte","","Kilometerpunkte","","db","Kilometerpunkte","4");
$data[] = array("Kilometrierungssprünge","","Kilometrierungssprünge","","db","Kilometrierungsspruenge","5");
$data[] = array("Schutzwände","","Schutzwände","","db","Schutzwaende","6");
$data[] = array("Schutzwandtüren","","Schutzwandtüren","","db","Schutzwandtueren","7");
$data[] = array("Straßenüberführungen","","Straßenüberführungen","","db","Straßenueberfuehrungen","8");
$data[] = array("Streckennetz","","Streckennetz","","db","Streckennetz","9");
$data[] = array("Gebiete","","regions","","dlm","Gebiete","1");
$data[] = array("GEW01-Gewässer","","GEW01-water bodies","","dlm","GEW01","10");
$data[] = array("41003","AX_Halde","41003","AX_Dump","dlm","41003","101");
$data[] = array("41004","AX_Bergbaubetrieb","41004","AX_MiningWorks","dlm","41004","102");
$data[] = array("41005","AX_TagebauGrubeSteinbruch","41005","AX_OpenPitMineQuarry","dlm","41005","103");
$data[] = array("41006","AX_FlaecheGemischterNutzung","41006","AX_AreaOfMixedUse","dlm","41006","105");
$data[] = array("41007","AX_FlaecheBesondererFunktionalerPraegung","41007","AX_AreaWithSpecialFunctionalCharacter","dlm","41007","106");
$data[] = array("41008","AX_SportFreizeitUndErholungsflaeche","41008","AX_SportsLeisureAndRecreationalArea","dlm","41008","107");
$data[] = array("41009","AX_Friedhof","41009","AX_Cemetery","dlm","41009","108");
$data[] = array("41010","AX_Siedlungsflaeche","41010","AX_Siedlungsflaeche","dlm","41010","109");
$data[] = array("GEW01-Gewässer und Bauwerke an Gewässern","","GEW01-Water bodies and buildings on water bodies","","dlm","GEW01","11");
$data[] = array("411","Sümpfe ","411","Sümpfe ","dlm","411","110");
$data[] = array("412","Torfmoore ","412","Torfmoore ","dlm","412","111");
$data[] = array("42000","Tatsaechliche Nutzung - Verkehr","42000","Tatsaechliche Nutzung - Verkehr","dlm","42000","112");
$data[] = array("42001","AX_Strassenverkehr","42001","AX_RoadTraffic","dlm","42001","113");
$data[] = array("42002","AX_Strasse","42002","AX_Road","dlm","42002","114");
$data[] = array("42003","AX_Strassenachse","42003","AX_RoadAxis","dlm","42003","115");
$data[] = array("42005","AX_Fahrbahnachse","42005","AX_RoadAxis","dlm","42005","116");
$data[] = array("42008","AX_Fahrwegachse","42008","AX_DrivewayAxis","dlm","42008","117");
$data[] = array("42009","AX_Platz","42009","AX_Place","dlm","42009","118");
$data[] = array("42010","AX_Bahnverkehr","42010","AX_railway traffic","dlm","42010","119");
$data[] = array("GEW02-Besondere Gewässermerkmale","","GEW02-Special water body features","","dlm","GEW02","12");
$data[] = array("42014","AX_Bahnstrecke","42014","AX_railway line","dlm","42014","120");
$data[] = array("42015","AX_Flugverkehr","42015","AX_AirTraffic","dlm","42015","121");
$data[] = array("42016","AX_Schiffsverkehr","42016","AX_ShippingTraffic","dlm","42016","122");
$data[] = array("421","Salzwiesen ","421","Salzwiesen ","dlm","421","123");
$data[] = array("422","Salinen ","422","Salinen ","dlm","422","124");
$data[] = array("423","In der Gezeitenzone liegende Flächen ","423","In der Gezeitenzone liegende Flächen ","dlm","423","125");
$data[] = array("43000","Tatsaechliche Nutzung - Vegetation","43000","Tatsaechliche Nutzung - Vegetation","dlm","43000","126");
$data[] = array("43001","AX_Landwirtschaft","43001","AX_Agriculture","dlm","43001","127");
$data[] = array("43002","AX_Wald","43002","AX_Forest","dlm","43002","128");
$data[] = array("43003","AX_Gehoelz","43003","AX_Grove","dlm","43003","129");
$data[] = array("GEW03-Gewässerachse","","GEW03-Water axes","","dlm","GEW03","13");
$data[] = array("43004","AX_Heide","43004","AX_Heathland","dlm","43004","130");
$data[] = array("43005","AX_Moor","43005","AX_Swamp","dlm","43005","131");
$data[] = array("43006","AX_Sumpf","43006","AX_Bog","dlm","43006","132");
$data[] = array("43007","AX_UnlandVegetationsloseFlaeche","43007","AX_WasteLandAreaWithoutVegetation","dlm","43007","133");
$data[] = array("43008","AX_FlaecheZurZeitUnbestimmbar","43008","AX_AreaPresentlyUndeterminable","dlm","43008","134");
$data[] = array("44000","Tatsaechliche Nutzung - Gewaesser","44000","Tatsaechliche Nutzung - Gewaesser","dlm","44000","135");
$data[] = array("44001","AX_Fliessgewaesser","44001","AX_Watercourse","dlm","44001","136");
$data[] = array("44002","AX_Wasserlauf","44002","AX_WaterCourse","dlm","44002","137");
$data[] = array("44003","AX_Kanal","44003","AX_Canal","dlm","44003","138");
$data[] = array("44004","AX_Gewaesserachse","44004","AX_WaterAxis","dlm","44004","139");
$data[] = array("HDU01-Referenzen","","HDU01-References","","dlm","HDU01","14");
$data[] = array("44005","AX_Hafenbecken","44005","AX_InnerHarbour","dlm","44005","140");
$data[] = array("44006","AX_StehendesGewaesser","44006","AX_StandingWaterBody","dlm","44006","141");
$data[] = array("44007","AX_Meer","44007","AX_Sea","dlm","44007","142");
$data[] = array("51000","Bauwerke und Einrichtungen in Siedlungsflaechen","51000","constructions and facilities in settlement areas","dlm","51000","143");
$data[] = array("51001","AX_Turm","51001","AX_Tower","dlm","51001","144");
$data[] = array("51002","AX_BauwerkOderAnlageFuerIndustrieUndGewerbe","51002","AX_BuildingOrFacilitiesForIndustryAndBusiness","dlm","51002","145");
$data[] = array("51003","AX_VorratsbehaelterSpeicherbauwerk","51003","AX_ReservoirStorageStructure","dlm","51003","146");
$data[] = array("51004","AX_Transportanlage","51004","AX_Conveyor","dlm","51004","147");
$data[] = array("51005","AX_Leitung","51005","AX_Line","dlm","51005","148");
$data[] = array("51006","AX_BauwerkOderAnlageFuerSportFreizeitUndErholung","51006","AX_BuildingOrFacilitiesForSportsLeisureTimeAndRecreation","dlm","51006","149");
$data[] = array("REL01-Reliefformen","","REL01-Relief forms","","dlm","REL01","15");
$data[] = array("51007","AX_HistorischesBauwerkOderHistorischeEinrichtung","51007","AX_HistoricalBuildingOrHistoricalConstruction","dlm","51007","150");
$data[] = array("51008","AX_HeilquelleGasquelle","51008","AX_HeilquelleGasquelle","dlm","51008","151");
$data[] = array("51009","AX_SonstigesBauwerkOderSonstigeEinrichtung","51009","AX_OtherBuildingsOrOther Facilities","dlm","51009","152");
$data[] = array("51010","AX_EinrichtungInOeffentlichenBereichen","51010","AX_FacilitiesInPublicAreas","dlm","51010","153");
$data[] = array("511","Gewässerläufe ","511","Gewässerläufe ","dlm","511","154");
$data[] = array("512","Wasserflächen ","512","Wasserflächen ","dlm","512","155");
$data[] = array("52000","Besondere Anlagen auf Siedlungsflaechen","52000","Special facilities on settlement areas","dlm","52000","156");
$data[] = array("52001","AX_Ortslage","52001","AX_Site","dlm","52001","157");
$data[] = array("52002","AX_Hafen","52002","AX_Harbour","dlm","52002","158");
$data[] = array("52003","AX_Schleuse","52003","AX_Sluice","dlm","52003","159");
$data[] = array("SIE01-Ortslage","","SIE01-Sites","","dlm","SIE01","16");
$data[] = array("52004","AX_Grenzuebergang","52004","AX_BorderCrossing","dlm","52004","160");
$data[] = array("52005","AX_Testgelaende","52005","AX_TestGround","dlm","52005","161");
$data[] = array("521","Lagunen ","521","Lagunen ","dlm","521","162");
$data[] = array("522","Mündungsgebiete ","522","Mündungsgebiete ","dlm","522","163");
$data[] = array("523","Meere und Ozeane ","523","Meere und Ozeane ","dlm","523","164");
$data[] = array("53000","Bauwerke, Anlagen und Einrichtungen für den Verkehr","53000","constructions, facilities and equipment for traffic","dlm","53000","165");
$data[] = array("53001","AX_BauwerkImVerkehrsbereich","53001","AX_BuildingInTrafficArea","dlm","53001","166");
$data[] = array("53002","AX_Strassenverkehrsanlage","53002","AX_RoadTrafficFacilities","dlm","53002","167");
$data[] = array("53003","AX_WegPfadSteig","53003","AX_WayPathSteepTrack","dlm","53003","168");
$data[] = array("53004","AX_Bahnverkehrsanlage","53004","AX_railway traffic facilities","dlm","53004","169");
$data[] = array("SIE02-Baulich geprägte Flächen","","SIE02-Constructionally characterized areas","","dlm","SIE02","17");
$data[] = array("53005","AX_SeilbahnSchwebebahn","53005","AX_CableCarSuspensionRailway","dlm","53005","170");
$data[] = array("53006","AX_Gleis","53006","AX_RailTrack","dlm","53006","171");
$data[] = array("53007","AX_Flugverkehrsanlage","53007","AX_AirTrafficFacilities","dlm","53007","172");
$data[] = array("53008","AX_EinrichtungenFuerDenSchiffsverkehr","53008","AX_FacilitiesForShippingTraffic","dlm","53008","173");
$data[] = array("53009","AX_BauwerkImGewaesserbereich","53009","AX_BuildingInWaterBodyArea","dlm","53009","174");
$data[] = array("54000","Besondere Vegetationsmerkmale","54000","Special vegetation features","dlm","54000","175");
$data[] = array("54001","AX_Vegetationsmerkmal","54001","AX_VegetationFeature","dlm","54001","176");
$data[] = array("55000","Besondere Eigenschaften von Gewässern","55000","Special characteristics of water bodies","dlm","55000","177");
$data[] = array("55001","AX_Gewaessermerkmal","55001","AX_WaterCharacteristic","dlm","55001","178");
$data[] = array("55002","AX_UntergeordnetesGewaesser","55002","AX_UntergeordnetesGewaesser","dlm","55002","179");
$data[] = array("SIE03-Bauwerke und sonstige Einrichtungen","","SIE03-Buildings and other facilities","","dlm","SIE03","18");
$data[] = array("55003","AX_Polder","55003","AX_Polder","dlm","55003","180");
$data[] = array("56000","Besondere Angaben zum Verkehr","56000","Specific information on the traffic","dlm","56000","181");
$data[] = array("56001","AX_Netzknoten","56001","AX_NetworkNode","dlm","56001","182");
$data[] = array("56002","AX_Nullpunkt","56002","AX_DatumPoint","dlm","56002","183");
$data[] = array("56003","AX_Abschnitt","56003","AX_section","dlm","56003","184");
$data[] = array("56004","AX_Ast","56004","AX_Ast","dlm","56004","185");
$data[] = array("57000","Besondere Angaben zum Gewässer","57000","Specific information on the water body","dlm","57000","186");
$data[] = array("57001","AX_Wasserspiegelhoehe","57001","AX_WaterSurfaceLevel","dlm","57001","187");
$data[] = array("57002","AX_SchifffahrtslinieFaehrverkehr","57002","AX_ShippingLineFerryTraffic","dlm","57002","188");
$data[] = array("57003","AX_Gewaesserstationierungsachse","57003","AX_WaterStationingAxis","dlm","57003","189");
$data[] = array("SIE04-Besondere Anlagen auf Siedlungsflächen","","SIE04-Special facilities on settlement areas","","dlm","SIE04","19");
$data[] = array("57004","AX_Sickerstrecke","57004","AX_SeepageCourse","dlm","57004","190");
$data[] = array("61000","Reliefformen","61000","Relief forms","dlm","61000","191");
$data[] = array("61001","AX_BoeschungKliff","61001","AX_SlopeCliff","dlm","61001","192");
$data[] = array("61002","AX_Boeschungsflaeche","61002","AX_Breakline","dlm","61002","193");
$data[] = array("61003","AX_DammWallDeich","61003","AX_DamRampartDike","dlm","61003","194");
$data[] = array("61004","AX_Einschnitt","61004","AX_Cutting","dlm","61004","195");
$data[] = array("61005","AX_Hoehleneingang","61005","AX_CaveEntrance","dlm","61005","196");
$data[] = array("61006","AX_FelsenFelsblockFelsnadel","61006","AX_RockBoulderRockspire","dlm","61006","197");
$data[] = array("61007","AX_Duene","61007","AX_Dune","dlm","61007","198");
$data[] = array("61008","AX_Hoehenlinie","61008","AX_Contour","dlm","61008","199");
$data[] = array("Gewässer","","water bodies","","dlm","Gewaesser","2");
$data[] = array("SIE05-Gebäude","","SIE05-building","","dlm","SIE05","20");
$data[] = array("62000","Primäres DGM","62000","Primäres DGM","dlm","62000","200");
$data[] = array("62040","AX_Gelaendekante","62040","AX_Breakline","dlm","62040","201");
$data[] = array("71000","Öffentlich-rechtliche und sonstige Festlegungen","71000","Öffentlich-rechtliche und sonstige Festlegungen","dlm","71000","202");
$data[] = array("71004","AX_AndereFestlegungNachWasserrecht","71004","AX_OtherSpecificationAccordingToWaterRight","dlm","71004","203");
$data[] = array("71005","AX_SchutzgebietNachWasserrecht","71005","AX_ProtectedAreaAccordingToWaterLaw","dlm","71005","204");
$data[] = array("71006","AX_NaturUmweltOderBodenschutzrecht","71006","AX_ConservationEnvironmentalOrSoilProtectionLaw","dlm","71006","205");
$data[] = array("71007","AX_SchutzgebietNachNaturUmweltOderBodenschutzrecht","71007","AX_ProtectedAreaAccordingToConservationEnvironmentalOrSoilProtectionLaw","dlm","71007","206");
$data[] = array("71009","AX_Denkmalschutzrecht","71009","AX_MonumentProtectionLaw","dlm","71009","207");
$data[] = array("71011","AX_SonstigesRecht","71011","AX_OtherLaw","dlm","71011","208");
$data[] = array("71012","AX_Schutzzone","71012","AX_ProtectionArea","dlm","71012","209");
$data[] = array("VEG01-Landwirtschaftliche Nutzfläche","","VEG01-Farmland","","dlm","VEG01","21");
$data[] = array("73000","Kataloge","73000","Kataloge","dlm","73000","210");
$data[] = array("73001","AX_Nationalstaat","73001","AX_Nationalstaat","dlm","73001","211");
$data[] = array("73002","AX_Bundesland","73002","AX_FederalState","dlm","73002","212");
$data[] = array("73003","AX_Regierungsbezirk","73003","AX_AdministrativeDistrict","dlm","73003","213");
$data[] = array("73004","AX_KreisRegion","73004","AX_DistrictRegion","dlm","73004","214");
$data[] = array("73005","AX_Gemeinde","73005","AX_Municipality","dlm","73005","215");
$data[] = array("73006","AX_Gemeindeteil","73006","AX_Gemeindeteil","dlm","73006","216");
$data[] = array("73009","AX_Verwaltungsgemeinschaft","73009","AX_Verwaltungsgemeinschaft","dlm","73009","217");
$data[] = array("73013","AX_LagebezeichnungKatalogeintrag","73013","AX_PlaceNameCatalogEntry","dlm","73013","218");
$data[] = array("73014","AX_Gemeindekennzeichen","73014","AX_Gemeindekennzeichen","dlm","73014","219");
$data[] = array("VEG02-Forstwirtschaftliche Nutzfläche","","VEG02-Woodland","","dlm","VEG02","22");
$data[] = array("73015","AX_Katalogeintrag","73015","AX_Katalogeintrag","dlm","73015","220");
$data[] = array("73018","AX_Bundesland_Schluessel","73018","AX_Bundesland_Schluessel","dlm","73018","221");
$data[] = array("73021","AX_Regierungsbezirk_Schluessel","73021","AX_Regierungsbezirk_Schluessel","dlm","73021","222");
$data[] = array("73022","AX_Kreis_Schluessel","73022","AX_Kreis_Schluessel","dlm","73022","223");
$data[] = array("73023","AX_VerschluesselteLagebezeichnung","73023","AX_VerschluesselteLagebezeichnung","dlm","73023","224");
$data[] = array("73024","AX_Verwaltungsgemeinschaft_Schluessel","73024","AX_Verwaltungsgemeinschaft_Schluessel","dlm","73024","225");
$data[] = array("73025","AX_Verwaltungsgemeinschaft_ATKIS","73025","AX_Verwaltungsgemeinschaft_ATKIS","dlm","73025","226");
$data[] = array("74000","Geographische Gebietseinheiten","74000","Geographische Gebietseinheiten","dlm","74000","227");
$data[] = array("74001","AX_Landschaft","74001","AX_Landscape","dlm","74001","228");
$data[] = array("74002","AX_KleinraeumigerLandschaftsteil","74002","AX_SmallScaleLandscapePart","dlm","74002","229");
$data[] = array("VEG03-Vegetationsflächen","","VEG03-Vegetation areas","","dlm","VEG03","23");
$data[] = array("74003","AX_Gewann","74003","AX_StripField","dlm","74003","230");
$data[] = array("74004","AX_Insel","74004","AX_Island","dlm","74004","231");
$data[] = array("74005","AX_Wohnplatz","74005","AX_Domicile","dlm","74005","232");
$data[] = array("75000","Administrative Gebietseinheiten","75000","Administrative areal units","dlm","75000","233");
$data[] = array("75003","AX_KommunalesGebiet","75003","AX_MunicipalArea","dlm","75003","234");
$data[] = array("75004","AX_Gebiet_Nationalstaat","75004","AX_Region_State","dlm","75004","235");
$data[] = array("75005","AX_Gebiet_Bundesland","75005","AX_Region_FederalState","dlm","75005","236");
$data[] = array("75006","AX_Gebiet_Regierungsbezirk","75006","AX_Region_AdministrativeDistrict","dlm","75006","238");
$data[] = array("75007","AX_Gebiet_Kreis","75007","AX_Region_District","dlm","75007","239");
$data[] = array("VEG04-Vegetationsmerkmal","","VEG04-Vegetation feature","","dlm","VEG04","24");
$data[] = array("75008","AX_Kondominium","75008","AX_Condominium","dlm","75008","240");
$data[] = array("75009","AX_Gebietsgrenze","75009","AX_RegionalBoundary","dlm","75009","241");
$data[] = array("75010","AX_Gebiet","75010","AX_Gebiet","dlm","75010","242");
$data[] = array("75011","AX_Gebiet_Verwaltungsgemeinschaft","75011","AX_Gebiet_Verwaltungsgemeinschaft","dlm","75011","243");
$data[] = array("81000","Nutzerprofile","81000","Nutzerprofile","dlm","81000","244");
$data[] = array("81001","AX_Benutzer","81001","AX_Benutzer","dlm","81001","245");
$data[] = array("81002","AX_Benutzergruppe","81002","AX_Benutzergruppe","dlm","81002","246");
$data[] = array("81003","AX_BenutzergruppeMitZugriffskontrolle","81003","AX_BenutzergruppeMitZugriffskontrolle","dlm","81003","247");
$data[] = array("81004","AX_BenutzergruppeNBA","81004","AX_BenutzergruppeNBA","dlm","81004","248");
$data[] = array("81005","AX_BereichZeitlich","81005","AX_BereichZeitlich","dlm","81005","249");
$data[] = array("VER01-Straßenverkehr","","VER01-road traffic","","dlm","VER01","25");
$data[] = array("81006","AX_Empfaenger","81006","AX_Empfaenger","dlm","81006","250");
$data[] = array("81007","AX_FOLGEVA","81007","AX_FOLGEVA","dlm","81007","251");
$data[] = array("997","Platzhalter für Verkehrstrassen (Bahn/Straße)","997","Platzhalter für Verkehrstrassen (Bahn/Straße)","dlm","997","252");
$data[] = array("998","bildabhängig, vorläufige Zuweisung nicht möglich","998","screen-depending, preliminary assignment not possible","dlm","998","253");
$data[] = array("99999","UeberfuehrungsUnterfuehrungsreferenz","99999","OverpassUnderpass reference","dlm","99999","254");
$data[] = array("VER02-Wege","","VER02-ways","","dlm","VER02","26");
$data[] = array("VER03-Bahnverkehr","","VER03-Rail traffic","","dlm","VER03","27");
$data[] = array("VER04-Flugverkehr","","VER04-Air traffic","","dlm","VER04","28");
$data[] = array("VER05-Schiffsverkehr","","VER05-Shipping traffic","","dlm","VER05","29");
$data[] = array("Relief","","relief","","dlm","Relief","3");
$data[] = array("VER06-Verkehrsbauwerke und -anlagen","","VER06-Traffic infrastructure and facilities","","dlm","VER06","30");
$data[] = array("VER07-Angaben zum Straßennetz","","VER07-Information on the road network","","dlm","VER07","31");
$data[] = array("Siedlung","","settlement","","dlm","Siedlung","4");
$data[] = array("02300","AP_GPO","02300","AP_GPO","dlm","02300","41");
$data[] = array("02300","AAA_Praesentationsobjekte","02300","AAA_presentation objects","dlm","02300","42");
$data[] = array("02310","AP_PPO","02310","AP_PPO","dlm","02310","43");
$data[] = array("02320","AP_LPO","02320","AP_LPO","dlm","02320","44");
$data[] = array("02330","AP_FPO","02330","AP_FPO","dlm","02330","45");
$data[] = array("02340","AP_TPO","02340","AP_TPO","dlm","02340","46");
$data[] = array("02341","AP_PTO","02341","AP_PTO","dlm","02341","47");
$data[] = array("02342","AP_LTO","02342","AP_LTO","dlm","02342","48");
$data[] = array("02350","AP_Darstellung","02350","AP_representation","dlm","02350","49");
$data[] = array("Vegetation","","vegetation","","dlm","Vegetation","5");
$data[] = array("111","Durchgängig städtische Prägung ","111","Durchgängig städtische Prägung ","dlm","111","50");
$data[] = array("112","Nicht durchgängig städtische Prägung ","112","Nicht durchgängig städtische Prägung ","dlm","112","51");
$data[] = array("12000","Angaben zur Lage","12000","Details on the location","dlm","12000","52");
$data[] = array("12002","AX_LagebezeichnungMitHausnummer","12002","AX_PlaceNameWithHouseNumber","dlm","12002","53");
$data[] = array("12003","AX_LagebezeichnungMitPseudonummer","12003","AX_PlaceNameWithPseudoNumber","dlm","12003","54");
$data[] = array("12004","AX_Lagebezeichnung","12004","AX_Lagebezeichnung","dlm","12004","55");
$data[] = array("12005","AX_Lage","12005","AX_Lage","dlm","12005","56");
$data[] = array("12006","AX_GeoreferenzierteGebaeudeadresse","12006","AX_GeoreferenzierteGebaeudeadresse","dlm","12006","57");
$data[] = array("12007","AX_Post","12007","AX_Post","dlm","12007","58");
$data[] = array("121","Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","121","Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","dlm","121","59");
$data[] = array("Verkehr","","traffic","","dlm","Verkehr","6");
$data[] = array("122","Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","122","Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","dlm","122","60");
$data[] = array("123","Hafengebiete ","123","Hafengebiete ","dlm","123","61");
$data[] = array("124","Flughäfen ","124","Flughäfen ","dlm","124","62");
$data[] = array("131","Abbauflächen ","131","extraction sites","dlm","131","63");
$data[] = array("132","Deponien und Abraumhalden ","132","Deponien und Abraumhalden ","dlm","132","64");
$data[] = array("133","Baustellen ","133","construction sites","dlm","133","65");
$data[] = array("141","Städtische Grünflächen ","141","Städtische Grünflächen ","dlm","141","66");
$data[] = array("142","Sport-und Freizeitanlagen ","142","Sport-und Freizeitanlagen ","dlm","142","67");
$data[] = array("21000","Personen- und Bestandsdaten","21000","Personen- und Bestandsdaten","dlm","21000","68");
$data[] = array("21001","AX_Person","21001","AX_Person","dlm","21001","69");
$data[] = array("GEB01-Verwaltungsgebiete","","GEB01-administrative regions","","dlm","GEB01","7");
$data[] = array("211","Nicht bewässertes Ackerland ","211","Nicht bewässertes Ackerland ","dlm","211","70");
$data[] = array("212","Regelmäßig bewässertes Ackerland ","212","Regelmäßig bewässertes Ackerland ","dlm","212","71");
$data[] = array("213","Reisfelder ","213","Reisfelder ","dlm","213","72");
$data[] = array("221","Weinbauflächen ","221","Weinbauflächen ","dlm","221","73");
$data[] = array("222","Obst-und Beerenobstbestände ","222","Obst-und Beerenobstbestände ","dlm","222","74");
$data[] = array("223","Olivenhaine ","223","Olivenhaine ","dlm","223","75");
$data[] = array("231","Wiesen und Weiden ","231","Wiesen und Weiden ","dlm","231","76");
$data[] = array("241","Einjährige Kulturen in Verbindung mit Dauerkulturen ","241","Einjährige Kulturen in Verbindung mit Dauerkulturen ","dlm","241","77");
$data[] = array("242","Komplexe Parzellenstrukturen ","242","Komplexe Parzellenstrukturen ","dlm","242","78");
$data[] = array("243","Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","243","Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","dlm","243","79");
$data[] = array("GEB02-Geographische Gebiete","","GEB02-Geographical areas","","dlm","GEB02","8");
$data[] = array("244","Land-und forstwirtschaftliche Flächen ","244","Land-und forstwirtschaftliche Flächen ","dlm","244","80");
$data[] = array("31000","Angaben zum Gebäude","31000","Details on the building ","dlm","31000","81");
$data[] = array("31001","AX_Gebaeude","31001","AX_Building","dlm","31001","82");
$data[] = array("31002","AX_Bauteil","31002","AX_component","dlm","31002","83");
$data[] = array("31006","AX_Nutzung_Gebaeude","31006","AX_Nutzung_Gebaeude","dlm","31006","84");
$data[] = array("311","Laubwälder ","311","Laubwälder ","dlm","311","85");
$data[] = array("312","Nadelwälder ","312","Nadelwälder ","dlm","312","86");
$data[] = array("313","Mischwälder ","313","Mischwälder ","dlm","313","87");
$data[] = array("321","Natürliches Grünland ","321","Natürliches Grünland ","dlm","321","88");
$data[] = array("322","Heiden und Moorheiden ","322","Heiden und Moorheiden ","dlm","322","89");
$data[] = array("GEB03-Schutzgebiete","","GEB03-Protected areas","","dlm","GEB03","9");
$data[] = array("323","Hartlaubbewuchs ","323","Hartlaubbewuchs ","dlm","323","90");
$data[] = array("324","Wald-Strauch-Übergangsstadien ","324","Wald-Strauch-Übergangsstadien ","dlm","324","91");
$data[] = array("331","Strände, Dünen und Sandflächen ","331","Strände, Dünen und Sandflächen ","dlm","331","92");
$data[] = array("332","Felsflächen ohne Vegetation ","332","Felsflächen ohne Vegetation ","dlm","332","93");
$data[] = array("333","Flächen mit spärlicher Vegetation ","333","Flächen mit spärlicher Vegetation ","dlm","333","94");
$data[] = array("334","Brandflächen ","334","Brandflächen ","dlm","334","95");
$data[] = array("335","Gletscher und Dauerschneegebiete ","335","Gletscher und Dauerschneegebiete ","dlm","335","96");
$data[] = array("41000","Tatsaechliche Nutzung - Siedlung","41000","Tatsaechliche Nutzung - Siedlung","dlm","41000","97");
$data[] = array("41001","AX_Wohnbauflaeche","41001","AX_ResidentialArea","dlm","41001","98");
$data[] = array("41002","AX_IndustrieUndGewerbeflaeche","41002","AX_IndustrialZone","dlm","41002","99");
$data[] = array("CIR","3-Kanal-Colorinfrarotbild, sog. Falschfarben (NIR–Rot–Grün)","CIR","3-Kanal-Colorinfrarotbild, sog. Falschfarben (NIR–Rot–Grün)","dopd","cir","1");
$data[] = array("IR","1-Kanal-Infrarotbild","IR","1-Kanal-Infrarotbild","dopd","ir","2");
$data[] = array("RGB","3-Kanal-Echtfarbbild (Rot-Grün-Blau)","RGB","3-Kanal-Echtfarbbild (Rot-Grün-Blau)","dopd","rgb","3");
$data[] = array("Grundriss/Schrift","( Layer 1 + 2 + 7 )","ground plan/lettering","( Layer 1 + 2 + 7 )","dtk","GrundrissSchrift","10");
$data[] = array("Grundriss/Schrift","","ground plan/lettering","","dtk","GrundrissSchrift","11");
$data[] = array("Grundriss/Schrift","( Layer 1 + 2 + 6 + 7 )","ground plan/lettering","( Layer 1 + 2 + 6 + 7 )","dtk","GrundrissSchrift","12");
$data[] = array("Höhenlinien","( Layer 4 + 2 )","relief","( Layer 4 + 2 )","dtk","Hoehenlinien","13");
$data[] = array("Höhenlinien","( Layer 4 )","relief","( Layer 4 )","dtk","Hoehenlinien","14");
$data[] = array("Höhenschichten","( Layer 9)","contour levels","( Layer 9)","dtk","Hoehenschichten","15");
$data[] = array("Relief","( Layer 4  + 12 )","relief","( Layer 4  + 12 )","dtk","Relief","16");
$data[] = array("Schummerung","( Layer 8)","shading","( Layer 8)","dtk","Schummerung","17");
$data[] = array("UTM - Gitter","( Layer 11)","UTM grid","( Layer 11)","dtk","UTMGitter","18");
$data[] = array("Vegetation","( Layer  5 )","vegetation","( Layer  5 )","dtk","Vegetation","19");
$data[] = array("Vegetation","( Layer 1 + 5 )","vegetation","( Layer 1 + 5 )","dtk","Vegetation","20");
$data[] = array("Verwaltungsgebiete","( Layer 6)","Verwaltungsgebiete","( Layer 6)","dtk","Verwaltungsgebiete","21");
$data[] = array("Layer 1","Straßenänder, Zug, Felse, schwarze Schrift","Layer 1","Straßenänder,Zug,Felse, schwarze Schrift","dtk","schw","22");
$data[] = array("Layer 2","Schwarze Schrift","Layer 2","Schwarze Schrift","dtk","swtx","23");
$data[] = array("Layer 3","Hochspannungsleitungen, Sand, Berge, braune Schrift","Layer 3","Hochspannungsleitungen, Sand,Berge, braune Schrift","dtk","grbr","24");
$data[] = array("Layer 4","Höhenlinien","Layer 4","Höhenlinien","dtk","rebr","25");
$data[] = array("Layer 5","Gewässerkonturen, blaue Schrift","Layer 5","Gewässerkonturen, blaue Schrift","dtk","babl","26");
$data[] = array("Layer 6","Baumgrüne Symbole und Schrift","Layer 6","Baumgrüne Symbole und Schrift","dtk","baum","27");
$data[] = array("Layer 7","Verwaltungsgrenzen","Layer 7","Verwaltungsgrenze","dtk","viol","28");
$data[] = array("Layer 8","","Layer 8","","dtk","Layer8","29");
$data[] = array("Layer 9","Gebäude ausserhalb von Siedlungen","Layer 9","Gebäude ausserhalb von Siedlungen","dtk","haus","30");
$data[] = array("Layer 10","Decker von ungeordn. Straßen, weiße Schrift","Layer 10","Decker von ungeordn. Straßen, weiße Schrift","dtk","weis","31");
$data[] = array("Layer 11","Gewässer (decker)","Layer 11","Gewässer (decker)","dtk","sebl","32");
$data[] = array("Layer 12","Siedlungsfläche, offene Bebauung","Layer 12","Siedlungsfläche, offene Bebauung","dtk","hrot","33");
$data[] = array("Layer 13","Industrie und Gewerbe,Bergbau, Bahnverkehr, Schiffahrtsinfrastruktur","Layer 13","Industrie und Gewerbe,Bergbau, Bahnverkehr, Schiffahrtsinfrastruktur","dtk","grau","34");
$data[] = array("Layer 14","Weinbau und Hopfenflächen","Layer 14","Weinbau und Hopfenflächen","dtk","acke","35");
$data[] = array("Layer 15","Klärbecken, Torf, Moor, Sumpf","Layer 15","Klärbecken, Torf, Moor, Sumpf","dtk","brac","36");
$data[] = array("Layer 16","Forst","Layer 16","Forst","dtk","wald","37");
$data[] = array("Layer 17","Flughafen, Friedhöfe","Layer 17","Flughafen, Friedhöfe","dtk","wies","38");
$data[] = array("Layer 18","Sport, Freizeit, Garten und Erholungsflächen","Layer 18","Sport, Freizeit, Garten und Erholungsflächen","dtk","park","39");
$data[] = array("Summen- und Einzellayer","","combined and single layers","","dtk","SummenundEinzellayer","4");
$data[] = array("Layer 19","Autobahn und Bundesstraßen (Decker)","Layer 19","Autobahn und Bundesstraßen (Decker)","dtk","stor","40");
$data[] = array("Layer 20","Staats- und Landesstraßen + Symbole (Decker)","Layer 20","Staats- und Landesstraßen + Symbole (Decker)","dtk","stge","41");
$data[] = array("Layer 21","Wattflächen","Layer 21","Wattflächen","dtk","watt","42");
$data[] = array("Layer 22","UTM-Gitter mit Schrift","Layer 22","UTM-Gitter mit Schrift","dtk","utmg","43");
$data[] = array("Layer 23","Siedlung, geschlossene Bebauung","Layer 23","Siedlung, geschl. Bebauung","dtk","mrot","44");
$data[] = array("Layer 24","Truppenübungsplatzgrenzen","Layer 24","Truppenübungsplatzgrenzen","dtk","trup","45");
$data[] = array("Layer 25","Heideflächen","Layer 25","Heideflächen","dtk","heid","46");
$data[] = array("Summenlayer","","combined layer","","dtk","Summenlayer","5");
$data[] = array("Geo - Netz","( Layer 10)","Geo-network","( Layer 10)","dtk","GeoNetz","7");
$data[] = array("Gewässer","","water bodies","( Layer 3  )","dtk","Gewaesser","8");
$data[] = array("Gewässer","( Layer 3 )","water bodies","( Layer 3 )","dtk","Gewaesser","9");
$data[] = array("POI","","POI","","poi","POI","1");
$data[] = array("Justizvollzugsanstalten","","Justizvollzugsanstalten","","poi","Justizvollzugsanstalten","10");
$data[] = array("Krankenhäuser","","Krankenhäuser","","poi","Krankenhaeuser","11");
$data[] = array("Landespolizei","","Landespolizei","","poi","Landespolizei","12");
$data[] = array("Nationale Referenzzentren und Konsiliarlabore","","Nationale Referenzzentren und Konsiliarlabore","","poi","NationaleReferenzzentrenundKonsiliarlabore","13");
$data[] = array("Reha-Einrichtungen","","Reha-Einrichtungen","","poi","RehaEinrichtungen","14");
$data[] = array("Staatsanwaltschaften","","Staatsanwaltschaften","","poi","Staatsanwaltschaften","15");
$data[] = array("Technisches Hilfswerk","","Technisches Hilfswerk","","poi","TechnischesHilfswerk","16");
$data[] = array("UN-Organisationen in Deutschland","","UN-Organisationen in Deutschland","","poi","UNOrganisationeninDeutschland","17");
$data[] = array("Zentrales Adress- und Kommunikationsverzeichnis","","Zentrales Adress- und Kommunikationsverzeichnis","","poi","ZentralesAdressundKommunikationsverzeichnis","18");
$data[] = array("Zoll","","Zoll","","poi","Zoll","19");
$data[] = array("POI-BPol","","POI-BPol","","poi","POIBPol","2");
$data[] = array("Berufsfeuerwehren","","Berufsfeuerwehren","","poi","Berufsfeuerwehren","3");
$data[] = array("Botschaften und Konsulate in Deutschland","","Botschaften und Konsulate in Deutschland","","poi","BotschaftenundKonsulateinDeutschland","4");
$data[] = array("Bundesbehörden","","Bundesbehörden","","poi","Bundesbehoerden","5");
$data[] = array("Bundesbehörden und Einrichtungen des Bundes","","Bundesbehörden und Einrichtungen des Bundes","","poi","BundesbehoerdenundEinrichtungendesBundes","6");
$data[] = array("Bundespolizei","","Bundespolizei","","poi","Bundespolizei","7");
$data[] = array("Gerichte","","Gerichte","","poi","Gerichte","8");
$data[] = array("Hochschulen","","Hochschulen","","poi","Hochschulen","9");
$data[] = array("NUTS1","","NUTS1","","sdp","NUTS1","1");
$data[] = array("NUTS2","","NUTS2","","sdp","NUTS2","2");
$data[] = array("NUTS3","","NUTS3","","sdp","NUTS3","3");
$data[] = array("Staat","","state","","Verwaltungsgebiet","Staat","");
$data[] = array("Gemeinden","","communes","","Verwaltungsgebiet","Gemeinden","");
$data[] = array("Kreise","","2nd order districts in Germany (Kreise)","","Verwaltungsgebiet","Kreise","");
$data[] = array("Verwaltungsgemeinschaften","","administrative communities","","Verwaltungsgebiet","Verwaltungsgemeinschaften","");
$data[] = array("Regierungsbezirke","","1st order administrative districts in Germany (Regierungsbezirke)","","Verwaltungsgebiet","Regierungsbezirke","");
$data[] = array("Bundesländer","","Federal States (Bundeslaender)","","Verwaltungsgebiet","Bundeslaender","");
//"0 EBENEN_DEU","1 EBENEN_NAME_DEU","2 EBENEN_ENG","3 EBENEN_NAME_ENG","4 KATEGORIE","5 CODE","6 POSITION");

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
	->setShortname($this->getRowValue($row,0))
	->setDescription($this->getRowValue($row,1))
    ->setCategoryId($cat->getId())
	->setPos($this->getRowValue($row,6)*100)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,2))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$data = array();
//$data[] = array("GLIEDERUNG","KNAME","TEXT_DEU","TEXT_ENG");
$data[] = array("bland","BL","Bundesland","Federal State");
$data[] = array("blatt","EB","Einzelblätter 1:25 000","Single sheets 1:25","000");
$data[] = array("blatt","EB","Einzelblätter 1:50 000","Single sheets 1:50","000");
$data[] = array("blatt","EB","Einzelblätter 1:100 000","Single sheets 1:100","000");
$data[] = array("blatt","EB","Einzelblätter 1:200 000","Single sheets 1:200","000");
$data[] = array("blatt","EB","Einzelblätter 1:500 000","Single sheets 1:500","000");
$data[] = array("blatt","EB","Einzelblätter 1:1 000 000","Single sheets 1:1","000","000");
$data[] = array("datei","GD","Gesamtdatei Deutschland","Total file of Germany");
$data[] = array("datei","GD","Gesamtdatei PLZ","Complete file postcode");
$data[] = array("datei","GD","Gesamtdatei GA","Total file GA");
$data[] = array("datei","GD","Gesamtdatei 1:2.500 000","Total file of Germany 1:2.500.000");
$data[] = array("datei","GD","Gesamtdatei 1:2.500 000","Total file of Germany 1:2.500.000");
$data[] = array("datei","GD","Gesamtdatei 1:2.500 000","Total file of Germany 1:2.500.000");
$data[] = array("datei","GD","Gesamtdatei POI","Total file POI");
$data[] = array("datei","GD","Gesamtdatei StreckenDB","Total file StreckenDB");
$data[] = array("datei","GD","Gesamtdatei StreckenDB-BPOL","Total file StreckenDB-BPOL");
$data[] = array("datenbestand","DB","Datenbestand RapidEye","Data stock RapidEye");
$data[] = array("EE","E0","Dummy","dummy");
$data[] = array("europa","EU","Gesamtdatei EBM","EBM-Gebiet");
$data[] = array("europa","EU","Gesamtdatei ERM","ERM-Gebiet");
$data[] = array("geogitter","GD","Gesamtdatei Geogitter","Gesamtdatei Geogitter");
$data[] = array("geoid","GE","Geoid","Geoid");
$data[] = array("geoid küste","GO","Geoid Küste","Geoid coast");
$data[] = array("kachel","KA","Kacheln 10km x 10km","Tiles 10km x 10km");
$data[] = array("kachel","KA","Kacheln 20km x 20km","Tiles 20km x 20km");
$data[] = array("kachel","KA","Kacheln 40km x 40km","Tiles 40km x 40km");
$data[] = array("kachel","KA","Kacheln 80km x 80km","Tiles 80km x 80km");
$data[] = array("kachel","KA","Kacheln 2km x 2km bzw. 1km x 1km","Tiles 2km x 2km or 1km x1km");
$data[] = array("kachel","KA","Kacheln 1km x 1km","Tiles 1km x 1km");
$data[] = array("kachel","KA","AdV-Kacheln 20km x 20km","Tiles 20km x 20km");
$data[] = array("kachel","KA","AdV-Kacheln 80km x 80km","Tiles 80km x 80km");
$data[] = array("kachel","KA","AdV-Kacheln 40km x 40km","Tiles 40km x 40km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv","Rasterkachelarchiv");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv Europa","Rasterkachelarchiv Europa");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 2km x 2km","Rasterkachelarchiv 2km x 2km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 4km x 4km","Rasterkachelarchiv 4km x 4km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 10km x 10km","Rasterkachelarchiv 10km x 10km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 20km x 20km","Rasterkachelarchiv 20km x 20km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 40km x 40km","Rasterkachelarchiv 40km x 40km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 120km x 120km","Rasterkachelarchiv 120km x 120km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 105km x 105km","Rasterkachelarchiv 105km x 105km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 1000km x 1000km","Rasterkachelarchiv 1000km x 1000km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv 200km x 200km","Rasterkachelarchiv 200km x 200km");
$data[] = array("kachelarchiv","KV","Rasterkachelarchiv Europa 1000km x 1000km","Rasterkachelarchiv Europa 1000km x 1000km");
$data[] = array("kachelarchiv","KV","Kachelliste Geogitter","Kachelliste Geogitter");
$data[] = array("teilgeoid","TG","Teilgeoid","Partial geoid");


$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_structure');
	$object
	->setType($this->getRowValue($row,0))
	->setCode($this->getRowValue($row,1))
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,2))
	->setDescription($this->getRowValue($row,2))
	->setPos($n)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,3))
	->setShortname($this->getRowValue($row,3))
	->setDescription($this->getRowValue($row,3))
	->save();
}

$installer->endSetup();

$data = array();
//"0 AUFLOESUNG_DEU","1 AUFLOESUNG_ENG","2 EINHEIT_DEU","3 EINHEIT_ENG","4 KATEGORIE","5 CODE","6 POSITION");
$data[] = array("0","0","0","","Allgemein","0","1");
$data[] = array("1","1","","","Allgemein","1","2");
$data[] = array("ca. 1000 x 1000 ","ca. 1000 x 1000 ","(in m)","(in m)","Gitterweite","ca.1000x1000","1");
$data[] = array("5 x 5 ","5 x 5 ","(in m) oder (in km)","(in m) oder (in km)","Gitterweite","5x5","10");
$data[] = array("1 x 1","1 x 1","(in km)","(in km)","Gitterweite","1x1","11");
$data[] = array("0,5 x 0,5 ","0,5 x 0,5 ","(in km)","(in km)","Gitterweite","0.5x0.5","12");
$data[] = array("0,25 x 0,25 ","0,25 x 0,25 ","(in km)","(in km)","Gitterweite","0.25x0.25","13");
$data[] = array("0,1 x 0,1","0,1 x 0,1","(in km)","(in km)","Gitterweite","0.1x0.1","14");
$data[] = array("200 x 200 ","200 x 200 ","(in m)","(in m)","Gitterweite","200x200","2");
$data[] = array("100 x 100 ","100 x 100 ","(in m)","(in m)","Gitterweite","100x100","3");
$data[] = array("60 x 60 ","60 x 60 ","(in m)","(in m)","Gitterweite","60x60","4");
$data[] = array("50 x 50 ","50 x 50 ","(in m)","(in m)","Gitterweite","50x50","5");
$data[] = array("20 x 20 / 40 x 40","20 x 20 / 40 x 40","(in m)","(in m)","Gitterweite","40x40","6");
$data[] = array("25 x 25 ","25 x 25 ","(in m)","(in m)","Gitterweite","25x25","7");
$data[] = array("20 x 20","20 x 20","(in m)","(in m)","Gitterweite","20x20","8");
$data[] = array("10 x 10 ","10 x 10 ","(in m)","(in m)","Gitterweite","10x10","9");
$data[] = array("160","160","Pixel/cm","Pixel/cm","Rasterdichte","160","1");
$data[] = array("200","200","Pixel/cm","Pixel/cm","Rasterdichte","200","2");
$data[] = array("250","250","Pixel/cm","Pixel/cm","Rasterdichte","250","3");
$data[] = array("320","320","Pixel/cm","Pixel/cm","Rasterdichte","320","4");

$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_resolution');
	$name = trim($this->getRowValue($row,0)." ".$this->getRowValue($row,2));
	$object
	->setCode($this->getRowValue($row,5))
	->setName($name)
	->setShortname($name)
	->setDescription($name)
	->setPos($n)
	->save();
}


$data = array();
//"0 BESCHREIBUNG_DEU","1 BESCHREIBUNG_ENG","2 CODE","3 POSITION");
$data[] = array("Download","Download","download","1");
$data[] = array("CD-DVD","CD-DVD","cd_dvd","2");
$data[] = array("USB-Festplatte","USB-Festplatte","usb_platte","3");
$data[] = array("USB-Stick","USB-Stick","usb_stick","4");
$data[] = array("Sonstiges","Sonstiges","sonstiges","5");

$n = 0;
foreach($data as $row)
{
    $n += 100;
    $object = Mage::getModel('virtualgeo/components_storage');
    $object
        ->setCode($this->getRowValue($row,2))
        ->setName($this->getRowValue($row,0))
        ->setShortname($this->getRowValue($row,0))
        ->setDescription($this->getRowValue($row,0))
        ->setPos($this->getRowValue($row,3)*100)
        ->save();
}