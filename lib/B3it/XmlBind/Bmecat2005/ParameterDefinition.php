<?php
class B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ParameterSymbol */
	private $_ParameterSymbol = null;	

	/* @var ParameterBasics */
	private $_ParameterBasics = null;	

	/* @var Fref */
	private $_Fref = null;	

	/* @var ParameterOrigin */
	private $_ParameterOrigin = null;	

	/* @var ParameterDefaultValue */
	private $_ParameterDefaultValue = null;	

	/* @var ParameterMeaning */
	private $_ParameterMeaning = null;	

	/* @var ParameterOrder */
	private $_ParameterOrder = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ParameterSymbol
	 */
	public function getParameterSymbol()
	{
		if($this->_ParameterSymbol == null)
		{
			$this->_ParameterSymbol = new B3it_XmlBind_Bmecat2005_ParameterSymbol();
		}
		
		return $this->_ParameterSymbol;
	}
	
	/**
	 * @param $value ParameterSymbol
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterSymbol($value)
	{
		$this->_ParameterSymbol = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterBasics
	 */
	public function getParameterBasics()
	{
		if($this->_ParameterBasics == null)
		{
			$this->_ParameterBasics = new B3it_XmlBind_Bmecat2005_ParameterBasics();
		}
		
		return $this->_ParameterBasics;
	}
	
	/**
	 * @param $value ParameterBasics
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterBasics($value)
	{
		$this->_ParameterBasics = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Fref
	 */
	public function getFref()
	{
		if($this->_Fref == null)
		{
			$this->_Fref = new B3it_XmlBind_Bmecat2005_Fref();
		}
		
		return $this->_Fref;
	}
	
	/**
	 * @param $value Fref
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFref($value)
	{
		$this->_Fref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterOrigin
	 */
	public function getParameterOrigin()
	{
		if($this->_ParameterOrigin == null)
		{
			$this->_ParameterOrigin = new B3it_XmlBind_Bmecat2005_ParameterOrigin();
		}
		
		return $this->_ParameterOrigin;
	}
	
	/**
	 * @param $value ParameterOrigin
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterOrigin($value)
	{
		$this->_ParameterOrigin = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefaultValue
	 */
	public function getParameterDefaultValue()
	{
		if($this->_ParameterDefaultValue == null)
		{
			$this->_ParameterDefaultValue = new B3it_XmlBind_Bmecat2005_ParameterDefaultValue();
		}
		
		return $this->_ParameterDefaultValue;
	}
	
	/**
	 * @param $value ParameterDefaultValue
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterDefaultValue($value)
	{
		$this->_ParameterDefaultValue = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterMeaning
	 */
	public function getParameterMeaning()
	{
		if($this->_ParameterMeaning == null)
		{
			$this->_ParameterMeaning = new B3it_XmlBind_Bmecat2005_ParameterMeaning();
		}
		
		return $this->_ParameterMeaning;
	}
	
	/**
	 * @param $value ParameterMeaning
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterMeaning($value)
	{
		$this->_ParameterMeaning = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterOrder
	 */
	public function getParameterOrder()
	{
		if($this->_ParameterOrder == null)
		{
			$this->_ParameterOrder = new B3it_XmlBind_Bmecat2005_ParameterOrder();
		}
		
		return $this->_ParameterOrder;
	}
	
	/**
	 * @param $value ParameterOrder
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterOrder($value)
	{
		$this->_ParameterOrder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARAMETER_DEFINITION');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ParameterSymbol != null){
			$this->_ParameterSymbol->toXml($xml);
		}
		if($this->_ParameterBasics != null){
			$this->_ParameterBasics->toXml($xml);
		}
		if($this->_Fref != null){
			$this->_Fref->toXml($xml);
		}
		if($this->_ParameterOrigin != null){
			$this->_ParameterOrigin->toXml($xml);
		}
		if($this->_ParameterDefaultValue != null){
			$this->_ParameterDefaultValue->toXml($xml);
		}
		if($this->_ParameterMeaning != null){
			$this->_ParameterMeaning->toXml($xml);
		}
		if($this->_ParameterOrder != null){
			$this->_ParameterOrder->toXml($xml);
		}


		return $xml;
	}
}