<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Bkg_VirtualAccess_Model_Service_AccountStatus
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_AccountStatus extends Varien_Object
{
    const ACCOUNTSTATUS_NEW			= 1;
    //const ACCOUNTSTATUS_NEWPASSWORD	= 2;
    const ACCOUNTSTATUS_ACTIVE		= 3;
    const ACCOUNTSTATUS_STORNO		= 4;
    

    static public function getOptionArray()
    {
        return array(
            self::ACCOUNTSTATUS_NEW    => Mage::helper('virtualaccess')->__('New'),
        	//self::ACCOUNTSTATUS_NEWPASSWORD    => Mage::helper('virtualaccess')->__('New Password'),
        	self::ACCOUNTSTATUS_ACTIVE    => Mage::helper('virtualaccess')->__('Active'),
            self::ACCOUNTSTATUS_STORNO   => Mage::helper('virtualaccess')->__('Storno')
        );
    }
}