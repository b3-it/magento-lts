<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ParameterDefinition
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbol */
	private $__ParameterSymbol = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics */
	private $__ParameterBasics = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fref */
	private $__Fref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterOrigin */
	private $__ParameterOrigin = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterDefaultValue */
	private $__ParameterDefaultValue = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterMeaning */
	private $__ParameterMeaning = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterOrder */
	private $__ParameterOrder = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbol
	 */
	public function getParameterSymbol()
	{
		if($this->__ParameterSymbol == null)
		{
			$this->__ParameterSymbol = new B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbol();
		}
	
		return $this->__ParameterSymbol;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbol
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setParameterSymbol($value)
	{
		$this->__ParameterSymbol = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics
	 */
	public function getParameterBasics()
	{
		if($this->__ParameterBasics == null)
		{
			$this->__ParameterBasics = new B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics();
		}
	
		return $this->__ParameterBasics;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setParameterBasics($value)
	{
		$this->__ParameterBasics = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fref
	 */
	public function getFref()
	{
		if($this->__Fref == null)
		{
			$this->__Fref = new B3it_XmlBind_Opentrans21_Bmecat_Fref();
		}
	
		return $this->__Fref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setFref($value)
	{
		$this->__Fref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterOrigin
	 */
	public function getParameterOrigin()
	{
		if($this->__ParameterOrigin == null)
		{
			$this->__ParameterOrigin = new B3it_XmlBind_Opentrans21_Bmecat_ParameterOrigin();
		}
	
		return $this->__ParameterOrigin;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterOrigin
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setParameterOrigin($value)
	{
		$this->__ParameterOrigin = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefaultValue
	 */
	public function getParameterDefaultValue()
	{
		if($this->__ParameterDefaultValue == null)
		{
			$this->__ParameterDefaultValue = new B3it_XmlBind_Opentrans21_Bmecat_ParameterDefaultValue();
		}
	
		return $this->__ParameterDefaultValue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterDefaultValue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setParameterDefaultValue($value)
	{
		$this->__ParameterDefaultValue = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterMeaning
	 */
	public function getParameterMeaning()
	{
		if($this->__ParameterMeaning == null)
		{
			$this->__ParameterMeaning = new B3it_XmlBind_Opentrans21_Bmecat_ParameterMeaning();
		}
	
		return $this->__ParameterMeaning;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterMeaning
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setParameterMeaning($value)
	{
		$this->__ParameterMeaning = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterOrder
	 */
	public function getParameterOrder()
	{
		if($this->__ParameterOrder == null)
		{
			$this->__ParameterOrder = new B3it_XmlBind_Opentrans21_Bmecat_ParameterOrder();
		}
	
		return $this->__ParameterOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function setParameterOrder($value)
	{
		$this->__ParameterOrder = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER_DEFINITION');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER_DEFINITION');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ParameterSymbol != null){
			$this->__ParameterSymbol->toXml($xml);
		}
		if($this->__ParameterBasics != null){
			$this->__ParameterBasics->toXml($xml);
		}
		if($this->__Fref != null){
			$this->__Fref->toXml($xml);
		}
		if($this->__ParameterOrigin != null){
			$this->__ParameterOrigin->toXml($xml);
		}
		if($this->__ParameterDefaultValue != null){
			$this->__ParameterDefaultValue->toXml($xml);
		}
		if($this->__ParameterMeaning != null){
			$this->__ParameterMeaning->toXml($xml);
		}
		if($this->__ParameterOrder != null){
			$this->__ParameterOrder->toXml($xml);
		}


		return $xml;
	}

}
