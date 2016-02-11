<?php

class Egovs_SepaDebitSax_MandateController extends Mage_Core_Controller_Front_Action
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
    	if (!$this->_getCustomerSession()->isLoggedIn()) {
    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("Please login first!"));
    		return $this->_redirectError(Mage::getBaseUrl());
    	}
    	
    	
    	if($this->getRequest()->getParam('order_id'))
    	{
    		$order_id = $this->getRequest()->getParam('order_id');
    		$order = Mage::getModel('sales/order')->load($order_id);
    		if($order->getCustomerId() != $this->_getCustomerSession()->getCustomer()->getId())
    		{
    			$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
    			return $this->_redirectError(Mage::getBaseUrl());
    		}
    		$mandate_ref = $order->getPayment()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
    	}
    	else	
    	{  	
    		if (!$this->_getCustomerSession()->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
    			$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
    			return $this->_redirectError(Mage::getBaseUrl());
    		}	 
    		$mandate_ref = $this->_getCustomerSession()->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
    	}
    	
    	$sepa = Mage::getModel('sepadebitsax/sepadebitsax');
    	$mandat = $sepa->getMandateMitPdf($mandate_ref);
    	
    	
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
    
    
}
