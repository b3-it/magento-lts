<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Status
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_Status extends Varien_Object
{
    const STATUS_ACTIVE	= 1;
    const STATUS_DELETE		= 2;
    const STATUS_CANCELED	= 3;
    const STATUS_EXPIRED	= 4;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ACTIVE    => Mage::helper('dwd_abo')->__('Active'),
            self::STATUS_DELETE   => Mage::helper('dwd_abo')->__('Deleted'),
        	self::STATUS_CANCELED   => Mage::helper('dwd_abo')->__('Resigned'),
        	self::STATUS_EXPIRED   => Mage::helper('dwd_abo')->__('Expired')
        );
    }
}