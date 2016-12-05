<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Order extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderHeader */
	private $__OrderHeader = null;

	/* @var B3it_XmlBind_Opentrans21_OrderItemList */
	private $__OrderItemList = null;

	/* @var B3it_XmlBind_Opentrans21_OrderSummary */
	private $__OrderSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderHeader
	 */
	public function getOrderHeader()
	{
		if($this->__OrderHeader == null)
		{
			$this->__OrderHeader = new B3it_XmlBind_Opentrans21_OrderHeader();
		}
	
		return $this->__OrderHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderHeader
	 * @return B3it_XmlBind_Opentrans21_Order
	 */
	public function setOrderHeader($value)
	{
		$this->__OrderHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderItemList
	 */
	public function getOrderItemList()
	{
		if($this->__OrderItemList == null)
		{
			$this->__OrderItemList = new B3it_XmlBind_Opentrans21_OrderItemList();
		}
	
		return $this->__OrderItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderItemList
	 * @return B3it_XmlBind_Opentrans21_Order
	 */
	public function setOrderItemList($value)
	{
		$this->__OrderItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderSummary
	 */
	public function getOrderSummary()
	{
		if($this->__OrderSummary == null)
		{
			$this->__OrderSummary = new B3it_XmlBind_Opentrans21_OrderSummary();
		}
	
		return $this->__OrderSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderSummary
	 * @return B3it_XmlBind_Opentrans21_Order
	 */
	public function setOrderSummary($value)
	{
		$this->__OrderSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = $xml->createElementNS('http://www.opentrans.org/XMLSchema/2.1', 'ORDER');
    	$node->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:bmecat','http://www.bmecat.org/bmecat/2005');
    	$node->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xmime','http://www.w3.org/2005/05/xmlmime');
		
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderHeader != null){
			$this->__OrderHeader->toXml($xml);
		}
		if($this->__OrderItemList != null){
			$this->__OrderItemList->toXml($xml);
		}
		if($this->__OrderSummary != null){
			$this->__OrderSummary->toXml($xml);
		}


		return $xml;
	}

}
