<?php
/**
 *
 * @category   	Dwd Fix
 * @package    	Dwd_Fix
 * @name        Dwd_Fix_Adminhtml_Fix_Rechnung_RechnungController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Fix_Adminhtml_Fix_Rechnung_RechnungController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('rechnungrechnung/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Rechnung Manager'), Mage::helper('adminhtml')->__('Rechnung Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Rechnung Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	
	public function newAction() {
		
		$model  = Mage::getModel('dwd_fix/rechnung_rechnung')->process();
		$this->_forward('index');
	}


	public function exportCsvAction()
	{
		$fileName   = 'send_invoices.csv';
		$content    = $this->getLayout()->createBlock('dwd_fix/adminhtml_rechnung_rechnung_grid')
		->getCsv();
	
		$this->_sendUploadResponse($fileName, $content);
	}
	
	public function exportXmlAction()
	{
		$fileName   = 'send_invoices.xml';
		$content    = $this->getLayout()->createBlock('dwd_fix/adminhtml_rechnung_rechnung_grid')
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
}
