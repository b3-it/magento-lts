<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Invoice
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Invoice extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceHeader */
	private $__InvoiceHeader = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceItemList */
	private $__InvoiceItemList = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceSummary */
	private $__InvoiceSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceHeader
	 */
	public function getInvoiceHeader()
	{
		if($this->__InvoiceHeader == null)
		{
			$this->__InvoiceHeader = new B3it_XmlBind_Opentrans21_InvoiceHeader();
		}
	
		return $this->__InvoiceHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceHeader
	 * @return B3it_XmlBind_Opentrans21_Invoice
	 */
	public function setInvoiceHeader($value)
	{
		$this->__InvoiceHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceItemList
	 */
	public function getInvoiceItemList()
	{
		if($this->__InvoiceItemList == null)
		{
			$this->__InvoiceItemList = new B3it_XmlBind_Opentrans21_InvoiceItemList();
		}
	
		return $this->__InvoiceItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceItemList
	 * @return B3it_XmlBind_Opentrans21_Invoice
	 */
	public function setInvoiceItemList($value)
	{
		$this->__InvoiceItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceSummary
	 */
	public function getInvoiceSummary()
	{
		if($this->__InvoiceSummary == null)
		{
			$this->__InvoiceSummary = new B3it_XmlBind_Opentrans21_InvoiceSummary();
		}
	
		return $this->__InvoiceSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceSummary
	 * @return B3it_XmlBind_Opentrans21_Invoice
	 */
	public function setInvoiceSummary($value)
	{
		$this->__InvoiceSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceHeader != null){
			$this->__InvoiceHeader->toXml($xml);
		}
		if($this->__InvoiceItemList != null){
			$this->__InvoiceItemList->toXml($xml);
		}
		if($this->__InvoiceSummary != null){
			$this->__InvoiceSummary->toXml($xml);
		}


		return $xml;
	}

}
