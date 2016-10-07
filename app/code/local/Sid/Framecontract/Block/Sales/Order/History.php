<?php

class Sid_Framecontract_Block_Sales_Order_History extends Mage_Sales_Block_Order_History
{

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('sales/order/history.phtml');
	
		$orders = Mage::getResourceModel('sales/order_collection')
		->addFieldToSelect('*')
		->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
		->addFieldToFilter('state', array('in' => Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates()))
		->setOrder('created_at', 'desc')
		
		;
		$orders->getSelect()
			->joinleft(array('export'=>$orders->getTable('exportorder/order')),'export.order_id=main_table.entity_id',array('export_status'=>'status'));
	
		$this->setOrders($orders);
	
		Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('sales')->__('My Orders'));
	}
	
    public function getCancelUrl($order)
    {
        return $this->getUrl('framecontract/order/cancel', array('order_id' => $order->getId()));
    }
    
    public function canCancel($order)
    {
    	$orderCanCancel = ($order->getStatus() == Mage_Sales_Model_Order::STATE_PROCESSING)	|| ($order->getStatus() == 'pending');
    	$isNotSync = ($order->getExportStatus() == Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)	|| ($order->getExportStatus() === null);
    	if($orderCanCancel && $isNotSync)
    	{
    		return true;
    	}
    	return false;
    }


    
}
