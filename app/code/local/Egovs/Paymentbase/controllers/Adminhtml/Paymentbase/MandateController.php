<?php

class Egovs_Paymentbase_Adminhtml_Paymentbase_MandateController extends Mage_Adminhtml_Controller_Action
{
	protected function _initCustomer($idFieldName = 'id')
	{
		$this->_title($this->__('Customers'))->_title($this->__('Manage Customers'));
	
		$customerId = (int) $this->getRequest()->getParam($idFieldName);
		$customer = Mage::getModel('customer/customer');
	
		if ($customerId) {
			$customer->load($customerId);
		}
		
		$mandateRef = (string) $this->getRequest()->getParam('reference');
		if ($mandateRef) {
			$customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandateRef);
		}
	
		Mage::register('current_customer', $customer);
		return $this;
	}
	
    /**
     * Return customer session object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getCustomerSession() {
    	if (Mage::app()->getStore()->isAdmin() || Mage::getDesign()->getArea() == 'adminhtml') {
    		Mage::getSingleton('core/session', array('name'=>'adminhtml'));
    		
    		/* @var $customer Mage_Customer_Model_Customer */
        	$customer = Mage::registry('current_customer');
    		$session =  Mage::getSingleton('admin/session');
    		$session->setCustomer($customer);
    		$session->setCustomerId($customer->getId());
    		return $session;
    	}
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
    	$this->_initCustomer();
    	if (!$this->_getCustomerSession()->isLoggedIn()) {
    		$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("Please login first!"));
    		return $this->_redirectError(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit', array('id' => $this->_getCustomerSession()->getCustomerId())));
    	}
    	
    	$basePath = Mage::helper('paymentbase')->getMandatePdfTemplateStore();
    	$file = Mage::helper('paymentbase')->getPdfMandateName($this->_getCustomerSession()->getCustomer());
    	$resource = Mage::helper('downloadable/file')->getFilePath(
    		$basePath, $file
    	);
    	$resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
    	$_referer = $this->_getRefererUrl();
    	
    	try {
    		$this->_processDownload($resource, $resourceType);
    		
    		exit(0);
    	}
    	catch (Exception $e) {
    		$this->_getSession()->addError(
    			Mage::helper('downloadable')->__("An error occurred while getting the requested content. Maybe the file doesn't exist anymore or access is denied.")
    		);
    	}
    	if ($_referer) {
    		return $this->_redirectError($_referer);
    	}
        
        return $this->_redirectError(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit', array('id' => $this->_getCustomerSession()->getCustomerId())));
    }
    
    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('customer/manage');
    }
}
