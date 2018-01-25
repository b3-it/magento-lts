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
//"0 ADV_VERSION_DEU","1 ADV_VERSION_ENG","2 GUELTIG_AB","3 CODE","4 POSITION"
$data[] = array("nicht bekannt","nicht bekannt","","nicht_bekannt","1");
$data[] = array("2.0 (09.09.2009)","2.0 (09.09.2009)","","AdV-2.0","2");
$data[] = array("2.1 (23.09.2010)","2.1 (23.09.2010)","01.05.11","AdV-2.1","3");
$data[] = array("2.2 (20.09.2012)","2.2 (20.09.2012)","31.05.13","AdV-2.2","4");
$data[] = array("2.2.1 (2.10.2013)","2.2.1 (2.10.2013)","02.10.13","AdV-2.2.1","5");
$data[] = array("2.2.2 (01.01.2015)","2.2.2 (01.01.2015)","01.01.15","AdV-2.2.2","6");
$data[] = array("3.0 (01.04.2016)","3.0 (01.04.2016)","01.04.16","AdV-3.0","7");
$data[] = array("3.1 (01.01.2017)","3.1 (01.01.2017)","01.01.17","AdV-3.1","8");
$data[] = array("WebAtlasDE.light","WebAtlasDE.light","","Freie_Nutzung","9");
$data[] = array("WebAtlasDE","WebAtlasDE","","WebAtlasDE","10");
$data[] = array("OpenData","OpenData","","OpenData","11");
$data[] = array("Vertrag_Bund","Vertrag_Bund","","Vertrag_Bund","12");


$toll = array();

foreach($data as $row)
{
    /**
     * @var Bkg_Tollpolicy_Model_Toll $object
     */
	$object = Mage::getModel('bkg_tollpolicy/toll');
	$object->setCode($row[3])
	->setName($row[0])
        ->setDateFrom($row[2])
	->save();
    $toll[$row[3]] = $object->getId();
}

