<?php

class TuChemnitz_Voucher_Model_Resource_Tan extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the voucher_id refers to the key field in your database table.
        $this->_init('tucvoucher/tan', 'tan_id');
    }
    
    /**
     * Nächste Freie Tan suchen und OrderItemId schreiben 
     * @param unknown $order_item_id
     */
    public function allocateNextFreeTan($order_item_id,$product_id)
    {
    	try {
    		$bind = "`status`=".TuChemnitz_Voucher_Model_Status::STATUS_SOLD . ",order_item_id=".$order_item_id;
    		$where = "`status` =".TuChemnitz_Voucher_Model_Status::STATUS_NEW . " AND product_id=".$product_id ." limit 1";
    		$sql = "UPDATE " .$this->getMainTable()." SET " . $bind . " WHERE " . $where;
    		$stmt = $this->_getWriteAdapter()->query($sql);
    	}
    	catch (Exception $ex)
    	{
    		Mage::logException($ex);
    	}
    	return $this;
    }
    
    /**
     * Löschen der Tans und Rückgabe Anzahl der gelöschten Tans 
     * @param unknown $TanIds
     * @return int $count
     */
    public function deleteTans($TanIds, $productId)
    {
    	try {
    		if(is_array($TanIds)){
    			$TanIds = implode(',', $TanIds);
    		}
    		$where = "`status` =".TuChemnitz_Voucher_Model_Status::STATUS_NEW . " AND product_id =".$productId." AND tan_id IN (". $TanIds .")";
    		$sql = "DELETE FROM " .$this->getMainTable(). " WHERE " . $where;
    		$stmt = $this->_getWriteAdapter()->query($sql);
    		return $stmt->rowCount();
    	}
    	catch (Exception $ex)
    	{
    		Mage::logException($ex);
    	}
    	return 0;
    }
    
    
    /**
     * Verkaufte Tans zaehlen
     * @param unknown $TanIds
     * @param unknown $productId
     * @return unknown|number
     */
    public function countSoldTans($TanIds, $productId)
    {
    	try {
    		if(is_array($TanIds)){
    			$TanIds = implode(',', $TanIds);
    		}
    		$where = "`status` =".TuChemnitz_Voucher_Model_Status::STATUS_SOLD . " AND product_id =".$productId." AND tan_id IN (". $TanIds .")";
    		$sql = "SELECT count(tan_id) FROM " .$this->getMainTable(). " WHERE " . $where;
    		$count = $this->_getWriteAdapter()->fetchOne($sql);
    		return $count;
    	}
    	catch (Exception $ex)
    	{
    		Mage::logException($ex);
    	}
    	return 0;
    }
    
    
    public function countPendingOrders4Product($productId)
    {
    	$state = "((`state` = 'pending' OR `state` = 'pending_payment'))";
    		$sql = "SELECT count(entity_id) FROM " .$this->getTable('sales/order_item');
    		$sql .= " Join " .$this->getTable('sales/order'). " as sorder on sorder.entity_id = ".$this->getTable('sales/order_item').".order_id and ". $state;
    		$sql .= " WHERE product_id=" . $productId;
    		
    		//die($sql);
    		
    		
    		$count = $this->_getWriteAdapter()->fetchOne($sql);
    		return $count;
    	
    }
    
}