<?php
class B3it_XmlBind_Bmecat2005_IppProductconfigIdref extends B3it_XmlBind_Bmecat2005_XmlBind
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
		 $node = new DOMElement('IPP_PRODUCTCONFIG_IDREF');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}



		return $xml;
	}
}