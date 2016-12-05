<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppParam
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppParam extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParamNameref */
	private $__IppParamNameref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParamValue */
	private $__IppParamValue = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamNameref
	 */
	public function getIppParamNameref()
	{
		if($this->__IppParamNameref == null)
		{
			$this->__IppParamNameref = new B3it_XmlBind_Opentrans21_Bmecat_IppParamNameref();
		}
	
		return $this->__IppParamNameref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParamNameref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParam
	 */
	public function setIppParamNameref($value)
	{
		$this->__IppParamNameref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamValue
	 */
	public function getIppParamValue()
	{
		if($this->__IppParamValue == null)
		{
			$this->__IppParamValue = new B3it_XmlBind_Opentrans21_Bmecat_IppParamValue();
		}
	
		return $this->__IppParamValue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParamValue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParam
	 */
	public function setIppParamValue($value)
	{
		$this->__IppParamValue = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PARAM');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PARAM');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppParamNameref != null){
			$this->__IppParamNameref->toXml($xml);
		}
		if($this->__IppParamValue != null){
			$this->__IppParamValue->toXml($xml);
		}


		return $xml;
	}

}
