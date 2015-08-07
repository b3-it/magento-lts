<?php

class Egovs_Paymentbase_Sepa_MandateController extends Mage_Core_Controller_Front_Action
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

    protected function _processDownload($resource, $resourceType)
    {
        $helper = Mage::helper('downloadable/download');
        /* @var $helper Mage_Downloadable_Helper_Download */

        $helper->setResource($resource, $resourceType);

        $fileName       = $helper->getFilename();
        $contentType    = $helper->getContentType();

        $this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', $contentType, true);

        if ($fileSize = $helper->getFilesize()) {
            $this->getResponse()
                ->setHeader('Content-Length', $fileSize);
        }

        $customer = $this->_getCustomerSession()->getCustomer();
        if ($customer && $codisFilename = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
            $codisFilename .= '.pdf';
        	$this->getResponse()
                ->setHeader('Content-Disposition', true . '; filename='.$codisFilename);
        }

        $this->getResponse()
            ->clearBody();
        $this->getResponse()
            ->sendHeaders();

        $helper->output();
    }

    /**
     * Download link action
     */
    public function linkAction() {
    	if (!$this->_getCustomerSession()->isLoggedIn()) {
    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("Please login first!"));
    		return $this->_redirectError(Mage::getBaseUrl());
    	}
    	
    	if (!$this->_getCustomerSession()->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
    		return $this->_redirectError(Mage::getBaseUrl());
    	}
    	
    	$basePath = Mage::helper('paymentbase')->getMandatePdfTemplateStore();
    	$file = Mage::helper('paymentbase')->getPdfMandateName($this->_getCustomerSession()->getCustomer());
    	$resource = Mage::helper('downloadable/file')->getFilePath(
    		$basePath, $file
    	);
    	$resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
    	
    	try {
    		$this->_processDownload($resource, $resourceType);
    		
    		exit(0);
    	}
    	catch (Exception $e) {
    		$this->_getSession()->addError(
    		Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
    		);
    	}
        
        return $this->_redirectError(Mage::getBaseUrl());
    }
    
    
    /**
     * Für Anzeige der Mandate in der Betellung im Kundenkonto
     * @return Egovs_Paymentbase_Sepa_MandateController|boolean
     */
    public function linkaccountAction() {
    	if (!$this->_getCustomerSession()->isLoggedIn()) {
    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("Please login first!"));
    		return $this->_redirectError(Mage::getBaseUrl());
    	}
    	 
    	$order = Mage::getModel('sales/order')->load(intval($this->getRequest()->getParam('order_id')));
    	if($order->getId())
    	{
	    	$mandateRef = $order->getPayment()->getAdditionalInformation('mandate_reference');
	    
	    	if (!$mandateRef) {
	    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
	    		return $this->_redirectError(Mage::getBaseUrl());
	    	}
	    	 
	    	$customerId = $order->getCustomerId();
	    	if (!$customerId) {
	    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
	    		return $this->_redirectError(Mage::getBaseUrl());
	    	}
	    	 
	    	 
	    	if ($this->_getCustomerSession()->getCustomer()->getId() != $customerId) {
	    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
	    		return $this->_redirectError(Mage::getBaseUrl());
	    	}
    	}
    	else
    	{
    		if (!$this->_getCustomerSession()->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
    			$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("No mandate available!"));
    			return $this->_redirectError(Mage::getBaseUrl());
    		}else
    		{
    			$mandateRef = null;
    		}
    	}
    	$basePath = Mage::helper('paymentbase')->getMandatePdfTemplateStore();
    	$file = Mage::helper('paymentbase')->getPdfMandateName($this->_getCustomerSession()->getCustomer(), $mandateRef);
    	$resource = Mage::helper('downloadable/file')->getFilePath(
    			$basePath, $file
    	);
    	$resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
    	 
    	try {
    		$this->_processDownload($resource, $resourceType);
    
    		exit(0);
    	}
    	catch (Exception $e) {
    		$this->_getSession()->addError(
    				Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
    		);
    	}
    
    	return $this->_redirectError(Mage::getBaseUrl());
    }
}
