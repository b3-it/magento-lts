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
class Dwd_Icd_Model_Mysql4_Account_Groups extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the icd_account_id refers to the key field in your database table.
        $this->_init('dwd_icd/icd_groups', 'id');
    }
    
   
    
    public function loadByAccountId_Application($group, $acountid, $application)
    {
    	$adapter = $this->_getReadAdapter();
    	//$bind    = array('account_id' => $acountid,'group'=>$application);
    	$select  = $adapter->select()
    	->from($this->getTable('dwd_icd/icd_groups'))
    	->where('account_id ='. $acountid)
    	->where("application ='".$application."'");
    
    	//die($select->__toString());
    	$data = $adapter->fetchOne($select);
    	if ($data) {
    		$this->load($group, $data);
    	} else {
    		$group->setApplication($application);
    		$group->setAccountId($acountid);
    	}
    
    	return $this;
    }
    
}