<?php
/**
 * Sid ExportOrder
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Adminhtml_ExportController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Adminhtml_ExportOrder_ExportController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('export/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function showAction() {
		$id     = $this->getRequest()->getParam('id');
		
		$model  = Mage::getModel('sales/order')->load(intval($id));
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
		
			Mage::register('order', $model);
		
			$this->loadLayout();
			$this->_setActiveMenu('framecontract/export');
		
		
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		
			$this->_addContent($this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit'))
			->_addLeft($this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tabs'));
		
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
		
		

	}
	
	public function downloadAction() {
		$id     = $this->getRequest()->getParam('id');
		
		$order = Mage::getModel('sales/order')->load(intval($id));
		$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
		$vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());
		
		
		$format = $vendor->getExportFormatModel();
		$content = $format->processOrder($order);
    	
		$this->_sendUploadResponse($format->getFilename($order), $content);
    	
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
