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



			if($periodId){
			    $period = Mage::getModel('b3it_subscription/period')->load($periodId);
                Mage::getModel('b3it_subscription/subscription')->addNewOrderItem($item, $quote, $period);
			}	
		}
	}


    
    public function getStoreId()
    {
          return Mage::app()->getStore()->getId();
    }
 

}