<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	QuotationHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_QuotationHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_QuotationInfo */
	private $__QuotationInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_QuotationHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function getQuotationInfo()
	{
		if($this->__QuotationInfo == null)
		{
			$this->__QuotationInfo = new B3it_XmlBind_Opentrans21_QuotationInfo();
		}
	
		return $this->__QuotationInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationInfo
	 * @return B3it_XmlBind_Opentrans21_QuotationHeader
	 */
	public function setQuotationInfo($value)
	{
		$this->__QuotationInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('QUOTATION_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__QuotationInfo != null){
			$this->__QuotationInfo->toXml($xml);
		}


		return $xml;
	}

}
