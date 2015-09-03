<?php

class Stala_Extcustomer_Adminhtml_Extcustomer_Customer_ParentcustomerController extends Mage_Adminhtml_Controller_action
{

	private function _init()
	{
		$id  = $this->getRequest()->getParam('customer_id');
		if($id)
		 {
		 	$customer = Mage::getModel('customer/customer')->load($id);		 	
		 	$collection = Mage::getResourceModel('sales/order_collection')
                        ->addAttributeToFilter('customer_id', $id);
           	$customer->setData('customer_orders_count', count($collection->getItems()));
           	Mage::register('current_customer', $customer);
		 }
	}

	public function indexAction() {
		
		$this->_init();

		$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('extcustomer/adminhtml_customer_tabs_parentcustomer')->toHtml());
	}

	public function gridAction() {
		$this->_init();
		$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('extcustomer/adminhtml_customer_tabs_parentcustomer_grid')->toHtml());
	}

}