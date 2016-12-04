<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DispatchnotificationHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DispatchnotificationHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationInfo */
	private $__DispatchnotificationInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function getDispatchnotificationInfo()
	{
		if($this->__DispatchnotificationInfo == null)
		{
			$this->__DispatchnotificationInfo = new B3it_XmlBind_Opentrans21_DispatchnotificationInfo();
		}
	
		return $this->__DispatchnotificationInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationHeader
	 */
	public function setDispatchnotificationInfo($value)
	{
		$this->__DispatchnotificationInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DISPATCHNOTIFICATION_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__DispatchnotificationInfo != null){
			$this->__DispatchnotificationInfo->toXml($xml);
		}


		return $xml;
	}

}
