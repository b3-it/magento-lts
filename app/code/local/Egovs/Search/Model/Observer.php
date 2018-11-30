<?php

class Egovs_Search_Model_Observer extends Mage_Core_Model_Abstract {
    
	
	
	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return null
	 */
	public function onModelSaveAfter($observer) 
	{
		if ($this->getData())
			return;
		
		$object = $observer->getProduct();
		//Egovs_Acl_Model_Product
		if (!($object instanceof Mage_Catalog_Model_Product))
			return;
		if (!$object->getId()) {
			Mage::throwException("The product ID wasn't set!");
		}
		$storeid =  Mage::app()->getRequest()->getParam('store');
		
		if ($storeid == null) {
			$storeid = 0;
		}
		
		//Mage::log("search::model_save_after raised", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		Mage::getModel('egovssearch_mysql4/soundex_collection')->addProduct($object, $storeid);
	}
}