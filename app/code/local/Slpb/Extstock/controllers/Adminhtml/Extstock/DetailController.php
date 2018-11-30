<?php

class Slpb_Extstock_Adminhtml_Extstock_DetailController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
        
		$this->loadLayout()
			->_setActiveMenu('extstock/detail')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Stock Detail'), Mage::helper('adminhtml')->__('Item Manager'));
        $block = $this->getLayout()->createBlock('extstock/adminhtml_detail');
        $this->_addContent($block);		
		return $this;
	}   
 
	public function indexAction() {
	
		$this->_initAction()
			->renderLayout();
	}
	
	/**
     * Product grid for AJAX request
     */
    public function gridAction()
    {
    	$this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('extstock/adminhtml_detail_grid')->toHtml()
        );
    }
 

    public function exportCsvAction()
    {
        $fileName   = 'extstock.csv';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_detail_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'extstock.xml';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_detail_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    
    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('extstock/detail');
    }
}