<?php
class B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var DescriptionShort */
	private $_DescriptionShort = null;	

	/* @var DescriptionLong */
	private $_DescriptionLong = null;	

	/* @var Ean */
	private $_Ean = null;	

	/* @var SupplierAltAid */
	private $_SupplierAltAid = null;	

	/* @var BuyerAid */
	private $_BuyerAids = array();	

	/* @var ManufacturerAid */
	private $_ManufacturerAid = null;	

	/* @var ManufacturerName */
	private $_ManufacturerName = null;	

	/* @var ManufacturerTypeDescr */
	private $_ManufacturerTypeDescr = null;	

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
	private $_Remarks = null;	

	/* @var Segment */
	private $_Segment = null;	

	/* @var ArticleOrder */
	private $_ArticleOrder = null;	

	/* @var ArticleStatus */
	private $_ArticleStatuss = array();	

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
	 * @return B3it_XmlBind_Bmecat12_DescriptionShort
	 */
	public function getDescriptionShort()
	{
		if($this->_DescriptionShort == null)
		{
			$this->_DescriptionShort = new B3it_XmlBind_Bmecat12_DescriptionShort();
		}
		
		return $this->_DescriptionShort;
	}
	
	/**
	 * @param $value DescriptionShort
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDescriptionShort($value)
	{
		$this->_DescriptionShort = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_DescriptionLong
	 */
	public function getDescriptionLong()
	{
		if($this->_DescriptionLong == null)
		{
			$this->_DescriptionLong = new B3it_XmlBind_Bmecat12_DescriptionLong();
		}
		
		return $this->_DescriptionLong;
	}
	
	/**
	 * @param $value DescriptionLong
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDescriptionLong($value)
	{
		$this->_DescriptionLong = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Ean
	 */
	public function getEan()
	{
		if($this->_Ean == null)
		{
			$this->_Ean = new B3it_XmlBind_Bmecat12_Ean();
		}
		
		return $this->_Ean;
	}
	
	/**
	 * @param $value Ean
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setEan($value)
	{
		$this->_Ean = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_SupplierAltAid
	 */
	public function getSupplierAltAid()
	{
		if($this->_SupplierAltAid == null)
		{
			$this->_SupplierAltAid = new B3it_XmlBind_Bmecat12_SupplierAltAid();
		}
		
		return $this->_SupplierAltAid;
	}
	
	/**
	 * @param $value SupplierAltAid
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setSupplierAltAid($value)
	{
		$this->_SupplierAltAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_BuyerAid[]
	 */
	public function getAllBuyerAid()
	{
		return $this->_BuyerAids;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_BuyerAid and add it to list
	 * @return B3it_XmlBind_Bmecat12_BuyerAid
	 */
	public function getBuyerAid()
	{
		$res = new B3it_XmlBind_Bmecat12_BuyerAid();
		$this->_BuyerAids[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value BuyerAid[]
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setBuyerAid($value)
	{
		$this->_BuyerAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ManufacturerAid
	 */
	public function getManufacturerAid()
	{
		if($this->_ManufacturerAid == null)
		{
			$this->_ManufacturerAid = new B3it_XmlBind_Bmecat12_ManufacturerAid();
		}
		
		return $this->_ManufacturerAid;
	}
	
	/**
	 * @param $value ManufacturerAid
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setManufacturerAid($value)
	{
		$this->_ManufacturerAid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ManufacturerName
	 */
	public function getManufacturerName()
	{
		if($this->_ManufacturerName == null)
		{
			$this->_ManufacturerName = new B3it_XmlBind_Bmecat12_ManufacturerName();
		}
		
		return $this->_ManufacturerName;
	}
	
	/**
	 * @param $value ManufacturerName
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setManufacturerName($value)
	{
		$this->_ManufacturerName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ManufacturerTypeDescr
	 */
	public function getManufacturerTypeDescr()
	{
		if($this->_ManufacturerTypeDescr == null)
		{
			$this->_ManufacturerTypeDescr = new B3it_XmlBind_Bmecat12_ManufacturerTypeDescr();
		}
		
		return $this->_ManufacturerTypeDescr;
	}
	
	/**
	 * @param $value ManufacturerTypeDescr
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setManufacturerTypeDescr($value)
	{
		$this->_ManufacturerTypeDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ErpGroupBuyer
	 */
	public function getErpGroupBuyer()
	{
		if($this->_ErpGroupBuyer == null)
		{
			$this->_ErpGroupBuyer = new B3it_XmlBind_Bmecat12_ErpGroupBuyer();
		}
		
		return $this->_ErpGroupBuyer;
	}
	
	/**
	 * @param $value ErpGroupBuyer
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setErpGroupBuyer($value)
	{
		$this->_ErpGroupBuyer = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ErpGroupSupplier
	 */
	public function getErpGroupSupplier()
	{
		if($this->_ErpGroupSupplier == null)
		{
			$this->_ErpGroupSupplier = new B3it_XmlBind_Bmecat12_ErpGroupSupplier();
		}
		
		return $this->_ErpGroupSupplier;
	}
	
	/**
	 * @param $value ErpGroupSupplier
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setErpGroupSupplier($value)
	{
		$this->_ErpGroupSupplier = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_DeliveryTime
	 */
	public function getDeliveryTime()
	{
		if($this->_DeliveryTime == null)
		{
			$this->_DeliveryTime = new B3it_XmlBind_Bmecat12_DeliveryTime();
		}
		
		return $this->_DeliveryTime;
	}
	
	/**
	 * @param $value DeliveryTime
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDeliveryTime($value)
	{
		$this->_DeliveryTime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_SpecialTreatmentClass[]
	 */
	public function getAllSpecialTreatmentClass()
	{
		return $this->_SpecialTreatmentClasss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_SpecialTreatmentClass and add it to list
	 * @return B3it_XmlBind_Bmecat12_SpecialTreatmentClass
	 */
	public function getSpecialTreatmentClass()
	{
		$res = new B3it_XmlBind_Bmecat12_SpecialTreatmentClass();
		$this->_SpecialTreatmentClasss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value SpecialTreatmentClass[]
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setSpecialTreatmentClass($value)
	{
		$this->_SpecialTreatmentClass = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->_Keywords;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Keyword and add it to list
	 * @return B3it_XmlBind_Bmecat12_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Bmecat12_Keyword();
		$this->_Keywords[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Keyword[]
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setKeyword($value)
	{
		$this->_Keyword = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Remarks
	 */
	public function getRemarks()
	{
		if($this->_Remarks == null)
		{
			$this->_Remarks = new B3it_XmlBind_Bmecat12_Remarks();
		}
		
		return $this->_Remarks;
	}
	
	/**
	 * @param $value Remarks
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setRemarks($value)
	{
		$this->_Remarks = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Segment
	 */
	public function getSegment()
	{
		if($this->_Segment == null)
		{
			$this->_Segment = new B3it_XmlBind_Bmecat12_Segment();
		}
		
		return $this->_Segment;
	}
	
	/**
	 * @param $value Segment
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setSegment($value)
	{
		$this->_Segment = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ArticleOrder
	 */
	public function getArticleOrder()
	{
		if($this->_ArticleOrder == null)
		{
			$this->_ArticleOrder = new B3it_XmlBind_Bmecat12_ArticleOrder();
		}
		
		return $this->_ArticleOrder;
	}
	
	/**
	 * @param $value ArticleOrder
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setArticleOrder($value)
	{
		$this->_ArticleOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ArticleStatus[]
	 */
	public function getAllArticleStatus()
	{
		return $this->_ArticleStatuss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ArticleStatus and add it to list
	 * @return B3it_XmlBind_Bmecat12_ArticleStatus
	 */
	public function getArticleStatus()
	{
		$res = new B3it_XmlBind_Bmecat12_ArticleStatus();
		$this->_ArticleStatuss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleStatus[]
	 * @return B3it_XmlBind_Bmecat12_ArticleDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setArticleStatus($value)
	{
		$this->_ArticleStatus = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_DescriptionShort != null){
			$this->_DescriptionShort->toXml($xml);
		}
		if($this->_DescriptionLong != null){
			$this->_DescriptionLong->toXml($xml);
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
		if($this->_ManufacturerName != null){
			$this->_ManufacturerName->toXml($xml);
		}
		if($this->_ManufacturerTypeDescr != null){
			$this->_ManufacturerTypeDescr->toXml($xml);
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
		if($this->_Remarks != null){
			$this->_Remarks->toXml($xml);
		}
		if($this->_Segment != null){
			$this->_Segment->toXml($xml);
		}
		if($this->_ArticleOrder != null){
			$this->_ArticleOrder->toXml($xml);
		}
		if($this->_ArticleStatuss != null){
			foreach($this->_ArticleStatuss as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}