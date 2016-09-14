<?php
/**
 *
 * Hauptkunden Controller
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH (http://www.b3-it.de)
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Stala_Extcustomer_Adminhtml_Extcustomer_Customer_ParentcustomerController extends Mage_Adminhtml_Controller_action
{

	protected function _init() {
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
	
	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('customer/manage');
	}
}