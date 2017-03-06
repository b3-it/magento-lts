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
class B3it_ConfigCompare_Adminhtml_Configcompare_Export_CoreconfigdataController extends B3it_ConfigCompare_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout();
		
		return $this;
	}   
 
	public function indexAction() {
		
		
		$xml = new DOMDocument('1.0', 'UTF-8'); 
		$xml->preserveWhiteSpace = false;
		
		$xml_config = $xml->createElement( "config" );
		$xml->appendChild($xml_config);
		
		Mage::getModel('configcompare/coreConfigData')->export($xml, $xml_config, "core_config_data");
		Mage::getModel('configcompare/cmsPages')->export($xml, $xml_config, "cms_page");
		Mage::getModel('configcompare/cmsBlocks')->export($xml, $xml_config, "cms_block");
		Mage::getModel('configcompare/pdfSections')->export($xml, $xml_config, "pdf_section");
		Mage::getModel('configcompare/pdfBlocks')->export($xml, $xml_config, "pdf_block");
		Mage::getModel('configcompare/emailTemplates')->export($xml, $xml_config, "email_template");
		Mage::getModel('configcompare/taxCalculations')->export($xml, $xml_config, "tax_calculation");
		
		
		$xml->formatOutput = true;
		$content = $xml->savexml();
		//echo '<pre>'; die($content);
		$this->_sendUploadResponse('config_data.xml', $content, $contentType='application/octet-stream');
		
	}
	


}