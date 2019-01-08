<?php
/**
 * 
 *  @category Egovs
 *  @package  Bkg_License_Model_Copy_Status
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy_Status extends Varien_Object
{
    const STATUS_INACTIVE	= 0;
    const STATUS_ACTIVE	= 1;
    const STATUS_ABO	= 2;
    const STATUS_AUTOMATIC	= 3;
    const STATUS_CANCELATION	= 4;


    static public function getOptionArray()
    {
        return array(
            self::STATUS_INACTIVE	    => Mage::helper('bkg_license')->__('Inactive'),
            self::STATUS_ACTIVE		    => Mage::helper('bkg_license')->__('Active'),
            self::STATUS_ABO		    => Mage::helper('bkg_license')->__('Abo'),
            self::STATUS_AUTOMATIC	    => Mage::helper('bkg_license')->__('Automatic'),
            self::STATUS_CANCELATION    => Mage::helper('bkg_license')->__('Cancelation'),
        );
    }
}