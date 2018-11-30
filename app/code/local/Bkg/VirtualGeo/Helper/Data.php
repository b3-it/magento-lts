<?php
/**
 * 
 *  @category Egovs
 *  @package  Bkg_VirtualGeo
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Helper_Data extends Mage_Core_Helper_Abstract
{

	
	public function getProj4() {
	    /**
	     * @var Bkg_VirtualGeo_Model_Resource_Components_Georef_Collection $col
	     */
	    $col = Mage::getModel("virtualgeo/components_georef")->getCollection();

	    $lines = array();

	    foreach($col->getItems() as $georef) {
	        /**
	         * @var Bkg_VirtualGeo_Model_Resource_Components_Georef $georef
	         */
	        if (empty($georef->getProj4())) {
	            continue;
	        }
	        $code = $georef->getEpsgCode();
	        $lines[]="proj4.defs('EPSG:".$code."','".$georef->getProj4()."');";
	        
	        $lines[]="proj4.defs('urn:x-ogc:def:crs:EPSG:".$code."',proj4.defs('EPSG:".$code."'));";
	        $lines[]="proj4.defs('urn:ogc:def:crs:EPSG:".$code."',proj4.defs('EPSG:".$code."'));";
	        $lines[]="proj4.defs('urn:ogc:def:crs:EPSG:6.9:".$code."',proj4.defs('EPSG:".$code."'));";
	        // TODO this is broken!
	        $lines[]="proj4.defs('http://www.opengis.net/gml/srs/epsg.xml#".$code."',proj4.defs('EPSG:".$code."'));";
	    }

	    return join(PHP_EOL, $lines);
	}
}