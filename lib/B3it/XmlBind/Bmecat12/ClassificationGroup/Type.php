<?php
class B3it_XmlBind_Bmecat12_ClassificationGroup_Type extends B3it_XmlBind_Bmecat12_XmlBind
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