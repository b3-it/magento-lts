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
class Dwd_Icd_Model_Mysql4_Account extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the icd_account_id refers to the key field in your database table.
        $this->_init('dwd_icd/icd_account', 'id');
    }
    
 	public function saveField($object, $field)
    {
    	if ($object->getId() && !empty($field)) 
    	{
    		$table = $this->getMainTable();
    		$data = array($field => $object->getData($field));
    		$this->_getWriteAdapter()->update($table, $data, 'id ='. (int) $object->getId());
    		
    	}
    
    	return $this;
    }
}