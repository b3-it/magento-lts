<?php
class B3it_XmlBind_Bmecat12_PriceFlag extends B3it_XmlBind_Bmecat12_Dtboolean
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
		 $node = new DOMElement('PRICE_FLAG');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		parent::toXml($xml);

	$xml->nodeValue = $this->getValue();

		return $xml;
	}
}