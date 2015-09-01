<?php

class Sid_Framecontract_Model_Observer extends Mage_Core_Model_Abstract
{
   
	/**
	 * Abgelaufenen Verträge und zugehoerige Produkte deaktivieren
	 * @param unknown $sceduler
	 */
	public function disableExpiredContracts($sceduler)
	{
		$collection = Mage::getModel('framecontract/contract')->getCollection();
		$collection->getSelect()
			->where("end_date < '". date('Y-m-d')."'")
			->where('status ='.Sid_Framecontract_Model_Status::STATUS_ENABLED );
		
		foreach($collection->getItems() as $contract)
		{
					
			$products = Mage::getModel('catalog/product')->getCollection();
			$products->addAttributeToFilter('framecontract',$contract->getId());
			$products->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
			
			
			$productIds = array();
			foreach ($products->getItems() as $product)
			{
				$productIds[] = $product->getId();
			}
			
			if(count($productIds) > 0){
				Mage::getSingleton('catalog/product_action')
				->updateAttributes($productIds, array('status' => Mage_Catalog_Model_Product_Status::STATUS_DISABLED), 0);
			}	
			
			$contract->setStatus(Sid_Framecontract_Model_Status::STATUS_DISABLED)->save();
		}
	}
    
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