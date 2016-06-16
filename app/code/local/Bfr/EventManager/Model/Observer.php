<?php
/**
 * 
 *  Abfangen der Bestellung und speichern der Anmeldedaten
 *  @category Egovs
 *  @package  Bfr_EventManager_Model_Observer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Observer extends Varien_Object
{
	

	public function onCheckoutSubmitAllAfter($observer)
	{
		$order = $observer->getOrder();
		
		foreach($order->getAllItems() as $item)
		{
			$product= $item->getProduct();
			if($product->getTypeId() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE){
				Mage::getModel('eventmanager/participant')->importOrder($order,$item);
			}	
		}
		
	}


    
    public function getStoreId()
    {
          return Mage::app()->getStore()->getId();
    }
 
    
    
}