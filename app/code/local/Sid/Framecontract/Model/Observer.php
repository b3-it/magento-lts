<?php

class Sid_Framecontract_Model_Observer extends Mage_Core_Model_Abstract
{
   
	
    
	/**
	 * Mail an Lieferanten versenden falls neue Bestellung
	 * @param unknown $observer
	 */
	public function onCreateOrder($observer)
	{
		try 
		{
			$orders = $observer->getOrders();
			//$address = $observer->getAddress();
			$model = Mage::getModel('framecontract/order');
			$model->sendOrderEmail($orders);
		}
		catch (Exception $e) {
            Mage::logException($e);
		}
	}
 
}