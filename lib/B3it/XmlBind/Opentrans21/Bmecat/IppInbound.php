<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppInbound
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppInbound extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppInboundFormat */
	private $__IppInboundFormat = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppInboundParams */
	private $__IppInboundParams = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppResponseTime */
	private $__IppResponseTime = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInboundFormat
	 */
	public function getIppInboundFormat()
	{
		if($this->__IppInboundFormat == null)
		{
			$this->__IppInboundFormat = new B3it_XmlBind_Opentrans21_Bmecat_IppInboundFormat();
		}
	
		return $this->__IppInboundFormat;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppInboundFormat
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInbound
	 */
	public function setIppInboundFormat($value)
	{
		$this->__IppInboundFormat = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInboundParams
	 */
	public function getIppInboundParams()
	{
		if($this->__IppInboundParams == null)
		{
			$this->__IppInboundParams = new B3it_XmlBind_Opentrans21_Bmecat_IppInboundParams();
		}
	
		return $this->__IppInboundParams;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppInboundParams
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInbound
	 */
	public function setIppInboundParams($value)
	{
		$this->__IppInboundParams = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppResponseTime
	 */
	public function getIppResponseTime()
	{
		if($this->__IppResponseTime == null)
		{
			$this->__IppResponseTime = new B3it_XmlBind_Opentrans21_Bmecat_IppResponseTime();
		}
	
		return $this->__IppResponseTime;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppResponseTime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInbound
	 */
	public function setIppResponseTime($value)
	{
		$this->__IppResponseTime = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_INBOUND');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_INBOUND');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppInboundFormat != null){
			$this->__IppInboundFormat->toXml($xml);
		}
		if($this->__IppInboundParams != null){
			$this->__IppInboundParams->toXml($xml);
		}
		if($this->__IppResponseTime != null){
			$this->__IppResponseTime->toXml($xml);
		}


		return $xml;
	}

}
