<?php

class Slpb_Verteiler_Model_Order extends Slpb_Verteiler_Model_Abstract
{
 
	
	
	public function createOrders($verteiler_id,$products = array(), $note=array())
	{
		
        $verteiler = Mage::getModel('verteiler/verteiler_customer')->getCollection();
   		$verteiler->getSelect()->where('verteiler_id=?', intval($verteiler_id));
   		
   		for($i =0, $iMax = count($products); $i < $iMax; $i++)
   		{
   			$id = $products[$i]['id'];
   			$qty = $products[$i]['qty'];
   			$product = Mage::getModel('catalog/product')->load($id);
   			$products[$i]= array('id'=>$id,'qty'=>$qty,'product' => $product);
   		}
   		$customers = array();
   		$errors = array();
   		foreach($verteiler->getItems() as $item)
        {
        	$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
        	$customers[] = $customer;
        	if($customer->getDefaultBillingAddress() == null)
        	{
        		$errors[] = 'Rchnungsadresse fehlt bei Kunden '.$customer->getId().".";
        	}
        	if($customer->getDefaultShippingAddress() == null)
        	{
        		$errors[] = 'Lieferadresse fehlt bei Kunden '.$customer->getId().".";
        	}
        	if(count($errors)>0)
        	{
        		$errors = implode(' ',$errors);
        		Mage::throwException($errors);
        	}
        }
   		
   	
        foreach($customers as $customer)
        {
        	$quote = $this->getQuote($customer);
        	
        	foreach($products as $product)
        	{
        		$this->addItem($quote,$product['product'],$product['qty']);
        	}
            		 
           	$order = $this->getOrder($quote,$note);
		    $this->destroyOrder($order);  	
           
        }
        
        return $this;
	}
	
	
	
	
	
}