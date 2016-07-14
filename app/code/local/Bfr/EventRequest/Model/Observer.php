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
	/**
	 * verhinderd, dass Veranstaltungen mit Zulassungsbeschränkung
	 * zusammen mit anderen im Korb liegen
	 * @param unknown $observer
	 * @return Bfr_EventRequest_Model_Observer
	 */
	public function onQuoteItemAdd($observer)
	{
		/* @var $orderItem Mage_Sales_Model_Quote_Item  */
		$quoteItem = $observer->getQuoteItem();
		$quote = $quoteItem->getQuote();
		$productAdd = $quoteItem->getProduct();
		
		$quoteItems= $quote->getAllItems();
		
		$n = 0;
		foreach($quoteItems as $item)
		{
			if($item->getParentItem() !== null ){
				$n++;
			}
		}
		
		if(($productAdd->getEventrequest() == 1) && ($n > 1))
		{
			$quote->deleteItem($quoteItem);
			Mage::throwException(Mage::helper('eventrequest')->__('%s may be contained only once in the cart.',$productAdd->getName()));
			return $this;
		}

		foreach($quoteItems as $item)
			{
				//das neue Item hat noch keine Id
				if($item->getItemId()){
					if($item->getProduct()->getEventrequest() == 1){
						$quote->deleteItem($quoteItem);
						Mage::throwException(
								Mage::helper('eventrequest')->__('Finalize application of %s first!',$item->getProduct()->getName())
						);
						return $this;
					}
				}
			}
		
		return $this;
		
	}
	
	/**
	 * verhindern, dass eine Veranstaltung ohne Zulassung gekauft wird
	 * @param unknown $observer
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
				$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer_id, $item->getProduct()->getId());
 				if(!$request->isAccepted()){
 					throw new Exception(Mage::helper('eventrequest')->__('Finalize application of %s first!',$item->getProduct()->getName()));
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
	
	private function _redirect($url)
	{
		$url = Mage::getUrl($url);
		$app = Mage::app()->getResponse()
		->setRedirect($url)
		->sendResponse();
		die();
	}
}
