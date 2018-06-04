<?php

class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsende extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{

	public function toXml($xml){
		$node = new DOMElement('vertragsende');
		$xml = $xml->appendChild($node);
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
