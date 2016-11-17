<?php
class B3it_XmlBind_Bmecat2005_IppInboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppParamDefinition */
	private $_IppParamDefinitions = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppParamDefinition[]
	 */
	public function getAllIppParamDefinition()
	{
		return $this->_IppParamDefinitions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppParamDefinition and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppParamDefinition
	 */
	public function getIppParamDefinition()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppParamDefinition();
		$this->_IppParamDefinitions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppParamDefinition[]
	 * @return B3it_XmlBind_Bmecat2005_IppInboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParamDefinition($value)
	{
		$this->_IppParamDefinition = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_INBOUND_PARAMS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppParamDefinitions != null){
			foreach($this->_IppParamDefinitions as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}