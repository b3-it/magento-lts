<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Ipp
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Ipp extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppIdref */
	private $__IppIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOperationIdref */
	private $__IppOperationIdrefA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppResponseTime */
	private $__IppResponseTime = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppUri */
	private $__IppUriA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParam */
	private $__IppParamA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppIdref
	 */
	public function getIppIdref()
	{
		if($this->__IppIdref == null)
		{
			$this->__IppIdref = new B3it_XmlBind_Opentrans21_Bmecat_IppIdref();
		}
	
		return $this->__IppIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp
	 */
	public function setIppIdref($value)
	{
		$this->__IppIdref = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppOperationIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperationIdref
	 */
	public function getIppOperationIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppOperationIdref();
		$this->__IppOperationIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOperationIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp
	 */
	public function setIppOperationIdref($value)
	{
		$this->__IppOperationIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperationIdref[]
	 */
	public function getAllIppOperationIdref()
	{
		return $this->__IppOperationIdrefA;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp
	 */
	public function setIppResponseTime($value)
	{
		$this->__IppResponseTime = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp
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


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppParam and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParam
	 */
	public function getIppParam()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppParam();
		$this->__IppParamA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParam
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp
	 */
	public function setIppParam($value)
	{
		$this->__IppParamA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParam[]
	 */
	public function getAllIppParam()
	{
		return $this->__IppParamA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppIdref != null){
			$this->__IppIdref->toXml($xml);
		}
		if($this->__IppOperationIdrefA != null){
			foreach($this->__IppOperationIdrefA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__IppResponseTime != null){
			$this->__IppResponseTime->toXml($xml);
		}
		if($this->__IppUriA != null){
			foreach($this->__IppUriA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__IppParamA != null){
			foreach($this->__IppParamA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
