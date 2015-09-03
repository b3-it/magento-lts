<?php

class Stala_Extcustomer_Model_Product_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Wird beim speichern von Cross Freecopies aufgerufen.
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	public function onProductPrepareSave($observer) {
		$product = $observer->getProduct();
		
		$data = Mage::app()->getRequest()->getPost('cross_freecopies');
		if (isset($data)) {
			$data = Mage::helper('adminhtml/js')->decodeGridSerializedInput($data);
			
			/* @var $crossFreecopies Stala_Extcustomer_Model_Product_Link */
			$crossFreecopies = Mage::getModel('extcustomer/product_link');
			
			if (!$crossFreecopies)
				return $this;
			
			//wichtig um getLinkTypeId nutzen zu können
			$crossFreecopies->useCrossFreecopiesLinks();
			
			if (count($data) > 0) {
				$data[$product->getId()] = array();
			}
			
			//Wichtig falls Items abgwählt werden
			$keys = array_keys($data);
			$collection = $crossFreecopies->getLinkCollection()
							->addFieldToFilter('linked_product_id', array(count($keys) > 0 ? 'in' : 'nin' => count($keys) > 0 ? $keys : array($product->getId())))
							->addFieldToFilter('product_id', array(count($keys) > 0 ? 'nin' : 'in' => count($keys) > 0 ? $keys : array($product->getId())))
							->addFieldToFilter('link_type_id', array('eq' => $crossFreecopies->getLinkTypeId()))
			;
			
			$itemsToDelete = array();
			foreach ($collection->getItems() as $item) {
				$found = array_search($item->getLinkedProductId(), $keys);
				if ($found === false) {
					$itemsToDelete[] = $item;
				} else {
					$assignedCol = $crossFreecopies->getLinkCollection()
						->addFieldToFilter('product_id', $product->getId())
						->addFieldToFilter('link_type_id', array('eq' => $crossFreecopies->getLinkTypeId()))
					;
					
					$wasAssigned = false;
					foreach ($assignedCol->getItems() as $assigned) {
						if ($assigned->getLinkedProductId() == $item->getProductId()) {
							$wasAssigned = true;
							break;
						}
					}
					//Nur falls es noch nicht zugewiesen war! && keine doppelten Einträge
					if (!$wasAssigned && array_search($item->getProductId(), $keys) !== false) {
						$keys[] = $item->getProductId();
					} elseif ($wasAssigned && array_search($item->getProductId(), $keys) === false) {
						$itemsToDelete[] = $item;
					}
				}
			}
			
			if (count($itemsToDelete) > 0) {
				//Kreuzverbindungen auflösen
				//#################################################################################
				$fromIds = array();
				$toIds = array();
				foreach ($itemsToDelete as $item) {
					if (!array_key_exists($item->getProductId(), $fromIds)) {
						$fromIds[$item->getProductId()] = true;
					}
				
					if (!array_key_exists($item->getLinkedProductId(), $toIds)) {
						$toIds[$item->getLinkedProductId()] = true;
					}
				}
				$collection = $crossFreecopies->getLinkCollection()
					->addFieldToFilter('linked_product_id', array('in' => array_keys($fromIds)))
					->addFieldToFilter('product_id', array('in' => array_keys($toIds)))
					->addFieldToFilter('link_type_id', array('eq' => $crossFreecopies->getLinkTypeId()))
				;
				foreach ($collection->getItems() as $item) {
					$itemsToDelete[] = $item;
				}
				//#################################################################################
				
				Mage::log(sprintf('There are %d Items to delete from cross freecopies:', count($itemsToDelete)), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
				//Abgewählte Items löschen
				//$collection->walk('delete');
				foreach ($itemsToDelete as $item) {
					Mage::log(sprintf("\tDeleting Item with ID: %d (Linked %d => %d) from cross freecopies", $item->getId(), $item->getProductId(), $item->getLinkedProductId()), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
					$item->delete();
				}
			}			
			
			if (!empty($keys)) {
				Mage::log('New items for cross freecopies:'.var_export($keys, true), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
				$crossFreecopies->saveCrossRelations($keys);
			}			
		}
		
		return $this;
	}
	
	/**
	 * Ruft die automatische Verlinkung der Produkte auf.
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	public function onProductSaveAfter($observer) {
		/* @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		
		if (empty($product) || $product->getId() < 1 || !$product->hasSku()) {
			return $this;
		}
		
		/* @var $crossFreecopies Stala_Extcustomer_Model_Product_Link */
		$crossFreecopies = Mage::getModel('extcustomer/product_link');
			
		if (!$crossFreecopies)
			return $this;
			
		//wichtig um getLinkTypeId nutzen zu können
		$crossFreecopies->useCrossFreecopiesLinks();
			
		$crossFreecopies->saveAutoProductRelations($product);
		
		return $this;
	}
}

?>