<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TUpdatePrices_Bmecat_Product
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPid */
	private $__SupplierPid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails */
	private $__ProductPriceDetailsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions */
	private $__UserDefinedExtensions = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product
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
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
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
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product
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
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->__UserDefinedExtensions = $value;
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
		if($this->__ProductPriceDetailsA != null){
			foreach($this->__ProductPriceDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__UserDefinedExtensions != null){
			$this->__UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}

}
