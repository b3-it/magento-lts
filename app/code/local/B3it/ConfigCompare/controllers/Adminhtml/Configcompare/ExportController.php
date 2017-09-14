<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Adminhtml_Configcompare_ExportController extends B3it_ConfigCompare_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout();
		
		return $this;
	}   
 
	public function indexAction() {
		
		$this->_initAction();
		$this->renderLayout();
		return $this;
		
	}
	
	public function exportAction() {
	
		$storeId = intval($this->getRequest()->getParam('store_id',0));
	
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->preserveWhiteSpace = false;
	
		$xml_config = $xml->createElement( "config" );
		$xml->appendChild($xml_config);
	
		Mage::getModel('configcompare/coreConfigData')->setStoreId($storeId)->export($xml, $xml_config, "core_config_data");
		Mage::getModel('configcompare/cmsPages')->setStoreId($storeId)->export($xml, $xml_config, "cms_page");
		Mage::getModel('configcompare/cmsBlocks')->setStoreId($storeId)->export($xml, $xml_config, "cms_block");
		Mage::getModel('configcompare/pdfSections')->setStoreId($storeId)->export($xml, $xml_config, "pdf_section");
		Mage::getModel('configcompare/pdfBlocks')->setStoreId($storeId)->export($xml, $xml_config, "pdf_block");
		Mage::getModel('configcompare/emailTemplates')->setStoreId($storeId)->export($xml, $xml_config, "email_template");
		Mage::getModel('configcompare/taxCalculations')->setStoreId($storeId)->export($xml, $xml_config, "tax_calculation");
	
	
		$xml->formatOutput = true;
		$content = $xml->savexml();
		//echo '<pre>'; die($content);
		$this->_sendUploadResponse('config_data.xml', $content, $contentType='application/octet-stream');
	
	}
	


}