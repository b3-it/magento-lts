<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ProductDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ProductDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort */
	private $__DescriptionShortA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong */
	private $__DescriptionLongA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalPid */
	private $__InternationalPidA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Ean */
	private $__Ean = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierAltPid */
	private $__SupplierAltPid = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerPid */
	private $__BuyerPidA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid */
	private $__ManufacturerPid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref */
	private $__ManufacturerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerName */
	private $__ManufacturerName = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr */
	private $__ManufacturerTypeDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ErpGroupBuyer */
	private $__ErpGroupBuyer = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ErpGroupSupplier */
	private $__ErpGroupSupplier = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_DeliveryTime */
	private $__DeliveryTime = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass */
	private $__SpecialTreatmentClassA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Keyword */
	private $__KeywordA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Remarks */
	private $__RemarksA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Segment */
	private $__SegmentA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductOrder */
	private $__ProductOrder = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductStatus */
	private $__ProductStatusA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions */
	private $__InternationalRestrictionsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo */
	private $__AccountingInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementRef */
	private $__AgreementRefA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductType */
	private $__ProductTypeA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductCategory */
	private $__ProductCategory = null;


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ean
	 */
	public function getEan()
	{
		if($this->__Ean == null)
		{
			$this->__Ean = new B3it_XmlBind_Opentrans21_Bmecat_Ean();
		}
	
		return $this->__Ean;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Ean
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setEan($value)
	{
		$this->__Ean = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierAltPid
	 */
	public function getSupplierAltPid()
	{
		if($this->__SupplierAltPid == null)
		{
			$this->__SupplierAltPid = new B3it_XmlBind_Opentrans21_Bmecat_SupplierAltPid();
		}
	
		return $this->__SupplierAltPid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierAltPid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setSupplierAltPid($value)
	{
		$this->__SupplierAltPid = $value;
		return $this;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid
	 */
	public function getManufacturerPid()
	{
		if($this->__ManufacturerPid == null)
		{
			$this->__ManufacturerPid = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid();
		}
	
		return $this->__ManufacturerPid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setManufacturerPid($value)
	{
		$this->__ManufacturerPid = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref
	 */
	public function getManufacturerIdref()
	{
		if($this->__ManufacturerIdref == null)
		{
			$this->__ManufacturerIdref = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref();
		}
	
		return $this->__ManufacturerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setManufacturerIdref($value)
	{
		$this->__ManufacturerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerName
	 */
	public function getManufacturerName()
	{
		if($this->__ManufacturerName == null)
		{
			$this->__ManufacturerName = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerName();
		}
	
		return $this->__ManufacturerName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setManufacturerName($value)
	{
		$this->__ManufacturerName = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr
	 */
	public function getManufacturerTypeDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr();
		$this->__ManufacturerTypeDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setManufacturerTypeDescr($value)
	{
		$this->__ManufacturerTypeDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr[]
	 */
	public function getAllManufacturerTypeDescr()
	{
		return $this->__ManufacturerTypeDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ErpGroupBuyer
	 */
	public function getErpGroupBuyer()
	{
		if($this->__ErpGroupBuyer == null)
		{
			$this->__ErpGroupBuyer = new B3it_XmlBind_Opentrans21_Bmecat_ErpGroupBuyer();
		}
	
		return $this->__ErpGroupBuyer;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ErpGroupBuyer
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setErpGroupBuyer($value)
	{
		$this->__ErpGroupBuyer = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ErpGroupSupplier
	 */
	public function getErpGroupSupplier()
	{
		if($this->__ErpGroupSupplier == null)
		{
			$this->__ErpGroupSupplier = new B3it_XmlBind_Opentrans21_Bmecat_ErpGroupSupplier();
		}
	
		return $this->__ErpGroupSupplier;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ErpGroupSupplier
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setErpGroupSupplier($value)
	{
		$this->__ErpGroupSupplier = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTime
	 */
	public function getDeliveryTime()
	{
		if($this->__DeliveryTime == null)
		{
			$this->__DeliveryTime = new B3it_XmlBind_Opentrans21_Bmecat_DeliveryTime();
		}
	
		return $this->__DeliveryTime;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DeliveryTime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setDeliveryTime($value)
	{
		$this->__DeliveryTime = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass
	 */
	public function getSpecialTreatmentClass()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass();
		$this->__SpecialTreatmentClassA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setSpecialTreatmentClass($value)
	{
		$this->__SpecialTreatmentClassA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass[]
	 */
	public function getAllSpecialTreatmentClass()
	{
		return $this->__SpecialTreatmentClassA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Keyword and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Keyword();
		$this->__KeywordA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Keyword
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setKeyword($value)
	{
		$this->__KeywordA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->__KeywordA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Remarks and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Remarks
	 */
	public function getRemarks()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Remarks();
		$this->__RemarksA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Remarks
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setRemarks($value)
	{
		$this->__RemarksA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Remarks[]
	 */
	public function getAllRemarks()
	{
		return $this->__RemarksA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Segment and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Segment
	 */
	public function getSegment()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Segment();
		$this->__SegmentA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Segment
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setSegment($value)
	{
		$this->__SegmentA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Segment[]
	 */
	public function getAllSegment()
	{
		return $this->__SegmentA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductOrder
	 */
	public function getProductOrder()
	{
		if($this->__ProductOrder == null)
		{
			$this->__ProductOrder = new B3it_XmlBind_Opentrans21_Bmecat_ProductOrder();
		}
	
		return $this->__ProductOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setProductOrder($value)
	{
		$this->__ProductOrder = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ProductStatus and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductStatus
	 */
	public function getProductStatus()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ProductStatus();
		$this->__ProductStatusA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductStatus
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setProductStatus($value)
	{
		$this->__ProductStatusA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductStatus[]
	 */
	public function getAllProductStatus()
	{
		return $this->__ProductStatusA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions
	 */
	public function getInternationalRestrictions()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions();
		$this->__InternationalRestrictionsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setInternationalRestrictions($value)
	{
		$this->__InternationalRestrictionsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions[]
	 */
	public function getAllInternationalRestrictions()
	{
		return $this->__InternationalRestrictionsA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 */
	public function getAccountingInfo()
	{
		if($this->__AccountingInfo == null)
		{
			$this->__AccountingInfo = new B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo();
		}
	
		return $this->__AccountingInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setAccountingInfo($value)
	{
		$this->__AccountingInfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AgreementRef and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementRef
	 */
	public function getAgreementRef()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AgreementRef();
		$this->__AgreementRefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementRef
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setAgreementRef($value)
	{
		$this->__AgreementRefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementRef[]
	 */
	public function getAllAgreementRef()
	{
		return $this->__AgreementRefA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ProductType and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductType
	 */
	public function getProductType()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ProductType();
		$this->__ProductTypeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setProductType($value)
	{
		$this->__ProductTypeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductType[]
	 */
	public function getAllProductType()
	{
		return $this->__ProductTypeA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductCategory
	 */
	public function getProductCategory()
	{
		if($this->__ProductCategory == null)
		{
			$this->__ProductCategory = new B3it_XmlBind_Opentrans21_Bmecat_ProductCategory();
		}
	
		return $this->__ProductCategory;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductCategory
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDetails
	 */
	public function setProductCategory($value)
	{
		$this->__ProductCategory = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_DETAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
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
		if($this->__InternationalPidA != null){
			foreach($this->__InternationalPidA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Ean != null){
			$this->__Ean->toXml($xml);
		}
		if($this->__SupplierAltPid != null){
			$this->__SupplierAltPid->toXml($xml);
		}
		if($this->__BuyerPidA != null){
			foreach($this->__BuyerPidA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ManufacturerPid != null){
			$this->__ManufacturerPid->toXml($xml);
		}
		if($this->__ManufacturerIdref != null){
			$this->__ManufacturerIdref->toXml($xml);
		}
		if($this->__ManufacturerName != null){
			$this->__ManufacturerName->toXml($xml);
		}
		if($this->__ManufacturerTypeDescrA != null){
			foreach($this->__ManufacturerTypeDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ErpGroupBuyer != null){
			$this->__ErpGroupBuyer->toXml($xml);
		}
		if($this->__ErpGroupSupplier != null){
			$this->__ErpGroupSupplier->toXml($xml);
		}
		if($this->__DeliveryTime != null){
			$this->__DeliveryTime->toXml($xml);
		}
		if($this->__SpecialTreatmentClassA != null){
			foreach($this->__SpecialTreatmentClassA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__KeywordA != null){
			foreach($this->__KeywordA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__RemarksA != null){
			foreach($this->__RemarksA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SegmentA != null){
			foreach($this->__SegmentA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductOrder != null){
			$this->__ProductOrder->toXml($xml);
		}
		if($this->__ProductStatusA != null){
			foreach($this->__ProductStatusA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__InternationalRestrictionsA != null){
			foreach($this->__InternationalRestrictionsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AccountingInfo != null){
			$this->__AccountingInfo->toXml($xml);
		}
		if($this->__AgreementRefA != null){
			foreach($this->__AgreementRefA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductTypeA != null){
			foreach($this->__ProductTypeA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductCategory != null){
			$this->__ProductCategory->toXml($xml);
		}


		return $xml;
	}

}
