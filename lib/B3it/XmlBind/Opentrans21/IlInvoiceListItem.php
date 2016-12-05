<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	IlInvoiceListItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_IlInvoiceListItem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceReference */
	private $__InvoiceReference = null;

	/* @var B3it_XmlBind_Opentrans21_ForeignCurrency */
	private $__ForeignCurrency = null;

	/* @var B3it_XmlBind_Opentrans21_ForeignAmount */
	private $__ForeignAmount = null;

	/* @var B3it_XmlBind_Opentrans21_ExchangeRate */
	private $__ExchangeRate = null;

	/* @var B3it_XmlBind_Opentrans21_NetValueGoods */
	private $__NetValueGoods = null;

	/* @var B3it_XmlBind_Opentrans21_NetValueExtra */
	private $__NetValueExtra = null;

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargesFix */
	private $__AllowOrChargesFix = null;

	/* @var B3it_XmlBind_Opentrans21_TotalTax */
	private $__TotalTax = null;

	/* @var B3it_XmlBind_Opentrans21_TotalAmount */
	private $__TotalAmount = null;

	
	/* @var B3it_XmlBind_Opentrans21_Rewards */
	private $__RewardsA = array();


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setInvoiceReference($value)
	{
		$this->__InvoiceReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ForeignCurrency
	 */
	public function getForeignCurrency()
	{
		if($this->__ForeignCurrency == null)
		{
			$this->__ForeignCurrency = new B3it_XmlBind_Opentrans21_ForeignCurrency();
		}
	
		return $this->__ForeignCurrency;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ForeignCurrency
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setForeignCurrency($value)
	{
		$this->__ForeignCurrency = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ForeignAmount
	 */
	public function getForeignAmount()
	{
		if($this->__ForeignAmount == null)
		{
			$this->__ForeignAmount = new B3it_XmlBind_Opentrans21_ForeignAmount();
		}
	
		return $this->__ForeignAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ForeignAmount
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setForeignAmount($value)
	{
		$this->__ForeignAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ExchangeRate
	 */
	public function getExchangeRate()
	{
		if($this->__ExchangeRate == null)
		{
			$this->__ExchangeRate = new B3it_XmlBind_Opentrans21_ExchangeRate();
		}
	
		return $this->__ExchangeRate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ExchangeRate
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setExchangeRate($value)
	{
		$this->__ExchangeRate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setAllowOrChargesFix($value)
	{
		$this->__AllowOrChargesFix = $value;
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setTotalTax($value)
	{
		$this->__TotalTax = $value;
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function setTotalAmount($value)
	{
		$this->__TotalAmount = $value;
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
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
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







	public function toXml($xml)
	{
		$node = new DOMElement('IL_INVOICE_LIST_ITEM');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceReference != null){
			$this->__InvoiceReference->toXml($xml);
		}
		if($this->__ForeignCurrency != null){
			$this->__ForeignCurrency->toXml($xml);
		}
		if($this->__ForeignAmount != null){
			$this->__ForeignAmount->toXml($xml);
		}
		if($this->__ExchangeRate != null){
			$this->__ExchangeRate->toXml($xml);
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
		if($this->__TotalTax != null){
			$this->__TotalTax->toXml($xml);
		}
		if($this->__TotalAmount != null){
			$this->__TotalAmount->toXml($xml);
		}
		if($this->__RewardsA != null){
			foreach($this->__RewardsA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
