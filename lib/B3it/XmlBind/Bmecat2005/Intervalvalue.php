<?php
class B3it_XmlBind_Bmecat2005_Intervalvalue extends B3it_XmlBind_Bmecat2005_Dtnumber
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
		 $node = new DOMElement('INTERVALVALUE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		parent::toXml($xml);


		return $xml;
	}
}