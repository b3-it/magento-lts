<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Access_Type
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Access_Type extends Varien_Object
{
    const ACCESS	= 1;
    const CUSTOMER	= 2;
    const ORDER	= 3;

    static public function getOptionArray()
    {
        return array(
            self::ACCESS    => Mage::helper('ibewi')->__('Access'),
            self::CUSTOMER   => Mage::helper('ibewi')->__('Customer'),
            self::ORDER   => Mage::helper('ibewi')->__('Order'),
        );
    }
}