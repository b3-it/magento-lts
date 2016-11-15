<?php
class B3it_XmlBind_Bmecat12_TypebuyerId extends B3it_XmlBind_Bmecat12_XmlBind
{

//Pattern
	private $_value = '';

	public function getValue(){
		return $this->_value;
	}

	public function setValue($value){
		$this->_value = $value;
		return $this->_value;
	}




	public function toXml($xml){
		$xml->nodeValue = $this->getValue();

		return $xml;
	}
}