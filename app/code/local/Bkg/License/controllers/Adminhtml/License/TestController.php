<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name        Bkg_License_Adminhtml_License_Master_EntityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Adminhtml_License_TestController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bkglicense/bkglicense_master')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('License Test'), Mage::helper('adminhtml')->__('License Test'));
		$this->_title(Mage::helper('adminhtml')->__('License Test'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction();
		
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
			$this->_addContent($this->getLayout()->createBlock('bkg_license/adminhtml_test_edit'));
			
			$this->renderLayout();
			return;
			
	}
	
	public function saveAction() {
		$this->_initAction();
		if ($data = $this->getRequest()->getPost()) {
	
			$customer = Mage::getModel('customer/customer')->load($data['customer']);
			$product = Mage::getModel('catalog/product')->load($data['product']);
			$toll =  Mage::getModel('bkg_license/master_toll')->load($data['tolloption'],'useoption_id');

            $online_only = boolval($data['type'] == Bkg_License_Model_Type::TYPE_ONLINE);

			$master = Mage::getModel('bkg_license/master')->getLicense($customer,$product,$toll,$online_only);
			Mage::register('license_master', $master);
			$masters = Mage::getModel('bkg_license/master')->getLicense($customer,$product,$toll,$online_only,true);
			Mage::register('license_masters', $masters);
			
			$copies = Mage::getModel('bkg_license/copy')->getLicense($customer,$product,$toll,$online_only,true);
			Mage::register('license_copies', $copies);
		}
		
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
		$this->_addContent($this->getLayout()->createBlock('bkg_license/adminhtml_test_search'));
			
		$this->renderLayout();
		return;
	}
	
	public function copyAction() {
		$this->_initAction();
		$id     =  intval($this->getRequest()->getParam('id'));
		if ($data = $this->getRequest()->getPost()) {
			$master = Mage::getModel('bkg_license/master')->load($id);
			Mage::register('license_master', $master);
			
			$customer = Mage::getModel('customer/customer')->load($data['customer']);
			$copy = $master->createCopyLicense($customer);
			Mage::register('license_copy', $copy);
			
		}
	
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
		$this->_addContent($this->getLayout()->createBlock('bkg_license/adminhtml_test_search'));
			
		$this->renderLayout();
		return;
	}


}
