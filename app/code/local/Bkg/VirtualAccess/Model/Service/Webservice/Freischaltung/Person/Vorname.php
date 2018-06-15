<?php

class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Vorname extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{

	public function toXml($xml){
		$node = new DOMElement('vorname');
		$xml = $xml->appendChild($node);
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
