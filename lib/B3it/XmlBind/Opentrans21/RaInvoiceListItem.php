<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RaInvoiceListItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RaInvoiceListItem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceReference */
	private $__InvoiceReference = null;

	/* @var B3it_XmlBind_Opentrans21_OriginalInvoiceSummary */
	private $__OriginalInvoiceSummary = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceAdjustment */
	private $__InvoiceAdjustment = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function getInvoiceReference()
	{
		if($this->__InvoiceReference == null)
		{
			$this->__InvoiceReference = new B3it_XmlBind_Opentrans21_InvoiceReference();
		}
	
		return $this->__InvoiceReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceReference
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceListItem
	 */
	public function setInvoiceReference($value)
	{
		$this->__InvoiceReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OriginalInvoiceSummary
	 */
	public function getOriginalInvoiceSummary()
	{
		if($this->__OriginalInvoiceSummary == null)
		{
			$this->__OriginalInvoiceSummary = new B3it_XmlBind_Opentrans21_OriginalInvoiceSummary();
		}
	
		return $this->__OriginalInvoiceSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OriginalInvoiceSummary
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceListItem
	 */
	public function setOriginalInvoiceSummary($value)
	{
		$this->__OriginalInvoiceSummary = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceAdjustment
	 */
	public function getInvoiceAdjustment()
	{
		if($this->__InvoiceAdjustment == null)
		{
			$this->__InvoiceAdjustment = new B3it_XmlBind_Opentrans21_InvoiceAdjustment();
		}
	
		return $this->__InvoiceAdjustment;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceAdjustment
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceListItem
	 */
	public function setInvoiceAdjustment($value)
	{
		$this->__InvoiceAdjustment = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RA_INVOICE_LIST_ITEM');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceReference != null){
			$this->__InvoiceReference->toXml($xml);
		}
		if($this->__OriginalInvoiceSummary != null){
			$this->__OriginalInvoiceSummary->toXml($xml);
		}
		if($this->__InvoiceAdjustment != null){
			$this->__InvoiceAdjustment->toXml($xml);
		}


		return $xml;
	}

}
