<?php

class Bkg_VirtualAccess_Adminhtml_VirtualAccess_PurchasedController extends Mage_Adminhtml_Controller_action
{
	//TODO: HK andere action wählen
	protected $_publicActions = array('index');
	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sales/credential')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Credentials'), Mage::helper('adminhtml')->__('Credentials'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction();
	
		$this->renderLayout();
	}


    public function purchasedgridAction()
    {
       die($this->getLayout()->createBlock('virtualaccess/adminhtml_credential_edit_tab_purchased_grid')->toHtml());
    }
    
    public function syncAction()
    {
    	$id     =  intval($this->getRequest()->getParam('id'));
    	
    	$model  = Mage::getModel('virtualaccess/purchased')->load($id);
    	$model->sync();
    	$this->_redirect('*/*/');
    	return;
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('sales/purchased');
    			break;
    	}
    }
}