<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Mysql4_Account
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Mysql4_Account_Log extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the icd_account_id refers to the key field in your database table.
        $this->_init('dwd_icd/icd_debug', 'id');
    }
    
    public function removeOldLines($bis)
    {
    	
    	//die($bis);
    	$adapter = $this->_getWriteAdapter();
    	$adapter->delete($this->getTable('dwd_icd/icd_debug'),"created_time <'". $bis."'");
    	
    	
    }
}