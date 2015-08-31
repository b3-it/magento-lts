<?php

class Stala_Abo_Adminhtml_Stalaabo_Contract_CustomerController extends Egovs_Base_Controller_Adminhtml_Abstract
{
    
    public function customerAction()
    {
    	$this->_initAction()
    		->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_contract_customer'))
			->renderLayout();
    }
    
    
    public function customerAjaxAction()
    {
 		$this->loadLayout();
 		$customer_id = $this->getRequest()->getParam('id','0');
 		Mage::getSingleton('adminhtml/session')->setData('customer_id', $customer_id);
    	$block = $this->getLayout()->createBlock('stalaabo/adminhtml_contract','',array('customer_id'=>$customer_id));
    	$this->getResponse()
    	 	->setBody($block->toHtml());
    }
    
    public function tabGridAction()
    {
    	$this->loadLayout();
    	$customer_id = $this->getRequest()->getParam('customer_id','0');
    	$block = $this->getLayout()->createBlock('stalaabo/adminhtml_contract_grid','',array('customer_id'=>$customer_id,'use_ajax'=>true));
    	//$block->setUseAjax(true);
    	$this->getResponse()
    	 	->setBody($block->toHtml());
    }
    
   public function exportCsvAction()
    {
        $fileName   = 'contract.csv';
        $content    = $this->getLayout()->createBlock('stalaabo/adminhtml_contract_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'contract.xml';
        $content    = $this->getLayout()->createBlock('stalaabo/adminhtml_contract_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('stalaabo/contract');
    			break;
    	}
    }
}