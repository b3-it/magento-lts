<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Status
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_OrderStatus extends Varien_Object
{
    const ORDERSTATUS_NEW			= 1;
    const ORDERSTATUS_NEWSTATION	= 2;
    const ORDERSTATUS_ACTIVE		= 3;
    const ORDERSTATUS_DELETE		= 4;
    const ORDERSTATUS_DISABLED		= 5;
    

    static public function getOptionArray()
    {
        return array(
            self::ORDERSTATUS_NEW    => Mage::helper('dwd_icd')->__('New'),
        	self::ORDERSTATUS_NEWSTATION    => Mage::helper('dwd_icd')->__('New Station'),
        	self::ORDERSTATUS_ACTIVE    => Mage::helper('dwd_icd')->__('Active'),
            self::ORDERSTATUS_DELETE   => Mage::helper('dwd_icd')->__('Deleted'),
        	self::ORDERSTATUS_DISABLED   => Mage::helper('dwd_icd')->__('Disabled')
        );
    }
}