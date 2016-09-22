<?php

class Sid_Haushalt_Model_Observer extends Mage_Core_Model_Abstract
{
   
	
    
	/**
	 * Exportstatus der Bestellung und Haushaltsystem speichern
	 * @param unknown $observer
	 */
	public function onCreateOrder($observer)
	{

		try 
		{
			$orders = $observer->getOrders();
			foreach($orders as $order){
				$address = Mage::getModel('customer/address')->load($order->getBillingAddress()->getCustomerAddressId());
				
				$order_info = Mage::getModel('sidhaushalt/order_info');
				$order_info->setOrderId($order->getId())
						->setCreatedAt(now());
				
				
				
				if(!empty($address->getHaushaltsSystem())){
				
					$order_info->setHauahaltsSystem($address->getHaushaltsSystem());
				}
				$order_info->save();
			}
		}
		catch (Exception $e) {
            Mage::logException($e);
		}
	}
 
}