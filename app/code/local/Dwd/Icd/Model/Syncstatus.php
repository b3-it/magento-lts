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
class Dwd_Icd_Model_Syncstatus extends Varien_Object
{
    const SYNCSTATUS_PENDING			= 1;
    const SYNCSTATUS_SUCCESS			= 2;
    const SYNCSTATUS_ERROR				= 3;
    const SYNCSTATUS_PERMANENTERROR		= 4;

    static public function getOptionArray()
    {
        return array(
            self::SYNCSTATUS_PENDING    => Mage::helper('dwd_icd')->__('Pending'),
            self::SYNCSTATUS_SUCCESS   => Mage::helper('dwd_icd')->__('Success'),
        	self::SYNCSTATUS_ERROR   => Mage::helper('dwd_icd')->__('Error'),
        	self::SYNCSTATUS_PERMANENTERROR   => Mage::helper('dwd_icd')->__('Permanent Error')
        );
    }
}