<?php

class Stala_Abo_Model_Shipping extends Stala_Abo_Model_Abstract
{
 
	protected $_deliverIds = array();
	
	
	
	
	public function setDeliverIds($deliverIds)
	{
		$this->_deliverIds = $deliverIds;
		return $this;
	}
	
	
	
	
	public function finishShipping()
	{
		$deliverIds = implode(',',$this->_deliverIds);
        $collection = Mage::getModel('stalaabo/delivered')->getCollection();
        $collection->getSelect()
            ->join(array('contract'=>$collection->getTable('stalaabo/contract')),'contract.abo_contract_id=main_table.abo_contract_id')
            ->where('abo_deliver_id IN('. $deliverIds .')  AND shipping_qty < contract_qty')
            ->order('shipping_address_id');

  //die($collection->getSelect()->__toString());                
            
        $abo_quote = null;
        $abo_quotes = array();
        $newOrder = true;
        $proccessedItems = array();  
        $shipId = -1;
		
        //LagermengenTesten
        $this->checkStockInventory($collection->getItems());
        
        //alle Produkte in quotes sortieren
        foreach($collection->getItems() as $item)
        {
        	    	
            //falls sich die Adresse ge�ndert hat neue Lieferung
            if($shipId != $item->getShippingAddressId())
            {
            	//neue Quote erzeugen
            	$abo_quote = $this->getQuote($item);
            	$abo_quote->setIsActive('0');
				$abo_quotes[] = $abo_quote;
            	
            }
            $shipId = $item->getShippingAddressId();
            $quoteItem = $this->addItem($abo_quote,$item);
            $item->setAboQuoteItem($quoteItem);
           	$proccessedItems[] = $item;
        }
       
        //Lager Tabelle vorbereiten
        $collection->prepareExtstockTable($deliverIds);
        
        //Rabatte f�r alle berechnen
        foreach($abo_quotes as $quote)
        {
        	$this->setRuleData($quote);
        	$quote->collectTotals();
        	$quote->save();
        }
       
        //quoteItemId merken
        foreach ($proccessedItems as $item) {
        	$quoteItem = $item->getAboQuoteItem();
        	$item->setAboQuoteItemId($quoteItem->getId());
        	//$item = $this->processFreeCopies($item);
        	$item = $this->processStockInventory($item,$collection);
        	$item->setShippingQty($item->getQty());
        	$item->setShippingDate(date("Y-m-d H:i:s", time()));
        	$item->save();
        	
        }
         
        return $this;
	}
	
	//freecopies 'reservieren'
   	private function processFreeCopies($item)
    {
		
    	$freecopy = Mage::getModel('extcustomer/freecopies');
    	
    	$res = $freecopy->decreaseFreecopies($item->getContractQty(),$item->getProductId(),$item->getCustomerId());
    	
    	if(($res != null) && (count($res) > 0))
    	{
    		$item->setFreecopies(serialize($res));
    		
    	}
    	return $item;	
    }
	
    //LagermengenReservieren
    private function processStockInventory($item,$collection)
    {
    	$product = Mage::getModel('catalog/product')->load($item->getProductId());
	  	$stock = $product->getStockItem();
	  	if($stock->getManageStock())
	  	{
		  	$stock->subtractQty($item->getQty());
		  	$stock->save();
		  	
		  	$collection->updateExtstockTable($item->getProductId(),$item->getQty());
	  	}
	  	return $item;
    }
    
    
	private function checkStockInventory($products)
	{
		$stockTotalQty = array();
		foreach ($products as $contractitem) 
		{
			
		  	$product = Mage::getModel('catalog/product')->load($contractitem->getProductId());
	  		$stock = $product->getStockItem();
	  		
	  		
	  		if(isset($stockTotalQty[$product->getId()]))
	  		{
	  			$stockTotalQty[$product->getId()] += $contractitem->getQty();
	  		}
	  		else 
	  		{
	  			$stockTotalQty[$product->getId()] = $contractitem->getQty();
	  		}
	  		
	  		if(($stock->getManageStock()) && ($stock->getQty() - $stockTotalQty[$product->getId()] < 0))
	  		{
	  			$txt = Mage::helper('stalaabo')->__('Action canceled! Product is out of stock!');
	  			Mage::throwException($txt.'(ID: '.$product->getId().')');
	  		}
		}
	}
	
	
	
}