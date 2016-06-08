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
			Mage::throwException(Mage::helper('eventrequest')->__('%s has to be alone in basket!',$productAdd->getName()));
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
}
