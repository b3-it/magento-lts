<?php

class Egovs_SepaDebitSax_Adminhtml_SepaDebitSax_MandateController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Return core session object
     *
     * @return Mage_Core_Model_Session
     */
    protected function _getSession() {
        return Mage::getSingleton('core/session');
    }

    /**
     * Return customer session object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getCustomerSession() {
    	return Mage::getSingleton('customer/session');
    }

 
    /**
     * Download link action
     */
    public function linkAction() {
    	
    	$mandateid = $this->getRequest()->getParam('mandateid'); 	
    	
    	
    	$sepa = Mage::getModel('sepadebitsax/sepadebitsax');
    	$mandat = $sepa->getMandateMitPdf($mandateid);
    	
    	
    	$pdfStream = $mandat->MandatPdf;
    	
    	try {
    		$this->_sendUploadResponse('Mandate.pdf', $pdfStream);
    		
    		exit(0);
    	}
    	catch (Exception $e) {
    		$this->_getSession()->addError(
    		Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
    		);
    	}
        
        return $this->_redirectError(Mage::getBaseUrl());
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
    
    
    public function syncAction()
    {
    	$m = Mage::getModel('sepadebitsax/cron');
    	$m->syncAll();
    }
    
    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('customer/manage');
    }
}
