<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppOutbound
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppOutbound extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOutboundFormat */
	private $__IppOutboundFormat = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams */
	private $__IppOutboundParams = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppUri */
	private $__IppUriA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundFormat
	 */
	public function getIppOutboundFormat()
	{
		if($this->__IppOutboundFormat == null)
		{
			$this->__IppOutboundFormat = new B3it_XmlBind_Opentrans21_Bmecat_IppOutboundFormat();
		}
	
		return $this->__IppOutboundFormat;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOutboundFormat
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutbound
	 */
	public function setIppOutboundFormat($value)
	{
		$this->__IppOutboundFormat = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function getIppOutboundParams()
	{
		if($this->__IppOutboundParams == null)
		{
			$this->__IppOutboundParams = new B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams();
		}
	
		return $this->__IppOutboundParams;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutbound
	 */
	public function setIppOutboundParams($value)
	{
		$this->__IppOutboundParams = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppUri and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppUri
	 */
	public function getIppUri()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppUri();
		$this->__IppUriA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppUri
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutbound
	 */
	public function setIppUri($value)
	{
		$this->__IppUriA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppUri[]
	 */
	public function getAllIppUri()
	{
		return $this->__IppUriA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_OUTBOUND');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_OUTBOUND');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppOutboundFormat != null){
			$this->__IppOutboundFormat->toXml($xml);
		}
		if($this->__IppOutboundParams != null){
			$this->__IppOutboundParams->toXml($xml);
		}
		if($this->__IppUriA != null){
			foreach($this->__IppUriA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
