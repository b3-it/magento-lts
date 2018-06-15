<?php
/**
 *
 *  @category B3it
 *  @package  B3it_Subscription_Model_Observer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2017 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Observer extends Varien_Object
{
	

	public function onCheckoutSubmitAllAfter($observer)
	{
		$order = $observer->getOrder();
		$quote = $observer->getQuote();

		foreach($order->getAllItems() as $item)
		{
			$product= $item->getProduct();
			$periodId = intval($product->getSubscriptionPeriod());

			/* @var $oldSubscription  B3it_Subscription_Model_Subscription */
			$oldSubscription = $this->_getSubscriptionItem($item,$quote);
			
			
			//falls abo Produkt oder Bestellung aus Abo
			if($periodId  || $oldSubscription)
			{
				/* @var $period  B3it_Subscription_Model_Period */
				$period = Mage::getModel('b3it_subscription/period');
				if($periodId){
					$period->load($periodId);
				}
				
				
				//alte Werte überschreiben die neuen
				if($oldSubscription)
				{
					$period->setPeriodLength($oldSubscription->getPeriodLength());
					$period->setPeriodUnit($oldSubscription->getPeriodUnit());
					$period->setRenewalOffset($oldSubscription->getRenewalOffset());
				}

                Mage::getModel('b3it_subscription/subscription')->addNewOrderItem($item, $quote, $period);
			}	
		}
	}

	/**
	 * @param Mage_Sales_Model_Order_Item $orderItem
	 * @param Mage_Sales_Model_Quote $quote
	 */
	protected function _getSubscriptionItem($orderItem, $quote)
	{
		$quoteItem = null;
		foreach($quote->getAllItems() as $item)
		{
			if($item->getId() == $orderItem->getQuoteItemId()){
				$quoteItem = $item;
			}
		}
	
		if($quoteItem){
			return $quoteItem->getSubscriptionItem();
		}
		return null;
	}

    
    public function getStoreId()
    {
          return Mage::app()->getStore()->getId();
    }
 

}