<?php
class B3it_XmlBind_Bmecat2005_IppParam extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppParamNameref */
	private $_IppParamNameref = null;	

	/* @var IppParamValue */
	private $_IppParamValue = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_IppParamNameref
	 */
	public function getIppParamNameref()
	{
		if($this->_IppParamNameref == null)
		{
			$this->_IppParamNameref = new B3it_XmlBind_Bmecat2005_IppParamNameref();
		}
		
		return $this->_IppParamNameref;
	}
	
	/**
	 * @param $value IppParamNameref
	 * @return B3it_XmlBind_Bmecat2005_IppParam extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParamNameref($value)
	{
		$this->_IppParamNameref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppParamValue
	 */
	public function getIppParamValue()
	{
		if($this->_IppParamValue == null)
		{
			$this->_IppParamValue = new B3it_XmlBind_Bmecat2005_IppParamValue();
		}
		
		return $this->_IppParamValue;
	}
	
	/**
	 * @param $value IppParamValue
	 * @return B3it_XmlBind_Bmecat2005_IppParam extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParamValue($value)
	{
		$this->_IppParamValue = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_PARAM');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppParamNameref != null){
			$this->_IppParamNameref->toXml($xml);
		}
		if($this->_IppParamValue != null){
			$this->_IppParamValue->toXml($xml);
		}


		return $xml;
	}
}