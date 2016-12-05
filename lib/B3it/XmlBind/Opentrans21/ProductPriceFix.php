<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ProductPriceFix
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ProductPriceFix extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceAmount */
	private $__PriceAmount = null;

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargesFix */
	private $__AllowOrChargesFix = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceFlag */
	private $__PriceFlagA = array();

	
	/* @var B3it_XmlBind_Opentrans21_TaxDetailsFix */
	private $__TaxDetailsFixA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity */
	private $__PriceQuantity = null;

	/* @var B3it_XmlBind_Opentrans21_PriceBaseFix */
	private $__PriceBaseFix = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceAmount
	 */
	public function getPriceAmount()
	{
		if($this->__PriceAmount == null)
		{
			$this->__PriceAmount = new B3it_XmlBind_Opentrans21_Bmecat_PriceAmount();
		}
	
		return $this->__PriceAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceAmount
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function setPriceAmount($value)
	{
		$this->__PriceAmount = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function setAllowOrChargesFix($value)
	{
		$this->__AllowOrChargesFix = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PriceFlag and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceFlag
	 */
	public function getPriceFlag()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PriceFlag();
		$this->__PriceFlagA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceFlag
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function setPriceFlag($value)
	{
		$this->__PriceFlagA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceFlag[]
	 */
	public function getAllPriceFlag()
	{
		return $this->__PriceFlagA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TaxDetailsFix and add it to list
	 * @return B3it_XmlBind_Opentrans21_TaxDetailsFix
	 */
	public function getTaxDetailsFix()
	{
		$res = new B3it_XmlBind_Opentrans21_TaxDetailsFix();
		$this->__TaxDetailsFixA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TaxDetailsFix
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function setTaxDetailsFix($value)
	{
		$this->__TaxDetailsFixA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TaxDetailsFix[]
	 */
	public function getAllTaxDetailsFix()
	{
		return $this->__TaxDetailsFixA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity
	 */
	public function getPriceQuantity()
	{
		if($this->__PriceQuantity == null)
		{
			$this->__PriceQuantity = new B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity();
		}
	
		return $this->__PriceQuantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function setPriceQuantity($value)
	{
		$this->__PriceQuantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PriceBaseFix
	 */
	public function getPriceBaseFix()
	{
		if($this->__PriceBaseFix == null)
		{
			$this->__PriceBaseFix = new B3it_XmlBind_Opentrans21_PriceBaseFix();
		}
	
		return $this->__PriceBaseFix;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PriceBaseFix
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function setPriceBaseFix($value)
	{
		$this->__PriceBaseFix = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PRODUCT_PRICE_FIX');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PriceAmount != null){
			$this->__PriceAmount->toXml($xml);
		}
		if($this->__AllowOrChargesFix != null){
			$this->__AllowOrChargesFix->toXml($xml);
		}
		if($this->__PriceFlagA != null){
			foreach($this->__PriceFlagA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__TaxDetailsFixA != null){
			foreach($this->__TaxDetailsFixA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PriceQuantity != null){
			$this->__PriceQuantity->toXml($xml);
		}
		if($this->__PriceBaseFix != null){
			$this->__PriceBaseFix->toXml($xml);
		}


		return $xml;
	}

}
