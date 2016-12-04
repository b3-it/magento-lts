<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoiceHeader
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoiceHeader extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ControlInfo */
	private $__ControlInfo = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceInfo */
	private $__InvoiceInfo = null;

	/* @var B3it_XmlBind_Opentrans21_OrderHistory */
	private $__OrderHistory = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_InvoiceHeader
	 */
	public function setControlInfo($value)
	{
		$this->__ControlInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceInfo
	 */
	public function getInvoiceInfo()
	{
		if($this->__InvoiceInfo == null)
		{
			$this->__InvoiceInfo = new B3it_XmlBind_Opentrans21_InvoiceInfo();
		}
	
		return $this->__InvoiceInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceInfo
	 * @return B3it_XmlBind_Opentrans21_InvoiceHeader
	 */
	public function setInvoiceInfo($value)
	{
		$this->__InvoiceInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function getOrderHistory()
	{
		if($this->__OrderHistory == null)
		{
			$this->__OrderHistory = new B3it_XmlBind_Opentrans21_OrderHistory();
		}
	
		return $this->__OrderHistory;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderHistory
	 * @return B3it_XmlBind_Opentrans21_InvoiceHeader
	 */
	public function setOrderHistory($value)
	{
		$this->__OrderHistory = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICE_HEADER');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ControlInfo != null){
			$this->__ControlInfo->toXml($xml);
		}
		if($this->__InvoiceInfo != null){
			$this->__InvoiceInfo->toXml($xml);
		}
		if($this->__OrderHistory != null){
			$this->__OrderHistory->toXml($xml);
		}


		return $xml;
	}

}
