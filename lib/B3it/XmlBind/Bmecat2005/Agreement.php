<?php
class B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AgreementId */
	private $_AgreementId = null;	

	/* @var AgreementLineId */
	private $_AgreementLineId = null;	

	/* @var AgreementStartDate */
	private $_AgreementStartDate = null;	

	/* @var AgreementEndDate */
	private $_AgreementEndDate = null;	

	/* @var Agreement_Datetime */
	private $_Datetimes = array();	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var AgreementDescr */
	private $_AgreementDescr = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_AgreementId
	 */
	public function getAgreementId()
	{
		if($this->_AgreementId == null)
		{
			$this->_AgreementId = new B3it_XmlBind_Bmecat2005_AgreementId();
		}
		
		return $this->_AgreementId;
	}
	
	/**
	 * @param $value AgreementId
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementId($value)
	{
		$this->_AgreementId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementLineId
	 */
	public function getAgreementLineId()
	{
		if($this->_AgreementLineId == null)
		{
			$this->_AgreementLineId = new B3it_XmlBind_Bmecat2005_AgreementLineId();
		}
		
		return $this->_AgreementLineId;
	}
	
	/**
	 * @param $value AgreementLineId
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementLineId($value)
	{
		$this->_AgreementLineId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementStartDate
	 */
	public function getAgreementStartDate()
	{
		if($this->_AgreementStartDate == null)
		{
			$this->_AgreementStartDate = new B3it_XmlBind_Bmecat2005_AgreementStartDate();
		}
		
		return $this->_AgreementStartDate;
	}
	
	/**
	 * @param $value AgreementStartDate
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementStartDate($value)
	{
		$this->_AgreementStartDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementEndDate
	 */
	public function getAgreementEndDate()
	{
		if($this->_AgreementEndDate == null)
		{
			$this->_AgreementEndDate = new B3it_XmlBind_Bmecat2005_AgreementEndDate();
		}
		
		return $this->_AgreementEndDate;
	}
	
	/**
	 * @param $value AgreementEndDate
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementEndDate($value)
	{
		$this->_AgreementEndDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Agreement_Datetime[]
	 */
	public function getAllDatetime()
	{
		return $this->_Datetimes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Agreement_Datetime and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Agreement_Datetime
	 */
	public function getDatetime()
	{
		$res = new B3it_XmlBind_Bmecat2005_Agreement_Datetime();
		$this->_Datetimes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Datetime[]
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDatetime($value)
	{
		$this->_Datetime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->_SupplierIdref == null)
		{
			$this->_SupplierIdref = new B3it_XmlBind_Bmecat2005_SupplierIdref();
		}
		
		return $this->_SupplierIdref;
	}
	
	/**
	 * @param $value SupplierIdref
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementDescr
	 */
	public function getAgreementDescr()
	{
		if($this->_AgreementDescr == null)
		{
			$this->_AgreementDescr = new B3it_XmlBind_Bmecat2005_AgreementDescr();
		}
		
		return $this->_AgreementDescr;
	}
	
	/**
	 * @param $value AgreementDescr
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementDescr($value)
	{
		$this->_AgreementDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_Agreement extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AGREEMENT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AgreementId != null){
			$this->_AgreementId->toXml($xml);
		}
		if($this->_AgreementLineId != null){
			$this->_AgreementLineId->toXml($xml);
		}
		if($this->_AgreementStartDate != null){
			$this->_AgreementStartDate->toXml($xml);
		}
		if($this->_AgreementEndDate != null){
			$this->_AgreementEndDate->toXml($xml);
		}
		if($this->_Datetimes != null){
			foreach($this->_Datetimes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_AgreementDescr != null){
			$this->_AgreementDescr->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}


		return $xml;
	}
}