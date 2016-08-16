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
class Bfr_Mach_Adminhtml_Mach_DownloadController extends Mage_Adminhtml_Controller_action
{


	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('history/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$lauf = $this->getRequest()->getParam('lauf');
		Mage::register('lauf', $lauf);
		$this->_initAction()
			->renderLayout();
	}

    
 	public function downloadKopfAction()
    {
 		$exportType = Bfr_Mach_Model_ExportType::TYPE_KOPF;
    	$lauf = $this->getRequest()->getParam('lauf');
    	$model = Mage::getModel('bfr_mach/export');
    	try {
    			$content = $model->loadData($lauf,$exportType);
    			$fileName = 'IRBelege_'.date('d_m_Y').'.csv';
    			$this->_sendUploadResponse($fileName, $content);
    			 
    	} catch (Exception $e) {
    			$this->_getSession()->addError($e->getMessage());
    	}
    	$model->updateHistory($lauf, $exportType);
    	die();
    }
    
    public function downloadPosAction()
    {
    	$exportType = Bfr_Mach_Model_ExportType::TYPE_POSITION;
    	$lauf = $this->getRequest()->getParam('lauf');
    	$model = Mage::getModel('bfr_mach/export');
    	try {
    
    		$content = $model->loadData($lauf,$exportType);
    		$fileName = 'IRPositionen'.date('d_m_Y').'.csv';
    		$this->_sendUploadResponse($fileName, $content);
    
    	} catch (Exception $e) {
    		$this->_getSession()->addError($e->getMessage());
    	}
    	$model->updateHistory($lauf, $exportType);
    	die();
    }
    
    
    public function downloadMappingAction()
    {
    	$exportType = Bfr_Mach_Model_ExportType::TYPE_ZUORDNUNG;
    	$lauf = $this->getRequest()->getParam('lauf');
    	$model = Mage::getModel('bfr_mach/export');
    	try {
    
    		$content = $model->loadData($lauf,$exportType);
    		$fileName = 'IRAObjZuordnung'. date('d_m_Y').'.csv';
    		$this->_sendUploadResponse($fileName, $content);
    
    	} catch (Exception $e) {
    		$this->_getSession()->addError($e->getMessage());
    	}
    	$model->updateHistory($lauf, $exportType);
    	die();
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
