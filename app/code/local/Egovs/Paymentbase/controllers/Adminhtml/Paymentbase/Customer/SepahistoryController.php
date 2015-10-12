<?php
/**
 * Controller zum Anzeigen von SEPA History
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_Customer_SepahistoryController extends Mage_Adminhtml_Controller_Action
{
	
	

	public function gridAction() {
		
		$customer = Mage::getModel('customer/customer')->load(intval($this->getRequest()->getParam('customer_id'))); 
		if(!Mage::registry('current_customer'))
		{
			Mage::register('current_customer', $customer);
		}
		$this->loadLayout();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('*/paymentbase_customer_edit_tab_sepahistory_grid')->toHtml()
		);
	}
	
	
	
	public function pdfAction()
	{
		$customer = Mage::getModel('customer/customer')->load(intval($this->getRequest()->getParam('customer_id')));
		$mandate = $this->getRequest()->getParam('sepa_mandate_id');
		
		
		
		$basePath = Mage::helper('paymentbase')->getMandatePdfTemplateStore();
		$file = sha1($mandate.$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID));
		$file .= '.pdf';
		$resource = Mage::helper('downloadable/file')->getFilePath(
				$basePath, $file
		);
		$resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
		$_referer = $this->_getRefererUrl();
		 
		try {
			$this->_processDownload($resource, $resourceType, $mandate);
		
			exit(0);
		}
		catch (Exception $e) {
			$this->_getSession()->addError(
					Mage::helper('downloadable')->__("An error occurred while getting the requested content. Maybe the file doesn't exist anymore or access is denied.")
			);
		}
		
		
		/*
		 *
		*    	$hash = sha1($customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID).$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID));
		$hash .= '.pdf';
		*
		*/
	}
	
	protected function _processDownload($resource, $resourceType, $codisFilename)
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
	
		
			$codisFilename .= '.pdf';
			$this->getResponse()
			->setHeader('Content-Disposition', true . '; filename='.$codisFilename);
		
	
		$this->getResponse()
		->clearBody();
		$this->getResponse()
		->sendHeaders();
	
		$helper->output();
	}
	
	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('customer/manage');
	}
 
}