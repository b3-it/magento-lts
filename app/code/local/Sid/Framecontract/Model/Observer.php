<?php

class Sid_Framecontract_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	public function onAdminSalesOrderView($observer) {
		if (!$observer->hasAction() || !($observer->getAction() instanceof Mage_Adminhtml_Sales_OrderController)) {
			return;
		}
		
		
		if($observer->getAction()->getRequest()->getActionName() != 'view'){
			return;
		}
		$order = Mage::registry('current_order');
		$session = Mage::getSingleton('adminhtml/session');
		
		$extport = Mage::getModel('exportorder/order')->load($order->getId(),'order_id');
		if($extport->getId() && $extport->getStatus() != Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)
		{
			$session->addNotice(Mage::helper('framecontract')->__('This order has been send to supplier already'));
		}
		
	}
}