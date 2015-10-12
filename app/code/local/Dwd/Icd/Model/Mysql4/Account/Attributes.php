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
class Dwd_Icd_Model_Mysql4_Account_Attributes extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the icd_account_id refers to the key field in your database table.
        $this->_init('dwd_icd/icd_attributes', 'id');
    }
    
    public function loadByAccountId_Attribute($model, $acountid, $attribute)
    {
    	$adapter = $this->_getReadAdapter();
    	//$bind    = array('account_id' => $acountid,'group'=>$application);
    	$select  = $adapter->select()
    	->from($this->getTable('dwd_icd/icd_attributes'))
    	->where('account_id ='. $acountid)
    	->where("attribute ='".$attribute."'");
    
    	//die($select->__toString());
    	$data = $adapter->fetchOne($select);
    	if ($data) {
    		$this->load($model, $data);
    	} else {
    		$model->setAttribute($attribute);
    		$model->setAccountId($acountid);
    	}
    
    	return $this;
    }
}