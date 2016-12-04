<?php

class B3it_XmlBind_Opentrans21_Bmecat_Dttimetype extends B3it_XmlBind_Opentrans21_XmlObject
{

	public function toXml($xml){
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
