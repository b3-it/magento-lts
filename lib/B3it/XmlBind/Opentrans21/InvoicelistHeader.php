<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoicelistHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoicelistHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_InvoicelistInfo */
	private $__InvoicelistInfo = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoicelistInfo
	 */
	public function getInvoicelistInfo()
	{
		if($this->__InvoicelistInfo == null)
		{
			$this->__InvoicelistInfo = new B3it_XmlBind_Opentrans21_InvoicelistInfo();
		}
	
		return $this->__InvoicelistInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoicelistInfo
	 * @return B3it_XmlBind_Opentrans21_InvoicelistHeader
	 */
	public function setInvoicelistInfo($value)
	{
		$this->__InvoicelistInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICELIST_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__InvoicelistInfo != null){
			$this->__InvoicelistInfo->toXml($xml);
		}


		return $xml;
	}

}
