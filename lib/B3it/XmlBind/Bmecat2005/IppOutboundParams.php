<?php
class B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppLanguages */
	private $_IppLanguages = null;	

	/* @var IppTerritories */
	private $_IppTerritories = null;	

	/* @var IppPriceCurrencies */
	private $_IppPriceCurrencies = null;	

	/* @var IppPriceTypes */
	private $_IppPriceTypes = null;	

	/* @var IppSupplierPid */
	private $_IppSupplierPid = null;	

	/* @var IppProductconfigIdref */
	private $_IppProductconfigIdref = null;	

	/* @var IppProductlistIdref */
	private $_IppProductlistIdref = null;	

	/* @var IppUserInfo */
	private $_IppUserInfo = null;	

	/* @var IppAuthentificationInfo */
	private $_IppAuthentificationInfo = null;	

	/* @var IppParamDefinition */
	private $_IppParamDefinitions = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppLanguages
	 */
	public function getIppLanguages()
	{
		if($this->_IppLanguages == null)
		{
			$this->_IppLanguages = new B3it_XmlBind_Bmecat2005_IppLanguages();
		}
		
		return $this->_IppLanguages;
	}
	
	/**
	 * @param $value IppLanguages
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppLanguages($value)
	{
		$this->_IppLanguages = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppTerritories
	 */
	public function getIppTerritories()
	{
		if($this->_IppTerritories == null)
		{
			$this->_IppTerritories = new B3it_XmlBind_Bmecat2005_IppTerritories();
		}
		
		return $this->_IppTerritories;
	}
	
	/**
	 * @param $value IppTerritories
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppTerritories($value)
	{
		$this->_IppTerritories = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppPriceCurrencies
	 */
	public function getIppPriceCurrencies()
	{
		if($this->_IppPriceCurrencies == null)
		{
			$this->_IppPriceCurrencies = new B3it_XmlBind_Bmecat2005_IppPriceCurrencies();
		}
		
		return $this->_IppPriceCurrencies;
	}
	
	/**
	 * @param $value IppPriceCurrencies
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppPriceCurrencies($value)
	{
		$this->_IppPriceCurrencies = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppPriceTypes
	 */
	public function getIppPriceTypes()
	{
		if($this->_IppPriceTypes == null)
		{
			$this->_IppPriceTypes = new B3it_XmlBind_Bmecat2005_IppPriceTypes();
		}
		
		return $this->_IppPriceTypes;
	}
	
	/**
	 * @param $value IppPriceTypes
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppPriceTypes($value)
	{
		$this->_IppPriceTypes = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppSupplierPid
	 */
	public function getIppSupplierPid()
	{
		if($this->_IppSupplierPid == null)
		{
			$this->_IppSupplierPid = new B3it_XmlBind_Bmecat2005_IppSupplierPid();
		}
		
		return $this->_IppSupplierPid;
	}
	
	/**
	 * @param $value IppSupplierPid
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppSupplierPid($value)
	{
		$this->_IppSupplierPid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppProductconfigIdref
	 */
	public function getIppProductconfigIdref()
	{
		if($this->_IppProductconfigIdref == null)
		{
			$this->_IppProductconfigIdref = new B3it_XmlBind_Bmecat2005_IppProductconfigIdref();
		}
		
		return $this->_IppProductconfigIdref;
	}
	
	/**
	 * @param $value IppProductconfigIdref
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppProductconfigIdref($value)
	{
		$this->_IppProductconfigIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppProductlistIdref
	 */
	public function getIppProductlistIdref()
	{
		if($this->_IppProductlistIdref == null)
		{
			$this->_IppProductlistIdref = new B3it_XmlBind_Bmecat2005_IppProductlistIdref();
		}
		
		return $this->_IppProductlistIdref;
	}
	
	/**
	 * @param $value IppProductlistIdref
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppProductlistIdref($value)
	{
		$this->_IppProductlistIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppUserInfo
	 */
	public function getIppUserInfo()
	{
		if($this->_IppUserInfo == null)
		{
			$this->_IppUserInfo = new B3it_XmlBind_Bmecat2005_IppUserInfo();
		}
		
		return $this->_IppUserInfo;
	}
	
	/**
	 * @param $value IppUserInfo
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppUserInfo($value)
	{
		$this->_IppUserInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppAuthentificationInfo
	 */
	public function getIppAuthentificationInfo()
	{
		if($this->_IppAuthentificationInfo == null)
		{
			$this->_IppAuthentificationInfo = new B3it_XmlBind_Bmecat2005_IppAuthentificationInfo();
		}
		
		return $this->_IppAuthentificationInfo;
	}
	
	/**
	 * @param $value IppAuthentificationInfo
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppAuthentificationInfo($value)
	{
		$this->_IppAuthentificationInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppParamDefinition[]
	 */
	public function getAllIppParamDefinition()
	{
		return $this->_IppParamDefinitions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppParamDefinition and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppParamDefinition
	 */
	public function getIppParamDefinition()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppParamDefinition();
		$this->_IppParamDefinitions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppParamDefinition[]
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParamDefinition($value)
	{
		$this->_IppParamDefinition = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_OUTBOUND_PARAMS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppLanguages != null){
			$this->_IppLanguages->toXml($xml);
		}
		if($this->_IppTerritories != null){
			$this->_IppTerritories->toXml($xml);
		}
		if($this->_IppPriceCurrencies != null){
			$this->_IppPriceCurrencies->toXml($xml);
		}
		if($this->_IppPriceTypes != null){
			$this->_IppPriceTypes->toXml($xml);
		}
		if($this->_IppSupplierPid != null){
			$this->_IppSupplierPid->toXml($xml);
		}
		if($this->_IppProductconfigIdref != null){
			$this->_IppProductconfigIdref->toXml($xml);
		}
		if($this->_IppProductlistIdref != null){
			$this->_IppProductlistIdref->toXml($xml);
		}
		if($this->_IppUserInfo != null){
			$this->_IppUserInfo->toXml($xml);
		}
		if($this->_IppAuthentificationInfo != null){
			$this->_IppAuthentificationInfo->toXml($xml);
		}
		if($this->_IppParamDefinitions != null){
			foreach($this->_IppParamDefinitions as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}