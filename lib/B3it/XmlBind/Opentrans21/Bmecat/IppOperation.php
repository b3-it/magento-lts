<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppOperation
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppOperation extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOperationId */
	private $__IppOperationId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOperationType */
	private $__IppOperationType = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOperationDescr */
	private $__IppOperationDescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOutbound */
	private $__IppOutboundA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppInbound */
	private $__IppInboundA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperationId
	 */
	public function getIppOperationId()
	{
		if($this->__IppOperationId == null)
		{
			$this->__IppOperationId = new B3it_XmlBind_Opentrans21_Bmecat_IppOperationId();
		}
	
		return $this->__IppOperationId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOperationId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 */
	public function setIppOperationId($value)
	{
		$this->__IppOperationId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperationType
	 */
	public function getIppOperationType()
	{
		if($this->__IppOperationType == null)
		{
			$this->__IppOperationType = new B3it_XmlBind_Opentrans21_Bmecat_IppOperationType();
		}
	
		return $this->__IppOperationType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOperationType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 */
	public function setIppOperationType($value)
	{
		$this->__IppOperationType = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppOperationDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperationDescr
	 */
	public function getIppOperationDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppOperationDescr();
		$this->__IppOperationDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOperationDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 */
	public function setIppOperationDescr($value)
	{
		$this->__IppOperationDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperationDescr[]
	 */
	public function getAllIppOperationDescr()
	{
		return $this->__IppOperationDescrA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppOutbound and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutbound
	 */
	public function getIppOutbound()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppOutbound();
		$this->__IppOutboundA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOutbound
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 */
	public function setIppOutbound($value)
	{
		$this->__IppOutboundA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutbound[]
	 */
	public function getAllIppOutbound()
	{
		return $this->__IppOutboundA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppInbound and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInbound
	 */
	public function getIppInbound()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppInbound();
		$this->__IppInboundA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppInbound
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 */
	public function setIppInbound($value)
	{
		$this->__IppInboundA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInbound[]
	 */
	public function getAllIppInbound()
	{
		return $this->__IppInboundA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_OPERATION');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_OPERATION');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppOperationId != null){
			$this->__IppOperationId->toXml($xml);
		}
		if($this->__IppOperationType != null){
			$this->__IppOperationType->toXml($xml);
		}
		if($this->__IppOperationDescrA != null){
			foreach($this->__IppOperationDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__IppOutboundA != null){
			foreach($this->__IppOutboundA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__IppInboundA != null){
			foreach($this->__IppInboundA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
