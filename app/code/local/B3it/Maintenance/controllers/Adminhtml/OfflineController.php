<?php

class B3it_Maintenance_Adminhtml_OfflineController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/maintenance')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Report'), Mage::helper('b3it_maintenance')->__('Maintenance'));
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	
    
}