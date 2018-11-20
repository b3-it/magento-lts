<?php

class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Service extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{

	public function toXml($xml){
		$node = new DOMElement('service');
		$xml = $xml->appendChild($node);
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
