<?php
class B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var GeneratorInfo */
	private $_GeneratorInfo = null;	

	/* @var Catalog */
	private $_Catalog = null;	

	/* @var BuyerIdref */
	private $_BuyerIdref = null;	

	/* @var Buyer */
	private $_Buyer = null;	

	/* @var Agreement */
	private $_Agreements = array();	

	/* @var LegalInfo */
	private $_LegalInfo = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var Supplier */
	private $_Supplier = null;	

	/* @var DocumentCreatorIdref */
	private $_DocumentCreatorIdref = null;	

	/* @var Parties */
	private $_Parties = null;	

	/* @var Areas */
	private $_Areas = null;	

	/* @var Header_UserDefinedExtensions */
	private $_UserDefinedExtensions = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_GeneratorInfo
	 */
	public function getGeneratorInfo()
	{
		if($this->_GeneratorInfo == null)
		{
			$this->_GeneratorInfo = new B3it_XmlBind_Bmecat2005_GeneratorInfo();
		}
		
		return $this->_GeneratorInfo;
	}
	
	/**
	 * @param $value GeneratorInfo
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGeneratorInfo($value)
	{
		$this->_GeneratorInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Catalog
	 */
	public function getCatalog()
	{
		if($this->_Catalog == null)
		{
			$this->_Catalog = new B3it_XmlBind_Bmecat2005_Catalog();
		}
		
		return $this->_Catalog;
	}
	
	/**
	 * @param $value Catalog
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalog($value)
	{
		$this->_Catalog = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_BuyerIdref
	 */
	public function getBuyerIdref()
	{
		if($this->_BuyerIdref == null)
		{
			$this->_BuyerIdref = new B3it_XmlBind_Bmecat2005_BuyerIdref();
		}
		
		return $this->_BuyerIdref;
	}
	
	/**
	 * @param $value BuyerIdref
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setBuyerIdref($value)
	{
		$this->_BuyerIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Buyer
	 */
	public function getBuyer()
	{
		if($this->_Buyer == null)
		{
			$this->_Buyer = new B3it_XmlBind_Bmecat2005_Buyer();
		}
		
		return $this->_Buyer;
	}
	
	/**
	 * @param $value Buyer
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setBuyer($value)
	{
		$this->_Buyer = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Agreement[]
	 */
	public function getAllAgreement()
	{
		return $this->_Agreements;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Agreement and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Agreement
	 */
	public function getAgreement()
	{
		$res = new B3it_XmlBind_Bmecat2005_Agreement();
		$this->_Agreements[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Agreement[]
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreement($value)
	{
		$this->_Agreement = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_LegalInfo
	 */
	public function getLegalInfo()
	{
		if($this->_LegalInfo == null)
		{
			$this->_LegalInfo = new B3it_XmlBind_Bmecat2005_LegalInfo();
		}
		
		return $this->_LegalInfo;
	}
	
	/**
	 * @param $value LegalInfo
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLegalInfo($value)
	{
		$this->_LegalInfo = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Supplier
	 */
	public function getSupplier()
	{
		if($this->_Supplier == null)
		{
			$this->_Supplier = new B3it_XmlBind_Bmecat2005_Supplier();
		}
		
		return $this->_Supplier;
	}
	
	/**
	 * @param $value Supplier
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplier($value)
	{
		$this->_Supplier = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DocumentCreatorIdref
	 */
	public function getDocumentCreatorIdref()
	{
		if($this->_DocumentCreatorIdref == null)
		{
			$this->_DocumentCreatorIdref = new B3it_XmlBind_Bmecat2005_DocumentCreatorIdref();
		}
		
		return $this->_DocumentCreatorIdref;
	}
	
	/**
	 * @param $value DocumentCreatorIdref
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDocumentCreatorIdref($value)
	{
		$this->_DocumentCreatorIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Parties
	 */
	public function getParties()
	{
		if($this->_Parties == null)
		{
			$this->_Parties = new B3it_XmlBind_Bmecat2005_Parties();
		}
		
		return $this->_Parties;
	}
	
	/**
	 * @param $value Parties
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParties($value)
	{
		$this->_Parties = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Areas
	 */
	public function getAreas()
	{
		if($this->_Areas == null)
		{
			$this->_Areas = new B3it_XmlBind_Bmecat2005_Areas();
		}
		
		return $this->_Areas;
	}
	
	/**
	 * @param $value Areas
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreas($value)
	{
		$this->_Areas = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Header_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat2005_Header_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat2005_Header extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('HEADER');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_GeneratorInfo != null){
			$this->_GeneratorInfo->toXml($xml);
		}
		if($this->_Catalog != null){
			$this->_Catalog->toXml($xml);
		}
		if($this->_BuyerIdref != null){
			$this->_BuyerIdref->toXml($xml);
		}
		if($this->_Buyer != null){
			$this->_Buyer->toXml($xml);
		}
		if($this->_Agreements != null){
			foreach($this->_Agreements as $item){
				$item->toXml($xml);
			}
		}
		if($this->_LegalInfo != null){
			$this->_LegalInfo->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_Supplier != null){
			$this->_Supplier->toXml($xml);
		}
		if($this->_DocumentCreatorIdref != null){
			$this->_DocumentCreatorIdref->toXml($xml);
		}
		if($this->_Parties != null){
			$this->_Parties->toXml($xml);
		}
		if($this->_Areas != null){
			$this->_Areas->toXml($xml);
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}
}