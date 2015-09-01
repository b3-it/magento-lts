<?php

class Stala_Abo_Model_Mysql4_Deliver_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract//Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stalaabo/deliver');
    }
    
     protected function _initSelect()
     {
     	parent::_initSelect();
     	$this->getSelect()
     		->where('contract_qty > shipping_qty')
     		->join(array('contract'=>$this->getTable('stalaabo/contract')),'main_table.abo_contract_id=contract.abo_contract_id');
     	return $this;
     }

    public function orderByShippmentAddress()
    {
    	$this->getSelect()->order('shipping_address_id');
    }
     
   	public function orderByBillingAddress()
    {
    	$this->getSelect()->order('billing_address_id');
    }
     
    
    
    
    
    //setzt die Liefermengen in der Lagerverwaltung, 
    //der erweiterten Lagerverwaltung und in stalaabo/delivered
    public function shippContractProducts($contractIds)
    {
    	
     	
    	//wenn config_manage_stock ON
    	if(Mage::getStoreConfigFlag(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_MANAGE_STOCK))
    	{
    		$manageStock = '(manage_stock=1 AND use_config_manage_stock=0) OR (use_config_manage_stock=1)';
    	}
    	else 
    	{
    		$manageStock = '(manage_stock=1 AND use_config_manage_stock=0)';
    	}
    	
    	$products = new Zend_Db_Expr('SELECT product_id, sum(contract_qty) as contract_qty FROM stala_abo_delivered 
    							where abo_deliver_id in ('.$contractIds.') group by product_id;');
    	
    	$products = trim($products->__toString(),';');
    	
    	$contractproducts = new Zend_Db_Expr('UPDATE stala_abo_delivered SET shipping_qty=contract_qty, shipping_date = now() WHERE abo_deliver_id in ('.$contractIds.')');
     	
    	$cataloginventoy = new Zend_Db_Expr('UPDATE cataloginventory_stock_item 
    									JOIN (' . $products . ') AS product ON product.product_id=cataloginventory_stock_item.product_id 								
    									SET qty = Case When '.$manageStock.'  Then qty - contract_qty else qty end,
										is_in_stock = Case When '.$manageStock.'  Then if(qty > contract_qty,1,0) else qty end ');
    	
    	//inserts für alle nicht vorhandenen Produkte in extstock -> damit ein UPDATE funktioniert
    	$extstockInsert = new Zend_Db_Expr('INSERT INTO extstock (product_id,quantity,quantity_ordered,price,distributor,is_abo) 
    					SELECT DISTINCT product_id, 0,0,0,\'Abo-Lieferung\',1 from stala_abo_delivered where product_id not in (select product_id from extstock where is_abo=1)');
	
 		
    	$extstockUpdate = new Zend_Db_Expr('UPDATE extstock 
    			JOIN  cataloginventory_stock_item as item ON item.product_id=extstock.product_id AND ('.$manageStock.')
    			JOIN (' . $products . ') AS product ON product.product_id=extstock.product_id
    			SET quantity = quantity-contract_qty WHERE is_abo=1');
    	
    	
    	//$sql = $cataloginventoy->__toString();
    	
    	$conn = $this->getConnection();
    	
    	try 
    	{
    	
    		
	    	$conn->beginTransaction();
	    	$conn->query($contractproducts);
	    	$conn->query($cataloginventoy);
	    	$conn->query($extstockInsert);
	    	$conn->query($extstockUpdate);
	    	$conn->commit();
	    	
	    	
	    	
    	}
    	catch (Exception $ex)
    	{
    		Mage::logException($ex);
    		$conn->rollBack();
    	}
    	
    	
    }
    
    
    
    
    
     /*
      * 
    // ursprüngliche Veriant um alle Produkte auf einmal zu sammeln
    protected function x_initSelect()
    {
    	//die StammArtikel
    	$base_product_att = $this->getEntity()->getAttribute('is_abo_base_product');   	
    	$base_product = new Zend_Db_Expr("SELECT entity_id AS `base_product_id` 
    			FROM `".$base_product_att->getBackendTable()."` AS `base_product` 
    			WHERE ((base_product.attribute_id=".$base_product_att->getAttributeId().") AND (base_product.value = '1'))");
    	 ;
    	
    	//die abgeleiteten Artikel
    	$product_att = $this->getEntity()->getAttribute('abo_parent_product');   	
    	$product = new Zend_Db_Expr("SELECT entity_id AS `product_id` 
    			FROM `".$product_att->getBackendTable()."` AS `base_product` 
    			WHERE ((base_product.attribute_id=".$product_att->getAttributeId().") AND (base_product.value IN (".$base_product.")))");
    	 ;
    	
    	 
    	 
//die($product->__toString());    	
    	parent::_initSelect();
    	$this//->addAttributeToSelect('abo_parent_product')
    		 ->addAttributeToSelect('name')	
    		 ->addAttributeToFilter('status','1')
    		 ;
    		 
    	$this->getSelect()
    		->join(array('base2'=>$product_att->getBackendTable()),'base2.attribute_id='.$product_att->getAttributeId()." AND base2.entity_id=e.entity_id", array('parent_id' => 'base2.value'))
    		->join(array('contract'=>'stala_abo_contract'),'contract.base_product_id=base2.value',
    						array(
    						'abo_id'=>'abo_contract_id',
    						'abo_qty'=>'qty',
    						))
    		->where('e.entity_id IN('.$product.')');
    	
    	
   //die($this->getSelect()->__toString());
    	return $this;
    }
    */
    
    
 
    
    
}