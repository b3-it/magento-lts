<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppOutboundParams
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppLanguages */
	private $__IppLanguages = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppTerritories */
	private $__IppTerritories = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppPriceCurrencies */
	private $__IppPriceCurrencies = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppPriceTypes */
	private $__IppPriceTypes = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppSupplierPid */
	private $__IppSupplierPid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppProductconfigIdref */
	private $__IppProductconfigIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppProductlistIdref */
	private $__IppProductlistIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppUserInfo */
	private $__IppUserInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppAuthentificationInfo */
	private $__IppAuthentificationInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition */
	private $__IppParamDefinitionA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppLanguages
	 */
	public function getIppLanguages()
	{
		if($this->__IppLanguages == null)
		{
			$this->__IppLanguages = new B3it_XmlBind_Opentrans21_Bmecat_IppLanguages();
		}
	
		return $this->__IppLanguages;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppLanguages
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppLanguages($value)
	{
		$this->__IppLanguages = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppTerritories
	 */
	public function getIppTerritories()
	{
		if($this->__IppTerritories == null)
		{
			$this->__IppTerritories = new B3it_XmlBind_Opentrans21_Bmecat_IppTerritories();
		}
	
		return $this->__IppTerritories;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppTerritories
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppTerritories($value)
	{
		$this->__IppTerritories = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppPriceCurrencies
	 */
	public function getIppPriceCurrencies()
	{
		if($this->__IppPriceCurrencies == null)
		{
			$this->__IppPriceCurrencies = new B3it_XmlBind_Opentrans21_Bmecat_IppPriceCurrencies();
		}
	
		return $this->__IppPriceCurrencies;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppPriceCurrencies
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppPriceCurrencies($value)
	{
		$this->__IppPriceCurrencies = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppPriceTypes
	 */
	public function getIppPriceTypes()
	{
		if($this->__IppPriceTypes == null)
		{
			$this->__IppPriceTypes = new B3it_XmlBind_Opentrans21_Bmecat_IppPriceTypes();
		}
	
		return $this->__IppPriceTypes;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppPriceTypes
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppPriceTypes($value)
	{
		$this->__IppPriceTypes = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppSupplierPid
	 */
	public function getIppSupplierPid()
	{
		if($this->__IppSupplierPid == null)
		{
			$this->__IppSupplierPid = new B3it_XmlBind_Opentrans21_Bmecat_IppSupplierPid();
		}
	
		return $this->__IppSupplierPid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppSupplierPid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppSupplierPid($value)
	{
		$this->__IppSupplierPid = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppProductconfigIdref
	 */
	public function getIppProductconfigIdref()
	{
		if($this->__IppProductconfigIdref == null)
		{
			$this->__IppProductconfigIdref = new B3it_XmlBind_Opentrans21_Bmecat_IppProductconfigIdref();
		}
	
		return $this->__IppProductconfigIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppProductconfigIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppProductconfigIdref($value)
	{
		$this->__IppProductconfigIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppProductlistIdref
	 */
	public function getIppProductlistIdref()
	{
		if($this->__IppProductlistIdref == null)
		{
			$this->__IppProductlistIdref = new B3it_XmlBind_Opentrans21_Bmecat_IppProductlistIdref();
		}
	
		return $this->__IppProductlistIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppProductlistIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppProductlistIdref($value)
	{
		$this->__IppProductlistIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppUserInfo
	 */
	public function getIppUserInfo()
	{
		if($this->__IppUserInfo == null)
		{
			$this->__IppUserInfo = new B3it_XmlBind_Opentrans21_Bmecat_IppUserInfo();
		}
	
		return $this->__IppUserInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppUserInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppUserInfo($value)
	{
		$this->__IppUserInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppAuthentificationInfo
	 */
	public function getIppAuthentificationInfo()
	{
		if($this->__IppAuthentificationInfo == null)
		{
			$this->__IppAuthentificationInfo = new B3it_XmlBind_Opentrans21_Bmecat_IppAuthentificationInfo();
		}
	
		return $this->__IppAuthentificationInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppAuthentificationInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppAuthentificationInfo($value)
	{
		$this->__IppAuthentificationInfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition
	 */
	public function getIppParamDefinition()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition();
		$this->__IppParamDefinitionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOutboundParams
	 */
	public function setIppParamDefinition($value)
	{
		$this->__IppParamDefinitionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition[]
	 */
	public function getAllIppParamDefinition()
	{
		return $this->__IppParamDefinitionA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_OUTBOUND_PARAMS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_OUTBOUND_PARAMS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppLanguages != null){
			$this->__IppLanguages->toXml($xml);
		}
		if($this->__IppTerritories != null){
			$this->__IppTerritories->toXml($xml);
		}
		if($this->__IppPriceCurrencies != null){
			$this->__IppPriceCurrencies->toXml($xml);
		}
		if($this->__IppPriceTypes != null){
			$this->__IppPriceTypes->toXml($xml);
		}
		if($this->__IppSupplierPid != null){
			$this->__IppSupplierPid->toXml($xml);
		}
		if($this->__IppProductconfigIdref != null){
			$this->__IppProductconfigIdref->toXml($xml);
		}
		if($this->__IppProductlistIdref != null){
			$this->__IppProductlistIdref->toXml($xml);
		}
		if($this->__IppUserInfo != null){
			$this->__IppUserInfo->toXml($xml);
		}
		if($this->__IppAuthentificationInfo != null){
			$this->__IppAuthentificationInfo->toXml($xml);
		}
		if($this->__IppParamDefinitionA != null){
			foreach($this->__IppParamDefinitionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
