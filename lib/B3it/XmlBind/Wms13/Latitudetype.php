<?php

class B3it_XmlBind_Wms13_Latitudetype extends B3it_XmlBind_Wms13_XmlObject
{

	public function toXml($xml){
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}