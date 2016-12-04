<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoiceReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoiceReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceId */
	private $__InvoiceId = null;

	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceDate */
	private $__InvoiceDate = null;

	/* @var B3it_XmlBind_Opentrans21_PostDate */
	private $__PostDate = null;

	/* @var B3it_XmlBind_Opentrans21_ReasonForTransfer */
	private $__ReasonForTransfer = null;

	
	/* @var B3it_XmlBind_Opentrans21_InvoiceDescr */
	private $__InvoiceDescrA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceId
	 */
	public function getInvoiceId()
	{
		if($this->__InvoiceId == null)
		{
			$this->__InvoiceId = new B3it_XmlBind_Opentrans21_InvoiceId();
		}
	
		return $this->__InvoiceId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceId
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function setInvoiceId($value)
	{
		$this->__InvoiceId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_LineItemId
	 */
	public function getLineItemId()
	{
		if($this->__LineItemId == null)
		{
			$this->__LineItemId = new B3it_XmlBind_Opentrans21_LineItemId();
		}
	
		return $this->__LineItemId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_LineItemId
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function setLineItemId($value)
	{
		$this->__LineItemId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceDate
	 */
	public function getInvoiceDate()
	{
		if($this->__InvoiceDate == null)
		{
			$this->__InvoiceDate = new B3it_XmlBind_Opentrans21_InvoiceDate();
		}
	
		return $this->__InvoiceDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceDate
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function setInvoiceDate($value)
	{
		$this->__InvoiceDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PostDate
	 */
	public function getPostDate()
	{
		if($this->__PostDate == null)
		{
			$this->__PostDate = new B3it_XmlBind_Opentrans21_PostDate();
		}
	
		return $this->__PostDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PostDate
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function setPostDate($value)
	{
		$this->__PostDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReasonForTransfer
	 */
	public function getReasonForTransfer()
	{
		if($this->__ReasonForTransfer == null)
		{
			$this->__ReasonForTransfer = new B3it_XmlBind_Opentrans21_ReasonForTransfer();
		}
	
		return $this->__ReasonForTransfer;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReasonForTransfer
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function setReasonForTransfer($value)
	{
		$this->__ReasonForTransfer = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_InvoiceDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_InvoiceDescr
	 */
	public function getInvoiceDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_InvoiceDescr();
		$this->__InvoiceDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceDescr
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function setInvoiceDescr($value)
	{
		$this->__InvoiceDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceDescr[]
	 */
	public function getAllInvoiceDescr()
	{
		return $this->__InvoiceDescrA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('INVOICE_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceId != null){
			$this->__InvoiceId->toXml($xml);
		}
		if($this->__LineItemId != null){
			$this->__LineItemId->toXml($xml);
		}
		if($this->__InvoiceDate != null){
			$this->__InvoiceDate->toXml($xml);
		}
		if($this->__PostDate != null){
			$this->__PostDate->toXml($xml);
		}
		if($this->__ReasonForTransfer != null){
			$this->__ReasonForTransfer->toXml($xml);
		}
		if($this->__InvoiceDescrA != null){
			foreach($this->__InvoiceDescrA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
