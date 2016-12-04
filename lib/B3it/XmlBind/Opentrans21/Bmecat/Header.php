<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Header
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Header extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GeneratorInfo */
	private $__GeneratorInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Catalog */
	private $__Catalog = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref */
	private $__BuyerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Buyer */
	private $__Buyer = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Agreement */
	private $__AgreementA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_LegalInfo */
	private $__LegalInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Supplier */
	private $__Supplier = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_DocumentCreatorIdref */
	private $__DocumentCreatorIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Parties */
	private $__Parties = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Areas */
	private $__Areas = null;

	/* @var B3it_XmlBind_Opentrans21_Header_Bmecat_UserDefinedExtensions */
	private $__UserDefinedExtensions = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GeneratorInfo
	 */
	public function getGeneratorInfo()
	{
		if($this->__GeneratorInfo == null)
		{
			$this->__GeneratorInfo = new B3it_XmlBind_Opentrans21_Bmecat_GeneratorInfo();
		}
	
		return $this->__GeneratorInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GeneratorInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setGeneratorInfo($value)
	{
		$this->__GeneratorInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 */
	public function getCatalog()
	{
		if($this->__Catalog == null)
		{
			$this->__Catalog = new B3it_XmlBind_Opentrans21_Bmecat_Catalog();
		}
	
		return $this->__Catalog;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Catalog
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setCatalog($value)
	{
		$this->__Catalog = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setBuyerIdref($value)
	{
		$this->__BuyerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Buyer
	 */
	public function getBuyer()
	{
		if($this->__Buyer == null)
		{
			$this->__Buyer = new B3it_XmlBind_Opentrans21_Bmecat_Buyer();
		}
	
		return $this->__Buyer;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Buyer
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setBuyer($value)
	{
		$this->__Buyer = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Agreement and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function getAgreement()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Agreement();
		$this->__AgreementA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setAgreement($value)
	{
		$this->__AgreementA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement[]
	 */
	public function getAllAgreement()
	{
		return $this->__AgreementA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_LegalInfo
	 */
	public function getLegalInfo()
	{
		if($this->__LegalInfo == null)
		{
			$this->__LegalInfo = new B3it_XmlBind_Opentrans21_Bmecat_LegalInfo();
		}
	
		return $this->__LegalInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_LegalInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setLegalInfo($value)
	{
		$this->__LegalInfo = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Supplier
	 */
	public function getSupplier()
	{
		if($this->__Supplier == null)
		{
			$this->__Supplier = new B3it_XmlBind_Opentrans21_Bmecat_Supplier();
		}
	
		return $this->__Supplier;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Supplier
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setSupplier($value)
	{
		$this->__Supplier = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DocumentCreatorIdref
	 */
	public function getDocumentCreatorIdref()
	{
		if($this->__DocumentCreatorIdref == null)
		{
			$this->__DocumentCreatorIdref = new B3it_XmlBind_Opentrans21_Bmecat_DocumentCreatorIdref();
		}
	
		return $this->__DocumentCreatorIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DocumentCreatorIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setDocumentCreatorIdref($value)
	{
		$this->__DocumentCreatorIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parties
	 */
	public function getParties()
	{
		if($this->__Parties == null)
		{
			$this->__Parties = new B3it_XmlBind_Opentrans21_Bmecat_Parties();
		}
	
		return $this->__Parties;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Parties
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setParties($value)
	{
		$this->__Parties = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Areas
	 */
	public function getAreas()
	{
		if($this->__Areas == null)
		{
			$this->__Areas = new B3it_XmlBind_Opentrans21_Bmecat_Areas();
		}
	
		return $this->__Areas;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Areas
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setAreas($value)
	{
		$this->__Areas = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Header_Bmecat_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->__UserDefinedExtensions == null)
		{
			$this->__UserDefinedExtensions = new B3it_XmlBind_Opentrans21_Header_Bmecat_UserDefinedExtensions();
		}
	
		return $this->__UserDefinedExtensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Header_Bmecat_UserDefinedExtensions
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->__UserDefinedExtensions = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:HEADER');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:HEADER');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__GeneratorInfo != null){
			$this->__GeneratorInfo->toXml($xml);
		}
		if($this->__Catalog != null){
			$this->__Catalog->toXml($xml);
		}
		if($this->__BuyerIdref != null){
			$this->__BuyerIdref->toXml($xml);
		}
		if($this->__Buyer != null){
			$this->__Buyer->toXml($xml);
		}
		if($this->__AgreementA != null){
			foreach($this->__AgreementA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__LegalInfo != null){
			$this->__LegalInfo->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__Supplier != null){
			$this->__Supplier->toXml($xml);
		}
		if($this->__DocumentCreatorIdref != null){
			$this->__DocumentCreatorIdref->toXml($xml);
		}
		if($this->__Parties != null){
			$this->__Parties->toXml($xml);
		}
		if($this->__Areas != null){
			$this->__Areas->toXml($xml);
		}
		if($this->__UserDefinedExtensions != null){
			$this->__UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}

}
