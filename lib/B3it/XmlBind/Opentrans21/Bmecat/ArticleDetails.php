<?php
/**
 *
 * XML Bind  f�r Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ArticleDetails
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DescriptionShort */
	private $__DescriptionShortA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_DescriptionLong */
	private $__DescriptionLongA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalAid */
	private $__InternationalAidA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Ean */
	private $__Ean = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierAltAid */
	private $__SupplierAltAid = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerAid */
	private $__BuyerAidA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerAid */
	private $__ManufacturerAid = null;

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

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleOrder */
	private $__ArticleOrder = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleStatus */
	private $__ArticleStatusA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions */
	private $__InternationalRestrictionsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo */
	private $__AccountingInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementRef */
	private $__AgreementRef = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleType */
	private $__ArticleTypeA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleCategory */
	private $__ArticleCategory = null;


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_InternationalAid and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_InternationalAid
	 */
	public function getInternationalAid()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_InternationalAid();
		$this->__InternationalAidA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_InternationalAid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setInternationalAid($value)
	{
		$this->__InternationalAidA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_InternationalAid[]
	 */
	public function getAllInternationalAid()
	{
		return $this->__InternationalAidA;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setEan($value)
	{
		$this->__Ean = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierAltAid
	 */
	public function getSupplierAltAid()
	{
		if($this->__SupplierAltAid == null)
		{
			$this->__SupplierAltAid = new B3it_XmlBind_Opentrans21_Bmecat_SupplierAltAid();
		}
	
		return $this->__SupplierAltAid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierAltAid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setSupplierAltAid($value)
	{
		$this->__SupplierAltAid = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_BuyerAid and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerAid
	 */
	public function getBuyerAid()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_BuyerAid();
		$this->__BuyerAidA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_BuyerAid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setBuyerAid($value)
	{
		$this->__BuyerAidA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerAid[]
	 */
	public function getAllBuyerAid()
	{
		return $this->__BuyerAidA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerAid
	 */
	public function getManufacturerAid()
	{
		if($this->__ManufacturerAid == null)
		{
			$this->__ManufacturerAid = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerAid();
		}
	
		return $this->__ManufacturerAid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerAid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setManufacturerAid($value)
	{
		$this->__ManufacturerAid = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrder
	 */
	public function getArticleOrder()
	{
		if($this->__ArticleOrder == null)
		{
			$this->__ArticleOrder = new B3it_XmlBind_Opentrans21_Bmecat_ArticleOrder();
		}
	
		return $this->__ArticleOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setArticleOrder($value)
	{
		$this->__ArticleOrder = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticleStatus and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleStatus
	 */
	public function getArticleStatus()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticleStatus();
		$this->__ArticleStatusA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleStatus
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setArticleStatus($value)
	{
		$this->__ArticleStatusA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleStatus[]
	 */
	public function getAllArticleStatus()
	{
		return $this->__ArticleStatusA;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setAccountingInfo($value)
	{
		$this->__AccountingInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementRef
	 */
	public function getAgreementRef()
	{
		if($this->__AgreementRef == null)
		{
			$this->__AgreementRef = new B3it_XmlBind_Opentrans21_Bmecat_AgreementRef();
		}
	
		return $this->__AgreementRef;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementRef
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setAgreementRef($value)
	{
		$this->__AgreementRef = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticleType and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleType
	 */
	public function getArticleType()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticleType();
		$this->__ArticleTypeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setArticleType($value)
	{
		$this->__ArticleTypeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleType[]
	 */
	public function getAllArticleType()
	{
		return $this->__ArticleTypeA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleCategory
	 */
	public function getArticleCategory()
	{
		if($this->__ArticleCategory == null)
		{
			$this->__ArticleCategory = new B3it_XmlBind_Opentrans21_Bmecat_ArticleCategory();
		}
	
		return $this->__ArticleCategory;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleCategory
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function setArticleCategory($value)
	{
		$this->__ArticleCategory = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_DETAILS');
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
		if($this->__InternationalAidA != null){
			foreach($this->__InternationalAidA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Ean != null){
			$this->__Ean->toXml($xml);
		}
		if($this->__SupplierAltAid != null){
			$this->__SupplierAltAid->toXml($xml);
		}
		if($this->__BuyerAidA != null){
			foreach($this->__BuyerAidA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ManufacturerAid != null){
			$this->__ManufacturerAid->toXml($xml);
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
		if($this->__ArticleOrder != null){
			$this->__ArticleOrder->toXml($xml);
		}
		if($this->__ArticleStatusA != null){
			foreach($this->__ArticleStatusA as $item){
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
		if($this->__AgreementRef != null){
			$this->__AgreementRef->toXml($xml);
		}
		if($this->__ArticleTypeA != null){
			foreach($this->__ArticleTypeA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ArticleCategory != null){
			$this->__ArticleCategory->toXml($xml);
		}


		return $xml;
	}

}
