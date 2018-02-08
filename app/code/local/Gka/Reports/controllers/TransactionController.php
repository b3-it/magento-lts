<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_TransactionController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
      
      $this->loadLayout();
      $this->renderLayout();
    }
    
    
 	public function gridAction()
    {
    	if(!$this->_validateFormKey()){
    		$this->_redirect('customer/account/logout');
    		return;
    	}
        $this->loadLayout(false);
        $this->getResponse()->setBody(
        		$this->getLayout()->createBlock('gka_reports/transaction_grid')->toHtml()
        );
    }
    
    public function exportCsvAction()
    {
    	$fileName   = 'kassenbuchjournal.csv';
    	$content    = $this->getLayout()->createBlock('gka_reports/transaction_grid')
    	->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportXmlAction()
    {
    	$fileName   = 'kassenbuchjournal.xml';
    	$content    = $this->getLayout()->createBlock('gka_reports/transaction_grid')
    	->getXml();
    
    	$this->_sendUploadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName   = 'report.xls';
        $content    = $this->getLayout()->createBlock('gka_reports/transaction_grid')
            ->getExcel($fileName);
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
}