<?php
class B3it_XmlBind_Bmecat2005_ClassificationSystemLevelName extends B3it_XmlBind_Bmecat2005_Typemlstring00080
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
		 $node = new DOMElement('CLASSIFICATION_SYSTEM_LEVEL_NAME');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		parent::toXml($xml);



		return $xml;
	}
}