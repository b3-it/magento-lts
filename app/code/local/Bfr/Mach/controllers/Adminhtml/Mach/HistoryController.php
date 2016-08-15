<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Adminhtml_HistoryController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Adminhtml_Mach_HistoryController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('history/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

    
    public function exportHeadAction()
    {
    	$orderIds = $this->getRequest()->getParam('order_id');
    	if(!is_array($orderIds)) {
    		Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    	} else {
    			$model = Mage::getModel('bfr_mach/export_head');
    		try {
    			
    			$content = $model->getData4Order($orderIds);
    			$fileName = date('d_m_Y').'_kopf.csv';
    			$this->_sendUploadResponse($fileName, $content);
    			
    		} catch (Exception $e) {
    			$this->_getSession()->addError($e->getMessage());
    		}
    		$model->saveHistory();
    		die();
    	}
    	$this->_redirect('*/*/index');
    }
    
    public function exportPosAction()
    {
    	$orderIds = $this->getRequest()->getParam('order_id');
    	if(!is_array($orderIds)) {
    		Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    	} else {
    		$model = Mage::getModel('bfr_mach/export_pos');
    		try {
    			 
    			$content = $model->getData4Order($orderIds);
    			$fileName = date('d_m_Y').'_pos.csv';
    			$this->_sendUploadResponse($fileName, $content);
    			 
    		} catch (Exception $e) {
    			$this->_getSession()->addError($e->getMessage());
    		}
    		$model->saveHistory();
    		die();
    	}
    	$this->_redirect('*/*/index');
    }
    
    public function exportMappingAction()
    {
    	$orderIds = $this->getRequest()->getParam('order_id');
    	if(!is_array($orderIds)) {
    		Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    	} else {
    		$model = Mage::getModel('bfr_mach/export_mapping');
    		try {
    			 
    			$content = $model->getData4Order($orderIds);
    			$fileName = date('d_m_Y').'_zuordnung.csv';
    			$this->_sendUploadResponse($fileName, $content);
    			 
    		} catch (Exception $e) {
    			$this->_getSession()->addError($e->getMessage());
    		}
    		$model->saveHistory();
    		die();
    	}
    	$this->_redirect('*/*/index');
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
        
    }
}
