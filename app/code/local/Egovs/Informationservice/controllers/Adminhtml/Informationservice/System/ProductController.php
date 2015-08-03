<?php

class Egovs_Informationservice_Adminhtml_Informationservice_System_ProductController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('requesttype/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Request Type'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
		->_addContent($this->getLayout()->createBlock('informationservice/adminhtml_system_product'))
			->renderLayout();
	}
	
	public function gridAction() {
		$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('informationservice/adminhtml_system_product_grid')->toHtml());
	}


 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) 
		{
			if((isset($data['master_product_id'])) &&(intval($data['master_product_id']) != 0))
			{
				Mage::getConfig()->saveConfig('informationservice/master_product_id',$data['master_product_id']);
				Mage::getConfig()->cleanCache();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('informationservice')->__('Master Product has been saved.'));
				$this->_redirect('*/*/');
				return;
			}
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('informationservice')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

}