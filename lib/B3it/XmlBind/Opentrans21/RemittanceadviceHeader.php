<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RemittanceadviceHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RemittanceadviceHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceInfo */
	private $__RemittanceadviceInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function getRemittanceadviceInfo()
	{
		if($this->__RemittanceadviceInfo == null)
		{
			$this->__RemittanceadviceInfo = new B3it_XmlBind_Opentrans21_RemittanceadviceInfo();
		}
	
		return $this->__RemittanceadviceInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceHeader
	 */
	public function setRemittanceadviceInfo($value)
	{
		$this->__RemittanceadviceInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('REMITTANCEADVICE_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__RemittanceadviceInfo != null){
			$this->__RemittanceadviceInfo->toXml($xml);
		}


		return $xml;
	}

}
