<?php
class B3it_XmlBind_Bmecat2005_ParameterDefinitions extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ParameterDefinition */
	private $_ParameterDefinitions = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition[]
	 */
	public function getAllParameterDefinition()
	{
		return $this->_ParameterDefinitions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ParameterDefinition and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition
	 */
	public function getParameterDefinition()
	{
		$res = new B3it_XmlBind_Bmecat2005_ParameterDefinition();
		$this->_ParameterDefinitions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ParameterDefinition[]
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinitions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterDefinition($value)
	{
		$this->_ParameterDefinition = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARAMETER_DEFINITIONS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ParameterDefinitions != null){
			foreach($this->_ParameterDefinitions as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}