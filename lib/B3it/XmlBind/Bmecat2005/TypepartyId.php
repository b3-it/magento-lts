<?php
class B3it_XmlBind_Bmecat2005_TypepartyId extends B3it_XmlBind_Bmecat2005_Typestring00250
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


	public function toXml($xml){
		parent::toXml($xml);

	$xml->nodeValue = $this->getValue();
		return $xml;
	}
}