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
		$this->_title(Mage::helper('adminhtml')->__('Vendor Order'));
		$this->loadLayout()
			->_setActiveMenu('framecontract/export')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Framecontract'), Mage::helper('adminhtml')->__('Vendor Order'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function showAction() {
		$this->_initAction();
		$id     = $this->getRequest()->getParam('id');
		
		$model  = Mage::getModel('sales/order')->load(intval($id));
		
		if ($model->getId() || $id == 0) {
			Mage::register('order', $model);
		
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
	
	public function resendAction() {
		$id     = $this->getRequest()->getParam('id');
	
		$order = Mage::getModel('sales/order')->load((int)$id);
		$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
		$vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());
		/** @var \Sid_ExportOrder_Model_Transfer $transfer */
		$transfer = $vendor->getTransferModel();
		$export =  Mage::getModel('exportorder/order')->load((int)$id,'order_id');
		$format = $vendor->getExportFormatModel();
		$content = $format->processOrder($order);

		$msg = false;
		try {
            if ($transfer instanceof Sid_ExportOrder_Model_Transfer_Link) {
                $content = array($order->getIncrementId() => $content);
                $orderIds = array($order->getId());
                $msg = $transfer->sendOrders($content, $format, $orderIds, $vendor->getId(), $contract);
            } else {
                $transfer->setFormatModel($format);
                $data = array();
                $data['contract'] = $contract;
                $data['order'] = $order;
                $msg = $transfer->send($content, $order, $data);
            }
        } catch (Exception $e) {
		    Mage::logException($e);
        }

		if($msg === false)
		{
			$export->setMessage("Die Bestellung konnte nicht versendet werden!")
				->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_ERROR)
				->save();
			die($this->renderMessage('error',"Die Bestellung konnte nicht versendet werden!"));
		}
		else {
			$export->setMessage($msg)
			->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_SUCCESS)
			->save();
		}
		
		die($this->renderMessage('success',$msg));
	}

	public function downloadgridAction()
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sales/order')->load($id);
		 
		Mage::register('order', $model);
		 
		$this->loadLayout(false);
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_download')->toHtml()
				);
		 
	}
	
	public function exportgridAction()
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sales/order')->load($id);
			
		Mage::register('order', $model);
			
		$this->loadLayout(false);
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_export')->toHtml()
				);
			
	}
	
	public function historygridAction()
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sales/order')->load($id);
			
		Mage::register('order', $model);
			
		$this->loadLayout(false);
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_history')->toHtml()
				);
			
	}
	

	public function deleteLinkAction()
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sales/order')->load($id);
			
		Mage::register('order', $model);
		
		$linkid     = $this->getRequest()->getParam('linkid');
		$link = Mage::getModel('exportorder/link')->load($linkid);
		$link->deleteFile()
			->setLinkStatus(Sid_ExportOrder_Model_Linkstatus::STATUS_DISABLED)
			->save();
		
		//$link->delete();
		
		$this->loadLayout(false);
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_download')->toHtml()
				);
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
    
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('admin/framecontract/export');
    }
    
    
    protected function renderMessage($code,$text)
    {
    	return "<ul class=\"messages\"><li class=\"$code-msg\"><ul><li><span>$text</span></li></ul></li></ul>";
    }
    
}
