<?php

class Dimdi_Import_Model_Order extends Dimdi_Import_Model_Abstract
{
    private $_conn = null;
    private $_countryCollection = null;
    
    
    public function run($conn)
    {
    	$this->_conn = $conn;
    	try 
    	{
    		$this->_run();
    	}
    	catch(Exception $ex)
    	{
    		echo $ex->getMessage(); die();
    	}
    }
    
    
    
  
    
	private function _run()
    {
  		$i = 0;
  		$transaction = Mage::getModel('core/resource_transaction');
  		
		$res = $this->_conn->fetchAll("SELECT * FROM orders WHERE orders_flagmigration > 0");
		foreach($res as $row)
		{ 
			$i++;
			$customer_id = $row['customers_id'];
			$customer = $this->_getCustomerByOscId($customer_id);
			Mage::log('-------------------------- begin ------------------------------', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			Mage::log(sprintf('OSC Import:: osc customer id: %d', $row['customers_id']), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			if($customer == null) continue;
			$quote = $this->_getQuote($customer, $row);
			
			//produkte hinzu
			$res1 = $this->_conn->fetchAll("SELECT * FROM orders_products WHERE orders_id = ".$row['orders_id']);
			$subTotal = 0;
			
			Mage::log(sprintf('OSC Import:: osc order id: %d', $row['orders_id']), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
			foreach($res1 as $row1)
			{
				Mage::log(sprintf('OSC Import:: osc product id: %d', $row1['products_id']), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				$_product = $this->_getProductByOscId($row1['products_id']);		
			
				if($_product == null) continue;
				Mage::log(sprintf('OSC Import:: product id: %d',$_product->getId()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				
				
				$qty = $row1['products_quantity'];
				
				$this->addItem($quote,$_product,$qty);
				
				
			}
			
			$order = $this->getOrder($quote);
			if(strlen($row['bff_kassenzeichen'])>0)
			{
				$order->getPayment()->setKassenzeichen($row['bff_kassenzeichen']);
        		Mage::log(sprintf('OSC Import:: Kassenzeichen: %s', $row['bff_kassenzeichen']), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				
			}
			$order->setCreatedAt($row['date_purchased']);
			$order->save();
			
			Mage::log(sprintf('OSC Import:: new Order created: %s', $order->getIncrementId()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
			
			//order status
			/*
			1,"Die Bestellung ist noch nicht bearbeitet."
			2,"Die Bestellung ist in Bearbeitung."
			3,"Die Bestellung wurde bearbeitet und die Artikel versendet."
			4,"Die Bestellung wurde bearbeitet."
			*/
			
			if(intval($row['orders_status']) > 1)
			{
				if($order->canInvoice()) 
				{
				    $invoiceId = Mage::getModel('sales/order_invoice_api')
				                        ->create($order->getIncrementId(), array());
				 
				    $invoice = Mage::getModel('sales/order_invoice')
				                        ->loadByIncrementId($invoiceId);
				 
				    $invoice->save();
				    Mage::log(sprintf('OSC Import:: new invoice created: %s',$invoice->getIncrementId()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				
				}
			}
			
			if(intval($row['orders_status']) == 3)
			{

				if($order->canShip())
				{
					$itemQty =  0;
					foreach($order->getItemsCollection()->getItems() as $item)
					{
						if(!$item->getIsVirtual())
						{
							$itemQty += $item->getQty();
						}
					}
					$shipment = new Mage_Sales_Model_Order_Shipment_Api();
					$shipmentId = $shipment->create($order->getIncrementId());
					Mage::log(sprintf('OSC Import:: new shippment created: %s',$shipmentId), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				
				}
			}
			
			
		}
		echo $i . " Bestellungen importiert!";
    	
    }
    
    
    private function _getProductByOscId($oscid)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$attribute_id = $eav->getIdByCode('catalog_product', 'osc_product_id');
    	
    	$collection = Mage::getModel('catalog/product')->getCollection();
    	$collection->getSelect()->join(array('osc'=>'catalog_product_entity_varchar'),'e.entity_id = osc.entity_id',array('oscid'=>'value'))
    		->where("osc.value = ?", $oscid)
    		->where("attribute_id = ?", $attribute_id);
    	$collection->addAttributeToSelect('*');
    	
     	foreach($collection->getItems() as $item)
    	{
    		return $item;
    	}
    	return null;
    }
    
    private function _getQuote($customer, $data)
    {
    	
		$quote = Mage::getModel('sales/quote');
		
		$storeId = $customer->getStoreId();				
		$quote->setStoreId($storeId);
		$quote->reserveOrderId();
		
		$quote->setCustomer($customer);
		
		
		$billingAddress = Mage::getModel('sales/quote_address')
		->setStoreId($storeId)
		->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
		->setCustomerId($customer->getId())
		//->setCustomerAddressId($customer->getDefaultBilling())
		//->setCustomer_address_id($billing->getEntityId())
		
		->setLastname($data['billing_name'])
		->setCompany($data['billing_company'])
		->setStreet($data['billing_street_address']."\n".$data['billing_street_address_2'])
		->setCity($data['billing_city'])
		->setCountry_id($this->_getCountryId($data['billing_country']))
		->setPostcode($data['billing_postcode']);
		
		

		$shippingAddress = Mage::getModel('sales/quote_address')
		->setStoreId($storeId)
		->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING)
		->setCustomerId($customer->getId())
		//->setCustomerAddressId($customer->getDefaultShipping())
		//->setCustomer_address_id($shipping->getEntityId())
		->setLastname($data['delivery_name'])
		->setCompany($data['delivery_company'])
		->setStreet($data['delivery_street_address']."\n".$data['delivery_street_address_2'])
		->setCity($data['delivery_city'])
		->setCountry_id($this->_getCountryId($data['delivery_country']))
		->setPostcode($data['delivery_postcode']);

		$quote->setBillingAddress(($billingAddress));
        $billingAddress->setQuote($quote);
		
        $quote->setShippingAddress(($shippingAddress));
        $shippingAddress->setQuote($quote);
		
		
        $shippingAddress->setShippingMethod('freeshipping_freeshipping')
                 ->setCollectShippingRates(true);
        
        $quote->save();
        return $quote;
			
    }
    
    
    protected function getOrder($quote)
    {
    	$quote->getShippingAddress()->setCollectShippingRates(true);
    	$quote->collectTotals()->save();
       
        $totals = $quote->getTotals();
       
       	if($totals['grand_total']['value'] < 0.01)
		{
			$this->addPaymentMethode($quote,'free');
		
		}
        else 
        {
			$this->addPaymentMethode($quote,'purchaseorder');
        }
        
        
        $quote->save();
		
        
        
        $quote->reserveOrderId();
        $convertQuote = Mage::getModel('sales/convert_quote');
 
        if($quote->isVirtual())
        {
        	$order = $convertQuote->addressToOrder($quote->getBillingAddress());
        }
        else
        {
        	$order = $convertQuote->addressToOrder($quote->getShippingAddress());
        }
        $order->setPayment($convertQuote->paymentToOrderPayment($quote->getPayment()));
        $order->save();
        /* @var $order Mage_Sales_Model_Order */
        $order->setBillingAddress($convertQuote->addressToOrderAddress($quote->getBillingAddress()));
		$order->setShippingAddress($convertQuote->addressToOrderAddress($quote->getShippingAddress()));
        

        foreach ($quote->getAllItems() as $item) {
            $orderItem = $convertQuote->itemToOrderItem($item);
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            $order->addItem($orderItem);            
        }
		$order->save();
       
        
        /**
         * We can use configuration data for declare new order status
         */
        Mage::dispatchEvent('checkout_type_onepage_save_order', array('order'=>$order, 'quote'=>$quote));  
        $order->place();
        $order->save();
        
     
        Mage::dispatchEvent('checkout_type_onepage_save_order_after', array('order'=>$order, 'quote'=>$quote));
        $quote->setIsActive(false);
        $quote->save();

       return $order;
       
    }
    
    private function _createOrder($customer, $data)
    {
		$storeId = $customer->getStoreId();
		$reservedOrderId = Mage::getSingleton('eav/config')->getEntityType('order')->fetchNewIncrementId($storeId);
		
		$order = Mage::getModel('sales/order')
		->setIncrementId($reservedOrderId)
		->setStoreId($storeId)
		->setQuoteId(0)
		->setGlobal_currency_code('EUR')
		->setBase_currency_code('EUR')
		->setStore_currency_code('EUR')
		->setOrder_currency_code('EUR');

		// set Customer data
		$order->setCustomer_email($customer->getEmail())
		->setCustomerFirstname($customer->getFirstname())
		->setCustomerLastname($customer->getLastname())
		->setCustomerGroupId($customer->getGroupId())
		->setCustomer_is_guest(0)
		->setCustomer($customer);


		$billingAddress = Mage::getModel('sales/order_address')
		->setStoreId($storeId)
		->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
		->setCustomerId($customer->getId())
		//->setCustomerAddressId($customer->getDefaultBilling())
		//->setCustomer_address_id($billing->getEntityId())
		
		->setLastname($data['billing_name'])
		->setCompany($data['billing_company'])
		->setStreet($data['billing_street_address']."\n".$data['billing_street_address_2'])
		->setCity($data['billing_city'])
		->setCountry_id($this->_getCountryId($data['billing_country']))
		->setPostcode($data['billing_postcode']);
		
		$order->setBillingAddress($billingAddress);

		$shippingAddress = Mage::getModel('sales/order_address')
		->setStoreId($storeId)
		->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING)
		->setCustomerId($customer->getId())
		//->setCustomerAddressId($customer->getDefaultShipping())
		//->setCustomer_address_id($shipping->getEntityId())
		->setLastname($data['delivery_name'])
		->setCompany($data['delivery_company'])
		->setStreet($data['delivery_street_address']."\n".$data['delivery_street_address_2'])
		->setCity($data['delivery_city'])
		->setCountry_id($this->_getCountryId($data['delivery_country']))
		->setPostcode($data['delivery_postcode']);

		$order->setShippingAddress($shippingAddress)
		->setShipping_method('freeshipping_freeshipping')
		//->setShippingDescription($this->getCarrierName('freeshipping'))
		;
		
		$orderPayment = Mage::getModel('sales/order_payment')
		->setStoreId($storeId)
		->setCustomerPaymentId(0)
		->setMethod('purchaseorder')
		->setPo_number(' - ')
		->setKassenzeichen($data['bff_kassenzeichen']);
		$order->setPayment($orderPayment);
		return $order;
    }
    
   	private function _getCustomerByOscId($oscid)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$attribute_id = $eav->getIdByCode('customer', 'osc_customer_id');
    	
    	$collection = Mage::getModel('customer/customer')->getCollection();
    	$collection->getSelect()->join(array('osc'=>'customer_entity_varchar'),'e.entity_id = osc.entity_id',array('oscid'=>'value'))
    		->where("osc.value = ?", $oscid)
    		->where("attribute_id = ?",$attribute_id);
     	foreach($collection->getItems() as $item)
    	{
    		return  Mage::getModel('customer/customer')->load($item->getId());
    	}
    	return null;
    }
    
    private function _getCountryId($countryName)
    {
    	if($this->_countryCollection == null)
    	{
    		$this->_countryCollection = Mage::getModel('directory/country_api')->items();
    	}
    	foreach($this->_countryCollection as $country)
    	{
    		if($country['name'] == $countryName) return $country['country_id'];
    	}
    	return 'DE';
    }
    
	private function addItem($quote,$product, $qty)
	{
		
        $item = Mage::getModel('sales/quote_item');
        $item->setQuote($quote);
		$item->setQty($qty);
        $product->setData('website_id', 0);
		$item->setProduct($product);
		$quote->addItem($item);

		return $item;
	}
	
   protected function addPaymentMethode($quote, $paymentMethod)
    {   	        
        $payment = $quote->getPayment();
        $payment->setMethod($paymentMethod);
        $quote->getShippingAddress()->setPaymentMethod($payment->getMethod());
    }
}
