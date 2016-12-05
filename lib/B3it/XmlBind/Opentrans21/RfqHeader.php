<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RfqHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RfqHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_RfqInfo */
	private $__RfqInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_RfqHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RfqInfo
	 */
	public function getRfqInfo()
	{
		if($this->__RfqInfo == null)
		{
			$this->__RfqInfo = new B3it_XmlBind_Opentrans21_RfqInfo();
		}
	
		return $this->__RfqInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RfqInfo
	 * @return B3it_XmlBind_Opentrans21_RfqHeader
	 */
	public function setRfqInfo($value)
	{
		$this->__RfqInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RFQ_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__RfqInfo != null){
			$this->__RfqInfo->toXml($xml);
		}


		return $xml;
	}

}
