<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_SourcingInfo */
	private $__SourcingInfo = null;

	/* @var B3it_XmlBind_Opentrans21_OrderInfo */
	private $__OrderInfo = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ControlInfo
	 */
	public function getControlInfo()
	{
		if($this->__ControlInfo == null)
		{
			$this->__ControlInfo = new B3it_XmlBind_Opentrans21_ControlInfo();
		}
	
		return $this->__ControlInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ControlInfo
	 * @return B3it_XmlBind_Opentrans21_OrderHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SourcingInfo
	 */
	public function getSourcingInfo()
	{
		if($this->__SourcingInfo == null)
		{
			$this->__SourcingInfo = new B3it_XmlBind_Opentrans21_SourcingInfo();
		}
	
		return $this->__SourcingInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SourcingInfo
	 * @return B3it_XmlBind_Opentrans21_OrderHeader
	 */
	public function setSourcingInfo($value)
	{
		$this->__SourcingInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderInfo
	 */
	public function getOrderInfo()
	{
		if($this->__OrderInfo == null)
		{
			$this->__OrderInfo = new B3it_XmlBind_Opentrans21_OrderInfo();
		}
	
		return $this->__OrderInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderInfo
	 * @return B3it_XmlBind_Opentrans21_OrderHeader
	 */
	public function setOrderInfo($value)
	{
		$this->__OrderInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDER_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__SourcingInfo != null){
			$this->__SourcingInfo->toXml($xml);
		}
		if($this->__OrderInfo != null){
			$this->__OrderInfo->toXml($xml);
		}


		return $xml;
	}

}
