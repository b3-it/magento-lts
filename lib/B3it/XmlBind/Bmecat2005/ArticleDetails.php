<?php
class B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var DescriptionShort */
	private $_DescriptionShorts = array();	

	/* @var DescriptionLong */
	private $_DescriptionLongs = array();	

	/* @var InternationalAid */
	private $_InternationalAids = array();	

	/* @var Ean */
	private $_Ean = null;	

	/* @var SupplierAltAid */
	private $_SupplierAltAid = null;	

	/* @var BuyerAid */
	private $_BuyerAids = array();	

	/* @var ManufacturerAid */
	private $_ManufacturerAid = null;	

	/* @var ManufacturerIdref */
	private $_ManufacturerIdref = null;	

	/* @var ManufacturerName */
	private $_ManufacturerName = null;	

	/* @var ManufacturerTypeDescr */
	private $_ManufacturerTypeDescrs = array();	

	/* @var ErpGroupBuyer */
	private $_ErpGroupBuyer = null;	

	/* @var ErpGroupSupplier */
	private $_ErpGroupSupplier = null;	

	/* @var DeliveryTime */
	private $_DeliveryTime = null;	

	/* @var SpecialTreatmentClass */
	private $_SpecialTreatmentClasss = array();	

	/* @var Keyword */
	private $_Keywords = array();	

	/* @var Remarks */
	private $_Remarkss = array();	

	/* @var Segment */
	private $_Segments = array();	

	/* @var ArticleOrder */
	private $_ArticleOrder = null;	

	/* @var ArticleStatus */
	private $_ArticleStatuss = array();	

	/* @var InternationalRestrictions */
	private $_InternationalRestrictionss = array();	

	/* @var AccountingInfo */
	private $_AccountingInfo = null;	

	/* @var AgreementRef */
	private $_AgreementRef = null;	

	/* @var ArticleType */
	private $_ArticleTypes = array();	

	/* @var ArticleCategory */
	private $_ArticleCategory = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_DescriptionShort[]
	 */
	public function getAllDescriptionShort()
	{
		return $this->_DescriptionShorts;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_DescriptionShort and add it to list
	 * @return B3it_XmlBind_Bmecat2005_DescriptionShort
	 */
	public function getDescriptionShort()
	{
		$res = new B3it_XmlBind_Bmecat2005_DescriptionShort();
		$this->_DescriptionShorts[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value DescriptionShort[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDescriptionShort($value)
	{
		$this->_DescriptionShort = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DescriptionLong[]
	 */
	public function getAllDescriptionLong()
	{
		return $this->_DescriptionLongs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_DescriptionLong and add it to list
	 * @return B3it_XmlBind_Bmecat2005_DescriptionLong
	 */
	public function getDescriptionLong()
	{
		$res = new B3it_XmlBind_Bmecat2005_DescriptionLong();
		$this->_DescriptionLongs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value DescriptionLong[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDescriptionLong($value)
	{
		$this->_DescriptionLong = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_InternationalAid[]
	 */
	public function getAllInternationalAid()
	{
		return $this->_InternationalAids;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_InternationalAid and add it to list
	 * @return B3it_XmlBind_Bmecat2005_InternationalAid
	 */
	public function getInternationalAid()
	{
		$res = new B3it_XmlBind_Bmecat2005_InternationalAid();
		$this->_InternationalAids[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value InternationalAid[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setInternationalAid($value)
	{
		$this->_InternationalAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Ean
	 */
	public function getEan()
	{
		if($this->_Ean == null)
		{
			$this->_Ean = new B3it_XmlBind_Bmecat2005_Ean();
		}
		
		return $this->_Ean;
	}
	
	/**
	 * @param $value Ean
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setEan($value)
	{
		$this->_Ean = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierAltAid
	 */
	public function getSupplierAltAid()
	{
		if($this->_SupplierAltAid == null)
		{
			$this->_SupplierAltAid = new B3it_XmlBind_Bmecat2005_SupplierAltAid();
		}
		
		return $this->_SupplierAltAid;
	}
	
	/**
	 * @param $value SupplierAltAid
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierAltAid($value)
	{
		$this->_SupplierAltAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_BuyerAid[]
	 */
	public function getAllBuyerAid()
	{
		return $this->_BuyerAids;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_BuyerAid and add it to list
	 * @return B3it_XmlBind_Bmecat2005_BuyerAid
	 */
	public function getBuyerAid()
	{
		$res = new B3it_XmlBind_Bmecat2005_BuyerAid();
		$this->_BuyerAids[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value BuyerAid[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setBuyerAid($value)
	{
		$this->_BuyerAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ManufacturerAid
	 */
	public function getManufacturerAid()
	{
		if($this->_ManufacturerAid == null)
		{
			$this->_ManufacturerAid = new B3it_XmlBind_Bmecat2005_ManufacturerAid();
		}
		
		return $this->_ManufacturerAid;
	}
	
	/**
	 * @param $value ManufacturerAid
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setManufacturerAid($value)
	{
		$this->_ManufacturerAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ManufacturerIdref
	 */
	public function getManufacturerIdref()
	{
		if($this->_ManufacturerIdref == null)
		{
			$this->_ManufacturerIdref = new B3it_XmlBind_Bmecat2005_ManufacturerIdref();
		}
		
		return $this->_ManufacturerIdref;
	}
	
	/**
	 * @param $value ManufacturerIdref
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setManufacturerIdref($value)
	{
		$this->_ManufacturerIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ManufacturerName
	 */
	public function getManufacturerName()
	{
		if($this->_ManufacturerName == null)
		{
			$this->_ManufacturerName = new B3it_XmlBind_Bmecat2005_ManufacturerName();
		}
		
		return $this->_ManufacturerName;
	}
	
	/**
	 * @param $value ManufacturerName
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setManufacturerName($value)
	{
		$this->_ManufacturerName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ManufacturerTypeDescr[]
	 */
	public function getAllManufacturerTypeDescr()
	{
		return $this->_ManufacturerTypeDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ManufacturerTypeDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ManufacturerTypeDescr
	 */
	public function getManufacturerTypeDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_ManufacturerTypeDescr();
		$this->_ManufacturerTypeDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ManufacturerTypeDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setManufacturerTypeDescr($value)
	{
		$this->_ManufacturerTypeDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ErpGroupBuyer
	 */
	public function getErpGroupBuyer()
	{
		if($this->_ErpGroupBuyer == null)
		{
			$this->_ErpGroupBuyer = new B3it_XmlBind_Bmecat2005_ErpGroupBuyer();
		}
		
		return $this->_ErpGroupBuyer;
	}
	
	/**
	 * @param $value ErpGroupBuyer
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setErpGroupBuyer($value)
	{
		$this->_ErpGroupBuyer = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ErpGroupSupplier
	 */
	public function getErpGroupSupplier()
	{
		if($this->_ErpGroupSupplier == null)
		{
			$this->_ErpGroupSupplier = new B3it_XmlBind_Bmecat2005_ErpGroupSupplier();
		}
		
		return $this->_ErpGroupSupplier;
	}
	
	/**
	 * @param $value ErpGroupSupplier
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setErpGroupSupplier($value)
	{
		$this->_ErpGroupSupplier = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTime
	 */
	public function getDeliveryTime()
	{
		if($this->_DeliveryTime == null)
		{
			$this->_DeliveryTime = new B3it_XmlBind_Bmecat2005_DeliveryTime();
		}
		
		return $this->_DeliveryTime;
	}
	
	/**
	 * @param $value DeliveryTime
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDeliveryTime($value)
	{
		$this->_DeliveryTime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SpecialTreatmentClass[]
	 */
	public function getAllSpecialTreatmentClass()
	{
		return $this->_SpecialTreatmentClasss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_SpecialTreatmentClass and add it to list
	 * @return B3it_XmlBind_Bmecat2005_SpecialTreatmentClass
	 */
	public function getSpecialTreatmentClass()
	{
		$res = new B3it_XmlBind_Bmecat2005_SpecialTreatmentClass();
		$this->_SpecialTreatmentClasss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value SpecialTreatmentClass[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSpecialTreatmentClass($value)
	{
		$this->_SpecialTreatmentClass = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->_Keywords;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Keyword and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Bmecat2005_Keyword();
		$this->_Keywords[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Keyword[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setKeyword($value)
	{
		$this->_Keyword = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Remarks[]
	 */
	public function getAllRemarks()
	{
		return $this->_Remarkss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Remarks and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Remarks
	 */
	public function getRemarks()
	{
		$res = new B3it_XmlBind_Bmecat2005_Remarks();
		$this->_Remarkss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Remarks[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setRemarks($value)
	{
		$this->_Remarks = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Segment[]
	 */
	public function getAllSegment()
	{
		return $this->_Segments;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Segment and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Segment
	 */
	public function getSegment()
	{
		$res = new B3it_XmlBind_Bmecat2005_Segment();
		$this->_Segments[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Segment[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSegment($value)
	{
		$this->_Segment = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleOrder
	 */
	public function getArticleOrder()
	{
		if($this->_ArticleOrder == null)
		{
			$this->_ArticleOrder = new B3it_XmlBind_Bmecat2005_ArticleOrder();
		}
		
		return $this->_ArticleOrder;
	}
	
	/**
	 * @param $value ArticleOrder
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleOrder($value)
	{
		$this->_ArticleOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleStatus[]
	 */
	public function getAllArticleStatus()
	{
		return $this->_ArticleStatuss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ArticleStatus and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ArticleStatus
	 */
	public function getArticleStatus()
	{
		$res = new B3it_XmlBind_Bmecat2005_ArticleStatus();
		$this->_ArticleStatuss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleStatus[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleStatus($value)
	{
		$this->_ArticleStatus = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_InternationalRestrictions[]
	 */
	public function getAllInternationalRestrictions()
	{
		return $this->_InternationalRestrictionss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_InternationalRestrictions and add it to list
	 * @return B3it_XmlBind_Bmecat2005_InternationalRestrictions
	 */
	public function getInternationalRestrictions()
	{
		$res = new B3it_XmlBind_Bmecat2005_InternationalRestrictions();
		$this->_InternationalRestrictionss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value InternationalRestrictions[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setInternationalRestrictions($value)
	{
		$this->_InternationalRestrictions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AccountingInfo
	 */
	public function getAccountingInfo()
	{
		if($this->_AccountingInfo == null)
		{
			$this->_AccountingInfo = new B3it_XmlBind_Bmecat2005_AccountingInfo();
		}
		
		return $this->_AccountingInfo;
	}
	
	/**
	 * @param $value AccountingInfo
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAccountingInfo($value)
	{
		$this->_AccountingInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementRef
	 */
	public function getAgreementRef()
	{
		if($this->_AgreementRef == null)
		{
			$this->_AgreementRef = new B3it_XmlBind_Bmecat2005_AgreementRef();
		}
		
		return $this->_AgreementRef;
	}
	
	/**
	 * @param $value AgreementRef
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementRef($value)
	{
		$this->_AgreementRef = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleType[]
	 */
	public function getAllArticleType()
	{
		return $this->_ArticleTypes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ArticleType and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ArticleType
	 */
	public function getArticleType()
	{
		$res = new B3it_XmlBind_Bmecat2005_ArticleType();
		$this->_ArticleTypes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleType[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleType($value)
	{
		$this->_ArticleType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleCategory
	 */
	public function getArticleCategory()
	{
		if($this->_ArticleCategory == null)
		{
			$this->_ArticleCategory = new B3it_XmlBind_Bmecat2005_ArticleCategory();
		}
		
		return $this->_ArticleCategory;
	}
	
	/**
	 * @param $value ArticleCategory
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleCategory($value)
	{
		$this->_ArticleCategory = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_DescriptionShorts != null){
			foreach($this->_DescriptionShorts as $item){
				$item->toXml($xml);
			}
		}
		if($this->_DescriptionLongs != null){
			foreach($this->_DescriptionLongs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_InternationalAids != null){
			foreach($this->_InternationalAids as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Ean != null){
			$this->_Ean->toXml($xml);
		}
		if($this->_SupplierAltAid != null){
			$this->_SupplierAltAid->toXml($xml);
		}
		if($this->_BuyerAids != null){
			foreach($this->_BuyerAids as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ManufacturerAid != null){
			$this->_ManufacturerAid->toXml($xml);
		}
		if($this->_ManufacturerIdref != null){
			$this->_ManufacturerIdref->toXml($xml);
		}
		if($this->_ManufacturerName != null){
			$this->_ManufacturerName->toXml($xml);
		}
		if($this->_ManufacturerTypeDescrs != null){
			foreach($this->_ManufacturerTypeDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ErpGroupBuyer != null){
			$this->_ErpGroupBuyer->toXml($xml);
		}
		if($this->_ErpGroupSupplier != null){
			$this->_ErpGroupSupplier->toXml($xml);
		}
		if($this->_DeliveryTime != null){
			$this->_DeliveryTime->toXml($xml);
		}
		if($this->_SpecialTreatmentClasss != null){
			foreach($this->_SpecialTreatmentClasss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Keywords != null){
			foreach($this->_Keywords as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Remarkss != null){
			foreach($this->_Remarkss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Segments != null){
			foreach($this->_Segments as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ArticleOrder != null){
			$this->_ArticleOrder->toXml($xml);
		}
		if($this->_ArticleStatuss != null){
			foreach($this->_ArticleStatuss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_InternationalRestrictionss != null){
			foreach($this->_InternationalRestrictionss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AccountingInfo != null){
			$this->_AccountingInfo->toXml($xml);
		}
		if($this->_AgreementRef != null){
			$this->_AgreementRef->toXml($xml);
		}
		if($this->_ArticleTypes != null){
			foreach($this->_ArticleTypes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ArticleCategory != null){
			$this->_ArticleCategory->toXml($xml);
		}


		return $xml;
	}
}