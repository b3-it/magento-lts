<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AdjustedInvoiceSummary
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_NetValueGoods */
	private $__NetValueGoods = null;

	/* @var B3it_XmlBind_Opentrans21_TotalTax */
	private $__TotalTax = null;

	/* @var B3it_XmlBind_Opentrans21_TotalAmount */
	private $__TotalAmount = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary
	 */
	public function setNetValueGoods($value)
	{
		$this->__NetValueGoods = $value;
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
	 * @return B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary
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
	 * @return B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary
	 */
	public function setTotalAmount($value)
	{
		$this->__TotalAmount = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ADJUSTED_INVOICE_SUMMARY');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__NetValueGoods != null){
			$this->__NetValueGoods->toXml($xml);
		}
		if($this->__TotalTax != null){
			$this->__TotalTax->toXml($xml);
		}
		if($this->__TotalAmount != null){
			$this->__TotalAmount->toXml($xml);
		}


		return $xml;
	}

}
