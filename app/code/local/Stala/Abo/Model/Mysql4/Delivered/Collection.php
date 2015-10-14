<?php

class Stala_Abo_Model_Mysql4_Delivered_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stalaabo/delivered');
    }
    
    public function prepareExtstockTable($contractIds)
    {
    	
     	
    	//inserts für alle nicht vorhandenen Produkte in extstock -> damit ein UPDATE funktioniert
    	$extstockInsert = new Zend_Db_Expr('INSERT INTO extstock (product_id,quantity,quantity_ordered,price,distributor,is_abo) 
    					SELECT DISTINCT product_id, 0,0,0,\'Abo-Lieferung\',1 from stala_abo_delivered where product_id not in (select product_id from extstock where is_abo=1)');

    	$conn = $this->getConnection();
		$conn->query($extstockInsert);	
    }
    
    public function updateExtstockTable($productId,$qty)
    {
    	
    	$extstockUpdate = new Zend_Db_Expr('UPDATE extstock SET quantity = quantity-'.$qty.' WHERE is_abo=1 AND product_id='.$productId); 	
  	 	
    	$conn = $this->getConnection();
    	$conn->query($extstockUpdate);
	   
    }
}