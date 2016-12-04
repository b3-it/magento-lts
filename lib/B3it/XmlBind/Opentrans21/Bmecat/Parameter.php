<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Parameter
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Parameter extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbolref */
	private $__ParameterSymbolref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterValue */
	private $__ParameterValue = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbolref
	 */
	public function getParameterSymbolref()
	{
		if($this->__ParameterSymbolref == null)
		{
			$this->__ParameterSymbolref = new B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbolref();
		}
	
		return $this->__ParameterSymbolref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterSymbolref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parameter
	 */
	public function setParameterSymbolref($value)
	{
		$this->__ParameterSymbolref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterValue
	 */
	public function getParameterValue()
	{
		if($this->__ParameterValue == null)
		{
			$this->__ParameterValue = new B3it_XmlBind_Opentrans21_Bmecat_ParameterValue();
		}
	
		return $this->__ParameterValue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterValue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parameter
	 */
	public function setParameterValue($value)
	{
		$this->__ParameterValue = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ParameterSymbolref != null){
			$this->__ParameterSymbolref->toXml($xml);
		}
		if($this->__ParameterValue != null){
			$this->__ParameterValue->toXml($xml);
		}


		return $xml;
	}

}
