<?php
class B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var DescriptionShort */
	private $_DescriptionShorts = array();	

	/* @var DescriptionLong */
	private $_DescriptionLongs = array();	

	/* @var InternationalPid */
	private $_InternationalPids = array();	

	/* @var Ean */
	private $_Ean = null;	

	/* @var SupplierAltPid */
	private $_SupplierAltPid = null;	

	/* @var BuyerPid */
	private $_BuyerPids = array();	

	/* @var ManufacturerPid */
	private $_ManufacturerPid = null;	

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

	/* @var ProductOrder */
	private $_ProductOrder = null;	

	/* @var ProductStatus */
	private $_ProductStatuss = array();	

	/* @var InternationalRestrictions */
	private $_InternationalRestrictionss = array();	

	/* @var AccountingInfo */
	private $_AccountingInfo = null;	

	/* @var AgreementRef */
	private $_AgreementRefs = array();	

	/* @var ProductType */
	private $_ProductTypes = array();	

	/* @var ProductCategory */
	private $_ProductCategory = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDescriptionLong($value)
	{
		$this->_DescriptionLong = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_InternationalPid[]
	 */
	public function getAllInternationalPid()
	{
		return $this->_InternationalPids;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_InternationalPid and add it to list
	 * @return B3it_XmlBind_Bmecat2005_InternationalPid
	 */
	public function getInternationalPid()
	{
		$res = new B3it_XmlBind_Bmecat2005_InternationalPid();
		$this->_InternationalPids[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value InternationalPid[]
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setInternationalPid($value)
	{
		$this->_InternationalPid = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setEan($value)
	{
		$this->_Ean = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierAltPid
	 */
	public function getSupplierAltPid()
	{
		if($this->_SupplierAltPid == null)
		{
			$this->_SupplierAltPid = new B3it_XmlBind_Bmecat2005_SupplierAltPid();
		}
		
		return $this->_SupplierAltPid;
	}
	
	/**
	 * @param $value SupplierAltPid
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierAltPid($value)
	{
		$this->_SupplierAltPid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_BuyerPid[]
	 */
	public function getAllBuyerPid()
	{
		return $this->_BuyerPids;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_BuyerPid and add it to list
	 * @return B3it_XmlBind_Bmecat2005_BuyerPid
	 */
	public function getBuyerPid()
	{
		$res = new B3it_XmlBind_Bmecat2005_BuyerPid();
		$this->_BuyerPids[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value BuyerPid[]
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setBuyerPid($value)
	{
		$this->_BuyerPid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ManufacturerPid
	 */
	public function getManufacturerPid()
	{
		if($this->_ManufacturerPid == null)
		{
			$this->_ManufacturerPid = new B3it_XmlBind_Bmecat2005_ManufacturerPid();
		}
		
		return $this->_ManufacturerPid;
	}
	
	/**
	 * @param $value ManufacturerPid
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setManufacturerPid($value)
	{
		$this->_ManufacturerPid = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSegment($value)
	{
		$this->_Segment = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductOrder
	 */
	public function getProductOrder()
	{
		if($this->_ProductOrder == null)
		{
			$this->_ProductOrder = new B3it_XmlBind_Bmecat2005_ProductOrder();
		}
		
		return $this->_ProductOrder;
	}
	
	/**
	 * @param $value ProductOrder
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductOrder($value)
	{
		$this->_ProductOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductStatus[]
	 */
	public function getAllProductStatus()
	{
		return $this->_ProductStatuss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductStatus and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductStatus
	 */
	public function getProductStatus()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductStatus();
		$this->_ProductStatuss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductStatus[]
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductStatus($value)
	{
		$this->_ProductStatus = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAccountingInfo($value)
	{
		$this->_AccountingInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementRef[]
	 */
	public function getAllAgreementRef()
	{
		return $this->_AgreementRefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AgreementRef and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AgreementRef
	 */
	public function getAgreementRef()
	{
		$res = new B3it_XmlBind_Bmecat2005_AgreementRef();
		$this->_AgreementRefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AgreementRef[]
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementRef($value)
	{
		$this->_AgreementRef = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductType[]
	 */
	public function getAllProductType()
	{
		return $this->_ProductTypes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductType and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductType
	 */
	public function getProductType()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductType();
		$this->_ProductTypes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductType[]
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductType($value)
	{
		$this->_ProductType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductCategory
	 */
	public function getProductCategory()
	{
		if($this->_ProductCategory == null)
		{
			$this->_ProductCategory = new B3it_XmlBind_Bmecat2005_ProductCategory();
		}
		
		return $this->_ProductCategory;
	}
	
	/**
	 * @param $value ProductCategory
	 * @return B3it_XmlBind_Bmecat2005_ProductDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductCategory($value)
	{
		$this->_ProductCategory = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_DETAILS');
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
		if($this->_InternationalPids != null){
			foreach($this->_InternationalPids as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Ean != null){
			$this->_Ean->toXml($xml);
		}
		if($this->_SupplierAltPid != null){
			$this->_SupplierAltPid->toXml($xml);
		}
		if($this->_BuyerPids != null){
			foreach($this->_BuyerPids as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ManufacturerPid != null){
			$this->_ManufacturerPid->toXml($xml);
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
		if($this->_ProductOrder != null){
			$this->_ProductOrder->toXml($xml);
		}
		if($this->_ProductStatuss != null){
			foreach($this->_ProductStatuss as $item){
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
		if($this->_AgreementRefs != null){
			foreach($this->_AgreementRefs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ProductTypes != null){
			foreach($this->_ProductTypes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ProductCategory != null){
			$this->_ProductCategory->toXml($xml);
		}


		return $xml;
	}
}