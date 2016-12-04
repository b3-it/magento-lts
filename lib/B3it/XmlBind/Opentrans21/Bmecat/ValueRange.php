<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ValueRange
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ValueRange extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Startvalue */
	private $__Startvalue = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Endvalue */
	private $__Endvalue = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Intervalvalue */
	private $__Intervalvalue = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Startvalue
	 */
	public function getStartvalue()
	{
		if($this->__Startvalue == null)
		{
			$this->__Startvalue = new B3it_XmlBind_Opentrans21_Bmecat_Startvalue();
		}
	
		return $this->__Startvalue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Startvalue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueRange
	 */
	public function setStartvalue($value)
	{
		$this->__Startvalue = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Endvalue
	 */
	public function getEndvalue()
	{
		if($this->__Endvalue == null)
		{
			$this->__Endvalue = new B3it_XmlBind_Opentrans21_Bmecat_Endvalue();
		}
	
		return $this->__Endvalue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Endvalue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueRange
	 */
	public function setEndvalue($value)
	{
		$this->__Endvalue = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Intervalvalue
	 */
	public function getIntervalvalue()
	{
		if($this->__Intervalvalue == null)
		{
			$this->__Intervalvalue = new B3it_XmlBind_Opentrans21_Bmecat_Intervalvalue();
		}
	
		return $this->__Intervalvalue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Intervalvalue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueRange
	 */
	public function setIntervalvalue($value)
	{
		$this->__Intervalvalue = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:VALUE_RANGE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:VALUE_RANGE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Startvalue != null){
			$this->__Startvalue->toXml($xml);
		}
		if($this->__Endvalue != null){
			$this->__Endvalue->toXml($xml);
		}
		if($this->__Intervalvalue != null){
			$this->__Intervalvalue->toXml($xml);
		}


		return $xml;
	}

}
