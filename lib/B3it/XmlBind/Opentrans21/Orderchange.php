<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Orderchange
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Orderchange extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderchangeHeader */
	private $__OrderchangeHeader = null;

	/* @var B3it_XmlBind_Opentrans21_OrderchangeItemList */
	private $__OrderchangeItemList = null;

	/* @var B3it_XmlBind_Opentrans21_OrderchangeSummary */
	private $__OrderchangeSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderchangeHeader
	 */
	public function getOrderchangeHeader()
	{
		if($this->__OrderchangeHeader == null)
		{
			$this->__OrderchangeHeader = new B3it_XmlBind_Opentrans21_OrderchangeHeader();
		}
	
		return $this->__OrderchangeHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderchangeHeader
	 * @return B3it_XmlBind_Opentrans21_Orderchange
	 */
	public function setOrderchangeHeader($value)
	{
		$this->__OrderchangeHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderchangeItemList
	 */
	public function getOrderchangeItemList()
	{
		if($this->__OrderchangeItemList == null)
		{
			$this->__OrderchangeItemList = new B3it_XmlBind_Opentrans21_OrderchangeItemList();
		}
	
		return $this->__OrderchangeItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderchangeItemList
	 * @return B3it_XmlBind_Opentrans21_Orderchange
	 */
	public function setOrderchangeItemList($value)
	{
		$this->__OrderchangeItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderchangeSummary
	 */
	public function getOrderchangeSummary()
	{
		if($this->__OrderchangeSummary == null)
		{
			$this->__OrderchangeSummary = new B3it_XmlBind_Opentrans21_OrderchangeSummary();
		}
	
		return $this->__OrderchangeSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderchangeSummary
	 * @return B3it_XmlBind_Opentrans21_Orderchange
	 */
	public function setOrderchangeSummary($value)
	{
		$this->__OrderchangeSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDERCHANGE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderchangeHeader != null){
			$this->__OrderchangeHeader->toXml($xml);
		}
		if($this->__OrderchangeItemList != null){
			$this->__OrderchangeItemList->toXml($xml);
		}
		if($this->__OrderchangeSummary != null){
			$this->__OrderchangeSummary->toXml($xml);
		}


		return $xml;
	}

}
