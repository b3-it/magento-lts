<?php
/**
 * 
 *  Status der Übertragung der Bestellung zum Lieferanten
 *  @category Egovs
 *  @package  Sid_Export_Order_Model_Syncstatus
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Syncstatus extends Varien_Object
{
    const SYNCSTATUS_PENDING			= 1;
    const SYNCSTATUS_SUCCESS			= 2;
    const SYNCSTATUS_ERROR				= 3;
    const SYNCSTATUS_PERMANENTERROR		= 4;

    static public function getOptionArray()
    {
        return array(
            self::SYNCSTATUS_PENDING    => Mage::helper('exportorder')->__('Pending'),
            self::SYNCSTATUS_SUCCESS   => Mage::helper('exportorder')->__('Success'),
        	self::SYNCSTATUS_ERROR   => Mage::helper('exportorder')->__('Error'),
        	self::SYNCSTATUS_PERMANENTERROR   => Mage::helper('exportorder')->__('Permanent Error')
        );
    }
}