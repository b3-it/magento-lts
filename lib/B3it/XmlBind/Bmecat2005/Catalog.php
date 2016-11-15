<?php
class B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Language */
	private $_Languages = array();	

	/* @var CatalogId */
	private $_CatalogId = null;	

	/* @var CatalogVersion */
	private $_CatalogVersion = null;	

	/* @var CatalogName */
	private $_CatalogNames = array();	

	/* @var GenerationDate */
	private $_GenerationDate = null;	

	/* @var Catalog_Datetime */
	private $_Datetime = null;	

	/* @var Territory */
	private $_Territorys = array();	

	/* @var AreaRefs */
	private $_AreaRefs = null;	

	/* @var Currency */
	private $_Currency = null;	

	/* @var MimeRoot */
	private $_MimeRoots = array();	

	/* @var PriceFlag */
	private $_PriceFlags = array();	

	/* @var PriceFactor */
	private $_PriceFactor = null;	

	/* @var ValidStartDate */
	private $_ValidStartDate = null;	

	/* @var ValidEndDate */
	private $_ValidEndDate = null;	

	/* @var ProductType */
	private $_ProductType = null;	

	/* @var CountryOfOrigin */
	private $_CountryOfOrigin = null;	

	/* @var DeliveryTimes */
	private $_DeliveryTimess = array();	

	/* @var Transport */
	private $_Transport = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	public function getAttribute($name){
		if(isset($this->_attributes[$name])){
			 return $this->_attributes[$name];
		}
		return null;
	}

	public function setAttribute($name,$value){
		$this->_attributes[$name] = $value;
		return $this;
	}



	/**
	 * @return B3it_XmlBind_Bmecat2005_Language[]
	 */
	public function getAllLanguage()
	{
		return $this->_Languages;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Language and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Language
	 */
	public function getLanguage()
	{
		$res = new B3it_XmlBind_Bmecat2005_Language();
		$this->_Languages[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Language[]
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLanguage($value)
	{
		$this->_Language = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->_CatalogId == null)
		{
			$this->_CatalogId = new B3it_XmlBind_Bmecat2005_CatalogId();
		}
		
		return $this->_CatalogId;
	}
	
	/**
	 * @param $value CatalogId
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogId($value)
	{
		$this->_CatalogId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->_CatalogVersion == null)
		{
			$this->_CatalogVersion = new B3it_XmlBind_Bmecat2005_CatalogVersion();
		}
		
		return $this->_CatalogVersion;
	}
	
	/**
	 * @param $value CatalogVersion
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogVersion($value)
	{
		$this->_CatalogVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogName[]
	 */
	public function getAllCatalogName()
	{
		return $this->_CatalogNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_CatalogName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_CatalogName
	 */
	public function getCatalogName()
	{
		$res = new B3it_XmlBind_Bmecat2005_CatalogName();
		$this->_CatalogNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value CatalogName[]
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogName($value)
	{
		$this->_CatalogName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_GenerationDate
	 */
	public function getGenerationDate()
	{
		if($this->_GenerationDate == null)
		{
			$this->_GenerationDate = new B3it_XmlBind_Bmecat2005_GenerationDate();
		}
		
		return $this->_GenerationDate;
	}
	
	/**
	 * @param $value GenerationDate
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGenerationDate($value)
	{
		$this->_GenerationDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Catalog_Datetime
	 */
	public function getDatetime()
	{
		if($this->_Datetime == null)
		{
			$this->_Datetime = new B3it_XmlBind_Bmecat2005_Catalog_Datetime();
		}
		
		return $this->_Datetime;
	}
	
	/**
	 * @param $value Datetime
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDatetime($value)
	{
		$this->_Datetime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->_Territorys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Territory and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Bmecat2005_Territory();
		$this->_Territorys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Territory[]
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTerritory($value)
	{
		$this->_Territory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AreaRefs
	 */
	public function getAreaRefs()
	{
		if($this->_AreaRefs == null)
		{
			$this->_AreaRefs = new B3it_XmlBind_Bmecat2005_AreaRefs();
		}
		
		return $this->_AreaRefs;
	}
	
	/**
	 * @param $value AreaRefs
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaRefs($value)
	{
		$this->_AreaRefs = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Currency
	 */
	public function getCurrency()
	{
		if($this->_Currency == null)
		{
			$this->_Currency = new B3it_XmlBind_Bmecat2005_Currency();
		}
		
		return $this->_Currency;
	}
	
	/**
	 * @param $value Currency
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCurrency($value)
	{
		$this->_Currency = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeRoot[]
	 */
	public function getAllMimeRoot()
	{
		return $this->_MimeRoots;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_MimeRoot and add it to list
	 * @return B3it_XmlBind_Bmecat2005_MimeRoot
	 */
	public function getMimeRoot()
	{
		$res = new B3it_XmlBind_Bmecat2005_MimeRoot();
		$this->_MimeRoots[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value MimeRoot[]
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeRoot($value)
	{
		$this->_MimeRoot = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceFlag[]
	 */
	public function getAllPriceFlag()
	{
		return $this->_PriceFlags;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PriceFlag and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PriceFlag
	 */
	public function getPriceFlag()
	{
		$res = new B3it_XmlBind_Bmecat2005_PriceFlag();
		$this->_PriceFlags[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PriceFlag[]
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceFlag($value)
	{
		$this->_PriceFlag = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceFactor
	 */
	public function getPriceFactor()
	{
		if($this->_PriceFactor == null)
		{
			$this->_PriceFactor = new B3it_XmlBind_Bmecat2005_PriceFactor();
		}
		
		return $this->_PriceFactor;
	}
	
	/**
	 * @param $value PriceFactor
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceFactor($value)
	{
		$this->_PriceFactor = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValidStartDate
	 */
	public function getValidStartDate()
	{
		if($this->_ValidStartDate == null)
		{
			$this->_ValidStartDate = new B3it_XmlBind_Bmecat2005_ValidStartDate();
		}
		
		return $this->_ValidStartDate;
	}
	
	/**
	 * @param $value ValidStartDate
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValidStartDate($value)
	{
		$this->_ValidStartDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValidEndDate
	 */
	public function getValidEndDate()
	{
		if($this->_ValidEndDate == null)
		{
			$this->_ValidEndDate = new B3it_XmlBind_Bmecat2005_ValidEndDate();
		}
		
		return $this->_ValidEndDate;
	}
	
	/**
	 * @param $value ValidEndDate
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValidEndDate($value)
	{
		$this->_ValidEndDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductType
	 */
	public function getProductType()
	{
		if($this->_ProductType == null)
		{
			$this->_ProductType = new B3it_XmlBind_Bmecat2005_ProductType();
		}
		
		return $this->_ProductType;
	}
	
	/**
	 * @param $value ProductType
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductType($value)
	{
		$this->_ProductType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CountryOfOrigin
	 */
	public function getCountryOfOrigin()
	{
		if($this->_CountryOfOrigin == null)
		{
			$this->_CountryOfOrigin = new B3it_XmlBind_Bmecat2005_CountryOfOrigin();
		}
		
		return $this->_CountryOfOrigin;
	}
	
	/**
	 * @param $value CountryOfOrigin
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCountryOfOrigin($value)
	{
		$this->_CountryOfOrigin = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes[]
	 */
	public function getAllDeliveryTimes()
	{
		return $this->_DeliveryTimess;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_DeliveryTimes and add it to list
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes
	 */
	public function getDeliveryTimes()
	{
		$res = new B3it_XmlBind_Bmecat2005_DeliveryTimes();
		$this->_DeliveryTimess[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value DeliveryTimes[]
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDeliveryTimes($value)
	{
		$this->_DeliveryTimes = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Transport
	 */
	public function getTransport()
	{
		if($this->_Transport == null)
		{
			$this->_Transport = new B3it_XmlBind_Bmecat2005_Transport();
		}
		
		return $this->_Transport;
	}
	
	/**
	 * @param $value Transport
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTransport($value)
	{
		$this->_Transport = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->_SupplierIdref == null)
		{
			$this->_SupplierIdref = new B3it_XmlBind_Bmecat2005_SupplierIdref();
		}
		
		return $this->_SupplierIdref;
	}
	
	/**
	 * @param $value SupplierIdref
	 * @return B3it_XmlBind_Bmecat2005_Catalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CATALOG');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Languages != null){
			foreach($this->_Languages as $item){
				$item->toXml($xml);
			}
		}
		if($this->_CatalogId != null){
			$this->_CatalogId->toXml($xml);
		}
		if($this->_CatalogVersion != null){
			$this->_CatalogVersion->toXml($xml);
		}
		if($this->_CatalogNames != null){
			foreach($this->_CatalogNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_GenerationDate != null){
			$this->_GenerationDate->toXml($xml);
		}
		if($this->_Datetime != null){
			$this->_Datetime->toXml($xml);
		}
		if($this->_Territorys != null){
			foreach($this->_Territorys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AreaRefs != null){
			$this->_AreaRefs->toXml($xml);
		}
		if($this->_Currency != null){
			$this->_Currency->toXml($xml);
		}
		if($this->_MimeRoots != null){
			foreach($this->_MimeRoots as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PriceFlags != null){
			foreach($this->_PriceFlags as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PriceFactor != null){
			$this->_PriceFactor->toXml($xml);
		}
		if($this->_ValidStartDate != null){
			$this->_ValidStartDate->toXml($xml);
		}
		if($this->_ValidEndDate != null){
			$this->_ValidEndDate->toXml($xml);
		}
		if($this->_ProductType != null){
			$this->_ProductType->toXml($xml);
		}
		if($this->_CountryOfOrigin != null){
			$this->_CountryOfOrigin->toXml($xml);
		}
		if($this->_DeliveryTimess != null){
			foreach($this->_DeliveryTimess as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Transport != null){
			$this->_Transport->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}


		return $xml;
	}
}