<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Bkg_VirtualAccess_Model_Service_Syncstatus
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Syncstatus extends Varien_Object
{
    const SYNCSTATUS_PENDING			= 1;
    const SYNCSTATUS_SUCCESS			= 2;
    const SYNCSTATUS_ERROR				= 3;
    const SYNCSTATUS_PERMANENTERROR		= 4;

    static public function getOptionArray()
    {
        return array(
            self::SYNCSTATUS_PENDING    => Mage::helper('virtualaccess')->__('Pending'),
            self::SYNCSTATUS_SUCCESS   => Mage::helper('virtualaccess')->__('Success'),
        	self::SYNCSTATUS_ERROR   => Mage::helper('virtualaccess')->__('Error'),
        	self::SYNCSTATUS_PERMANENTERROR   => Mage::helper('virtualaccess')->__('Permanent Error')
        );
    }
    
    static public function getLabel($var)
    {
    	$options = self::getOptionArray();
    	if(isset($options[$var])){
    		return $options[$var];
    	}
    	 
    	return "";
    }
}