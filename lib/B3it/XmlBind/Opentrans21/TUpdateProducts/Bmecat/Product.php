<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TUpdateProducts_Bmecat_Product
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPid */
	private $__SupplierPid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductDetails */
	private $__ProductDetails = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductFeatures */
	private $__ProductFeaturesA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductOrderDetails */
	private $__ProductOrderDetails = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails */
	private $__ProductPriceDetailsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions */
	private $__UserDefinedExtensions = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductReference */
	private $__ProductReferenceA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductContacts */
	private $__ProductContacts = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductIppDetails */
	private $__ProductIppDetails = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductLogisticDetails */
	private $__ProductLogisticDetails = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails */
	private $__ProductConfigDetails = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierPid
	 */
	public function getSupplierPid()
	{
		if($this->__SupplierPid == null)
		{
			$this->__SupplierPid = new B3it_XmlBind_Opentrans21_Bmecat_SupplierPid();
		}
	
		return $this->__SupplierPid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierPid
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setSupplierPid($value)
	{
		$this->__SupplierPid = $value;
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
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function getProductDetails()
	{
		if($this->__ProductDetails == null)
		{
			$this->__ProductDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductDetails();
		}
	
		return $this->__ProductDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductDetails($value)
	{
		$this->__ProductDetails = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ProductFeatures and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductFeatures
	 */
	public function getProductFeatures()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ProductFeatures();
		$this->__ProductFeaturesA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductFeatures
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductFeatures($value)
	{
		$this->__ProductFeaturesA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductFeatures[]
	 */
	public function getAllProductFeatures()
	{
		return $this->__ProductFeaturesA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductOrderDetails
	 */
	public function getProductOrderDetails()
	{
		if($this->__ProductOrderDetails == null)
		{
			$this->__ProductOrderDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductOrderDetails();
		}
	
		return $this->__ProductOrderDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductOrderDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductOrderDetails($value)
	{
		$this->__ProductOrderDetails = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails();
		$this->__ProductPriceDetailsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductPriceDetails($value)
	{
		$this->__ProductPriceDetailsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails[]
	 */
	public function getAllProductPriceDetails()
	{
		return $this->__ProductPriceDetailsA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->__UserDefinedExtensions == null)
		{
			$this->__UserDefinedExtensions = new B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions();
		}
	
		return $this->__UserDefinedExtensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->__UserDefinedExtensions = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ProductReference and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function getProductReference()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ProductReference();
		$this->__ProductReferenceA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductReference($value)
	{
		$this->__ProductReferenceA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference[]
	 */
	public function getAllProductReference()
	{
		return $this->__ProductReferenceA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductContacts
	 */
	public function getProductContacts()
	{
		if($this->__ProductContacts == null)
		{
			$this->__ProductContacts = new B3it_XmlBind_Opentrans21_Bmecat_ProductContacts();
		}
	
		return $this->__ProductContacts;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductContacts
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductContacts($value)
	{
		$this->__ProductContacts = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductIppDetails
	 */
	public function getProductIppDetails()
	{
		if($this->__ProductIppDetails == null)
		{
			$this->__ProductIppDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductIppDetails();
		}
	
		return $this->__ProductIppDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductIppDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductIppDetails($value)
	{
		$this->__ProductIppDetails = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductLogisticDetails
	 */
	public function getProductLogisticDetails()
	{
		if($this->__ProductLogisticDetails == null)
		{
			$this->__ProductLogisticDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductLogisticDetails();
		}
	
		return $this->__ProductLogisticDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductLogisticDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductLogisticDetails($value)
	{
		$this->__ProductLogisticDetails = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails
	 */
	public function getProductConfigDetails()
	{
		if($this->__ProductConfigDetails == null)
		{
			$this->__ProductConfigDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails();
		}
	
		return $this->__ProductConfigDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_Product
	 */
	public function setProductConfigDetails($value)
	{
		$this->__ProductConfigDetails = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SupplierPid != null){
			$this->__SupplierPid->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__ProductDetails != null){
			$this->__ProductDetails->toXml($xml);
		}
		if($this->__ProductFeaturesA != null){
			foreach($this->__ProductFeaturesA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductOrderDetails != null){
			$this->__ProductOrderDetails->toXml($xml);
		}
		if($this->__ProductPriceDetailsA != null){
			foreach($this->__ProductPriceDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__UserDefinedExtensions != null){
			$this->__UserDefinedExtensions->toXml($xml);
		}
		if($this->__ProductReferenceA != null){
			foreach($this->__ProductReferenceA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductContacts != null){
			$this->__ProductContacts->toXml($xml);
		}
		if($this->__ProductIppDetails != null){
			$this->__ProductIppDetails->toXml($xml);
		}
		if($this->__ProductLogisticDetails != null){
			$this->__ProductLogisticDetails->toXml($xml);
		}
		if($this->__ProductConfigDetails != null){
			$this->__ProductConfigDetails->toXml($xml);
		}


		return $xml;
	}

}
