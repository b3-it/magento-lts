<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Bkg_VirtualAccess_Model_Purchased__Renewalstatus
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Purchased__Renewalstatus extends Varien_Object
{
    const STATUS_PAUSE		= 1;
    const STATUS_REORDERD	= 2;
    const STATUS_EMAIL_SEND	= 3;
    const STATUS_ORDER_PENDING	= 4;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_PAUSE    		=> Mage::helper('virtualaccess')->__('Pause'),
            self::STATUS_REORDERD   	=> Mage::helper('virtualaccess')->__('Reorderd'),
        	//self::STATUS_EMAIL_SEND 	=> Mage::helper('virtualaccess')->__('Email sent'),
        	self::STATUS_ORDER_PENDING=> Mage::helper('virtualaccess')->__('in Bestellung')
        );
    }
}