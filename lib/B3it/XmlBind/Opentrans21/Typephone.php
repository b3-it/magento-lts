<?php

class B3it_XmlBind_Opentrans21_Typephone extends B3it_XmlBind_Opentrans21_Bmecat_Dtstring
{

	public function toXml($xml){
		$xml = $this->addValueToXml($xml);
		return $xml;
	}

}
