<?php
/**
 * 
 * Nebenkunden Controller
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH (http://www.b3-it.de)
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Stala_Extcustomer_Adminhtml_Extcustomer_Customer_ChildcustomerController extends Mage_Adminhtml_Controller_action
{
	public function indexAction() {
		$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('extcustomer/adminhtml_customer_tabs_childcustomer')->toHtml());
	}

	public function gridAction() {
		$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('extcustomer/adminhtml_customer_tabs_childcustomer_grid')->toHtml());
	}
	
	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('customer/manage');
	}
}