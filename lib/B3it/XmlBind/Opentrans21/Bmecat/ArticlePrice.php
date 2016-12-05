<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ArticlePrice
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceAmount */
	private $__PriceAmount = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceFormula */
	private $__PriceFormula = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency */
	private $__PriceCurrency = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_TaxDetails */
	private $__TaxDetailsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Tax */
	private $__Tax = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceFactor */
	private $__PriceFactor = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_LowerBound */
	private $__LowerBound = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaRefs */
	private $__AreaRefs = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceBase */
	private $__PriceBase = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceFlag */
	private $__PriceFlagA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Leadtime */
	private $__Leadtime = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setPriceAmount($value)
	{
		$this->__PriceAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceFormula
	 */
	public function getPriceFormula()
	{
		if($this->__PriceFormula == null)
		{
			$this->__PriceFormula = new B3it_XmlBind_Opentrans21_Bmecat_PriceFormula();
		}
	
		return $this->__PriceFormula;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceFormula
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setPriceFormula($value)
	{
		$this->__PriceFormula = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency
	 */
	public function getPriceCurrency()
	{
		if($this->__PriceCurrency == null)
		{
			$this->__PriceCurrency = new B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency();
		}
	
		return $this->__PriceCurrency;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setPriceCurrency($value)
	{
		$this->__PriceCurrency = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_TaxDetails and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function getTaxDetails()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_TaxDetails();
		$this->__TaxDetailsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setTaxDetails($value)
	{
		$this->__TaxDetailsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails[]
	 */
	public function getAllTaxDetails()
	{
		return $this->__TaxDetailsA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Tax
	 */
	public function getTax()
	{
		if($this->__Tax == null)
		{
			$this->__Tax = new B3it_XmlBind_Opentrans21_Bmecat_Tax();
		}
	
		return $this->__Tax;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Tax
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setTax($value)
	{
		$this->__Tax = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceFactor
	 */
	public function getPriceFactor()
	{
		if($this->__PriceFactor == null)
		{
			$this->__PriceFactor = new B3it_XmlBind_Opentrans21_Bmecat_PriceFactor();
		}
	
		return $this->__PriceFactor;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceFactor
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setPriceFactor($value)
	{
		$this->__PriceFactor = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_LowerBound
	 */
	public function getLowerBound()
	{
		if($this->__LowerBound == null)
		{
			$this->__LowerBound = new B3it_XmlBind_Opentrans21_Bmecat_LowerBound();
		}
	
		return $this->__LowerBound;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_LowerBound
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setLowerBound($value)
	{
		$this->__LowerBound = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Territory and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Territory();
		$this->__TerritoryA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Territory
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setTerritory($value)
	{
		$this->__TerritoryA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->__TerritoryA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaRefs
	 */
	public function getAreaRefs()
	{
		if($this->__AreaRefs == null)
		{
			$this->__AreaRefs = new B3it_XmlBind_Opentrans21_Bmecat_AreaRefs();
		}
	
		return $this->__AreaRefs;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaRefs
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setAreaRefs($value)
	{
		$this->__AreaRefs = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceBase
	 */
	public function getPriceBase()
	{
		if($this->__PriceBase == null)
		{
			$this->__PriceBase = new B3it_XmlBind_Opentrans21_Bmecat_PriceBase();
		}
	
		return $this->__PriceBase;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceBase
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setPriceBase($value)
	{
		$this->__PriceBase = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Leadtime
	 */
	public function getLeadtime()
	{
		if($this->__Leadtime == null)
		{
			$this->__Leadtime = new B3it_XmlBind_Opentrans21_Bmecat_Leadtime();
		}
	
		return $this->__Leadtime;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Leadtime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function setLeadtime($value)
	{
		$this->__Leadtime = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_PRICE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_PRICE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PriceAmount != null){
			$this->__PriceAmount->toXml($xml);
		}
		if($this->__PriceFormula != null){
			$this->__PriceFormula->toXml($xml);
		}
		if($this->__PriceCurrency != null){
			$this->__PriceCurrency->toXml($xml);
		}
		if($this->__TaxDetailsA != null){
			foreach($this->__TaxDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Tax != null){
			$this->__Tax->toXml($xml);
		}
		if($this->__PriceFactor != null){
			$this->__PriceFactor->toXml($xml);
		}
		if($this->__LowerBound != null){
			$this->__LowerBound->toXml($xml);
		}
		if($this->__TerritoryA != null){
			foreach($this->__TerritoryA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AreaRefs != null){
			$this->__AreaRefs->toXml($xml);
		}
		if($this->__PriceBase != null){
			$this->__PriceBase->toXml($xml);
		}
		if($this->__PriceFlagA != null){
			foreach($this->__PriceFlagA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Leadtime != null){
			$this->__Leadtime->toXml($xml);
		}


		return $xml;
	}

}
