<?php

class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_PersonId extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{

	public function toXml($xml){
		$node = new DOMElement('person_id');
		$xml = $xml->appendChild($node);
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
