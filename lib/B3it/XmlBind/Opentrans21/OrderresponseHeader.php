<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderresponseHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderresponseHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_OrderresponseInfo */
	private $__OrderresponseInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function getOrderresponseInfo()
	{
		if($this->__OrderresponseInfo == null)
		{
			$this->__OrderresponseInfo = new B3it_XmlBind_Opentrans21_OrderresponseInfo();
		}
	
		return $this->__OrderresponseInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderresponseInfo
	 * @return B3it_XmlBind_Opentrans21_OrderresponseHeader
	 */
	public function setOrderresponseInfo($value)
	{
		$this->__OrderresponseInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDERRESPONSE_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__OrderresponseInfo != null){
			$this->__OrderresponseInfo->toXml($xml);
		}


		return $xml;
	}

}
