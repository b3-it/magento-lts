<?php

class Stala_Abo_Model_Delivered extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stalaabo/delivered');
    }
    
    //setzt die Liefermengen in der Lagerverwaltung, 
    //ZURUECK (das Lager wurde bei der Lieferung manipuliertund muss vor der Bestellung zur�ckgesetzt werden)
   public function revertStockItem()
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
    	   	
  		$product_id = intval($this->getProductId());
  		$qty = intval($this->getShippingQty());
     	
    	$cataloginventoy = new Zend_Db_Expr('UPDATE cataloginventory_stock_item 								
    									SET qty = Case When '.$manageStock.'  Then qty + '.$qty.' else qty end,
										is_in_stock = Case When '.$manageStock.'  Then if(qty + '.$qty.' > 0,1,0) else qty end WHERE product_id='.$product_id);
    	

	
 		
    	$extstockUpdate = new Zend_Db_Expr('UPDATE extstock 
    			JOIN  cataloginventory_stock_item as item ON item.product_id=extstock.product_id AND ('.$manageStock.')
    			SET quantity = quantity+'.$qty.' WHERE is_abo=1 AND extstock.product_id='.$product_id);
    	
    	
    	//$sql = $cataloginventoy->__toString();
    	
    	//echo('<pre>'); var_dump($sql); die();
    	/*
		$tmp = $this->getFreecopies();
		$this->setFreecopies('');
		

		if(strlen($tmp) > 0)
		{
			$freecopies = unserialize($tmp);
			if((is_array($freecopies)) && count($freecopies)> 0 )
			{
				$freecopy = Mage::getModel('extcustomer/freecopies');
				$freecopy->increaseFreecopies($freecopies, null, $this->getProductId(), $this->getCustomerId());
			}
		}
    	*/
		
		
		$salesdiscount = Mage::getModel("extcustomer/salesdiscount");
		$salesdiscount->updateCustomerDiscountQuota($this->getAboQuoteItemId());
		
		$quoteItem = Mage::getModel('sales/quote_item')->load($this->getAboQuoteItemId());
    	$tmp = $quoteItem->getStalaFreecopies();

		if(strlen($tmp) > 0)
		{
			$freecopies = unserialize($tmp);
			if((is_array($freecopies)) && count($freecopies)> 0 )
			{
				$freecopy = Mage::getModel('extcustomer/freecopies');
				$freecopy->increaseFreecopies($freecopies, null, $this->getProductId(), $this->getCustomerId());
			}
		}
    	$conn = $this->getResource()->getReadConnection();
    	
    	try 
    	{
    	
	    	$conn->beginTransaction();
	    
	    	$conn->query($cataloginventoy);
	    	
	    	$conn->query($extstockUpdate);
	    	$conn->commit();
    	}
    	catch (Exception $ex)
    	{
    		Mage::logException($ex);
    		$conn->rollBack();
    	}
    }
    
    //falls die Order fehlschlägt muss wieder alles auf Anfang
    public function revertStockItem_Rollback()
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
    		
    	$product_id = intval($this->getProductId());
    	$qty = intval($this->getShippingQty());
    
    	$cataloginventoy = new Zend_Db_Expr('UPDATE cataloginventory_stock_item
    									SET qty = Case When '.$manageStock.'  Then qty - '.$qty.' else qty end,
										is_in_stock = Case When '.$manageStock.'  Then if(qty - '.$qty.' > 0,1,0) else qty end WHERE product_id='.$product_id);
    	 
    
    
    		
    	$extstockUpdate = new Zend_Db_Expr('UPDATE extstock
    			JOIN  cataloginventory_stock_item as item ON item.product_id=extstock.product_id AND ('.$manageStock.')
    			SET quantity = quantity-'.$qty.' WHERE is_abo=1 AND extstock.product_id='.$product_id);
    	 
    	
    	$conn = $this->getResource()->getReadConnection();
    	 
    	try
    	{
    		 
    		$conn->beginTransaction();
    	  
    		$conn->query($cataloginventoy);
    
    		$conn->query($extstockUpdate);
    		$conn->commit();
    	}
    	catch (Exception $ex)
    	{
    		Mage::logException($ex);
    		$conn->rollBack();
    	}
    }
    
    public function addDownloadInfo()
    {
    	$this->_getResource()->addDownloadInfo();
    	    	
    	return $this;
    }
    
	public function addContractInfo()
    {
    	$this->_getResource()->addContractInfo();
    	    	
    	return $this;
    }
    
	public function stornoShipping() 
	{
		/*
		 * 
		$product = Mage::getModel('catalog/product')->load($this->getProductId());
		$stock = $product->getStockItem();
		{
			$extstockUpdate = new Zend_Db_Expr('UPDATE extstock SET quantity = quantity + '.$this->getShippingQty().' WHERE is_abo=1 AND product_id='.$this->getProductId());
		  	$stock->addQty($this->getShippingQty());
		  	$stock->save();
		  	$write = $this->getResource()->getReadConnection();
		  	$write->query($extstockUpdate);
		}
		*/
		$this->revertStockItem();
		$this->setShippingQty(0)->save();
	}

}