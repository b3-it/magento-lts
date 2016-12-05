<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Catalog
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Catalog extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Language */
	private $__LanguageA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogId */
	private $__CatalogId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion */
	private $__CatalogVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogName */
	private $__CatalogNameA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_GenerationDate */
	private $__GenerationDate = null;

	/* @var B3it_XmlBind_Opentrans21_Catalog_Bmecat_Datetime */
	private $__Datetime = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaRefs */
	private $__AreaRefs = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Currency */
	private $__Currency = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeRoot */
	private $__MimeRootA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceFlag */
	private $__PriceFlagA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceFactor */
	private $__PriceFactor = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate */
	private $__ValidStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate */
	private $__ValidEndDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductType */
	private $__ProductType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin */
	private $__CountryOfOrigin = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes */
	private $__DeliveryTimesA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Transport */
	private $__Transport = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->__CatalogId == null)
		{
			$this->__CatalogId = new B3it_XmlBind_Opentrans21_Bmecat_CatalogId();
		}
	
		return $this->__CatalogId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setCatalogId($value)
	{
		$this->__CatalogId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->__CatalogVersion == null)
		{
			$this->__CatalogVersion = new B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion();
		}
	
		return $this->__CatalogVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setCatalogVersion($value)
	{
		$this->__CatalogVersion = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_CatalogName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogName
	 */
	public function getCatalogName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_CatalogName();
		$this->__CatalogNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setCatalogName($value)
	{
		$this->__CatalogNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogName[]
	 */
	public function getAllCatalogName()
	{
		return $this->__CatalogNameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GenerationDate
	 */
	public function getGenerationDate()
	{
		if($this->__GenerationDate == null)
		{
			$this->__GenerationDate = new B3it_XmlBind_Opentrans21_Bmecat_GenerationDate();
		}
	
		return $this->__GenerationDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GenerationDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setGenerationDate($value)
	{
		$this->__GenerationDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Catalog_Bmecat_Datetime
	 */
	public function getDatetime()
	{
		if($this->__Datetime == null)
		{
			$this->__Datetime = new B3it_XmlBind_Opentrans21_Catalog_Bmecat_Datetime();
		}
	
		return $this->__Datetime;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Catalog_Bmecat_Datetime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setDatetime($value)
	{
		$this->__Datetime = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setAreaRefs($value)
	{
		$this->__AreaRefs = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setCurrency($value)
	{
		$this->__Currency = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_MimeRoot and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeRoot
	 */
	public function getMimeRoot()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_MimeRoot();
		$this->__MimeRootA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeRoot
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setMimeRoot($value)
	{
		$this->__MimeRootA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeRoot[]
	 */
	public function getAllMimeRoot()
	{
		return $this->__MimeRootA;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setPriceFactor($value)
	{
		$this->__PriceFactor = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate
	 */
	public function getValidStartDate()
	{
		if($this->__ValidStartDate == null)
		{
			$this->__ValidStartDate = new B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate();
		}
	
		return $this->__ValidStartDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setValidStartDate($value)
	{
		$this->__ValidStartDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate
	 */
	public function getValidEndDate()
	{
		if($this->__ValidEndDate == null)
		{
			$this->__ValidEndDate = new B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate();
		}
	
		return $this->__ValidEndDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setValidEndDate($value)
	{
		$this->__ValidEndDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductType
	 */
	public function getProductType()
	{
		if($this->__ProductType == null)
		{
			$this->__ProductType = new B3it_XmlBind_Opentrans21_Bmecat_ProductType();
		}
	
		return $this->__ProductType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setProductType($value)
	{
		$this->__ProductType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin
	 */
	public function getCountryOfOrigin()
	{
		if($this->__CountryOfOrigin == null)
		{
			$this->__CountryOfOrigin = new B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin();
		}
	
		return $this->__CountryOfOrigin;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setCountryOfOrigin($value)
	{
		$this->__CountryOfOrigin = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes
	 */
	public function getDeliveryTimes()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes();
		$this->__DeliveryTimesA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setDeliveryTimes($value)
	{
		$this->__DeliveryTimesA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes[]
	 */
	public function getAllDeliveryTimes()
	{
		return $this->__DeliveryTimesA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport
	 */
	public function getTransport()
	{
		if($this->__Transport == null)
		{
			$this->__Transport = new B3it_XmlBind_Opentrans21_Bmecat_Transport();
		}
	
		return $this->__Transport;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Transport
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setTransport($value)
	{
		$this->__Transport = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CATALOG');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CATALOG');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__LanguageA != null){
			foreach($this->__LanguageA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CatalogId != null){
			$this->__CatalogId->toXml($xml);
		}
		if($this->__CatalogVersion != null){
			$this->__CatalogVersion->toXml($xml);
		}
		if($this->__CatalogNameA != null){
			foreach($this->__CatalogNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__GenerationDate != null){
			$this->__GenerationDate->toXml($xml);
		}
		if($this->__Datetime != null){
			$this->__Datetime->toXml($xml);
		}
		if($this->__TerritoryA != null){
			foreach($this->__TerritoryA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AreaRefs != null){
			$this->__AreaRefs->toXml($xml);
		}
		if($this->__Currency != null){
			$this->__Currency->toXml($xml);
		}
		if($this->__MimeRootA != null){
			foreach($this->__MimeRootA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PriceFlagA != null){
			foreach($this->__PriceFlagA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PriceFactor != null){
			$this->__PriceFactor->toXml($xml);
		}
		if($this->__ValidStartDate != null){
			$this->__ValidStartDate->toXml($xml);
		}
		if($this->__ValidEndDate != null){
			$this->__ValidEndDate->toXml($xml);
		}
		if($this->__ProductType != null){
			$this->__ProductType->toXml($xml);
		}
		if($this->__CountryOfOrigin != null){
			$this->__CountryOfOrigin->toXml($xml);
		}
		if($this->__DeliveryTimesA != null){
			foreach($this->__DeliveryTimesA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Transport != null){
			$this->__Transport->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}


		return $xml;
	}

}
