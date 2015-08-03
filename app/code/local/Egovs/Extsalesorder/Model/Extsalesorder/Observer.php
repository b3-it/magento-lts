<?php
/**
 * Observer für spezielle Stornos
 *
 * Setzt special_cancel Flag
 * Setzt return_to_stock Flag der Items
 *
 * @category   	Egovs
 * @package    	Egovs_Saferpay
 * @name       	Egovs_Saferpay_Block_Form
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extsalesorder_Model_Observer extends Mage_Core_Model_Abstract
{
	public function onAdminhtmlSalesOrderCreditmemoRegisterBefore($observer) {
		$creditmemo = $observer->getCreditmemo();
		
		$creditmemo->setSpecialCancel(true);
		
		/* @var $request Mage_Core_Controller_Request_Http */
		$request = $observer->getRequest();
		if ($request->getActionName() != 'new') {
			return;
		}
		
		foreach ($creditmemo->getAllItems() as $item) {
			if ($this->_canReturnItemToStock($item) && $item->getQty() > 0 && $item->getOrderItem()->getQtyToShip() > 0) {
				$item->setBackToStock(true);
			} else {
				$item->setBackToStock(false);
			}
		}
	}
	
	protected function _canReturnItemToStock($item=null) {
    	$canReturnToStock = Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_CAN_SUBTRACT);
    	if (!is_null($item)) {
    		if (!$item->hasCanReturnToStock()) {
	    		$product = Mage::getModel('catalog/product')->load($item->getOrderItem()->getProductId());
	    		if ( $product->getId() && $product->getStockItem()->getManageStock() ) {
	    			$item->setCanReturnToStock(true);
	    		} else {
	    			$item->setCanReturnToStock(false);
	    		}
    		} 
    		$canReturnToStock = $item->getCanReturnToStock();
    	}
    	return $canReturnToStock;
    }
}