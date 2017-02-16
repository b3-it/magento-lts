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
		
		$config = Mage::getModel('core/config_data')->getCollection();
		$xml = new DOMDocument('1.0', 'UTF-8'); 
		$xml->preserveWhiteSpace = false;
		
		$xml_type = $xml->createElement( "config" );
		//$xml_type->setAttribute( "type", "core_config_data" );
		
		$xml->appendChild($xml_type);
		
		foreach($config->getItems() as $item){
			$xml_item = $xml->createElement( "core_config_data");
			$xml_type->appendChild($xml_item);
			
			$node = $xml->createElement( "scope",$item->getScope());
			$xml_item->appendChild($node);
			
			$node = $xml->createElement( "scope_id",$item->getScopeId());
			$xml_item->appendChild($node);
			
			$node = $xml->createElement( "path",$item->getPath());
			$xml_item->appendChild($node);
			
			
			$data = $xml->createCDATASection($item->getValue());
			$node = $xml->createElement("value");
			$node->appendChild($data);
			
			//$node = $xml->createElement("value", $item->getValue());
			$xml_item->appendChild($node);
			
		}
		
		$xml->formatOutput = true;
		$content = $xml->savexml();
		
		$this->_sendUploadResponse('core_config_data.xml', $content, $contentType='application/octet-stream');
		
	}


}