<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Package
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Package extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_PackageId */
	private $__PackageIdA = array();

	
	/* @var B3it_XmlBind_Opentrans21_PackageDescr */
	private $__PackageDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode */
	private $__PackingUnitCode = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr */
	private $__PackingUnitDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_PackageOrderUnitQuantity */
	private $__PackageOrderUnitQuantity = null;

	/* @var B3it_XmlBind_Opentrans21_PackageQuantity */
	private $__PackageQuantity = null;

	/* @var B3it_XmlBind_Opentrans21_PackageDimensions */
	private $__PackageDimensions = null;

	
	/* @var B3it_XmlBind_Opentrans21_MeansOfTransportIdref */
	private $__MeansOfTransportIdrefA = array();

	/* @var B3it_XmlBind_Opentrans21_SubPackages */
	private $__SubPackages = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_PackageId and add it to list
	 * @return B3it_XmlBind_Opentrans21_PackageId
	 */
	public function getPackageId()
	{
		$res = new B3it_XmlBind_Opentrans21_PackageId();
		$this->__PackageIdA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PackageId
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackageId($value)
	{
		$this->__PackageIdA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PackageId[]
	 */
	public function getAllPackageId()
	{
		return $this->__PackageIdA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_PackageDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_PackageDescr
	 */
	public function getPackageDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_PackageDescr();
		$this->__PackageDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PackageDescr
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackageDescr($value)
	{
		$this->__PackageDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PackageDescr[]
	 */
	public function getAllPackageDescr()
	{
		return $this->__PackageDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode
	 */
	public function getPackingUnitCode()
	{
		if($this->__PackingUnitCode == null)
		{
			$this->__PackingUnitCode = new B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode();
		}
	
		return $this->__PackingUnitCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackingUnitCode($value)
	{
		$this->__PackingUnitCode = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr
	 */
	public function getPackingUnitDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr();
		$this->__PackingUnitDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackingUnitDescr($value)
	{
		$this->__PackingUnitDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr[]
	 */
	public function getAllPackingUnitDescr()
	{
		return $this->__PackingUnitDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_PackageOrderUnitQuantity
	 */
	public function getPackageOrderUnitQuantity()
	{
		if($this->__PackageOrderUnitQuantity == null)
		{
			$this->__PackageOrderUnitQuantity = new B3it_XmlBind_Opentrans21_PackageOrderUnitQuantity();
		}
	
		return $this->__PackageOrderUnitQuantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PackageOrderUnitQuantity
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackageOrderUnitQuantity($value)
	{
		$this->__PackageOrderUnitQuantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PackageQuantity
	 */
	public function getPackageQuantity()
	{
		if($this->__PackageQuantity == null)
		{
			$this->__PackageQuantity = new B3it_XmlBind_Opentrans21_PackageQuantity();
		}
	
		return $this->__PackageQuantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PackageQuantity
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackageQuantity($value)
	{
		$this->__PackageQuantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PackageDimensions
	 */
	public function getPackageDimensions()
	{
		if($this->__PackageDimensions == null)
		{
			$this->__PackageDimensions = new B3it_XmlBind_Opentrans21_PackageDimensions();
		}
	
		return $this->__PackageDimensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PackageDimensions
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setPackageDimensions($value)
	{
		$this->__PackageDimensions = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_MeansOfTransportIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_MeansOfTransportIdref
	 */
	public function getMeansOfTransportIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_MeansOfTransportIdref();
		$this->__MeansOfTransportIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MeansOfTransportIdref
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setMeansOfTransportIdref($value)
	{
		$this->__MeansOfTransportIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_MeansOfTransportIdref[]
	 */
	public function getAllMeansOfTransportIdref()
	{
		return $this->__MeansOfTransportIdrefA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_SubPackages
	 */
	public function getSubPackages()
	{
		if($this->__SubPackages == null)
		{
			$this->__SubPackages = new B3it_XmlBind_Opentrans21_SubPackages();
		}
	
		return $this->__SubPackages;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SubPackages
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function setSubPackages($value)
	{
		$this->__SubPackages = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PACKAGE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PackageIdA != null){
			foreach($this->__PackageIdA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PackageDescrA != null){
			foreach($this->__PackageDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PackingUnitCode != null){
			$this->__PackingUnitCode->toXml($xml);
		}
		if($this->__PackingUnitDescrA != null){
			foreach($this->__PackingUnitDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PackageOrderUnitQuantity != null){
			$this->__PackageOrderUnitQuantity->toXml($xml);
		}
		if($this->__PackageQuantity != null){
			$this->__PackageQuantity->toXml($xml);
		}
		if($this->__PackageDimensions != null){
			$this->__PackageDimensions->toXml($xml);
		}
		if($this->__MeansOfTransportIdrefA != null){
			foreach($this->__MeansOfTransportIdrefA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SubPackages != null){
			$this->__SubPackages->toXml($xml);
		}


		return $xml;
	}

}
