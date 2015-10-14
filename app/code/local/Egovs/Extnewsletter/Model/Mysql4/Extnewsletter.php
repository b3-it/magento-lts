<?php

class Egovs_Extnewsletter_Model_Mysql4_Extnewsletter extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extnewsletter_id refers to the key field in your database table.
        $this->_init('extnewsletter/extnewsletter_subscriber', 'extnewsletter_id');
    }
    
   public function loadByIdAndProduct($subsciberId,$productId)
    {
    	$read = $this->_getReadAdapter(); 
        $select = clone $read->select()
            ->from($this->_mainTable)
            ->where('subscriber_id=?',$subsciberId)
            ->where('product_id=?',$productId);

        $result = $read->fetchRow($select);

        if(!$result) {
            return array();
        }

        return $result;
    }
    
    public function resetProductsBySubscriberId($subsciberId)
    {
    	$sql = "UPDATE ".$this->getTable("extnewsletter_subscriber");
    	$sql .= " SET is_active=0 WHERE subscriber_id=".$subsciberId;
		$this->_getWriteAdapter()->query($sql);
		
    }
    
    public function deleteNotExistingProductKeys()
    {
    	$sql =  "DELETE FROM ".$this->getTable("extnewsletter_subscriber")." WHERE product_id <> 0 ";
    	$sql .= " AND product_id not in ";
    	$sql .= "(select entity_id from catalog_product_entity)";
		$this->_getWriteAdapter()->query($sql);
    }

}