<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ArticleOrderDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_OrderUnit */
	private $__OrderUnit = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ContentUnit */
	private $__ContentUnit = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_NoCuPerOu */
	private $__NoCuPerOu = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref */
	private $__SupplierPidref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity */
	private $__PriceQuantity = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_QuantityMin */
	private $__QuantityMin = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_QuantityInterval */
	private $__QuantityInterval = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_QuantityMax */
	private $__QuantityMax = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PackingUnits */
	private $__PackingUnits = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_OrderUnit
	 */
	public function getOrderUnit()
	{
		if($this->__OrderUnit == null)
		{
			$this->__OrderUnit = new B3it_XmlBind_Opentrans21_Bmecat_OrderUnit();
		}
	
		return $this->__OrderUnit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_OrderUnit
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setOrderUnit($value)
	{
		$this->__OrderUnit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContentUnit
	 */
	public function getContentUnit()
	{
		if($this->__ContentUnit == null)
		{
			$this->__ContentUnit = new B3it_XmlBind_Opentrans21_Bmecat_ContentUnit();
		}
	
		return $this->__ContentUnit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ContentUnit
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setContentUnit($value)
	{
		$this->__ContentUnit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_NoCuPerOu
	 */
	public function getNoCuPerOu()
	{
		if($this->__NoCuPerOu == null)
		{
			$this->__NoCuPerOu = new B3it_XmlBind_Opentrans21_Bmecat_NoCuPerOu();
		}
	
		return $this->__NoCuPerOu;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_NoCuPerOu
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setNoCuPerOu($value)
	{
		$this->__NoCuPerOu = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref
	 */
	public function getSupplierPidref()
	{
		if($this->__SupplierPidref == null)
		{
			$this->__SupplierPidref = new B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref();
		}
	
		return $this->__SupplierPidref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setSupplierPidref($value)
	{
		$this->__SupplierPidref = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity
	 */
	public function getPriceQuantity()
	{
		if($this->__PriceQuantity == null)
		{
			$this->__PriceQuantity = new B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity();
		}
	
		return $this->__PriceQuantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceQuantity
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setPriceQuantity($value)
	{
		$this->__PriceQuantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_QuantityMin
	 */
	public function getQuantityMin()
	{
		if($this->__QuantityMin == null)
		{
			$this->__QuantityMin = new B3it_XmlBind_Opentrans21_Bmecat_QuantityMin();
		}
	
		return $this->__QuantityMin;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_QuantityMin
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setQuantityMin($value)
	{
		$this->__QuantityMin = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_QuantityInterval
	 */
	public function getQuantityInterval()
	{
		if($this->__QuantityInterval == null)
		{
			$this->__QuantityInterval = new B3it_XmlBind_Opentrans21_Bmecat_QuantityInterval();
		}
	
		return $this->__QuantityInterval;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_QuantityInterval
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setQuantityInterval($value)
	{
		$this->__QuantityInterval = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_QuantityMax
	 */
	public function getQuantityMax()
	{
		if($this->__QuantityMax == null)
		{
			$this->__QuantityMax = new B3it_XmlBind_Opentrans21_Bmecat_QuantityMax();
		}
	
		return $this->__QuantityMax;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_QuantityMax
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setQuantityMax($value)
	{
		$this->__QuantityMax = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnits
	 */
	public function getPackingUnits()
	{
		if($this->__PackingUnits == null)
		{
			$this->__PackingUnits = new B3it_XmlBind_Opentrans21_Bmecat_PackingUnits();
		}
	
		return $this->__PackingUnits;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PackingUnits
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function setPackingUnits($value)
	{
		$this->__PackingUnits = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_ORDER_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_ORDER_DETAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderUnit != null){
			$this->__OrderUnit->toXml($xml);
		}
		if($this->__ContentUnit != null){
			$this->__ContentUnit->toXml($xml);
		}
		if($this->__NoCuPerOu != null){
			$this->__NoCuPerOu->toXml($xml);
		}
		if($this->__SupplierPidref != null){
			$this->__SupplierPidref->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__PriceQuantity != null){
			$this->__PriceQuantity->toXml($xml);
		}
		if($this->__QuantityMin != null){
			$this->__QuantityMin->toXml($xml);
		}
		if($this->__QuantityInterval != null){
			$this->__QuantityInterval->toXml($xml);
		}
		if($this->__QuantityMax != null){
			$this->__QuantityMax->toXml($xml);
		}
		if($this->__PackingUnits != null){
			$this->__PackingUnits->toXml($xml);
		}


		return $xml;
	}

}
