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
class Dwd_Icd_Model_AccountStatus extends Varien_Object
{
    const ACCOUNTSTATUS_NEW			= 1;
    const ACCOUNTSTATUS_NEWPASSWORD	= 2;
    const ACCOUNTSTATUS_ACTIVE		= 3;
    const ACCOUNTSTATUS_DELETE		= 4;
    

    static public function getOptionArray()
    {
        return array(
            self::ACCOUNTSTATUS_NEW    => Mage::helper('dwd_icd')->__('New'),
        	self::ACCOUNTSTATUS_NEWPASSWORD    => Mage::helper('dwd_icd')->__('New Password'),
        	self::ACCOUNTSTATUS_ACTIVE    => Mage::helper('dwd_icd')->__('Active'),
            self::ACCOUNTSTATUS_DELETE   => Mage::helper('dwd_icd')->__('Deleted')
        );
    }
}