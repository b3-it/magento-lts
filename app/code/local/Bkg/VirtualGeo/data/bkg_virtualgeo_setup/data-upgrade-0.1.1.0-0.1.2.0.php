<?php
/**
  *
  * @category   	Bkg Virtualgeo
  * @package    	Bkg_Virtualgeo
  * @name       	Bkg_Virtualgeo Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();





$storeId_EN = 2;

$data = array();
//$data[] = array("GEOREF_ID","GEOREF","GEO_KUERZEL","BESCHREIBUNG_DEU","HINWEIS","BESCHREIBUNG_ENG","HINWEIS_ENG","EPSG");
$data[] = array("2","gk","GK","Gauß-Krüger-Abbildung im 3-Grad-Streifensystem<br>Ellipsoid Bessel, Datum Potsdam","nur für einzelne Kartenblätter anwendbar","Gauss Kruger Projection in the 3-degree zone system<br>Ellipsoid Bessel, Datum Potsdam","only applicable for single map sheets","");
$data[] = array("3","gk2","GK2","Gauß-Krüger-Abbildung im 2. Meridianstreifen<br>(Mittelmeridian 6°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung. Besonders geeignet für blattschnittfreie Daten im Westen Deutschlands.","Gauss Kruger Projection in the 2nd longitude zone<br>(Central Meridian 6°)<br>Ellipsoid Bessel, Datum Potsdam","especially suited for data without sheet line system in the West of Germany","");
$data[] = array("4","gk3","GK3","Gauß-Krüger-Abbildung im 3. Meridianstreifen<br>(Mittelmeridian 9°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung.Der 3. Streifen wurde oft auch für die Darstellung von deutschlandweiten Datensätzen verwendet.","Gauss Kruger Projection in the 3rd longitude zone<br>(Central Meridian 9°)<br>Ellipsoid Bessel, Datum Potsdam","common standard for Germany-wide data without sheet line system in the Gauss Kruger system","");
$data[] = array("5","gk4","GK4","Gauß-Krüger-Abbildung im 4. Meridianstreifen<br>(Mittelmeridian 12°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung.Besonders geeignet für blattschnittfreie Daten im Osten Deutschlands.","Gauss Kruger Projection in the 4th longitude zone<br>(Central Meridian 12°)<br>Ellipsoid Bessel, Datum Potsdam","especially suited for data without sheet line system in the East of Germany","");
$data[] = array("6","gk5","GK5","Gauß-Krüger-Abbildung im 5. Meridianstreifen<br>(Mittelmeridian 15°)<br>Ellipsoid Bessel, Datum Potsdam","Ehemaliges Standardsystem der deutschen Landesvermessung.Besonders geeignet für blattschnittfreie Daten im äußersten Osten Deutschlands.","Gauss Kruger Projection in the 5th longitude zone<br>(Central Meridian 15°)<br>Ellipsoid Bessel, Datum Potsdam","especially suited for data without sheet line system in the extreme East of Germany","");
$data[] = array("7","lamgw","LAMGw","Lambert-Abbildung (winkeltreu)<br> längentreue Breitenkreise: 48°40' und 53°40'<br> Bezugsmittelpunkt: 10°30' ö.L., 51°00' n.B.<br> Ellipsoid WGS84, Datum WGS84","besonders geeignet für deutschlandweite blattschnittfreie Daten bei möglichst geringen Verzerrungen","Lambert Projection (conformal)<br>isometric parallels of latitude: 48°40' and 53°40'<br>centre of reference: 10°30' EL, 51°00' NL<br>Ellipsoid WGS84, Datum WGS84","especially suited for Germany-wide data without sheet line system with as little distortions as possible","");
$data[] = array("10","utm32w","UTM32w","UTM-Abbildung in der Zone 32<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid WGS84, Datum WGS84)","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Deutschland liegt überwiegend in der Zone 32, so dass diese auch für deutschlandweite blattschnittfreie Daten im UTM-System sehr geeignet ist.","UTM Projection in zone 32<br>(Centre 9°)<br> Ellipsoid WGS84, Datum WGS84 ","With zone indication at the beginning in the easting this georeferencing corresponds to a common form in Germany. Germany is mostly situated in the zone 32 so that this is very appropriate also for Germany-wide data without sheet line system in the UTM system.","");
$data[] = array("11","utm33w","UTM33w","UTM-Abbildung in der Zone 33<br>mit führender Zonenangabe im Rechtswert <br>(Mittelmeridian   15°)<br>Ellipsoid WGS84, Datum WGS84","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Besonders geeignet für blattschnittfreie Daten im Osten Deutschlands.","UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  WGS84, Datum WGS84 ","especially suited for data without sheet line system in the East of Germany","");
$data[] = array("16","utm32e","UTM32e","UTM-Abbildung in der Zone 32<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Sie unterscheidet sich von utm32wdurch ihren geodätischen Bezug.","UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89","","");
$data[] = array("17","utm33e","UTM33e","UTM-Abbildung in der Zone 33<br>mit führender Zonenangabe im Rechtswert <br>Mittelmeridian   15°<br>(Ellipsoid GRS80, Datum ETRS89)","Mit führender Zonenangabe im Rechtswert entspricht diese Georeferenzierung einer in Deutschland verbreiteten Form. Sie unterscheidet sich von utm33wdurch ihren geodätischen Bezug.","UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  GRS80,  Datum ETRS89","","");
$data[] = array("20","geo84","GEO84","Geographische Koordinaten in Dezimalgrad<br> Ellipsoid WGS84, Datum WGS84","","Geographical coordinates in decimal degrees <br> (Ellipsoid WGS84, Datum WGS84)","","");
$data[] = array("35","utm32s","UTM32s","UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","Standardsystem der deutschen Landesvermessung und international eingesetztes UTM-Systems.Die Zone 32 wird oft auch für die Darstellung von deutschlandweiten Datensätzen verwendet.","UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89","common standard for Germany-wide data without sheet line system in the UTM system","");
$data[] = array("36","utm33s","UTM33s","UTM-Abbildung in der Zone 33<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   15°<br>(Ellipsoid GRS80, Datum ETRS89)","Standardsystem der deutschen Landesvermessung und international eingesetztes UTM-Systems.","UTM Projection in zone 33<br>(Centre 15°)<br> Ellipsoid  GRS80,  Datum ETRS89","especially suited for data without sheet line system in the East of Germany","");
$data[] = array("37","gkutm","GKUTM","Gauß-Krüger-Abbildung  im 3-Grad-Streifensystem <br> (Bessel1841,Potsdam-Datum) oder UTM-Abbildung (WGS84,WGS84) im 6-Grad-Streifensystem","Bundeslandbezogen","Gauß-Krüger projection  in the 3-degree zone system <br> (Bessel1841,Potsdam Datum) or UTM projection (WGS84,WGS84) in the 6-degree zone system","Federal state specific","");
$data[] = array("38","geo89","GEO89","Geographische Koordinaten in Dezimalgrad <br> (Ellipsoid GRS80, Datum ETRS89)","","Geographical coordinates in decimal degrees <br>  (Ellipsoid GRS80, Datum ETRS89)","");
$data[] = array("39","utms","UTMS","UTM-Abbildung Im 6-Grad-Streifensystem<br>ohne führende Zonenangabe im Rechtswert <br>(Ellipsoid GRS80, Datum ETRS89)","Bundeslandbezogen Ohne führende Zonenangabe im Rechtswert entspricht diese Georeferenzierung dem international üblichen Standard für UTM. Deutschland liegt überwiegend in der Zone 32, so dass diese auch für deutschlandweite blattschnittfreie Daten im UTM-System sehr geeignet ist.","UTM Projection in zone 32<br>(Centre 9°)<br>Ellipsoid GRS80, Datum ETRS89","common standard for Germany-wide data without sheet line system in the UTM system","");
$data[] = array("42","tm32","TM32","UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","","UTM-Abbildung in der Zone 32<br>ohne führende Zonenangabe im Rechtswert <br>Mittelmeridian   9°<br>(Ellipsoid GRS80, Datum ETRS89)","");
$data[] = array("43","lamge","LAMGe","Lambert-Abbildung (winkeltreu)<br> längentreue Breitenkreise: 48°40' und 53°40'<br> Bezugsmittelpunkt: 10°30' ö.L., 51°00' n.B.<br> Ellipsoid GRS80, Datum ETRS89","besonders geeignet für deutschlandweite blattschnittfreie Daten bei möglichst geringen Verzerrungen","Lambert Projection (conformal)<br>isometric parallels of latitude: 48°40' and 53°40'<br>centre of reference: 10°30' EL, 51°00' NL<br>Ellipsoid GRS80, Datum ETRS89","especially suited for Germany-wide data without sheet line system with as little distortions as possible","");
$data[] = array("45","psmerc","PSEUDO_MERCATOR","Pseudo-Mercator (Ellipsoid WGS84, Datum WGS84)","Sphärische Mercator-Projektion <br> Standardsystem für weltweite Webdienste z.B. von Google oder OpenStreetMap","Pseudo-Mercator (Ellipsoid WGS84, Datum WGS84)","Standardsystem für Webdienste von Google oder OpenStreetMap","");

$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_georef');
	$object->setGeoref($this->getRowValue($row,1))
	->setEpsgCode($this->getRowValue($row,7))
	->setName($this->getRowValue($row,3))
	->setShortname($this->getRowValue($row,2))
	->setDescription($this->getRowValue($row,4))
	->setPos($n)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,5))
	->setShortname($this->getRowValue($row,2))
	->setDescription($this->getRowValue($row,6))
	->save();
}

$data = array();
//$data[] = array("FORMAT_ID","FORMAT","BESCHREIBUNG_DEU","HINWEIS","BESCHREIBUNG_ENG","HINWEIS_ENG","","","","","","","","","","","","","","");
$data[] = array("1","grid","ArcInfo-GRID","farbcodierte Darstellung"," internes Format des Geoinformationssystems ArcInfo","ArcInfo-GRID","color-coded representation"," internal format of the Geographic Information System ArcInfo","","","","","","","","","","","","","","");
$data[] = array("2","tif-lzw","TIFF-LZW","farbcodierte Darstellung","GeoTIFF mit Komprimierung LZW","GeoTIFF with compression LZW","8-Bit"," palette colors","","","","","","","","","","","","","","","","");
$data[] = array("3","EE","Dummy","Dummy","Dummy","","","","","","","","","","","","","","","");
$data[] = array("4","tif-g4","TIFF-GROUP4","Schwarz-Weiß-Darstellung","TIFF mit Komprimierung CCITT-GROUP4","TIFF-GROUP4","Black-and-white representation","TIFF with compression CCITT-GROUP4","","","","","","","","","","","","","","");
$data[] = array("6","dxf","DXF","Verbreitetes CAD-Datenformat"," das nach wie vor von vielen Geoinformationssystemen unterstützt wird. In der Regel gehen beim Einsatz von DXF bestimmte Informationen der Ausgangsdaten verloren. Attributive Informationen werden häufig in einem gewissen Umfang über beigestellte ASCII-Dateien transportiert.","DXF","Widely spread CAD data format"," that is still supported by many GI Systems. As a rule by using DXF certain informations get lost","","","","","","","","","","","","","","");
$data[] = array("9","shape","ArcInfo-SHAPE","Offen gelegtes Austauschformat"," das von vielenGeoinformationssystemen unterstützt wird.","ArcInfo-SHAPE","Open Exchange format"," that is supported by many GI Systems","","","","","","","","","","","","","","");
$data[] = array("11","grida","GRID-ASCII","ASCII-Datei. Von ArcInfo unterstütztes ASCII-Format"," das nach Angaben zur Berechnung derGitterpunkte eine Matrix mit Höhenwerten enthält.","GRID-ASCII","ASCII file. ASCII format supported by ArcInfo that contains after data for the computation of the grid points a matrix with elevations. ","","","","","","","","","","","","","","");
$data[] = array("12","ascii","XYZ-ASCII","ASCII-Datei. Enthält zeilenweise einen Höhenpunkt mit Lagekoordinate und Höhe:<br>x_koordinate y_koordinate höhenwert","XYZ-ASCII","ASCII file. Contains per spot height a data set of the form: x_koordinate","y_koordinate","höhenwert (x_coordinate","y_coordinate","elevation) ","","","","","","","","","","","","","","");
$data[] = array("17","text","ASCII-Text","ASCII-Textdatei","ASCII text","ASCII-Textdatei","","","","","","","","","","","","","","");
$data[] = array("18","sde","SDE-Ablageformat","SDE-Ablageformat","SDE filing format","SDE filing format","","","","","","","","","","","","","","");
$data[] = array("19","geoid","(1)&nbsp","ASCII&nbsp","(B","L","H)&nbsp","&nbsp","&nbsp","&nbsp","<br>(2)&nbsp","Binäres&nbsp","Format<br>(3)&nbsp","Trimble-Format<br>(4)&nbsp","LEICA-Format&nbsp","&nbsp","<br>(5)&nbsp","TOPCON-Format<br>(6)&nbsp","SurvCE-Format<br>(7)&nbsp","JAVAD-Format","(1) Ascii-Datei. Enthält je Rasterpunkt einen Datensatz der Form x-Koordinate y-Koordinate Geoidundulation<br>(2) Header zur Beschreibung des Rasters"," danach Folge von 4-Byte-Werten mit Geoidundulationen<br>(3) spezielles Datenformat zur Einbindung in die Trimble Geomatics Office bzw. Trimble Business Center Software<br>(4) spezielles Datenformat zur Einbindung in LEICA Geo Office Software <br>(5) spezielles Datenformat zur Einbindung in TOPCON-Software <br> (6) spezielles Datenformat zur Einbindung in SurvCE-Software <br> (7) spezielles Datenformat zur Einbindung in JAVAD-Geräte","(1) ASCII (B","L","H)(2) Binary Format(3) Trimble-Format(4) LEICA-Format(5) SurvCE-Format","(1) Ascii-Datei. Enthält je Rasterpunkt einen Datensatz der Form x-Koordinate y-Koordinate Geoidundulation<br>(2) Header zur Beschreibung des Rasters"," danach Folge von 4-Byte-Werten mit Geoidundulationen<br>(3) spezielles Datenformat zur Einbindung in die Trimble Geomatics Office bzw. Trimble Business Center Software<br>(4) spezielles Datenformat zur Einbindung in LEICA Geo Office Software <br>(5) spezielles Datenformat zur Einbindung in SurvCE-Software (SOKKIA)");
$data[] = array("22","tif","TIFF","TIFF unkomprimiert"," 24-Bit Farbtiefe","TIFF","TIFF unpacked"," 24-Bit colour depth","","","","","","","","","","","","","","");
$data[] = array("23","csv","CSV","Textdatei in UTF8-Zeichenkodierung.<br> Enthält zeilenweise Lagegeometrie und Attribute mit Semikolon als Trennzeichen.","CSV","Text file in UTF8 character coding.<br> Contains line-by-line position geometry and attributes with semicolon as separator.","","","","","","","","","","","","","","");
$data[] = array("24","tif-der","TIFF-DER","um WEB-Darstellung zu erzeugen","TIFF-DER","to be generated for WEB presentation","","","","","","","","","","","","","","");
$data[] = array("25","jpeg","JPEG","JPEG","JPEG","JPEG","","","","","","","","","","","","","","");
$data[] = array("26","pdf","Portable Document Format","PDF is a file format created by Adobe Systems","Portable Document Format","PDF is a file format created by Adobe Systems","","","","","","","","","","","","","","");
$data[] = array("27","nas_nba","NAS - normbasierte Austauschschnittstelle","Normbasierte Austauschschnittstelle. Datenaustauschformat des AAA-Modells ","NAS - norm-based data exchange interface","Norm-based data exchange interface. Data exchange format of the AAA model","","","","","","","","","","","","","","");
$data[] = array("28","svg","Scalable Vector Graphics","SVG ist die vom World Wide Web Consortium (W3C) empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken","Scalable Vector Graphics","SVG is a family of specifications of an XML-based file format for describing two-dimensional vector graphics","","","","","","","","","","","","","","");
$data[] = array("29","tif-k","TIFF-K","TIFF komprimiert"," 24-Bit Farbtiefe","TIFF-K","TIFF packed"," 24-Bit colour depth","","","","","","","","","","","","","","");
$data[] = array("31","eps","EPS","Vom World Wide Web Consortium empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken. Auf XML basierend","EPS","Vom World Wide Web Consortium empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken. Auf XML basierend","","","","","","","","","","","","","","");
$data[] = array("32","ai","AI","Vom World Wide Web Consortium empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken. Auf XML basierend","AI","Vom World Wide Web Consortium empfohlene Spezifikation zur Beschreibung zweidimensionaler Vektorgrafiken. Auf XML basierend","","","","","","","","","","","","","","");
$data[] = array("35","nas_bda","NAS - normbasierte Austauschschnittstelle","Normbasierte Austauschschnittstelle. Datenaustauschformat des AAA-Modells ","NAS - norm-based data exchange interface","Norm-based data exchange interface. Data exchange format of the AAA model","","","","","","","","","","","","","","");
$data[] = array("37","fgdb","ESRI fGDB ","ESRI file geodatabase ","ESRI fGDB ","ESRI file geodatabase","","","","","","","","","","","","","","");
$data[] = array("38","geogrid","GEOGRID","spezielles Format des Geogrid-Viewers","GEOGRID","spezielles Format des Geogrid-Viewers","","","","","","","","","","","","","","");
$data[] = array("39","citygml","Standardabgabeformat für 3D-Gebäudemodelle","Format entsprechend dem AdV-CityGML-Profil","Standardabgabeformat für 3D-Gebäudemodelle","CityGML-Format entsprechend dem AdV-CityGML-Profil","","","","","","","","","","","","","","");
$data[] = array("40","ee-png","ESRI Exploded PNG","Rasterkachelarchiv mit PNG-Kacheln.Dieses Format eignet sich für den Einsatz mit ESRI-Produkten. Es müssen aber zusätzlich entsprechende Konfigurationsdateien bereitgestellt werden"," damit das Verzeichnis als MapCache von ArcGIS erkannt wird. ","ESRI Exploded PNG","Rasterkachelarchiv mit PNG-Kacheln.Dieses Format eignet sich für den Einsatz mit ESRI-Produkten. Es müssen aber zusätzlich entsprechende Konfigurationsdateien bereitgestellt werden"," damit das Verzeichnis als MapCache von ArcGIS erkannt wird. ","","","","","","","","","","","","","","");
$data[] = array("41","png+wld","PNG+WLD","Ein Grafikformat für Rastergrafiken mit verlustfreier Kompression"," hier mit Angabe eines World-Files.","PNG+WLD","Ein Grafikformat für Rastergrafiken mit verlustfreier Kompression"," hier mit World-File.","","","","","","","","","","","","","","");
$data[] = array("47","ec-png","ESRI Compact PNG","Rasterkachelarchiv mit PNG-Kacheln. Gruppiert einzelne PNGs/Tiles zu bundle-Dateien - ein Bundle kann bis zu 16.000 Tiles beinhalten. Eignet sich für den Einsatz mit ESRI-Produkten oder MapProxy.","ESRI Compact PNG","Rasterkachelarchiv mit PNG-Kacheln. Gruppiert einzelne PNGs/Tiles zu bundle-Dateien - ein Bundle kann bis zu 16.000 Tiles beinhalten. Eignet sich für den Einsatz mit ESRI-Produkten oder MapProxy.","","","","","","","","","","","","","","");
$data[] = array("48","tilecache","TileCache PNG","Dieses Format ist gut geeignet für dateibasierte Caches mit sehr vielen Dateien. Die maximale Datei-/Ordneranzahl pro Verzeichnis ist 1000 und kann damit von jedem System gut verarbeitet werden. ","TileCache PNG","Dieses Format ist gut geeignet für dateibasierte Caches mit sehr vielen Dateien. Die maximale Datei-/Ordneranzahl pro Verzeichnis ist 1000 und kann damit von jedem System gut verarbeitet werden. ","","","","","","","","","","","","","","");
$data[] = array("49","SQLITE","SQLITE MBTILE","Jede Zoomstufe wird in einer separaten SQLite-Datenbank gespeichert. Der Dateiname der Datenbank ist die Zoomstufe (ohne führende Null). Der Dateiname der Datenbank besitzt die Dateierweiterung mbtiles. ","SQLITE MBTILE","Jede Zoomstufe wird in einer separaten SQLite-Datenbank gespeichert. Der Dateiname der Datenbank ist die Zoomstufe (ohne führende Null). Der Dateiname der Datenbank besitzt die Dateierweiterung mbtiles. ","","","","","","","","","","","","","","");
$data[] = array("50","tif-jpeg","TIFF-JPEG","GeoTIFF mit Komprimierung JPEG","TIFF-JPEG","GeoTIFF with compression JPEG","","","","","","","","","","","","","","");

$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_format');
	$object->setCode($this->getRowValue($row,1))
	->setHasResolution(1)
	->setName($this->getRowValue($row,2))
	->setShortname($this->getRowValue($row,2))
	->setDescription($this->getRowValue($row,3))
	->setPos($n)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,4))
	->setShortname($this->getRowValue($row,4))
	->setDescription($this->getRowValue($row,6))
	->save();
}

$data = array();

$data[] = array("02300","AAA_Praesentationsobjekte","02300","AAA_presentation objects","dlm");
$data[] = array("02300","AP_GPO","02300","AP_GPO","dlm");
$data[] = array("02310","AP_PPO","02310","AP_PPO","dlm");
$data[] = array("02320","AP_LPO","02320","AP_LPO","dlm");
$data[] = array("02330","AP_FPO","02330","AP_FPO","dlm");
$data[] = array("02340","AP_TPO","02340","AP_TPO","dlm");
$data[] = array("02341","AP_PTO","02341","AP_PTO","dlm");
$data[] = array("02342","AP_LTO","02342","AP_LTO","dlm");
$data[] = array("02350","AP_Darstellung","02350","AP_representation","dlm");
$data[] = array("111","Durchgängig städtische Prägung ","111","Durchgängig städtische Prägung ","dlm");
$data[] = array("112","Nicht durchgängig städtische Prägung ","112","Nicht durchgängig städtische Prägung ","dlm");
$data[] = array("12000","Angaben zur Lage","12000","Details on the location","dlm");
$data[] = array("12002","AX_LagebezeichnungMitHausnummer","12002","AX_PlaceNameWithHouseNumber","dlm");
$data[] = array("12003","AX_LagebezeichnungMitPseudonummer","12003","AX_PlaceNameWithPseudoNumber","dlm");
$data[] = array("12004","AX_Lagebezeichnung","12004","AX_Lagebezeichnung","dlm");
$data[] = array("12005","AX_Lage","12005","AX_Lage","dlm");
$data[] = array("12006","AX_GeoreferenzierteGebaeudeadresse","12006","AX_GeoreferenzierteGebaeudeadresse","dlm");
$data[] = array("12007","AX_Post","12007","AX_Post","dlm");
$data[] = array("121","Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","121","Industrie-und Gewerbeflächen, öffentliche Einrichtungen ","dlm");
$data[] = array("122","Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","122","Straßen-, Eisenbahnnetze und funktionell zugeordnete Flächen ","dlm");
$data[] = array("123","Hafengebiete ","123","Hafengebiete ","dlm");
$data[] = array("124","Flughäfen ","124","Flughäfen ","dlm");
$data[] = array("131","Abbauflächen ","131","extraction sites","dlm");
$data[] = array("131","Abbauflächen ","131","Abbauflächen ","dlm");
$data[] = array("132","Deponien und Abraumhalden ","132","Deponien und Abraumhalden ","dlm");
$data[] = array("133","Baustellen ","133","Baustellen ","dlm");
$data[] = array("133","Baustellen ","133","construction sites","dlm");
$data[] = array("141","Städtische Grünflächen ","141","Städtische Grünflächen ","dlm");
$data[] = array("142","Sport-und Freizeitanlagen ","142","Sport-und Freizeitanlagen ","dlm");
$data[] = array("21000","Personen- und Bestandsdaten","21000","Personen- und Bestandsdaten","dlm");
$data[] = array("21001","AX_Person","21001","AX_Person","dlm");
$data[] = array("211","Nicht bewässertes Ackerland ","211","Nicht bewässertes Ackerland ","dlm");
$data[] = array("212","Regelmäßig bewässertes Ackerland ","212","Regelmäßig bewässertes Ackerland ","dlm");
$data[] = array("213","Reisfelder ","213","Reisfelder ","dlm");
$data[] = array("221","Weinbauflächen ","221","Weinbauflächen ","dlm");
$data[] = array("222","Obst-und Beerenobstbestände ","222","Obst-und Beerenobstbestände ","dlm");
$data[] = array("223","Olivenhaine ","223","Olivenhaine ","dlm");
$data[] = array("231","Wiesen und Weiden ","231","Wiesen und Weiden ","dlm");
$data[] = array("241","Einjährige Kulturen in Verbindung mit Dauerkulturen ","241","Einjährige Kulturen in Verbindung mit Dauerkulturen ","dlm");
$data[] = array("242","Komplexe Parzellenstrukturen ","242","Komplexe Parzellenstrukturen ","dlm");
$data[] = array("243","Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","243","Landwirtschaftlich genutztes Land mit Flächen natürlicher Bodenbedeckung von signifikanter Größe ","dlm");
$data[] = array("244","Land-und forstwirtschaftliche Flächen ","244","Land-und forstwirtschaftliche Flächen ","dlm");
$data[] = array("31000","Angaben zum Gebäude","31000","Details on the building ","dlm");
$data[] = array("31001","AX_Gebaeude","31001","AX_Gebaeude","dlm");
$data[] = array("31001","AX_Gebaeude","31001","AX_Building","dlm");
$data[] = array("31002","AX_Bauteil","31002","AX_component","dlm");
$data[] = array("31006","AX_Nutzung_Gebaeude","31006","AX_Nutzung_Gebaeude","dlm");
$data[] = array("311","Laubwälder ","311","Laubwälder ","dlm");
$data[] = array("312","Nadelwälder ","312","Nadelwälder ","dlm");
$data[] = array("313","Mischwälder ","313","Mischwälder ","dlm");
$data[] = array("321","Natürliches Grünland ","321","Natürliches Grünland ","dlm");
$data[] = array("322","Heiden und Moorheiden ","322","Heiden und Moorheiden ","dlm");
$data[] = array("323","Hartlaubbewuchs ","323","Hartlaubbewuchs ","dlm");
$data[] = array("324","Wald-Strauch-Übergangsstadien ","324","Wald-Strauch-Übergangsstadien ","dlm");
$data[] = array("331","Strände, Dünen und Sandflächen ","331","Strände, Dünen und Sandflächen ","dlm");
$data[] = array("332","Felsflächen ohne Vegetation ","332","Felsflächen ohne Vegetation ","dlm");
$data[] = array("333","Flächen mit spärlicher Vegetation ","333","Flächen mit spärlicher Vegetation ","dlm");
$data[] = array("334","Brandflächen ","334","Brandflächen ","dlm");
$data[] = array("335","Gletscher und Dauerschneegebiete ","335","Gletscher und Dauerschneegebiete ","dlm");
$data[] = array("41000","Tatsaechliche Nutzung - Siedlung","41000","Tatsaechliche Nutzung - Siedlung","dlm");
$data[] = array("41001","AX_Wohnbauflaeche","41001","AX_ResidentialArea","dlm");
$data[] = array("41002","AX_IndustrieUndGewerbeflaeche","41002","AX_IndustrieUndGewerbeflaeche","dlm");
$data[] = array("41002","AX_IndustrieUndGewerbeflaeche","41002","AX_IndustrialZone","dlm");
$data[] = array("41003","AX_Halde","41003","AX_Dump","dlm");
$data[] = array("41004","AX_Bergbaubetrieb","41004","AX_Bergbaubetrieb","dlm");
$data[] = array("41004","AX_Bergbaubetrieb","41004","AX_MiningWorks","dlm");
$data[] = array("41005","AX_TagebauGrubeSteinbruch","41005","AX_OpenPitMineQuarry","dlm");
$data[] = array("41005","AX_TagebauGrubeSteinbruch","41005","AX_TagebauGrubeSteinbruch","dlm");
$data[] = array("41006","AX_FlaecheGemischterNutzung","41006","AX_AreaOfMixedUse","dlm");
$data[] = array("41006","AX_FlaecheGemischterNutzung","41006","AX_FlaecheGemischterNutzung","dlm");
$data[] = array("41007","AX_FlaecheBesondererFunktionalerPraegung","41007","AX_FlaecheBesondererFunktionalerPraegung","dlm");
$data[] = array("41007","AX_FlaecheBesondererFunktionalerPraegung","41007","AX_AreaWithSpecialFunctionalCharacter","dlm");
$data[] = array("41008","AX_SportFreizeitUndErholungsflaeche","41008","AX_SportFreizeitUndErholungsflaeche","dlm");
$data[] = array("41008","AX_SportFreizeitUndErholungsflaeche","41008","AX_SportsLeisureAndRecreationalArea","dlm");
$data[] = array("41009","AX_Friedhof","41009","AX_Friedhof","dlm");
$data[] = array("41009","AX_Friedhof","41009","AX_Cemetery","dlm");
$data[] = array("41010","AX_Siedlungsflaeche","41010","AX_Siedlungsflaeche","dlm");
$data[] = array("411","Sümpfe ","411","Sümpfe ","dlm");
$data[] = array("412","Torfmoore ","412","Torfmoore ","dlm");
$data[] = array("42000","Tatsaechliche Nutzung - Verkehr","42000","Tatsaechliche Nutzung - Verkehr","dlm");
$data[] = array("42001","AX_Strassenverkehr","42001","AX_RoadTraffic","dlm");
$data[] = array("42002","AX_Strasse","42002","AX_Road","dlm");
$data[] = array("42002","AX_Strasse","42002","AX_Strasse","dlm");
$data[] = array("42003","AX_Strassenachse","42003","AX_Strassenachse","dlm");
$data[] = array("42003","AX_Strassenachse","42003","AX_RoadAxis","dlm");
$data[] = array("42005","AX_Fahrbahnachse","42005","AX_RoadAxis","dlm");
$data[] = array("42008","AX_Fahrwegachse","42008","AX_DrivewayAxis","dlm");
$data[] = array("42008","AX_Fahrwegachse","42008","AX_Fahrwegachse","dlm");
$data[] = array("42009","AX_Platz","42009","AX_Place","dlm");
$data[] = array("42010","AX_Bahnverkehr","42010","AX_Bahnverkehr","dlm");
$data[] = array("42010","AX_Bahnverkehr","42010","AX_railway traffic","dlm");
$data[] = array("42014","AX_Bahnstrecke","42014","AX_Bahnstrecke","dlm");
$data[] = array("42014","AX_Bahnstrecke","42014","AX_railway line","dlm");
$data[] = array("42015","AX_Flugverkehr","42015","AX_Flugverkehr","dlm");
$data[] = array("42015","AX_Flugverkehr","42015","AX_AirTraffic");
$data[] = array("","dlm");
$data[] = array("42016","AX_Schiffsverkehr","42016","AX_ShippingTraffic","dlm");
$data[] = array("421","Salzwiesen ","421","Salzwiesen ","dlm");
$data[] = array("422","Salinen ","422","Salinen ","dlm");
$data[] = array("423","In der Gezeitenzone liegende Flächen ","423","In der Gezeitenzone liegende Flächen ","dlm");
$data[] = array("43000","Tatsaechliche Nutzung - Vegetation","43000","Tatsaechliche Nutzung - Vegetation","dlm");
$data[] = array("43001","AX_Landwirtschaft","43001","AX_Landwirtschaft","dlm");
$data[] = array("43001","AX_Landwirtschaft","43001","AX_Agriculture","dlm");
$data[] = array("43002","AX_Wald","43002","AX_Forest","dlm");
$data[] = array("43002","AX_Wald","43002","AX_Wald","dlm");
$data[] = array("43003","AX_Gehoelz","43003","AX_Grove","dlm");
$data[] = array("43004","AX_Heide","43004","AX_Heathland","dlm");
$data[] = array("43004","AX_Heide","43004","AX_Heide","dlm");
$data[] = array("43005","AX_Moor","43005","AX_Swamp","dlm");
$data[] = array("43005","AX_Moor","43005","AX_Moor","dlm");
$data[] = array("43006","AX_Sumpf","43006","AX_Sumpf","dlm");
$data[] = array("43006","AX_Sumpf","43006","AX_Bog","dlm");
$data[] = array("43007","AX_UnlandVegetationsloseFlaeche","43007","AX_UnlandVegetationsloseFlaeche","dlm");
$data[] = array("43007","AX_UnlandVegetationsloseFlaeche","43007","AX_WasteLandAreaWithoutVegetation","dlm");
$data[] = array("43008","AX_FlaecheZurZeitUnbestimmbar","43008","AX_AreaPresentlyUndeterminable","dlm");
$data[] = array("44000","Tatsaechliche Nutzung - Gewaesser","44000","Tatsaechliche Nutzung - Gewaesser","dlm");
$data[] = array("44001","AX_Fliessgewaesser","44001","AX_Watercourse","dlm");
$data[] = array("44001","AX_Fliessgewaesser","44001","AX_Fliessgewaesser","dlm");
$data[] = array("44002","AX_Wasserlauf","44002","AX_Wasserlauf","dlm");
$data[] = array("44002","AX_Wasserlauf","44002","AX_WaterCourse","dlm");
$data[] = array("44003","AX_Kanal","44003","AX_Canal","dlm");
$data[] = array("44003","AX_Kanal","44003","AX_Kanal","dlm");
$data[] = array("44004","AX_Gewaesserachse","44004","AX_WaterAxis","dlm");
$data[] = array("44004","AX_Gewaesserachse","44004","AX_Gewaesserachse","dlm");
$data[] = array("44005","AX_Hafenbecken","44005","AX_InnerHarbour","dlm");
$data[] = array("44006","AX_StehendesGewaesser","44006","AX_StehendesGewaesser","dlm");
$data[] = array("44006","AX_StehendesGewaesser","44006","AX_StandingWaterBody","dlm");
$data[] = array("44007","AX_Meer","44007","AX_Meer","dlm");
$data[] = array("44007","AX_Meer","44007","AX_Sea","dlm");
$data[] = array("51000","Bauwerke und Einrichtungen in Siedlungsflaechen","51000","constructions and facilities in settlement areas","dlm");
$data[] = array("51001","AX_Turm","51001","AX_Tower","dlm");
$data[] = array("51001","AX_Turm","51001","AX_Turm","dlm");
$data[] = array("51002","AX_BauwerkOderAnlageFuerIndustrieUndGewerbe","51002","AX_BuildingOrFacilitiesForIndustryAndBusiness","dlm");
$data[] = array("51002","AX_BauwerkOderAnlageFuerIndustrieUndGewerbe","51002","AX_BauwerkOderAnlageFuerIndustrieUndGewerbe","dlm");
$data[] = array("51003","AX_VorratsbehaelterSpeicherbauwerk","51003","AX_ReservoirStorageStructure","dlm");
$data[] = array("51004","AX_Transportanlage","51004","AX_Transportanlage","dlm");
$data[] = array("51004","AX_Transportanlage","51004","AX_Conveyor","dlm");
$data[] = array("51005","AX_Leitung","51005","AX_Leitung","dlm");
$data[] = array("51005","AX_Leitung","51005","AX_Line","dlm");
$data[] = array("51006","AX_BauwerkOderAnlageFuerSportFreizeitUndErholung","51006","AX_BauwerkOderAnlageFuerSportFreizeitUndErholung","dlm");
$data[] = array("51006","AX_BauwerkOderAnlageFuerSportFreizeitUndErholung","51006","AX_BuildingOrFacilitiesForSportsLeisureTimeAndRecreation","dlm");
$data[] = array("51007","AX_HistorischesBauwerkOderHistorischeEinrichtung","51007","AX_HistoricalBuildingOrHistoricalConstruction","dlm");
$data[] = array("51007","AX_HistorischesBauwerkOderHistorischeEinrichtung","51007","AX_HistorischesBauwerkOderHistorischeEinrichtung","dlm");
$data[] = array("51008","AX_HeilquelleGasquelle","51008","AX_HeilquelleGasquelle","dlm");
$data[] = array("51009","AX_SonstigesBauwerkOderSonstigeEinrichtung","51009","AX_SonstigesBauwerkOderSonstigeEinrichtung","dlm");
$data[] = array("51009","AX_SonstigesBauwerkOderSonstigeEinrichtung","51009","AX_OtherBuildingsOrOther Facilities","dlm");
$data[] = array("51010","AX_EinrichtungInOeffentlichenBereichen","51010","AX_FacilitiesInPublicAreas","dlm");
$data[] = array("511","Gewässerläufe ","511","Gewässerläufe ","dlm");
$data[] = array("512","Wasserflächen ","512","Wasserflächen ","dlm");
$data[] = array("52000","Besondere Anlagen auf Siedlungsflaechen","52000","Special facilities on settlement areas","dlm");
$data[] = array("52001","AX_Ortslage","52001","AX_Ortslage","dlm");
$data[] = array("52001","AX_Ortslage","52001","AX_Site","dlm");
$data[] = array("52002","AX_Hafen","52002","AX_Harbour","dlm");
$data[] = array("52003","AX_Schleuse","52003","AX_Sluice","dlm");
$data[] = array("52003","AX_Schleuse","52003","AX_Schleuse","dlm");
$data[] = array("52004","AX_Grenzuebergang","52004","AX_Grenzuebergang","dlm");
$data[] = array("52004","AX_Grenzuebergang","52004","AX_BorderCrossing","dlm");
$data[] = array("52005","AX_Testgelaende","52005","AX_Testgelaende","dlm");
$data[] = array("52005","AX_Testgelaende","52005","AX_TestGround","dlm");
$data[] = array("521","Lagunen ","521","Lagunen ","dlm");
$data[] = array("522","Mündungsgebiete ","522","Mündungsgebiete ","dlm");
$data[] = array("523","Meere und Ozeane ","523","Meere und Ozeane ","dlm");
$data[] = array("53000","Bauwerke, Anlagen und Einrichtungen für den Verkehr","53000","constructions, facilities and equipment for traffic","dlm");
$data[] = array("53001","AX_BauwerkImVerkehrsbereich","53001","AX_BauwerkImVerkehrsbereich","dlm");
$data[] = array("53001","AX_BauwerkImVerkehrsbereich","53001","AX_BuildingInTrafficArea","dlm");
$data[] = array("53002","AX_Strassenverkehrsanlage","53002","AX_RoadTrafficFacilities","dlm");
$data[] = array("53002","AX_Strassenverkehrsanlage","53002","AX_Strassenverkehrsanlage","dlm");
$data[] = array("53003","AX_WegPfadSteig","53003","AX_WegPfadSteig","dlm");
$data[] = array("53003","AX_WegPfadSteig","53003","AX_WayPathSteepTrack","dlm");
$data[] = array("53004","AX_Bahnverkehrsanlage","53004","AX_railway traffic facilities","dlm");
$data[] = array("53004","AX_Bahnverkehrsanlage","53004","AX_Bahnverkehrsanlage","dlm");
$data[] = array("53005","AX_SeilbahnSchwebebahn","53005","AX_SeilbahnSchwebebahn","dlm");
$data[] = array("53005","AX_SeilbahnSchwebebahn","53005","AX_CableCarSuspensionRailway","dlm");
$data[] = array("53006","AX_Gleis","53006","AX_RailTrack","dlm");
$data[] = array("53007","AX_Flugverkehrsanlage","53007","AX_AirTrafficFacilities","dlm");
$data[] = array("53007","AX_Flugverkehrsanlage","53007","AX_Flugverkehrsanlage","dlm");
$data[] = array("53008","AX_EinrichtungenFuerDenSchiffsverkehr","53008","AX_EinrichtungenFuerDenSchiffsverkehr","dlm");
$data[] = array("53008","AX_EinrichtungenFuerDenSchiffsverkehr","53008","AX_FacilitiesForShippingTraffic","dlm");
$data[] = array("53009","AX_BauwerkImGewaesserbereich","53009","AX_BauwerkImGewaesserbereich","dlm");
$data[] = array("53009","AX_BauwerkImGewaesserbereich","53009","AX_BuildingInWaterBodyArea","dlm");
$data[] = array("54000","Besondere Vegetationsmerkmale","54000","Special vegetation features","dlm");
$data[] = array("54001","AX_Vegetationsmerkmal","54001","AX_VegetationFeature","dlm");
$data[] = array("54001","AX_Vegetationsmerkmal","54001","AX_Vegetationsmerkmal","dlm");
$data[] = array("55000","Besondere Eigenschaften von Gewässern","55000","Special characteristics of water bodies","dlm");
$data[] = array("55001","AX_Gewaessermerkmal","55001","AX_WaterCharacteristic","dlm");
$data[] = array("55001","AX_Gewaessermerkmal","55001","AX_Gewaessermerkmal","dlm");
$data[] = array("55002","AX_UntergeordnetesGewaesser","55002","AX_UntergeordnetesGewaesser","dlm");
$data[] = array("55003","AX_Polder","55003","AX_Polder","dlm");
$data[] = array("56000","Besondere Angaben zum Verkehr","56000","Specific information on the traffic","dlm");
$data[] = array("56001","AX_Netzknoten","56001","AX_NetworkNode","dlm");
$data[] = array("56002","AX_Nullpunkt","56002","AX_DatumPoint","dlm");
$data[] = array("56003","AX_Abschnitt","56003","AX_section","dlm");
$data[] = array("56004","AX_Ast","56004","AX_Ast","dlm");
$data[] = array("57000","Besondere Angaben zum Gewässer","57000","Specific information on the water body","dlm");
$data[] = array("57001","AX_Wasserspiegelhoehe","57001","AX_WaterSurfaceLevel","dlm");
$data[] = array("57001","AX_Wasserspiegelhoehe","57001","AX_Wasserspiegelhoehe","dlm");
$data[] = array("57002","AX_SchifffahrtslinieFaehrverkehr","57002","AX_SchifffahrtslinieFaehrverkehr","dlm");
$data[] = array("57002","AX_SchifffahrtslinieFaehrverkehr","57002","AX_ShippingLineFerryTraffic","dlm");
$data[] = array("57003","AX_Gewaesserstationierungsachse","57003","AX_Gewaesserstationierungsachse","dlm");
$data[] = array("57003","AX_Gewaesserstationierungsachse","57003","AX_WaterStationingAxis","dlm");
$data[] = array("57004","AX_Sickerstrecke","57004","AX_Sickerstrecke","dlm");
$data[] = array("57004","AX_Sickerstrecke","57004","AX_SeepageCourse","dlm");
$data[] = array("61000","Reliefformen","61000","Reliefformen","dlm");
$data[] = array("61000","Reliefformen","61000","Relief forms","dlm");
$data[] = array("61001","AX_BoeschungKliff","61001","AX_BoeschungKliff","dlm");
$data[] = array("61001","AX_BoeschungKliff","61001","AX_SlopeCliff","dlm");
$data[] = array("61002","AX_Boeschungsflaeche","61002","AX_SlopeArea","dlm");
$data[] = array("61002","AX_Boeschungsflaeche","61002","AX_Breakline","dlm");
$data[] = array("61003","AX_DammWallDeich","61003","AX_DammWallDeich","dlm");
$data[] = array("61003","AX_DammWallDeich","61003","AX_DamRampartDike","dlm");
$data[] = array("61004","AX_Einschnitt","61004","AX_Cutting","dlm");
$data[] = array("61005","AX_Hoehleneingang","61005","AX_Hoehleneingang","dlm");
$data[] = array("61005","AX_Hoehleneingang","61005","AX_CaveEntrance","dlm");
$data[] = array("61006","AX_FelsenFelsblockFelsnadel","61006","AX_RockBoulderRockspire","dlm");
$data[] = array("61007","AX_Duene","61007","AX_Dune","dlm");
$data[] = array("61008","AX_Hoehenlinie","61008","AX_Contour","dlm");
$data[] = array("61008","AX_Hoehenlinie","61008","AX_Hoehenlinie","dlm");
$data[] = array("62000","Primäres DGM","62000","Primäres DGM","dlm");
$data[] = array("62040","AX_Gelaendekante","62040","AX_Gelaendekante","dlm");
$data[] = array("62040","AX_Gelaendekante","62040","AX_Breakline","dlm");
$data[] = array("71000","Öffentlich-rechtliche und sonstige Festlegungen","71000","Öffentlich-rechtliche und sonstige Festlegungen","dlm");
$data[] = array("71004","AX_AndereFestlegungNachWasserrecht","71004","AX_OtherSpecificationAccordingToWaterRight","dlm");
$data[] = array("71005","AX_SchutzgebietNachWasserrecht","71005","AX_ProtectedAreaAccordingToWaterLaw","dlm");
$data[] = array("71006","AX_NaturUmweltOderBodenschutzrecht","71006","AX_NaturUmweltOderBodenschutzrecht","dlm");
$data[] = array("71006","AX_NaturUmweltOderBodenschutzrecht","71006","AX_ConservationEnvironmentalOrSoilProtectionLaw","dlm");
$data[] = array("71007","AX_SchutzgebietNachNaturUmweltOderBodenschutzrecht","71007","AX_ProtectedAreaAccordingToConservationEnvironmentalOrSoilProtectionLaw","dlm");
$data[] = array("71007","AX_SchutzgebietNachNaturUmweltOderBodenschutzrecht","71007","AX_SchutzgebietNachNaturUmweltOderBodenschutzrecht","dlm");
$data[] = array("71009","AX_Denkmalschutzrecht","71009","AX_MonumentProtectionLaw","dlm");
$data[] = array("71011","AX_SonstigesRecht","71011","AX_OtherLaw","dlm");
$data[] = array("71011","AX_SonstigesRecht","71011","AX_SonstigesRecht","dlm");
$data[] = array("71012","AX_Schutzzone","71012","AX_Schutzzone","dlm");
$data[] = array("71012","AX_Schutzzone","71012","AX_ProtectionArea","dlm");
$data[] = array("73000","Kataloge","73000","Kataloge","dlm");
$data[] = array("73001","AX_Nationalstaat","73001","AX_Nationalstaat","dlm");
$data[] = array("73002","AX_Bundesland","73002","AX_FederalState","dlm");
$data[] = array("73002","AX_Bundesland","73002","AX_Bundesland","dlm");
$data[] = array("73003","AX_Regierungsbezirk","73003","AX_AdministrativeDistrict","dlm");
$data[] = array("73003","AX_Regierungsbezirk","73003","AX_Regierungsbezirk","dlm");
$data[] = array("73004","AX_KreisRegion","73004","AX_DistrictRegion","dlm");
$data[] = array("73004","AX_KreisRegion","73004","AX_KreisRegion","dlm");
$data[] = array("73005","AX_Gemeinde","73005","AX_Gemeinde","dlm");
$data[] = array("73005","AX_Gemeinde","73005","AX_Municipality","dlm");
$data[] = array("73006","AX_Gemeindeteil","73006","AX_Gemeindeteil","dlm");
$data[] = array("73009","AX_Verwaltungsgemeinschaft","73009","AX_Verwaltungsgemeinschaft","dlm");
$data[] = array("73013","AX_LagebezeichnungKatalogeintrag","73013","AX_PlaceNameCatalogEntry","dlm");
$data[] = array("73014","AX_Gemeindekennzeichen","73014","AX_Gemeindekennzeichen","dlm");
$data[] = array("73015","AX_Katalogeintrag","73015","AX_Katalogeintrag","dlm");
$data[] = array("73018","AX_Bundesland_Schluessel","73018","AX_Bundesland_Schluessel","dlm");
$data[] = array("73021","AX_Regierungsbezirk_Schluessel","73021","AX_Regierungsbezirk_Schluessel","dlm");
$data[] = array("73022","AX_Kreis_Schluessel","73022","AX_Kreis_Schluessel","dlm");
$data[] = array("73023","AX_VerschluesselteLagebezeichnung","73023","AX_VerschluesselteLagebezeichnung","dlm");
$data[] = array("73024","AX_Verwaltungsgemeinschaft_Schluessel","73024","AX_Verwaltungsgemeinschaft_Schluessel","dlm");
$data[] = array("73025","AX_Verwaltungsgemeinschaft_ATKIS","73025","AX_Verwaltungsgemeinschaft_ATKIS","dlm");
$data[] = array("74000","Geographische Gebietseinheiten","74000","Geographische Gebietseinheiten","dlm");
$data[] = array("74001","AX_Landschaft","74001","AX_Landschaft","dlm");
$data[] = array("74001","AX_Landschaft","74001","AX_Landscape","dlm");
$data[] = array("74002","AX_KleinraeumigerLandschaftsteil","74002","AX_SmallScaleLandscapePart","dlm");
$data[] = array("74003","AX_Gewann","74003","AX_StripField","dlm");
$data[] = array("74004","AX_Insel","74004","AX_Island","dlm");
$data[] = array("74004","AX_Insel","74004","AX_Insel","dlm");
$data[] = array("74005","AX_Wohnplatz","74005","AX_Domicile","dlm");
$data[] = array("75000","Administrative Gebietseinheiten","75000","Administrative areal units","dlm");
$data[] = array("75003","AX_KommunalesGebiet","75003","AX_MunicipalArea","dlm");
$data[] = array("75003","AX_KommunalesGebiet","75003","AX_KommunalesGebiet","dlm");
$data[] = array("75004","AX_Gebiet_Nationalstaat","75004","AX_Gebiet_Nationalstaat","dlm");
$data[] = array("75004","AX_Gebiet_Nationalstaat","75004","AX_Region_State","dlm");
$data[] = array("75005","AX_Gebiet_Bundesland","75005","AX_Gebiet_Bundesland","dlm");
$data[] = array("75005","AX_Gebiet_Bundesland","75005","AX_Region_FederalState","dlm");
$data[] = array("75006","AX_Gebiet_Regierungsbezirk","75006","AX_Region_AdministrativeDistrict","dlm");
$data[] = array("75006","AX_Gebiet_Regierungsbezirk","75006","AX_Gebiet_Regierungsbezirk","dlm");
$data[] = array("75007","AX_Gebiet_Kreis","75007","AX_Region_District","dlm");
$data[] = array("75007","AX_Gebiet_Kreis","75007","AX_Gebiet_Kreis","dlm");
$data[] = array("75008","AX_Kondominium","75008","AX_Condominium","dlm");
$data[] = array("75008","AX_Kondominium","75008","AX_Kondominium","dlm");
$data[] = array("75009","AX_Gebietsgrenze","75009","AX_Gebietsgrenze","dlm");
$data[] = array("75009","AX_Gebietsgrenze","75009","AX_RegionalBoundary","dlm");
$data[] = array("75010","AX_Gebiet","75010","AX_Gebiet","dlm");
$data[] = array("75011","AX_Gebiet_Verwaltungsgemeinschaft","75011","AX_Gebiet_Verwaltungsgemeinschaft","dlm");
$data[] = array("75011","AX_Gebiet_Verwaltungsgemeinschaft","75011","AX_Flugverkehrsanlage","dlm");
$data[] = array("81000","Nutzerprofile","81000","Nutzerprofile","dlm");
$data[] = array("81001","AX_Benutzer","81001","AX_Benutzer","dlm");
$data[] = array("81002","AX_Benutzergruppe","81002","AX_Benutzergruppe","dlm");
$data[] = array("81003","AX_BenutzergruppeMitZugriffskontrolle","81003","AX_BenutzergruppeMitZugriffskontrolle","dlm");
$data[] = array("81004","AX_BenutzergruppeNBA","81004","AX_BenutzergruppeNBA","dlm");
$data[] = array("81005","AX_BereichZeitlich","81005","AX_BereichZeitlich","dlm");
$data[] = array("81006","AX_Empfaenger","81006","AX_Empfaenger","dlm");
$data[] = array("81007","AX_FOLGEVA","81007","AX_FOLGEVA","dlm");
$data[] = array("997","Platzhalter für Verkehrstrassen (Bahn/Straße)","997","Platzhalter für Verkehrstrassen (Bahn/Straße)","dlm");
$data[] = array("998","bildabhängig, vorläufige Zuweisung nicht möglich","998","screen-depending, preliminary assignment not possible","dlm");
$data[] = array("99999","UeberfuehrungsUnterfuehrungsreferenz","99999","OverpassUnderpass reference","dlm");


$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_content');
	$object->setCode($this->getRowValue($row,0))
	->setName($this->getRowValue($row,1))
	->setShortname($this->getRowValue($row,1))
	->setDescription($this->getRowValue($row,1))
	->setPos($n)
	->save();
	$object->setStoreId($storeId_EN)
	->setName($this->getRowValue($row,3))
	->setShortname($this->getRowValue($row,3))
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
//$data[] = array("AUFL_ID","NAME","EINHEIT");
$data[] = array("2","1","ohne Einheit(Vektordaten)");
$data[] = array("4","160","Pixel/cm");
$data[] = array("5","200","Pixel/cm");
$data[] = array("7","320","Pixel/cm");
$data[] = array("9","1000 x 1000","(in m)");
$data[] = array("10","200 x 200 ","(in m)");
$data[] = array("11","100 x 100 ","(in km)");
$data[] = array("12","50 x 50 ","(in m)");
$data[] = array("13","25 x 25 ","(in m)");
$data[] = array("14","20 x 20","(in m)");
$data[] = array("15","20 x 20 / 40 x 40","(in m)");
$data[] = array("17","10 x 10 ","(in m)");
$data[] = array("18","60 x 60 ","(in m)");
$data[] = array("20","5 x 5 ","(in m)oder(in km)");
$data[] = array("21","1 x 1","(in km)");
$data[] = array("22","0,5 x 0,5 ","(in km)");
$data[] = array("23","0,25 x 0,25 ","(in km)");
$data[] = array("24","0,1 x 0,1","(in km)");
$data[] = array("DTK","Einheit: Pixel/cm","");
$data[] = array("DGM","Einheit: in m","");
$data[] = array("Geogitter","Einheit: in km","");
$data[] = array("DOP","Einheit: in km","");
$data[] = array("Andere Produkte"," Vektordaten ohne Angaben","");

$n = 0;
foreach($data as $row)
{
	$n += 100;
	$object = Mage::getModel('virtualgeo/components_resolution');
	$name = trim($this->getRowValue($row,1)." ".$this->getRowValue($row,2));
	$object
	->setCode($this->getRowValue($row,0))
	->setName($name)
	->setShortname($name)
	->setDescription($name)
	->setPos($n)
	->save();

}