$data = array();
//"0 NUTZUNG_DEU"",1 NUTZUNG_ENG","2 FAKTOR","3 CODE","4 ADV_VERSION","5 POSITION"
$data[] = array("Einplatz-Lizenz","Einplatz-Lizenz","1","Einplatz-Lizenz","AdV-2.0","9");
$data[] = array("2 - 5 Arbeitsplätze","2 - 5 Arbeitsplätze","1,5","2-5_Arbeitsplaetze","AdV-2.0","10");
$data[] = array("6 - 20 Arbeitsplätze","6 - 20 Arbeitsplätze","2","6-20_Arbeitsplaetze","AdV-2.0","11");
$data[] = array("21 - 50 Arbeitsplätze","21 - 50 Arbeitsplätze","2,5","21-50_Arbeitsplaetze","AdV-2.0","12");
$data[] = array("51 - 100 Arbeitsplätze","51 - 100 Arbeitsplätze","3","51-100_Arbeitsplaetze","AdV-2.0","13");
$data[] = array("101 - 150 Arbeitsplätze","101 - 150 Arbeitsplätze","3,5","101-150_Arbeitsplaetze","AdV-2.0","14");
$data[] = array("151 - 200 Arbeitsplätze","151 - 200 Arbeitsplätze","4","151-200_Arbeitsplaetze","AdV-2.0","15");
$data[] = array("Firmenlizenz","Firmenlizenz","5","Firmenlizenz","AdV-2.0","16");
$data[] = array("Einplatz-Lizenz","Einplatz-Lizenz","1","Einplatz-Lizenz","AdV-2.1","17");
$data[] = array("2 - 5 Arbeitsplätze","2 - 5 Arbeitsplätze","1,5","2-5_Arbeitsplaetze","AdV-2.1","18");
$data[] = array("6 - 20 Arbeitsplätze","6 - 20 Arbeitsplätze","2","6-20_Arbeitsplaetze","AdV-2.1","19");
$data[] = array("21 - 50 Arbeitsplätze","21 - 50 Arbeitsplätze","2,5","21-50_Arbeitsplaetze","AdV-2.1","20");
$data[] = array("51 - 100 Arbeitsplätze","51 - 100 Arbeitsplätze","3","51-100_Arbeitsplaetze","AdV-2.1","21");
$data[] = array("101 - 150 Arbeitsplätze","101 - 150 Arbeitsplätze","3,5","101-150_Arbeitsplaetze","AdV-2.1","22");
$data[] = array("151 - 200 Arbeitsplätze","151 - 200 Arbeitsplätze","4","151-200_Arbeitsplaetze","AdV-2.1","23");
$data[] = array("Firmenlizenz","Firmenlizenz","5","Firmenlizenz","AdV-2.1","24");
$data[] = array("Einplatz-Lizenz","Einplatz-Lizenz","1","Einplatz-Lizenz","AdV-2.2","25");
$data[] = array("2 - 5 Arbeitsplätze","2 - 5 Arbeitsplätze","1,5","2-5_Arbeitsplaetze","AdV-2.2","26");
$data[] = array("6 - 20 Arbeitsplätze","6 - 20 Arbeitsplätze","2","6-20_Arbeitsplaetze","AdV-2.2","27");
$data[] = array("21 - 50 Arbeitsplätze","21 - 50 Arbeitsplätze","2,5","21-50_Arbeitsplaetze","AdV-2.2","28");
$data[] = array("51 - 100 Arbeitsplätze","51 - 100 Arbeitsplätze","3","51-100_Arbeitsplaetze","AdV-2.2","29");
$data[] = array("101 - 150 Arbeitsplätze","101 - 150 Arbeitsplätze","3,5","101-150_Arbeitsplaetze","AdV-2.2","30");
$data[] = array("151 - 200 Arbeitsplätze","151 - 200 Arbeitsplätze","4","151-200_Arbeitsplaetze","AdV-2.2","31");
$data[] = array("Firmenlizenz","Firmenlizenz","5","Firmenlizenz","AdV-2.2","32");
$data[] = array("Einplatz-Lizenz","Einplatz-Lizenz","1","Einplatz-Lizenz","AdV-2.2.1","33");
$data[] = array("2 - 5 Arbeitsplätze","2 - 5 Arbeitsplätze","1,5","2-5_Arbeitsplaetze","AdV-2.2.1","34");
$data[] = array("6 - 20 Arbeitsplätze","6 - 20 Arbeitsplätze","2","6-20_Arbeitsplaetze","AdV-2.2.1","35");
$data[] = array("21 - 50 Arbeitsplätze","21 - 50 Arbeitsplätze","2,5","21-50_Arbeitsplaetze","AdV-2.2.1","36");
$data[] = array("51 - 100 Arbeitsplätze","51 - 100 Arbeitsplätze","3","51-100_Arbeitsplaetze","AdV-2.2.1","37");
$data[] = array("101 - 150 Arbeitsplätze","101 - 150 Arbeitsplätze","3,5","101-150_Arbeitsplaetze","AdV-2.2.1","38");
$data[] = array("151 - 200 Arbeitsplätze","151 - 200 Arbeitsplätze","4","151-200_Arbeitsplaetze","AdV-2.2.1","39");
$data[] = array("Firmenlizenz","Firmenlizenz","5","Firmenlizenz","AdV-2.2.1","40");
$data[] = array("Konzernlizenz","Konzernlizenz","","Konzernlizenz","AdV-2.2.2","41");
$data[] = array("1 - 5 Arbeitsplätze","1 - 5 Arbeitsplätze","1","1-5_Arbeitsplaetze","AdV-2.2.2","42");
$data[] = array("6 - 20 Arbeitsplätze","6 - 20 Arbeitsplätze","1,5","6-20_Arbeitsplaetze","AdV-2.2.2","43");
$data[] = array("21 - 100 Arbeitsplätze","21 - 100 Arbeitsplätze","2","21-100_Arbeitsplaetze","AdV-2.2.2","44");
$data[] = array("ab 101. Arbeitsplatz","ab 101. Arbeitsplatz","2,5","ab_101_Arbeitsplaetze","AdV-2.2.2","45");
$data[] = array("1 Unternehmen","1 Unternehmen","1","1_Unternehmen","AdV-3.0","46");
$data[] = array("1 - 2 Unternehmen","1 - 2 Unternehmen","1,5","1-2_Unternehmen","AdV-3.0","47");
$data[] = array("mehr als 2 Unternehmen","mehr als 2 Unternehmen","2,5","ab_3_Unternehmen","AdV-3.0","48");
$data[] = array("1 Unternehmen","1 Unternehmen","1","1_Unternehmen","AdV-3.1","49");
$data[] = array("1 - 2 Unternehmen","1 - 2 Unternehmen","1,5","1-2_Unternehmen","AdV-3.1","50");
$data[] = array("mehr als 2 Unternehmen","mehr als 2 Unternehmen","2,5","ab_3_Unternehmen","AdV-3.1","51");
$data[] = array("Einplatz-Lizenz","Einplatz-Lizenz","1","Einplatz-Lizenz","nicht_bekannt","1");
$data[] = array("2 - 5 Arbeitsplätze","2 - 5 Arbeitsplätze","1,5","2-5_Arbeitsplaetze","nicht_bekannt","2");
$data[] = array("6 - 20 Arbeitsplätze","6 - 20 Arbeitsplätze","2","6-20_Arbeitsplaetze","nicht_bekannt","3");
$data[] = array("21 - 50 Arbeitsplätze","21 - 50 Arbeitsplätze","2,5","21-50_Arbeitsplaetze","nicht_bekannt","4");
$data[] = array("51 - 100 Arbeitsplätze","51 - 100 Arbeitsplätze","3","51-100_Arbeitsplaetze","nicht_bekannt","5");
$data[] = array("101 - 150 Arbeitsplätze","101 - 150 Arbeitsplätze","3,5","101-150_Arbeitsplaetze","nicht_bekannt","6");
$data[] = array("151 - 200 Arbeitsplätze","151 - 200 Arbeitsplätze","4","151-200_Arbeitsplaetze","nicht_bekannt","7");
$data[] = array("Firmenlizenz","Firmenlizenz","5","Firmenlizenz","nicht_bekannt","8");

