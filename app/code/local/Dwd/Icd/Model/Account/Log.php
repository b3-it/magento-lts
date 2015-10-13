<?php
/**
 * Dwd Icd
 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Account
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Account_Log extends Mage_Core_Model_Abstract
{
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/account_log');
    }
    
    
  
   public function removeOldLines()
   {
   		$lifetime = intval(Mage::getStoreConfig('dwd_icd/debug/lifetime'));
   		if($lifetime)
   		{		
   			$date = new Zend_Date();
   			 
   			$date->add($lifetime *-1, Zend_Date::DAY);
   			
   			$this->getResource()->removeOldLines(date("Y-m-d H:i:s", $date->getTimestamp()));
   		}
   		/*
   		$dateObj = Mage::app()->getLocale()->date(time() - $lifetime);
   		//convert store date to default date in UTC timezone without DST
   		$dateObj->setTimezone(Mage_Core_Model_Locale::DEFAULT_TIMEZONE);
   		$bis = date("Y-m-d H:i:s", $dateObj->getTimestamp());
   		*/
   		
   		
   		
   }
    
    
}