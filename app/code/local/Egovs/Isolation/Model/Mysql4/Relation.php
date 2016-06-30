<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Mysql4_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Mysql4_Relation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the isolation_relation_id refers to the key field in your database table.
        $this->_init('isolation/store_user_relation', 'relation_id');
    }
    
    
    
   
    public function removeAllStoreRelations($user_id)
    {
    	$this->_getWriteAdapter()->delete($this->getTable('isolation/store_user_relation'),"user_id='" . $user_id ."'");
    	
    	return $this;
    }
    
    public function getCountOrderItems4Stores($store_group_ids, $order_id)
    {
    	$sql = "";
    	$adapter = $this->_getReadAdapter();
    	$select  = $adapter->select()
    		->from($this->getTable('sales/order_item'), array("count(*)"))
    		->where('order_id = '.$order_id)
    		->where('store_group IN ('.$store_group_ids.')')
    	;
    	//die($select->__toString());
    	$count = $adapter->fetchOne($select);
    	return $count;
    }
    
 
    
}