$useType = array();

foreach($toll as $k=> $v)
{
    $object = Mage::getModel('bkg_tollpolicy/usetype');
    $object->setCode('int')
        ->setName('Interne Nutzung')
        ->setIsInternal('1')
        ->setActive('1')
        ->setTollId($v)
        ->save();

    $useType[$k.":int"] = $object->getId();
}

foreach($toll as $k=> $v)
{
    $object = Mage::getModel('bkg_tollpolicy/usetype');
    $object->setCode('ext')
        ->setName('Externe Nutzung')
        ->setIsExternal('1')
        ->setActive('1')
        ->setTollId($v)
        ->save();

    $useType[$k.":ext"] = $object->getId();
}



foreach($data as $row)
{
    if(isset($useType[$row[4].":int"]))
    {
        $usetype_id = $useType[$row[4].":int"];
        $object = Mage::getModel('bkg_tollpolicy/useoptions');
        $object->setCode($row[3])
            ->setName($row[0])
            ->setFactor($row[2])
            ->setUseTypeId($usetype_id)
            ->save();
    }
}



//"0 NUTZUNG_DEU","1 NUTZUNG_ENG","2 CODE","3 ADV_VERSION","4 POSITION");
$data[] = array("Keine","Keine","Keine","AdV-2.0","6");
$data[] = array("Folgeprodukt","Folgeprodukt","Folgeprodukt","AdV-2.0","7");
$data[] = array("Folgedienst","Folgedienst","Folgedienst","AdV-2.0","8");
$data[] = array("Wiederverkauf digital","Wiederverkauf digital","Wiederverkauf","AdV-2.0","9");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-2.0","10");
$data[] = array("Keine","Keine","Keine","AdV-2.1","11");
$data[] = array("Folgeprodukt","Folgeprodukt","Folgeprodukt","AdV-2.1","12");
$data[] = array("Folgedienst","Folgedienst","Folgedienst","AdV-2.1","13");
$data[] = array("Wiederverkauf digital","Wiederverkauf digital","Wiederverkauf","AdV-2.1","14");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-2.1","15");
$data[] = array("Keine","Keine","Keine","AdV-2.2","16");
$data[] = array("Folgeprodukt","Folgeprodukt","Folgeprodukt","AdV-2.2","17");
$data[] = array("Folgedienst","Folgedienst","Folgedienst","AdV-2.2","18");
$data[] = array("Wiederverkauf digital","Wiederverkauf digital","Wiederverkauf","AdV-2.2","19");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-2.2","20");
$data[] = array("Keine","Keine","Keine","AdV-2.2.1","21");
$data[] = array("Folgeprodukt","Folgeprodukt","Folgeprodukt","AdV-2.2.1","22");
$data[] = array("Folgedienst","Folgedienst","Folgedienst","AdV-2.2.1","23");
$data[] = array("Wiederverkauf digital","Wiederverkauf digital","Wiederverkauf","AdV-2.2.1","24");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-2.2.1","25");
$data[] = array("Keine","Keine","Keine","AdV-2.2.2","26");
$data[] = array("Folgeprodukt","Folgeprodukt","Folgeprodukt","AdV-2.2.2","27");
$data[] = array("Folgedienst","Folgedienst","Folgedienst","AdV-2.2.2","28");
$data[] = array("Wiederverkauf digital","Wiederverkauf digital","Wiederverkauf","AdV-2.2.2","29");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-2.2.2","30");
$data[] = array("Keine","Keine","Keine","AdV-3.0","31");
$data[] = array("Wiederverkauf","Wiederverkauf","Wiederverkauf","AdV-3.0","32");
$data[] = array("Folgeprodukte oder -dienste Selbst","Folgeprodukte oder -dienste Selbst","Folgeprodukte-Dienste-Selbst","AdV-3.0","33");
$data[] = array("Folgeprodukte oder -dienste ULZ","Folgeprodukte oder -dienste ULZ","Folgeprodukte-Dienste-ULZ","AdV-3.0","34");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-3.0","35");
$data[] = array("Keine","Keine","Keine","AdV-3.1","36");
$data[] = array("Wiederverkauf","Wiederverkauf","Wiederverkauf","AdV-3.1","37");
$data[] = array("Folgeprodukte oder -dienste Selbst","Folgeprodukte oder -dienste Selbst","Folgeprodukte-Dienste-Selbst","AdV-3.1","38");
$data[] = array("Folgeprodukte oder -dienste ULZ","Folgeprodukte oder -dienste ULZ","Folgeprodukte-Dienste-ULZ","AdV-3.1","39");
$data[] = array("Sonstige","Sonstige","Sonstige","AdV-3.1","40");
$data[] = array("Keine","Keine","Keine","nicht_bekannt","1");
$data[] = array("Folgeprodukt","Folgeprodukt","Folgeprodukt","nicht_bekannt","2");
$data[] = array("Folgedienst","Folgedienst","Folgedienst","nicht_bekannt","3");
$data[] = array("Wiederverkauf digital","Wiederverkauf digital","Wiederverkauf","nicht_bekannt","4");
$data[] = array("Sonstige","Sonstige","Sonstige","nicht_bekannt","5");



foreach($data as $row)
{
    if(isset($useType[$row[3].":ext"]))
    {
        $usetype_id = $useType[$row[3].":ext"];
        $object = Mage::getModel('bkg_tollpolicy/useoptions');
        $object->setCode($row[2])
            ->setName($row[0])
            ->setUseTypeId($usetype_id)
            ->save();
    }
}