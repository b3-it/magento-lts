<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoicelistItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoicelistItem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceRecipientIdref */
	private $__InvoiceRecipientIdref = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryIdref */
	private $__DeliveryIdref = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceIssuerIdref */
	private $__InvoiceIssuerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_AccountingPeriod */
	private $__AccountingPeriod = null;

	/* @var B3it_XmlBind_Opentrans21_CreditLimit */
	private $__CreditLimit = null;

	/* @var B3it_XmlBind_Opentrans21_OpeningBalance */
	private $__OpeningBalance = null;

	/* @var B3it_XmlBind_Opentrans21_IlInvoiceList */
	private $__IlInvoiceList = null;

	/* @var B3it_XmlBind_Opentrans21_TotalItemNum */
	private $__TotalItemNum = null;

	/* @var B3it_XmlBind_Opentrans21_NetValueGoods */
	private $__NetValueGoods = null;

	/* @var B3it_XmlBind_Opentrans21_NetValueExtra */
	private $__NetValueExtra = null;

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargesFix */
	private $__AllowOrChargesFix = null;

	/* @var B3it_XmlBind_Opentrans21_TotalAmount */
	private $__TotalAmount = null;

	/* @var B3it_XmlBind_Opentrans21_TotalTax */
	private $__TotalTax = null;

	/* @var B3it_XmlBind_Opentrans21_DirectDebit */
	private $__DirectDebit = null;

	/* @var B3it_XmlBind_Opentrans21_ClosingBalance */
	private $__ClosingBalance = null;

	/* @var B3it_XmlBind_Opentrans21_AmountOverCreditLimit */
	private $__AmountOverCreditLimit = null;

	/* @var B3it_XmlBind_Opentrans21_CreditAvailable */
	private $__CreditAvailable = null;

	
	/* @var B3it_XmlBind_Opentrans21_Rewards */
	private $__RewardsA = array();

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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setLineItemId($value)
	{
		$this->__LineItemId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setInvoiceRecipientIdref($value)
	{
		$this->__InvoiceRecipientIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryIdref
	 */
	public function getDeliveryIdref()
	{
		if($this->__DeliveryIdref == null)
		{
			$this->__DeliveryIdref = new B3it_XmlBind_Opentrans21_DeliveryIdref();
		}
	
		return $this->__DeliveryIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryIdref
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setDeliveryIdref($value)
	{
		$this->__DeliveryIdref = $value;
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setInvoiceIssuerIdref($value)
	{
		$this->__InvoiceIssuerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AccountingPeriod
	 */
	public function getAccountingPeriod()
	{
		if($this->__AccountingPeriod == null)
		{
			$this->__AccountingPeriod = new B3it_XmlBind_Opentrans21_AccountingPeriod();
		}
	
		return $this->__AccountingPeriod;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AccountingPeriod
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setAccountingPeriod($value)
	{
		$this->__AccountingPeriod = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CreditLimit
	 */
	public function getCreditLimit()
	{
		if($this->__CreditLimit == null)
		{
			$this->__CreditLimit = new B3it_XmlBind_Opentrans21_CreditLimit();
		}
	
		return $this->__CreditLimit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CreditLimit
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setCreditLimit($value)
	{
		$this->__CreditLimit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OpeningBalance
	 */
	public function getOpeningBalance()
	{
		if($this->__OpeningBalance == null)
		{
			$this->__OpeningBalance = new B3it_XmlBind_Opentrans21_OpeningBalance();
		}
	
		return $this->__OpeningBalance;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OpeningBalance
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setOpeningBalance($value)
	{
		$this->__OpeningBalance = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceList
	 */
	public function getIlInvoiceList()
	{
		if($this->__IlInvoiceList == null)
		{
			$this->__IlInvoiceList = new B3it_XmlBind_Opentrans21_IlInvoiceList();
		}
	
		return $this->__IlInvoiceList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_IlInvoiceList
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setIlInvoiceList($value)
	{
		$this->__IlInvoiceList = $value;
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setTotalItemNum($value)
	{
		$this->__TotalItemNum = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_NetValueGoods
	 */
	public function getNetValueGoods()
	{
		if($this->__NetValueGoods == null)
		{
			$this->__NetValueGoods = new B3it_XmlBind_Opentrans21_NetValueGoods();
		}
	
		return $this->__NetValueGoods;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_NetValueGoods
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setNetValueGoods($value)
	{
		$this->__NetValueGoods = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_NetValueExtra
	 */
	public function getNetValueExtra()
	{
		if($this->__NetValueExtra == null)
		{
			$this->__NetValueExtra = new B3it_XmlBind_Opentrans21_NetValueExtra();
		}
	
		return $this->__NetValueExtra;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_NetValueExtra
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setNetValueExtra($value)
	{
		$this->__NetValueExtra = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargesFix
	 */
	public function getAllowOrChargesFix()
	{
		if($this->__AllowOrChargesFix == null)
		{
			$this->__AllowOrChargesFix = new B3it_XmlBind_Opentrans21_AllowOrChargesFix();
		}
	
		return $this->__AllowOrChargesFix;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargesFix
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setAllowOrChargesFix($value)
	{
		$this->__AllowOrChargesFix = $value;
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setTotalAmount($value)
	{
		$this->__TotalAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TotalTax
	 */
	public function getTotalTax()
	{
		if($this->__TotalTax == null)
		{
			$this->__TotalTax = new B3it_XmlBind_Opentrans21_TotalTax();
		}
	
		return $this->__TotalTax;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TotalTax
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setTotalTax($value)
	{
		$this->__TotalTax = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DirectDebit
	 */
	public function getDirectDebit()
	{
		if($this->__DirectDebit == null)
		{
			$this->__DirectDebit = new B3it_XmlBind_Opentrans21_DirectDebit();
		}
	
		return $this->__DirectDebit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DirectDebit
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setDirectDebit($value)
	{
		$this->__DirectDebit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ClosingBalance
	 */
	public function getClosingBalance()
	{
		if($this->__ClosingBalance == null)
		{
			$this->__ClosingBalance = new B3it_XmlBind_Opentrans21_ClosingBalance();
		}
	
		return $this->__ClosingBalance;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ClosingBalance
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setClosingBalance($value)
	{
		$this->__ClosingBalance = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AmountOverCreditLimit
	 */
	public function getAmountOverCreditLimit()
	{
		if($this->__AmountOverCreditLimit == null)
		{
			$this->__AmountOverCreditLimit = new B3it_XmlBind_Opentrans21_AmountOverCreditLimit();
		}
	
		return $this->__AmountOverCreditLimit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AmountOverCreditLimit
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setAmountOverCreditLimit($value)
	{
		$this->__AmountOverCreditLimit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CreditAvailable
	 */
	public function getCreditAvailable()
	{
		if($this->__CreditAvailable == null)
		{
			$this->__CreditAvailable = new B3it_XmlBind_Opentrans21_CreditAvailable();
		}
	
		return $this->__CreditAvailable;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CreditAvailable
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setCreditAvailable($value)
	{
		$this->__CreditAvailable = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Rewards and add it to list
	 * @return B3it_XmlBind_Opentrans21_Rewards
	 */
	public function getRewards()
	{
		$res = new B3it_XmlBind_Opentrans21_Rewards();
		$this->__RewardsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Rewards
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setRewards($value)
	{
		$this->__RewardsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Rewards[]
	 */
	public function getAllRewards()
	{
		return $this->__RewardsA;
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
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
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function setItemUdx($value)
	{
		$this->__ItemUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICELIST_ITEM');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__LineItemId != null){
			$this->__LineItemId->toXml($xml);
		}
		if($this->__InvoiceRecipientIdref != null){
			$this->__InvoiceRecipientIdref->toXml($xml);
		}
		if($this->__DeliveryIdref != null){
			$this->__DeliveryIdref->toXml($xml);
		}
		if($this->__InvoiceIssuerIdref != null){
			$this->__InvoiceIssuerIdref->toXml($xml);
		}
		if($this->__AccountingPeriod != null){
			$this->__AccountingPeriod->toXml($xml);
		}
		if($this->__CreditLimit != null){
			$this->__CreditLimit->toXml($xml);
		}
		if($this->__OpeningBalance != null){
			$this->__OpeningBalance->toXml($xml);
		}
		if($this->__IlInvoiceList != null){
			$this->__IlInvoiceList->toXml($xml);
		}
		if($this->__TotalItemNum != null){
			$this->__TotalItemNum->toXml($xml);
		}
		if($this->__NetValueGoods != null){
			$this->__NetValueGoods->toXml($xml);
		}
		if($this->__NetValueExtra != null){
			$this->__NetValueExtra->toXml($xml);
		}
		if($this->__AllowOrChargesFix != null){
			$this->__AllowOrChargesFix->toXml($xml);
		}
		if($this->__TotalAmount != null){
			$this->__TotalAmount->toXml($xml);
		}
		if($this->__TotalTax != null){
			$this->__TotalTax->toXml($xml);
		}
		if($this->__DirectDebit != null){
			$this->__DirectDebit->toXml($xml);
		}
		if($this->__ClosingBalance != null){
			$this->__ClosingBalance->toXml($xml);
		}
		if($this->__AmountOverCreditLimit != null){
			$this->__AmountOverCreditLimit->toXml($xml);
		}
		if($this->__CreditAvailable != null){
			$this->__CreditAvailable->toXml($xml);
		}
		if($this->__RewardsA != null){
			foreach($this->__RewardsA as $item){
				$item->toXml($xml);
			}
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
