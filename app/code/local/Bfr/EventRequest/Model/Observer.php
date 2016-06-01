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
	public function onQuoteItemAdd($observer)
	{
		/* @var $orderItem Mage_Sales_Model_Quote_Item  */
		$quoteItem = $observer->getQuoteItem();
		$quote = $quoteItem->getQuote();
		$productAdd = $quoteItem->getProduct();
		
		$quoteItems= $quote->getAllItems();
		if(($productAdd->getEventrequest() == 1) && (count($quoteItems) > 0))
		{
			$quote->deleteItem($quoteItem);
			Mage::getSingleton('customer/session')->addError("It is not possible");
			return $this;
		}
		else{
		foreach($quoteItems as $item)
			{
				//das neue Item hat noch keine Id
				if($item->getItemId()){
					if($item->getProduct()->getEventrequest() == 1){
						$quote->deleteItem($quoteItem);
						//Mage::getSingleton('customer/session')->addError("It is not possible altes entfernen");
						Mage::throwException(
								Mage::helper('sales')->__('It is not possible altes entfernen')
						);
						return $this;
					}
				}
			}
		}
		
		
	}
}
