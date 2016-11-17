<?php
class B3it_XmlBind_Bmecat2005_Parameter extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ParameterSymbolref */
	private $_ParameterSymbolref = null;	

	/* @var ParameterValue */
	private $_ParameterValue = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ParameterSymbolref
	 */
	public function getParameterSymbolref()
	{
		if($this->_ParameterSymbolref == null)
		{
			$this->_ParameterSymbolref = new B3it_XmlBind_Bmecat2005_ParameterSymbolref();
		}
		
		return $this->_ParameterSymbolref;
	}
	
	/**
	 * @param $value ParameterSymbolref
	 * @return B3it_XmlBind_Bmecat2005_Parameter extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterSymbolref($value)
	{
		$this->_ParameterSymbolref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterValue
	 */
	public function getParameterValue()
	{
		if($this->_ParameterValue == null)
		{
			$this->_ParameterValue = new B3it_XmlBind_Bmecat2005_ParameterValue();
		}
		
		return $this->_ParameterValue;
	}
	
	/**
	 * @param $value ParameterValue
	 * @return B3it_XmlBind_Bmecat2005_Parameter extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterValue($value)
	{
		$this->_ParameterValue = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARAMETER');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ParameterSymbolref != null){
			$this->_ParameterSymbolref->toXml($xml);
		}
		if($this->_ParameterValue != null){
			$this->_ParameterValue->toXml($xml);
		}


		return $xml;
	}
}