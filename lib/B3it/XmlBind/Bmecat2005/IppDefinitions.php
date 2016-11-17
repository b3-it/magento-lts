<?php
class B3it_XmlBind_Bmecat2005_IppDefinitions extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppDefinition */
	private $_IppDefinitions = array();	

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



	/**
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition[]
	 */
	public function getAllIppDefinition()
	{
		return $this->_IppDefinitions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppDefinition and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition
	 */
	public function getIppDefinition()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppDefinition();
		$this->_IppDefinitions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppDefinition[]
	 * @return B3it_XmlBind_Bmecat2005_IppDefinitions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppDefinition($value)
	{
		$this->_IppDefinition = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_DEFINITIONS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppDefinitions != null){
			foreach($this->_IppDefinitions as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}