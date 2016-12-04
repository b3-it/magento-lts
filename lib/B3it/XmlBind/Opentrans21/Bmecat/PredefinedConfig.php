<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_PredefinedConfig
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCode */
	private $__PredefinedConfigCode = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigName */
	private $__PredefinedConfigNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigDescr */
	private $__PredefinedConfigDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigOrder */
	private $__PredefinedConfigOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails */
	private $__ProductPriceDetails = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPid */
	private $__SupplierPid = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalPid */
	private $__InternationalPidA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCode
	 */
	public function getPredefinedConfigCode()
	{
		if($this->__PredefinedConfigCode == null)
		{
			$this->__PredefinedConfigCode = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCode();
		}
	
		return $this->__PredefinedConfigCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCode
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setPredefinedConfigCode($value)
	{
		$this->__PredefinedConfigCode = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigName
	 */
	public function getPredefinedConfigName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigName();
		$this->__PredefinedConfigNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setPredefinedConfigName($value)
	{
		$this->__PredefinedConfigNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigName[]
	 */
	public function getAllPredefinedConfigName()
	{
		return $this->__PredefinedConfigNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigDescr
	 */
	public function getPredefinedConfigDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigDescr();
		$this->__PredefinedConfigDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setPredefinedConfigDescr($value)
	{
		$this->__PredefinedConfigDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigDescr[]
	 */
	public function getAllPredefinedConfigDescr()
	{
		return $this->__PredefinedConfigDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigOrder
	 */
	public function getPredefinedConfigOrder()
	{
		if($this->__PredefinedConfigOrder == null)
		{
			$this->__PredefinedConfigOrder = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigOrder();
		}
	
		return $this->__PredefinedConfigOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setPredefinedConfigOrder($value)
	{
		$this->__PredefinedConfigOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		if($this->__ProductPriceDetails == null)
		{
			$this->__ProductPriceDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails();
		}
	
		return $this->__ProductPriceDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setProductPriceDetails($value)
	{
		$this->__ProductPriceDetails = $value;
		return $this;
	}
	
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setSupplierPid($value)
	{
		$this->__SupplierPid = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_InternationalPid and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_InternationalPid
	 */
	public function getInternationalPid()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_InternationalPid();
		$this->__InternationalPidA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_InternationalPid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function setInternationalPid($value)
	{
		$this->__InternationalPidA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_InternationalPid[]
	 */
	public function getAllInternationalPid()
	{
		return $this->__InternationalPidA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PREDEFINED_CONFIG');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PREDEFINED_CONFIG');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PredefinedConfigCode != null){
			$this->__PredefinedConfigCode->toXml($xml);
		}
		if($this->__PredefinedConfigNameA != null){
			foreach($this->__PredefinedConfigNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PredefinedConfigDescrA != null){
			foreach($this->__PredefinedConfigDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PredefinedConfigOrder != null){
			$this->__PredefinedConfigOrder->toXml($xml);
		}
		if($this->__ProductPriceDetails != null){
			$this->__ProductPriceDetails->toXml($xml);
		}
		if($this->__SupplierPid != null){
			$this->__SupplierPid->toXml($xml);
		}
		if($this->__InternationalPidA != null){
			foreach($this->__InternationalPidA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
