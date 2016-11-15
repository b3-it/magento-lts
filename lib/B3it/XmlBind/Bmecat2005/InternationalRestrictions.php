<?php
class B3it_XmlBind_Bmecat2005_InternationalRestrictions extends B3it_XmlBind_Bmecat2005_Typestring00250
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
		 $node = new DOMElement('INTERNATIONAL_RESTRICTIONS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		parent::toXml($xml);

	$xml->nodeValue = $this->getValue();

		return $xml;
	}
}