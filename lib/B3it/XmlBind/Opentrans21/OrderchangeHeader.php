<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderchangeHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderchangeHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_OrderchangeInfo */
	private $__OrderchangeInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_OrderchangeHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderchangeInfo
	 */
	public function getOrderchangeInfo()
	{
		if($this->__OrderchangeInfo == null)
		{
			$this->__OrderchangeInfo = new B3it_XmlBind_Opentrans21_OrderchangeInfo();
		}
	
		return $this->__OrderchangeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderchangeInfo
	 * @return B3it_XmlBind_Opentrans21_OrderchangeHeader
	 */
	public function setOrderchangeInfo($value)
	{
		$this->__OrderchangeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDERCHANGE_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__OrderchangeInfo != null){
			$this->__OrderchangeInfo->toXml($xml);
		}


		return $xml;
	}

}
