<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ProductId
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ProductId extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPid */
	private $__SupplierPid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_ConfigCodeFix */
	private $__ConfigCodeFix = null;

	
	/* @var B3it_XmlBind_Opentrans21_LotNumber */
	private $__LotNumberA = array();

	
	/* @var B3it_XmlBind_Opentrans21_SerialNumber */
	private $__SerialNumberA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalPid */
	private $__InternationalPidA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerPid */
	private $__BuyerPidA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort */
	private $__DescriptionShortA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong */
	private $__DescriptionLongA = array();

	/* @var B3it_XmlBind_Opentrans21_ManufacturerInfo */
	private $__ManufacturerInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductType */
	private $__ProductType = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_ProductId
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
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ConfigCodeFix
	 */
	public function getConfigCodeFix()
	{
		if($this->__ConfigCodeFix == null)
		{
			$this->__ConfigCodeFix = new B3it_XmlBind_Opentrans21_ConfigCodeFix();
		}
	
		return $this->__ConfigCodeFix;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ConfigCodeFix
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setConfigCodeFix($value)
	{
		$this->__ConfigCodeFix = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_LotNumber and add it to list
	 * @return B3it_XmlBind_Opentrans21_LotNumber
	 */
	public function getLotNumber()
	{
		$res = new B3it_XmlBind_Opentrans21_LotNumber();
		$this->__LotNumberA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_LotNumber
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setLotNumber($value)
	{
		$this->__LotNumberA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_LotNumber[]
	 */
	public function getAllLotNumber()
	{
		return $this->__LotNumberA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_SerialNumber and add it to list
	 * @return B3it_XmlBind_Opentrans21_SerialNumber
	 */
	public function getSerialNumber()
	{
		$res = new B3it_XmlBind_Opentrans21_SerialNumber();
		$this->__SerialNumberA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SerialNumber
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setSerialNumber($value)
	{
		$this->__SerialNumberA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SerialNumber[]
	 */
	public function getAllSerialNumber()
	{
		return $this->__SerialNumberA;
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
	 * @return B3it_XmlBind_Opentrans21_ProductId
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


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_BuyerPid and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerPid
	 */
	public function getBuyerPid()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_BuyerPid();
		$this->__BuyerPidA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_BuyerPid
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setBuyerPid($value)
	{
		$this->__BuyerPidA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerPid[]
	 */
	public function getAllBuyerPid()
	{
		return $this->__BuyerPidA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort
	 */
	public function getDescriptionShort()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort();
		$this->__DescriptionShortA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setDescriptionShort($value)
	{
		$this->__DescriptionShortA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort[]
	 */
	public function getAllDescriptionShort()
	{
		return $this->__DescriptionShortA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong
	 */
	public function getDescriptionLong()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong();
		$this->__DescriptionLongA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setDescriptionLong($value)
	{
		$this->__DescriptionLongA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong[]
	 */
	public function getAllDescriptionLong()
	{
		return $this->__DescriptionLongA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_ManufacturerInfo
	 */
	public function getManufacturerInfo()
	{
		if($this->__ManufacturerInfo == null)
		{
			$this->__ManufacturerInfo = new B3it_XmlBind_Opentrans21_ManufacturerInfo();
		}
	
		return $this->__ManufacturerInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ManufacturerInfo
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setManufacturerInfo($value)
	{
		$this->__ManufacturerInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductType
	 */
	public function getProductType()
	{
		if($this->__ProductType == null)
		{
			$this->__ProductType = new B3it_XmlBind_Opentrans21_Bmecat_ProductType();
		}
	
		return $this->__ProductType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductType
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function setProductType($value)
	{
		$this->__ProductType = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PRODUCT_ID');
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
		if($this->__ConfigCodeFix != null){
			$this->__ConfigCodeFix->toXml($xml);
		}
		if($this->__LotNumberA != null){
			foreach($this->__LotNumberA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SerialNumberA != null){
			foreach($this->__SerialNumberA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__InternationalPidA != null){
			foreach($this->__InternationalPidA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__BuyerPidA != null){
			foreach($this->__BuyerPidA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DescriptionShortA != null){
			foreach($this->__DescriptionShortA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DescriptionLongA != null){
			foreach($this->__DescriptionLongA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ManufacturerInfo != null){
			$this->__ManufacturerInfo->toXml($xml);
		}
		if($this->__ProductType != null){
			$this->__ProductType->toXml($xml);
		}


		return $xml;
	}

}
