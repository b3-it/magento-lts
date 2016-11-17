<?php
/**
 *  Klasse für Abomigration anlegen der Bestellung
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Model_Order extends Dwd_Abo_Model_Order_Order
{
	
	/**
	 * neue Bestellungen anlegen, limit = 5
	 * @param number $limit
	 */
    public function createNewAboOrders($limit = 5)
    {
    	//5 Tage Vorlauf
    	//$bis = date('Y-m-d',time() + (60*60*24) * 5);
    	
    	//1.7.2015 telefonat mit Hr. Krüger Bestellung am selben Tag wie das Aboende
    	$bis = date('Y-m-d',time());
    	$collection = Mage::getModel('abomigration/abomigration')->getCollection();
    	$collection->getSelect()
    	->where('order_id = 0')
    	->where('customer_id > 0')
    	->where('error = 0')
    	->where("period_end <= ?",$bis)
    	->limit($limit);
    	//die($collection->getSelect()->__toString());
    	foreach($collection->getItems() as $item)
    	{
    		$this->setLog('Customer Id:' .$item->getCustomerId());
    		$abo_quote = $this->createQuote($item['customer_id'], $item['address_id']);
    		
    		for($i = 1; $i < 4; $i++)
    		{
    			if($item->getData('station'.$i))
    			{
	    			$o = new Varien_Object();
	    			$o->setProductId($item->getData('product_id'));
	    			$o->setPeriodId($item->getData('period_id'));
	    			$o->setStationId($item->getData('station'.$i));
	    			$quoteItem = $this->addItem($abo_quote, $o);
	    			$quoteItem->getAboMigItem()->setStopDate($item['period_end']);   			
    			}
    		}
    		
    		
    		$this->setRuleData($abo_quote);
    		$abo_quote->collectTotals()->save();
    		
    		
    		$lastmethod = new Varien_Object();
    		$lastmethod->setMethod('openaccount');
    		
    		
    		$abo_quote->setIsBatchOrder(true);
    		
    		$product = Mage::getModel('catalog/product')->load($item->getData('product_id'));
    		
    		if(!$item['pwd_ldap_is_safe'])
    		{
    			$pwd = Dwd_Abomigration_Model_Abomigration::createPassword('');
    			$item['pwd_ldap'] = $pwd;
    			$item['pwd_ldap_is_safe'] = 1;
    			$item->save();
    			//wg decrypt
    			$item['pwd_ldap'] = $pwd;
    		}
    		
    		Dwd_Icd_Model_Account::loadOrCreate($item['customer_id'],true,$item['username_ldap'],$product->getData('icd_connection'), $item['pwd_ldap']);
    		
    		
    		
    		$AllowedPaymentMethod = $this->getAllowedPaymentMethod($abo_quote, $lastmethod);
    		
    		if($AllowedPaymentMethod)
    		{
    			try {
    				$order = $this->getOrder($abo_quote, $AllowedPaymentMethod, "");
    				$item->setOrderId($order->getId())->save();
    			}
    			catch(Exception $ex)
    			{
    				$item->setError(1)
    				->setErrorText($ex->getMessage())
    				->save();
    				Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    			}
    		}
    		else 
    		{
    			$item->setError(1)
    			->setErrorText("Zahlmethode nicht gefunden oder nicht erlaubt. (".$lastmethod->getMethod().")")
    			->save();
    		}
    	}
    }
    
    /**
     *
     *
     * @param Mage_Sales_Model_Quote $quote
     * @param Dwd_Abo_Model_Abo $aboitem
     * @return Mage_Sales_Model_Quote_Item
     */
    protected function addItem($quote,$aboitem)
    {
    	$product = Mage::getModel('catalog/product')->load($aboitem->getProductId());
    
    	$item = Mage::getModel('sales/quote_item');
    	$item->setQuote($quote);
    	$item->setQty(1);
    	//$item->setData('stala_abo_shipping_address_id',intval($contractitem->getShippingAddressId()));
    
    	$product->setData('website_id', 0);
    	/* @var $item Mage_Sales_Model_Quote_Item */
    	$item->addOption(array('code'=>'periode_id','value'=>$aboitem->getPeriodId()));
    	$item->addOption(array('code'=>'station_id','value'=>$aboitem->getStationId()));
    	 
    	$p = Mage::getModel('periode/periode')->load($aboitem->getPeriodId());
    	$item->setPeriode($p);
    	$item->setAboMigItem($aboitem);
    
    	$item->setProduct($product);
    	//$item->setStationId($contractitem->getStationId());
    
    
    
    	$quote->addItem($item);
    
    	return $item;
    }
    
    protected function getOrder($quote, $payment, $first_increment_id=null)
    {
    	/* @var $quote Mage_Sales_Model_Quote */
    	$totals = $quote->getTotals();
    	 
    	if($totals['grand_total']['value'] < 0.01)
    	{
    		$this->addPaymentMethode($quote,'free');
    	}
    	else
    	{
    		$this->addPaymentMethode($quote,$payment->getCode());
    		//$this->addPaymentMethode($quote,'checkmo');
    	}
    
    
    	$quote->save();
    
    	$quote->reserveOrderId();
    	/* @var $convertQuote Mage_Sales_Model_Convert_Quote */
    	$convertQuote = Mage::getModel('sales/convert_quote');
    
    	if($quote->isVirtual())
    	{
    		$order = $convertQuote->addressToOrder($quote->getBillingAddress());
    	}
    	else
    	{
    		$order = $convertQuote->addressToOrder($quote->getShippingAddress());
    	}
    	$p = $convertQuote->paymentToOrderPayment($quote->getPayment());
    
    
    
    	if($this->_customer)
    	{
    		if($this->_customer->getId() != $order->getCustomerId())
    		{
    			$this->_customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
    		}
    	}
    	else
    	{
    		$this->_customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
    	}
    
    
    	if( $lastSepa =  $payment->getLastSepaMethod())
    	{
    		$ref =$lastSepa->getAdditionalInformation('mandate_reference');
    		if($ref != $this->_customer->getSepaMandateId()){
    			$this->fillSepaDebitValues($p, $this->_customer);
    		}
    		else{
    			$this->copySepaDebitValues($payment->getLastSepaMethod(), $p);
    		}
    	}
    	$order->setPayment($p);
    	$order->save();
    	/* @var $order Mage_Sales_Model_Order */
    	$order->setBillingAddress($convertQuote->addressToOrderAddress($quote->getBillingAddress()));
    	$baseAdr = $quote->getBaseAddress();
    	if($baseAdr)
    	{
    		$order->setBaseAddress($convertQuote->addressToOrderAddress($baseAdr));
    	}
    	//$order->setShippingAddress($convertQuote->addressToOrderAddress($quote->getShippingAddress()));
    
    
    
    	/*
    	 $order->setPrintnote1($this->_customer->getAboPrintNote1());
    	$order->setPrintnote2($this->_customer->getAboPrintNote2());
    
    	$order->setIsAbo('1');
    	*/
    
    	foreach ($quote->getAllItems() as $item) {
    		$orderItem = $convertQuote->itemToOrderItem($item);
    		if ($item->getParentItem()) {
    			$orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
    		}
    		$orderItem->setPeriodId($item->getPeriode()->getId());
    		$orderItem->setPeriodType($item->getPeriode()->getType());
    		$orderItem->setPeriodStart($item->getAboMigItem()->getStopDate());
    		$orderItem->setPeriodEnd($item->getPeriode()->getEndDate(strtotime($item->getAboMigItem()->getStopDate())));
    		$orderItem->setIbewiMaszeinheit($item->getProduct()->getIbewiMaszeinheit());
    		$orderItem->setStoreId($order->getStoreId());
    		$order->addItem($orderItem);
    	}
    	$order->save();
    	 
    	
    	
    
    	/**
    	 * We can use configuration data for declare new order status
    	*/
    	Mage::dispatchEvent('checkout_type_onepage_save_order', array('order'=>$order, 'quote'=>$quote));
    	Mage::dispatchEvent('sales_model_service_quote_submit_before', array('order'=>$order, 'quote'=>$quote));
    	try {
    		$order->place();
    		if($first_increment_id){
    			$order->setOriginalIncrementId($first_increment_id);
    		}
    
    		$order->save();
    		Mage::dispatchEvent('sales_model_service_quote_submit_success', array('order'=>$order, 'quote'=>$quote));
    	}
    	catch(Exception $ex)
    	{
    		Mage::dispatchEvent('sales_model_service_quote_submit_success', array('order'=>$order, 'quote'=>$quote));
    		$quote->setIsActive(false);
    		$quote->save();
    
    		$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, Mage_Sales_Model_Order::STATE_CANCELED,"Fehler bei der Aboverlängerung",false);
    		$order->save();
    		
    		Mage::dispatchEvent('sales_model_service_quote_submit_failure', array('order'=>$order, 'quote'=>$quote));
    		throw $ex;
    
    	}
    
    	//20111114::Frank Rochlitzer:: Die eCustomerID muss zurÃ¼ckgesetzt werden -> Caching Problem
    	Mage::helper('paymentbase')->resetECustomerId();
    
    	Mage::dispatchEvent('checkout_type_onepage_save_order_after', array('order'=>$order, 'quote'=>$quote));
    
    	/**
    	 * need to have somelogic to set order as new status to make sure order is not finished yet
    	 * quote will be still active when we send the customer to paypal
    	*/
    
    	 
    
    	$quote->setIsActive(false);
    	$quote->save();
    
    	//Egovs_Helper::printMemUsage('getOrder=>');
    	Mage::unregister('_singleton/salesrule/observer');
    
    
    		 
   
    	return $order;
    }
    
    
    
    protected function createQuote($customer_id, $address_id)
    {
    	$customer = Mage::getModel('customer/customer')->load($customer_id);
    	Mage::getSingleton('customer/session')->setCustomerGroupId($customer->getGroupId());
    	$quote = Mage::getModel('sales/quote');
    
    	$storeId = $customer->getStoreId();
    	if (empty($storeId) || '' == $storeId) {
    		$storeId = 0;
    	}
    	$quote->setStoreId($storeId);
    	$quote->reserveOrderId();
    
    	$quote->setCustomer($customer);
    
    	$billingAdr = $customer->getAddressById($address_id);
    
    	$billingAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($billingAdr);
    	$billingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING);
    	$quote->setBillingAddress($this->addressToQuoteAddress($billingAdr));
    	$billingAdr->setQuote($quote);
    
    	$baseAdr = $customer->getBaseAddress();
    
    	if (is_numeric($baseAdr) && $baseAdr > 0) {
    		$baseAdr = $customer->getAddressById($baseAdr);
    		if ($baseAdr && $baseAdr->getId()) {
    			$baseAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($baseAdr);
    			$baseAdr->setAddressType('base_address');
    			$quote->setBaseAddress($this->addressToQuoteAddress($baseAdr));
    			$baseAdr->setQuote($quote);
    		}
    	}
    
    	 
    
    
    	 
    	$quote->save();
    	return $quote;
    		
    }
    
    
}