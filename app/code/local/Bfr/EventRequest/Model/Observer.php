<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Model_Observer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Model_Observer extends Varien_Object
{
	private $_lastQuote = 0;
	/**
	 * verhinderd, dass Veranstaltungen mit Zulassungsbeschränkung
	 * zusammen mit anderen im Korb liegen
	 * @param Bfr_EventRequest_Model_Observer $observer
	 * @return Bfr_EventRequest_Model_Observer
	 */
	public function onQuoteItemAdd($observer)
	{
		/* @var $orderItem Mage_Sales_Model_Quote_Item  */
		$quoteItem = $observer->getQuoteItem();
		$quote = $quoteItem->getQuote();
		
		if($this->_lastQuote == $quote->getId())
		{
			return $this;
		}
		
		$this->_lastQuote = $quote->getId();
		
		$productAdd = $quoteItem->getProduct();
		$customer_id = $quote->getCustomer()->getId();
		
		$quoteItems= $quote->getAllItems();
		
		//Produkte im Warenkorb zählen
		$n = 0;
		foreach($quoteItems as $item)
		{
			if($item->getParentItem() === null ){
				$n += $item->getQty();
			}
		}
		
		$n += $productAdd->getQty();
		//falls ein Produkt mit eventrequest darf nur alleine im Warenkorb liegen
		if(($productAdd->getEventrequest() == 1) && ($n > 1))
		{
			$quote->deleteItem($quoteItem);
			Mage::throwException(Mage::helper('eventrequest')->__('%s can only be ordered/requested separately.',$productAdd->getName()));
			return $this;
		}

		//falls der Kunde sich bereits für die Veranstaltung angemeldet hat
		if($productAdd->getEventrequest() == 1)
		{
			$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer_id, $productAdd->getId());
			if($request->getId() && !$request->isAccepted()){
	 					Mage::throwException(Mage::helper('eventrequest')->__('An application of %s has been found!',$item->getProduct()->getName()));
	 					return $this;
	 				}
		}
		
		foreach($quoteItems as $item)
			{
				//das neue Item hat noch keine Id
				if($item->getItemId()){
					if($item->getProduct()->getEventrequest() == 1){
						$quote->deleteItem($quoteItem);
						Mage::throwException(
								Mage::helper('eventrequest')->__('Please complete registration for the event %s first.',$item->getProduct()->getName())
						);
						return $this;
					}
				}
			}
		
		return $this;
		
	}
	
	/**
	 * verhindern, dass eine Veranstaltung ohne Zulassung gekauft wird
	 * @param Bfr_EventRequest_Model_Observer $observer
	 * @throws Exception
	 */
	public function onCheckoutEntryBefore($observer)
	{
		try {
			$quote = $observer['quote'];
			$quoteItems= $quote->getAllItems();
			$customer_id = $quote->getCustomer()->getId();
			foreach($quoteItems as $item)
			{
				if($item->getProduct()->getEventrequest() == 1){
					$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer_id, $item->getProduct()->getId());
	 				if(!$request->isAccepted()){
	 					throw new Exception(Mage::helper('eventrequest')->__('Finalize application of %s first!',$item->getProduct()->getName()));
	 				}
				}
			}
		}
		catch(Exception $ex){
			$sess = Mage::getSingleton('core/session');
			$messages = $sess->getMessages();	
			$sess->addError($ex->getMessage());
			$this->_redirect('checkout/cart');
		}
	}
	
	
	public function onClearExpiredQuotesBefore($observer)
	{
		$sales_observer = $observer['sales_observer'];
		$sales_observer->setExpireQuotesAdditionalFilterFields(array('is_event_request'=>'0'));
	}
	
	
	public function onSalesOrderSaveCommitAfter($observer)
	{
		try {
			$order = $observer['order'];
			$quoteItems= $order->getAllItems();
			$customer_id = $order->getCustomerId();
			foreach($quoteItems as $item)
			{
				if($item->getProduct()->getEventrequest() == 1){
					$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer_id, $item->getProduct()->getId());
					$request->setStatus(Bfr_EventRequest_Model_Status::STATUS_ORDERED)->save();
				}
			}
		}
		catch(Exception $ex){
			Mage::logException($ex);
			}
		}

	
	
	private function _redirect($url)
	{
		$url = Mage::getUrl($url);
		$app = Mage::app()->getResponse()
		->setRedirect($url)
		->sendResponse();
		die();
	}
}
