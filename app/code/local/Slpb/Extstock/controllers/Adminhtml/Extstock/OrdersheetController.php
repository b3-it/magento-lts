<?php

class Slpb_Extstock_Adminhtml_Extstock_OrdersheetController extends Mage_Adminhtml_Controller_Action
{
	private $_DeliveryId = null;
	
	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
        
		$this->loadLayout()
			->_setActiveMenu('extstock/journal')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Stock Journal'), Mage::helper('adminhtml')->__('Item Manager'));
        $block = $this->getLayout()->createBlock('extstock/adminhtml_ordersheet');
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
            $this->getLayout()->createBlock('extstock/adminhtml_ordersheet_grid')->toHtml()
        );
    }
 
    
    public function printAction()
    {
    	$OrderSheetsIds = $this->getRequest()->getParam('lieferid');
           	$pdf = Mage::getModel('extstock/ordersheet_pdf');
        	$pdf = $pdf->getPdf($OrderSheetsIds);
       
       return $this->_sendUploadResponse('Bestellschein'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
    }
	


    public function exportCsvAction()
    {
        $fileName   = 'journal.csv';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_journal_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'journal.xml';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_journal_grid')
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
    	return Mage::getSingleton('admin/session')->isAllowed('extstock/ordersheet');
    }
}