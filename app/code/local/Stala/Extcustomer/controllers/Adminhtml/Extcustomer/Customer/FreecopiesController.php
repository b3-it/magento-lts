<?php
/**
 * Adminhtml customer freecopies controller
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel (http://www.edv-beratung-hempel.de)
 * @copyright	Copyright (c) 2011 TRW-NET (http://www.trw-net.de)
 */
class Stala_Extcustomer_Adminhtml_Extcustomer_Customer_FreecopiesController extends Mage_Adminhtml_Controller_Action
{
	private function _init()
	{
		$id  = $this->getRequest()->getParam('customer_id');
		if($id)
		{
			$customer = Mage::getModel('customer/customer')->load($id);
			Mage::register('current_customer', $customer);
		}
		$this->loadLayout();
			
		return $this;
	}

	public function reportAction() {
		$this->_init();
		//Alle Layoutfunktionen werden über die extcustomer.xml Layoutdatei gesteuert
		$this->renderLayout();
		return $this;
	}
	
	public function indexAction() {
		$this->_init();
		$this->getLayout()->getBlock('customer.edit.tab.freecopies.grid')
		->setCustomerFreecopies($this->getRequest()->getPost('customer_freecopies', null));
		//Alle Layoutfunktionen werden über die extcustomer.xml Layoutdatei gesteuert
		$this->renderLayout();
		return $this;
	}

	public function gridAction() {
		$this->_init();

		$this->getLayout()->getBlock('customer.edit.tab.freecopies.grid')
		->setCustomerFreecopies($this->getRequest()->getPost('customer_freecopies', null));
		//Alle Layoutfunktionen werden über die extcustomer.xml Layoutdatei gesteuert
		$this->renderLayout();
		return $this;
	}

	public function freecopiesAction() {
		$this->_forward('grid');
	}
}