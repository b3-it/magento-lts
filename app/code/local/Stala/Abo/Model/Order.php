<?php

class Stala_Abo_Model_Order extends Stala_Abo_Model_Abstract
{
 
	protected $_deliverIds = array();
	protected $_perShippingAddress = false;
	
	
	
	public function setDeliverIds($deliverIds)
	{
		$this->_deliverIds = $deliverIds;
		return $this;
	}
	
	//eine Rechnung pro Lieferanschrift
	public function setPerShippingAddress($value)
	{
		$this->_perShippingAddress = $value;
		return $this;
	}
	
	
	
	public function createOrdersInvoices()
	{
		$deliverIds = implode(',',$this->_deliverIds);
        $collection = Mage::getModel('stalaabo/delivered')->getCollection();
        $collection->getSelect()
            ->join(array('contract'=>$collection->getTable('stalaabo/contract')),'contract.abo_contract_id=main_table.abo_contract_id')
            ->where('abo_deliver_id IN('. $deliverIds .')  AND invoiced_qty < shipping_qty');

        if($this->_perShippingAddress)
        {
        	$collection->getSelect()
        		->order('shipping_address_id')
        	    ->order('billing_address_id');
        }   
        else
        {
        	$collection->getSelect()
        	    ->order('billing_address_id')
            	->order('shipping_address_id');
        } 
            
            
        $abo_quote = null;
        $newOrder = true;
        $abo_orders = array();
        $proccessedItems = array();  
        $shipId = -1;
        $billId = -1;  
        $invoices = array();
        foreach($collection->getItems() as $item)
        {
        	//testen ob neue Order noetig
        	if($this->_perShippingAddress)
        	{
        		//bei pro Lieferadresse muss auch auf die Rechnungsadresse getriggert werden
        		$newOrder = false;   		
        		if(($shipId != $item->getShippingAddressId()) || ($billId != $item->getBillingAddressId()))
        		{
        			 $newOrder = true;
        		}
        		$shipId = $item->getShippingAddressId();
        		$billId = $item->getBillingAddressId();
        	}
        	else 
        	{
        		//bei pro Rechnungsadresse muss nur auf die Rechnungsadresse aufgepasst werden
        		$newOrder = false;
        		if ($billId != $item->getBillingAddressId())
        		{
        			 $newOrder = true;
        		}
        		$billId = $item->getBillingAddressId();
        	}
            //falls sich die Adresse ge�ndert hat neue Lieferung
            if($newOrder) 
            {
            	//falls es schon eine quote gibt, in order wandeln und merken
            	if($abo_quote != null)
            	{
            		 foreach ($proccessedItems as $citem)
		             {
		             	$citem->revertStockItem();
		             }
		        	 
		             
		             try {
		             	$order = $this->getOrder($abo_quote);
		             }
		             catch (Exception $ex)
		             {
		             	foreach ($proccessedItems as $citem)
		             	{
		             		$citem->revertStockItem_Rollback();
		             	}
		             	throw $ex;
		             }
		             
		             $orderid = $order->getId();
             		 $abo_orders[] = $order->getId();
             		 $this->destroyOrder($order);
             		
            		 foreach ($proccessedItems as $citem)
            		 {
            		 	//$citem->revertStockItem();
            		 	$citem->setInvoicedQty($citem->getShippingQty())
            		 		  ->setInvoiceDate(time())
            		 		  ->setOrderId($orderid)
            		 		  ->save();	
            		 	
            		 	
            		 }
            		 
            		 $proccessedItems = array();
            	}
            	//neue Quote erzeugen
            	$abo_quote = $this->getQuote($item);

            	
            }
            $this->addItem($abo_quote,$item);
           	$proccessedItems[] = $item;
        }
        
        //letzten anfügen
		if($abo_quote != null)
        {

        	 foreach ($proccessedItems as $citem)
             {
             	$citem->revertStockItem();
             }
        	 
             try {
             	$order = $this->getOrder($abo_quote);
             }
             catch (Exception $ex)
             {
             	foreach ($proccessedItems as $citem)
             	{
             		$citem->revertStockItem_Rollback();
             	}
             	throw $ex;
             }
             $orderid = $order->getId();
             $abo_orders[] = $order->getId();
             $this->destroyOrder($order);
             
             foreach ($proccessedItems as $citem)
             {
             	
             	$citem->setInvoicedQty($citem->getShippingQty())
             		  ->setInvoiceDate(new Zend_Date())
             		  ->setOrderId($orderid)
             		  ->save();	
             }
             
             $proccessedItems = array();
         }
        
         //Egovs_Helper::printMemUsage('loadInvoices<=');

         //Invoicedatum setzen
         $sql = "UPDATE ".$collection->getResource()->getMainTable()." set invoice_date=now() where abo_deliver_id IN(".$deliverIds.")";
         $collection->getConnection()->query($sql);
       
         if(count($abo_orders) > 0)
         {
	         $icollection = Mage::getResourceModel('sales/order_invoice_collection')
	                ->addAttributeToSelect('*')
	                ->setOrderFilter($abo_orders);
	         foreach ($icollection->getItems() as $invoice) 
	         {
	         	$invoices[] = $invoice;
	         }
         }
		//Egovs_Helper::printMemUsage('loadInvoices=>');
        
        return $invoices;
	}
	
	
	
	
	
}