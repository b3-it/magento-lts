<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Model_Access_Type
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Model_Access_Type extends Varien_Object
{
    const ACCESS	= 1;
    const CUSTOMER	= 2;
    const ORDER	= 3;

    static public function getOptionArray()
    {
        return array(
            self::ACCESS    => Mage::helper('dimdireport')->__('Access'),
            self::CUSTOMER   => Mage::helper('dimdireport')->__('Customer'),
            self::ORDER   => Mage::helper('dimdireport')->__('Order'),
        );
    }
}