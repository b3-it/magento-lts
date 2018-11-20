<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Bkg_VirtualAccess_Model_Purchased_Status
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Purchased_Status extends Varien_Object
{
    const STATUS_ACTIVE	= 1;
    const STATUS_DELETE		= 2;
    const STATUS_CANCELED	= 3;
    const STATUS_EXPIRED	= 4;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ACTIVE    => Mage::helper('virtualaccess')->__('Active'),
            self::STATUS_DELETE   => Mage::helper('virtualaccess')->__('Deleted'),
        	self::STATUS_CANCELED   => Mage::helper('virtualaccess')->__('Resigned'),
        	self::STATUS_EXPIRED   => Mage::helper('virtualaccess')->__('Expired')
        );
    }
}