<?php

class Stala_Abo_Adminhtml_Stalaabo_DeliverController extends Egovs_Base_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('deliver/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_deliver'))
			->renderLayout();
	}

    public function gridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('stalaabo/adminhtml_deliver_grid')->toHtml());
    }

    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('stalaabo/deliver');
    			break;
    	}
    }
 
}