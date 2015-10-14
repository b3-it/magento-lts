<?php

class Egovs_Maintenance_Adminhtml_Maintenance_OfflineController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('system/maintenance')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Maintenance'), Mage::helper('adminhtml')->__('Maintenance'));
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	
    
}