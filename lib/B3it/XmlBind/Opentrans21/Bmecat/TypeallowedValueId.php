<?php

class B3it_XmlBind_Opentrans21_Bmecat_TypeallowedValueId extends B3it_XmlBind_Opentrans21_Bmecat_Dtstring
{

	public function toXml($xml){
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
