<?php
class B3it_XmlBind_Bmecat2005_AllowedValueShortname extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	public function getAttribute($name){
		if(isset($this->_attributes[$name])){
			 return $this->_attributes[$name];
		}
		return null;
	}

	public function setAttribute($name,$value){
		$this->_attributes[$name] = $value;
		return $this;
	}

	private $_value = '';

	public function getValue(){
		return $this->_value;
	}

	public function setValue($value){
		$this->_value = $value;
		return $this->_value;
	}

	public function toXml($xml){
		 $node = new DOMElement('ALLOWED_VALUE_SHORTNAME');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

	$xml->nodeValue = $this->getValue();

		return $xml;
	}
}