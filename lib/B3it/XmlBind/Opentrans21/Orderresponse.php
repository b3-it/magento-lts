<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Orderresponse
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Orderresponse extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderresponseHeader */
	private $__OrderresponseHeader = null;

	/* @var B3it_XmlBind_Opentrans21_OrderresponseItemList */
	private $__OrderresponseItemList = null;

	/* @var B3it_XmlBind_Opentrans21_OrderresponseSummary */
	private $__OrderresponseSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderresponseHeader
	 */
	public function getOrderresponseHeader()
	{
		if($this->__OrderresponseHeader == null)
		{
			$this->__OrderresponseHeader = new B3it_XmlBind_Opentrans21_OrderresponseHeader();
		}
	
		return $this->__OrderresponseHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderresponseHeader
	 * @return B3it_XmlBind_Opentrans21_Orderresponse
	 */
	public function setOrderresponseHeader($value)
	{
		$this->__OrderresponseHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderresponseItemList
	 */
	public function getOrderresponseItemList()
	{
		if($this->__OrderresponseItemList == null)
		{
			$this->__OrderresponseItemList = new B3it_XmlBind_Opentrans21_OrderresponseItemList();
		}
	
		return $this->__OrderresponseItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderresponseItemList
	 * @return B3it_XmlBind_Opentrans21_Orderresponse
	 */
	public function setOrderresponseItemList($value)
	{
		$this->__OrderresponseItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderresponseSummary
	 */
	public function getOrderresponseSummary()
	{
		if($this->__OrderresponseSummary == null)
		{
			$this->__OrderresponseSummary = new B3it_XmlBind_Opentrans21_OrderresponseSummary();
		}
	
		return $this->__OrderresponseSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderresponseSummary
	 * @return B3it_XmlBind_Opentrans21_Orderresponse
	 */
	public function setOrderresponseSummary($value)
	{
		$this->__OrderresponseSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDERRESPONSE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderresponseHeader != null){
			$this->__OrderresponseHeader->toXml($xml);
		}
		if($this->__OrderresponseItemList != null){
			$this->__OrderresponseItemList->toXml($xml);
		}
		if($this->__OrderresponseSummary != null){
			$this->__OrderresponseSummary->toXml($xml);
		}


		return $xml;
	}

}
