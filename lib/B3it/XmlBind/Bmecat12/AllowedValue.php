<?php
class B3it_XmlBind_Bmecat12_AllowedValue extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var AllowedValueId */
	private $_AllowedValueId = null;	

	/* @var AllowedValueName */
	private $_AllowedValueName = null;	

	/* @var AllowedValueDescr */
	private $_AllowedValueDescr = null;	

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
	 * @return B3it_XmlBind_Bmecat12_AllowedValueId
	 */
	public function getAllowedValueId()
	{
		if($this->_AllowedValueId == null)
		{
			$this->_AllowedValueId = new B3it_XmlBind_Bmecat12_AllowedValueId();
		}
		
		return $this->_AllowedValueId;
	}
	
	/**
	 * @param $value AllowedValueId
	 * @return B3it_XmlBind_Bmecat12_AllowedValue extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAllowedValueId($value)
	{
		$this->_AllowedValueId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_AllowedValueName
	 */
	public function getAllowedValueName()
	{
		if($this->_AllowedValueName == null)
		{
			$this->_AllowedValueName = new B3it_XmlBind_Bmecat12_AllowedValueName();
		}
		
		return $this->_AllowedValueName;
	}
	
	/**
	 * @param $value AllowedValueName
	 * @return B3it_XmlBind_Bmecat12_AllowedValue extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAllowedValueName($value)
	{
		$this->_AllowedValueName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_AllowedValueDescr
	 */
	public function getAllowedValueDescr()
	{
		if($this->_AllowedValueDescr == null)
		{
			$this->_AllowedValueDescr = new B3it_XmlBind_Bmecat12_AllowedValueDescr();
		}
		
		return $this->_AllowedValueDescr;
	}
	
	/**
	 * @param $value AllowedValueDescr
	 * @return B3it_XmlBind_Bmecat12_AllowedValue extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAllowedValueDescr($value)
	{
		$this->_AllowedValueDescr = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ALLOWED_VALUE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AllowedValueId != null){
			$this->_AllowedValueId->toXml($xml);
		}
		if($this->_AllowedValueName != null){
			$this->_AllowedValueName->toXml($xml);
		}
		if($this->_AllowedValueDescr != null){
			$this->_AllowedValueDescr->toXml($xml);
		}


		return $xml;
	}
}