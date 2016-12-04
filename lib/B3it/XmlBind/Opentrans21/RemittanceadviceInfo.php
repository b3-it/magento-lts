<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RemittanceadviceInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RemittanceadviceInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceId */
	private $__RemittanceadviceId = null;

	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceDate */
	private $__RemittanceadviceDate = null;

	/* @var B3it_XmlBind_Opentrans21_ReasonForTransfer */
	private $__ReasonForTransfer = null;

	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceType */
	private $__RemittanceadviceType = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Language */
	private $__LanguageA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeRoot */
	private $__MimeRoot = null;

	/* @var B3it_XmlBind_Opentrans21_Parties */
	private $__Parties = null;

	/* @var B3it_XmlBind_Opentrans21_PayerIdref */
	private $__PayerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_RemitteeIdref */
	private $__RemitteeIdref = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceIssuerIdref */
	private $__InvoiceIssuerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceRecipientIdref */
	private $__InvoiceRecipientIdref = null;

	/* @var B3it_XmlBind_Opentrans21_DocexchangePartiesReference */
	private $__DocexchangePartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref */
	private $__BuyerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Currency */
	private $__Currency = null;

	/* @var B3it_XmlBind_Opentrans21_Payment */
	private $__Payment = null;

	/* @var B3it_XmlBind_Opentrans21_PaymentDate */
	private $__PaymentDate = null;

	/* @var B3it_XmlBind_Opentrans21_TermsAndConditions */
	private $__TermsAndConditions = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo */
	private $__AccountingInfo = null;

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_HeaderUdx */
	private $__HeaderUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceId
	 */
	public function getRemittanceadviceId()
	{
		if($this->__RemittanceadviceId == null)
		{
			$this->__RemittanceadviceId = new B3it_XmlBind_Opentrans21_RemittanceadviceId();
		}
	
		return $this->__RemittanceadviceId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceId
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setRemittanceadviceId($value)
	{
		$this->__RemittanceadviceId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceDate
	 */
	public function getRemittanceadviceDate()
	{
		if($this->__RemittanceadviceDate == null)
		{
			$this->__RemittanceadviceDate = new B3it_XmlBind_Opentrans21_RemittanceadviceDate();
		}
	
		return $this->__RemittanceadviceDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceDate
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setRemittanceadviceDate($value)
	{
		$this->__RemittanceadviceDate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setReasonForTransfer($value)
	{
		$this->__ReasonForTransfer = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceType
	 */
	public function getRemittanceadviceType()
	{
		if($this->__RemittanceadviceType == null)
		{
			$this->__RemittanceadviceType = new B3it_XmlBind_Opentrans21_RemittanceadviceType();
		}
	
		return $this->__RemittanceadviceType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceType
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setRemittanceadviceType($value)
	{
		$this->__RemittanceadviceType = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Language and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Language
	 */
	public function getLanguage()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Language();
		$this->__LanguageA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Language
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setLanguage($value)
	{
		$this->__LanguageA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Language[]
	 */
	public function getAllLanguage()
	{
		return $this->__LanguageA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeRoot
	 */
	public function getMimeRoot()
	{
		if($this->__MimeRoot == null)
		{
			$this->__MimeRoot = new B3it_XmlBind_Opentrans21_Bmecat_MimeRoot();
		}
	
		return $this->__MimeRoot;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeRoot
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setMimeRoot($value)
	{
		$this->__MimeRoot = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Parties
	 */
	public function getParties()
	{
		if($this->__Parties == null)
		{
			$this->__Parties = new B3it_XmlBind_Opentrans21_Parties();
		}
	
		return $this->__Parties;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Parties
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setParties($value)
	{
		$this->__Parties = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PayerIdref
	 */
	public function getPayerIdref()
	{
		if($this->__PayerIdref == null)
		{
			$this->__PayerIdref = new B3it_XmlBind_Opentrans21_PayerIdref();
		}
	
		return $this->__PayerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PayerIdref
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setPayerIdref($value)
	{
		$this->__PayerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemitteeIdref
	 */
	public function getRemitteeIdref()
	{
		if($this->__RemitteeIdref == null)
		{
			$this->__RemitteeIdref = new B3it_XmlBind_Opentrans21_RemitteeIdref();
		}
	
		return $this->__RemitteeIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemitteeIdref
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setRemitteeIdref($value)
	{
		$this->__RemitteeIdref = $value;
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setInvoiceRecipientIdref($value)
	{
		$this->__InvoiceRecipientIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DocexchangePartiesReference
	 */
	public function getDocexchangePartiesReference()
	{
		if($this->__DocexchangePartiesReference == null)
		{
			$this->__DocexchangePartiesReference = new B3it_XmlBind_Opentrans21_DocexchangePartiesReference();
		}
	
		return $this->__DocexchangePartiesReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DocexchangePartiesReference
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setDocexchangePartiesReference($value)
	{
		$this->__DocexchangePartiesReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref
	 */
	public function getBuyerIdref()
	{
		if($this->__BuyerIdref == null)
		{
			$this->__BuyerIdref = new B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref();
		}
	
		return $this->__BuyerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setBuyerIdref($value)
	{
		$this->__BuyerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->__SupplierIdref == null)
		{
			$this->__SupplierIdref = new B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref();
		}
	
		return $this->__SupplierIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Currency
	 */
	public function getCurrency()
	{
		if($this->__Currency == null)
		{
			$this->__Currency = new B3it_XmlBind_Opentrans21_Bmecat_Currency();
		}
	
		return $this->__Currency;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Currency
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setCurrency($value)
	{
		$this->__Currency = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function getPayment()
	{
		if($this->__Payment == null)
		{
			$this->__Payment = new B3it_XmlBind_Opentrans21_Payment();
		}
	
		return $this->__Payment;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Payment
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setPayment($value)
	{
		$this->__Payment = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PaymentDate
	 */
	public function getPaymentDate()
	{
		if($this->__PaymentDate == null)
		{
			$this->__PaymentDate = new B3it_XmlBind_Opentrans21_PaymentDate();
		}
	
		return $this->__PaymentDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PaymentDate
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setPaymentDate($value)
	{
		$this->__PaymentDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TermsAndConditions
	 */
	public function getTermsAndConditions()
	{
		if($this->__TermsAndConditions == null)
		{
			$this->__TermsAndConditions = new B3it_XmlBind_Opentrans21_TermsAndConditions();
		}
	
		return $this->__TermsAndConditions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TermsAndConditions
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setTermsAndConditions($value)
	{
		$this->__TermsAndConditions = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 */
	public function getAccountingInfo()
	{
		if($this->__AccountingInfo == null)
		{
			$this->__AccountingInfo = new B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo();
		}
	
		return $this->__AccountingInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setAccountingInfo($value)
	{
		$this->__AccountingInfo = $value;
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
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
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
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
	 * @return B3it_XmlBind_Opentrans21_HeaderUdx
	 */
	public function getHeaderUdx()
	{
		if($this->__HeaderUdx == null)
		{
			$this->__HeaderUdx = new B3it_XmlBind_Opentrans21_HeaderUdx();
		}
	
		return $this->__HeaderUdx;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_HeaderUdx
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceInfo
	 */
	public function setHeaderUdx($value)
	{
		$this->__HeaderUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('REMITTANCEADVICE_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RemittanceadviceId != null){
			$this->__RemittanceadviceId->toXml($xml);
		}
		if($this->__RemittanceadviceDate != null){
			$this->__RemittanceadviceDate->toXml($xml);
		}
		if($this->__ReasonForTransfer != null){
			$this->__ReasonForTransfer->toXml($xml);
		}
		if($this->__RemittanceadviceType != null){
			$this->__RemittanceadviceType->toXml($xml);
		}
		if($this->__LanguageA != null){
			foreach($this->__LanguageA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeRoot != null){
			$this->__MimeRoot->toXml($xml);
		}
		if($this->__Parties != null){
			$this->__Parties->toXml($xml);
		}
		if($this->__PayerIdref != null){
			$this->__PayerIdref->toXml($xml);
		}
		if($this->__RemitteeIdref != null){
			$this->__RemitteeIdref->toXml($xml);
		}
		if($this->__InvoiceIssuerIdref != null){
			$this->__InvoiceIssuerIdref->toXml($xml);
		}
		if($this->__InvoiceRecipientIdref != null){
			$this->__InvoiceRecipientIdref->toXml($xml);
		}
		if($this->__DocexchangePartiesReference != null){
			$this->__DocexchangePartiesReference->toXml($xml);
		}
		if($this->__BuyerIdref != null){
			$this->__BuyerIdref->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__Currency != null){
			$this->__Currency->toXml($xml);
		}
		if($this->__Payment != null){
			$this->__Payment->toXml($xml);
		}
		if($this->__PaymentDate != null){
			$this->__PaymentDate->toXml($xml);
		}
		if($this->__TermsAndConditions != null){
			$this->__TermsAndConditions->toXml($xml);
		}
		if($this->__AccountingInfo != null){
			$this->__AccountingInfo->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__RemarksA != null){
			foreach($this->__RemarksA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__HeaderUdx != null){
			$this->__HeaderUdx->toXml($xml);
		}


		return $xml;
	}

}
