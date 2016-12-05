<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RemittanceadviceItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RemittanceadviceItem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceIssuerIdref */
	private $__InvoiceIssuerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceRecipientIdref */
	private $__InvoiceRecipientIdref = null;

	/* @var B3it_XmlBind_Opentrans21_RaInvoiceList */
	private $__RaInvoiceList = null;

	/* @var B3it_XmlBind_Opentrans21_TotalItemNum */
	private $__TotalItemNum = null;

	/* @var B3it_XmlBind_Opentrans21_TotalAmount */
	private $__TotalAmount = null;

	/* @var B3it_XmlBind_Opentrans21_OriginalSummaryAmount */
	private $__OriginalSummaryAmount = null;

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_ItemUdx */
	private $__ItemUdx = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setLineItemId($value)
	{
		$this->__LineItemId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceIssuerIdref
	 */
	public function getInvoiceIssuerIdref()
	{
		if($this->__InvoiceIssuerIdref == null)
		{
			$this->__InvoiceIssuerIdref = new B3it_XmlBind_Opentrans21_InvoiceIssuerIdref();
		}
	
		return $this->__InvoiceIssuerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceIssuerIdref
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setInvoiceIssuerIdref($value)
	{
		$this->__InvoiceIssuerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceRecipientIdref
	 */
	public function getInvoiceRecipientIdref()
	{
		if($this->__InvoiceRecipientIdref == null)
		{
			$this->__InvoiceRecipientIdref = new B3it_XmlBind_Opentrans21_InvoiceRecipientIdref();
		}
	
		return $this->__InvoiceRecipientIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceRecipientIdref
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setInvoiceRecipientIdref($value)
	{
		$this->__InvoiceRecipientIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceList
	 */
	public function getRaInvoiceList()
	{
		if($this->__RaInvoiceList == null)
		{
			$this->__RaInvoiceList = new B3it_XmlBind_Opentrans21_RaInvoiceList();
		}
	
		return $this->__RaInvoiceList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RaInvoiceList
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setRaInvoiceList($value)
	{
		$this->__RaInvoiceList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TotalItemNum
	 */
	public function getTotalItemNum()
	{
		if($this->__TotalItemNum == null)
		{
			$this->__TotalItemNum = new B3it_XmlBind_Opentrans21_TotalItemNum();
		}
	
		return $this->__TotalItemNum;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TotalItemNum
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setTotalItemNum($value)
	{
		$this->__TotalItemNum = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TotalAmount
	 */
	public function getTotalAmount()
	{
		if($this->__TotalAmount == null)
		{
			$this->__TotalAmount = new B3it_XmlBind_Opentrans21_TotalAmount();
		}
	
		return $this->__TotalAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TotalAmount
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setTotalAmount($value)
	{
		$this->__TotalAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OriginalSummaryAmount
	 */
	public function getOriginalSummaryAmount()
	{
		if($this->__OriginalSummaryAmount == null)
		{
			$this->__OriginalSummaryAmount = new B3it_XmlBind_Opentrans21_OriginalSummaryAmount();
		}
	
		return $this->__OriginalSummaryAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OriginalSummaryAmount
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setOriginalSummaryAmount($value)
	{
		$this->__OriginalSummaryAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Remarks and add it to list
	 * @return B3it_XmlBind_Opentrans21_Remarks
	 */
	public function getRemarks()
	{
		$res = new B3it_XmlBind_Opentrans21_Remarks();
		$this->__RemarksA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Remarks
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setRemarks($value)
	{
		$this->__RemarksA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Remarks[]
	 */
	public function getAllRemarks()
	{
		return $this->__RemarksA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_ItemUdx
	 */
	public function getItemUdx()
	{
		if($this->__ItemUdx == null)
		{
			$this->__ItemUdx = new B3it_XmlBind_Opentrans21_ItemUdx();
		}
	
		return $this->__ItemUdx;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ItemUdx
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function setItemUdx($value)
	{
		$this->__ItemUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('REMITTANCEADVICE_ITEM');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__LineItemId != null){
			$this->__LineItemId->toXml($xml);
		}
		if($this->__InvoiceIssuerIdref != null){
			$this->__InvoiceIssuerIdref->toXml($xml);
		}
		if($this->__InvoiceRecipientIdref != null){
			$this->__InvoiceRecipientIdref->toXml($xml);
		}
		if($this->__RaInvoiceList != null){
			$this->__RaInvoiceList->toXml($xml);
		}
		if($this->__TotalItemNum != null){
			$this->__TotalItemNum->toXml($xml);
		}
		if($this->__TotalAmount != null){
			$this->__TotalAmount->toXml($xml);
		}
		if($this->__OriginalSummaryAmount != null){
			$this->__OriginalSummaryAmount->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__RemarksA != null){
			foreach($this->__RemarksA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ItemUdx != null){
			$this->__ItemUdx->toXml($xml);
		}


		return $xml;
	}

}
