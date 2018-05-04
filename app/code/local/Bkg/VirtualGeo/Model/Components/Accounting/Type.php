<?php
/**
 * 
 *  @category Egovs
 *  @package  Bkg_VirtualGeo_Model_Components_Accounting_Type
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2018 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Accounting_Type extends Varien_Object
{
    const ACCOUNTING_FLATRATE		= 1;
    const ACCOUNTING_CONSUMTION		= 0;

    static public function getOptionArray()
    {
        return array(
            self::ACCOUNTING_FLATRATE    => Mage::helper('virtualgeo')->__('Flat-Rate'),
        	self::ACCOUNTING_CONSUMTION    => Mage::helper('virtualgeo')->__('Consumtion'),

        );
    }
}