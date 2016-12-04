<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Invoicelist
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Invoicelist extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoicelistHeader */
	private $__InvoicelistHeader = null;

	/* @var B3it_XmlBind_Opentrans21_InvoicelistItemList */
	private $__InvoicelistItemList = null;

	/* @var B3it_XmlBind_Opentrans21_InvoicelistSummary */
	private $__InvoicelistSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoicelistHeader
	 */
	public function getInvoicelistHeader()
	{
		if($this->__InvoicelistHeader == null)
		{
			$this->__InvoicelistHeader = new B3it_XmlBind_Opentrans21_InvoicelistHeader();
		}
	
		return $this->__InvoicelistHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoicelistHeader
	 * @return B3it_XmlBind_Opentrans21_Invoicelist
	 */
	public function setInvoicelistHeader($value)
	{
		$this->__InvoicelistHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItemList
	 */
	public function getInvoicelistItemList()
	{
		if($this->__InvoicelistItemList == null)
		{
			$this->__InvoicelistItemList = new B3it_XmlBind_Opentrans21_InvoicelistItemList();
		}
	
		return $this->__InvoicelistItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoicelistItemList
	 * @return B3it_XmlBind_Opentrans21_Invoicelist
	 */
	public function setInvoicelistItemList($value)
	{
		$this->__InvoicelistItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoicelistSummary
	 */
	public function getInvoicelistSummary()
	{
		if($this->__InvoicelistSummary == null)
		{
			$this->__InvoicelistSummary = new B3it_XmlBind_Opentrans21_InvoicelistSummary();
		}
	
		return $this->__InvoicelistSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoicelistSummary
	 * @return B3it_XmlBind_Opentrans21_Invoicelist
	 */
	public function setInvoicelistSummary($value)
	{
		$this->__InvoicelistSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICELIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoicelistHeader != null){
			$this->__InvoicelistHeader->toXml($xml);
		}
		if($this->__InvoicelistItemList != null){
			$this->__InvoicelistItemList->toXml($xml);
		}
		if($this->__InvoicelistSummary != null){
			$this->__InvoicelistSummary->toXml($xml);
		}


		return $xml;
	}

}
