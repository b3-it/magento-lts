<?php
class B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SupplierPid */
	private $_SupplierPid = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var ProductDetails */
	private $_ProductDetails = null;	

	/* @var ProductFeatures */
	private $_ProductFeaturess = array();	

	/* @var ProductOrderDetails */
	private $_ProductOrderDetails = null;	

	/* @var ProductPriceDetails */
	private $_ProductPriceDetailss = array();	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var UserDefinedExtensions */
	private $_UserDefinedExtensions = null;	

	/* @var ProductReference */
	private $_ProductReferences = array();	

	/* @var ProductContacts */
	private $_ProductContacts = null;	

	/* @var ProductIppDetails */
	private $_ProductIppDetails = null;	

	/* @var ProductLogisticDetails */
	private $_ProductLogisticDetails = null;	

	/* @var ProductConfigDetails */
	private $_ProductConfigDetails = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_SupplierPid
	 */
	public function getSupplierPid()
	{
		if($this->_SupplierPid == null)
		{
			$this->_SupplierPid = new B3it_XmlBind_Bmecat2005_SupplierPid();
		}
		
		return $this->_SupplierPid;
	}
	
	/**
	 * @param $value SupplierPid
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierPid($value)
	{
		$this->_SupplierPid = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails
	 */
	public function getProductDetails()
	{
		if($this->_ProductDetails == null)
		{
			$this->_ProductDetails = new B3it_XmlBind_Bmecat2005_ProductDetails();
		}
		
		return $this->_ProductDetails;
	}
	
	/**
	 * @param $value ProductDetails
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductDetails($value)
	{
		$this->_ProductDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductFeatures[]
	 */
	public function getAllProductFeatures()
	{
		return $this->_ProductFeaturess;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductFeatures and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductFeatures
	 */
	public function getProductFeatures()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductFeatures();
		$this->_ProductFeaturess[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductFeatures[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductFeatures($value)
	{
		$this->_ProductFeatures = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails
	 */
	public function getProductOrderDetails()
	{
		if($this->_ProductOrderDetails == null)
		{
			$this->_ProductOrderDetails = new B3it_XmlBind_Bmecat2005_ProductOrderDetails();
		}
		
		return $this->_ProductOrderDetails;
	}
	
	/**
	 * @param $value ProductOrderDetails
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductOrderDetails($value)
	{
		$this->_ProductOrderDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails[]
	 */
	public function getAllProductPriceDetails()
	{
		return $this->_ProductPriceDetailss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductPriceDetails and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductPriceDetails();
		$this->_ProductPriceDetailss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductPriceDetails[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPriceDetails($value)
	{
		$this->_ProductPriceDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat2005_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductReference[]
	 */
	public function getAllProductReference()
	{
		return $this->_ProductReferences;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductReference and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductReference
	 */
	public function getProductReference()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductReference();
		$this->_ProductReferences[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductReference[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductReference($value)
	{
		$this->_ProductReference = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductContacts
	 */
	public function getProductContacts()
	{
		if($this->_ProductContacts == null)
		{
			$this->_ProductContacts = new B3it_XmlBind_Bmecat2005_ProductContacts();
		}
		
		return $this->_ProductContacts;
	}
	
	/**
	 * @param $value ProductContacts
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductContacts($value)
	{
		$this->_ProductContacts = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductIppDetails
	 */
	public function getProductIppDetails()
	{
		if($this->_ProductIppDetails == null)
		{
			$this->_ProductIppDetails = new B3it_XmlBind_Bmecat2005_ProductIppDetails();
		}
		
		return $this->_ProductIppDetails;
	}
	
	/**
	 * @param $value ProductIppDetails
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductIppDetails($value)
	{
		$this->_ProductIppDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductLogisticDetails
	 */
	public function getProductLogisticDetails()
	{
		if($this->_ProductLogisticDetails == null)
		{
			$this->_ProductLogisticDetails = new B3it_XmlBind_Bmecat2005_ProductLogisticDetails();
		}
		
		return $this->_ProductLogisticDetails;
	}
	
	/**
	 * @param $value ProductLogisticDetails
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductLogisticDetails($value)
	{
		$this->_ProductLogisticDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductConfigDetails
	 */
	public function getProductConfigDetails()
	{
		if($this->_ProductConfigDetails == null)
		{
			$this->_ProductConfigDetails = new B3it_XmlBind_Bmecat2005_ProductConfigDetails();
		}
		
		return $this->_ProductConfigDetails;
	}
	
	/**
	 * @param $value ProductConfigDetails
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductConfigDetails($value)
	{
		$this->_ProductConfigDetails = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_SupplierPid != null){
			$this->_SupplierPid->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_ProductDetails != null){
			$this->_ProductDetails->toXml($xml);
		}
		if($this->_ProductFeaturess != null){
			foreach($this->_ProductFeaturess as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ProductOrderDetails != null){
			$this->_ProductOrderDetails->toXml($xml);
		}
		if($this->_ProductPriceDetailss != null){
			foreach($this->_ProductPriceDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}
		if($this->_ProductReferences != null){
			foreach($this->_ProductReferences as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ProductContacts != null){
			$this->_ProductContacts->toXml($xml);
		}
		if($this->_ProductIppDetails != null){
			$this->_ProductIppDetails->toXml($xml);
		}
		if($this->_ProductLogisticDetails != null){
			$this->_ProductLogisticDetails->toXml($xml);
		}
		if($this->_ProductConfigDetails != null){
			$this->_ProductConfigDetails->toXml($xml);
		}


		return $xml;
	}
}