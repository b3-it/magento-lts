<?php
class B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Language */
	private $_Language = null;	

	/* @var CatalogId */
	private $_CatalogId = null;	

	/* @var CatalogVersion */
	private $_CatalogVersion = null;	

	/* @var CatalogName */
	private $_CatalogName = null;	

	/* @var Catalog_Datetime */
	private $_Datetime = null;	

	/* @var Territory */
	private $_Territorys = array();	

	/* @var Currency */
	private $_Currency = null;	

	/* @var MimeRoot */
	private $_MimeRoot = null;	

	/* @var PriceFlag */
	private $_PriceFlags = array();	

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
	 * @return B3it_XmlBind_Bmecat12_Language
	 */
	public function getLanguage()
	{
		if($this->_Language == null)
		{
			$this->_Language = new B3it_XmlBind_Bmecat12_Language();
		}
		
		return $this->_Language;
	}
	
	/**
	 * @param $value Language
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setLanguage($value)
	{
		$this->_Language = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->_CatalogId == null)
		{
			$this->_CatalogId = new B3it_XmlBind_Bmecat12_CatalogId();
		}
		
		return $this->_CatalogId;
	}
	
	/**
	 * @param $value CatalogId
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogId($value)
	{
		$this->_CatalogId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->_CatalogVersion == null)
		{
			$this->_CatalogVersion = new B3it_XmlBind_Bmecat12_CatalogVersion();
		}
		
		return $this->_CatalogVersion;
	}
	
	/**
	 * @param $value CatalogVersion
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogVersion($value)
	{
		$this->_CatalogVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogName
	 */
	public function getCatalogName()
	{
		if($this->_CatalogName == null)
		{
			$this->_CatalogName = new B3it_XmlBind_Bmecat12_CatalogName();
		}
		
		return $this->_CatalogName;
	}
	
	/**
	 * @param $value CatalogName
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogName($value)
	{
		$this->_CatalogName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Catalog_Datetime
	 */
	public function getDatetime()
	{
		if($this->_Datetime == null)
		{
			$this->_Datetime = new B3it_XmlBind_Bmecat12_Catalog_Datetime();
		}
		
		return $this->_Datetime;
	}
	
	/**
	 * @param $value Datetime
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDatetime($value)
	{
		$this->_Datetime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->_Territorys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Territory and add it to list
	 * @return B3it_XmlBind_Bmecat12_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Bmecat12_Territory();
		$this->_Territorys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Territory[]
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setTerritory($value)
	{
		$this->_Territory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Currency
	 */
	public function getCurrency()
	{
		if($this->_Currency == null)
		{
			$this->_Currency = new B3it_XmlBind_Bmecat12_Currency();
		}
		
		return $this->_Currency;
	}
	
	/**
	 * @param $value Currency
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCurrency($value)
	{
		$this->_Currency = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimeRoot
	 */
	public function getMimeRoot()
	{
		if($this->_MimeRoot == null)
		{
			$this->_MimeRoot = new B3it_XmlBind_Bmecat12_MimeRoot();
		}
		
		return $this->_MimeRoot;
	}
	
	/**
	 * @param $value MimeRoot
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeRoot($value)
	{
		$this->_MimeRoot = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_PriceFlag[]
	 */
	public function getAllPriceFlag()
	{
		return $this->_PriceFlags;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_PriceFlag and add it to list
	 * @return B3it_XmlBind_Bmecat12_PriceFlag
	 */
	public function getPriceFlag()
	{
		$res = new B3it_XmlBind_Bmecat12_PriceFlag();
		$this->_PriceFlags[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PriceFlag[]
	 * @return B3it_XmlBind_Bmecat12_Catalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPriceFlag($value)
	{
		$this->_PriceFlag = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CATALOG');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Language != null){
			$this->_Language->toXml($xml);
		}
		if($this->_CatalogId != null){
			$this->_CatalogId->toXml($xml);
		}
		if($this->_CatalogVersion != null){
			$this->_CatalogVersion->toXml($xml);
		}
		if($this->_CatalogName != null){
			$this->_CatalogName->toXml($xml);
		}
		if($this->_Datetime != null){
			$this->_Datetime->toXml($xml);
		}
		if($this->_Territorys != null){
			foreach($this->_Territorys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Currency != null){
			$this->_Currency->toXml($xml);
		}
		if($this->_MimeRoot != null){
			$this->_MimeRoot->toXml($xml);
		}
		if($this->_PriceFlags != null){
			foreach($this->_PriceFlags as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}