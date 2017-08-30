<?php

class Egovs_Downloadupdate_Model_Observer extends Mage_Core_Model_Abstract {
		
	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return Egovs_Downloadupdate_Model_Observer
	 */
	public function onModelSaveAfter($observer) {
		//Mage::log("downloadupdate::model_save_after raised", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		if ($this->getData())
			return $this;
		
		$object = $observer->getProduct();
		//Egovs_Acl_Model_Product
		if (!($object instanceof Mage_Catalog_Model_Product))
			return $this;
		if (!$object->getId()) {
			Mage::throwException("The product ID wasn't set!");
		}
		
		
		$update = Mage::app()->getRequest()->getPost('downloadupdate_update_old_orders');
		if($update != 1) 
			return $this;
		
		if($object->getTypeId() == Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE)
		{
			$Fileupdate = Mage::getModel('downloadupdate/file');
			$Fileupdate->updateFile($object);		
		}
		
		return $this;    	
	}
}