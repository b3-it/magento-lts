<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Agreement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Agreement extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementId */
	private $__AgreementId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementLineId */
	private $__AgreementLineId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementStartDate */
	private $__AgreementStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementEndDate */
	private $__AgreementEndDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_Agreement_Bmecat_Datetime */
	private $__DatetimeA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementDescr */
	private $__AgreementDescr = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementId
	 */
	public function getAgreementId()
	{
		if($this->__AgreementId == null)
		{
			$this->__AgreementId = new B3it_XmlBind_Opentrans21_Bmecat_AgreementId();
		}
	
		return $this->__AgreementId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setAgreementId($value)
	{
		$this->__AgreementId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementLineId
	 */
	public function getAgreementLineId()
	{
		if($this->__AgreementLineId == null)
		{
			$this->__AgreementLineId = new B3it_XmlBind_Opentrans21_Bmecat_AgreementLineId();
		}
	
		return $this->__AgreementLineId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementLineId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setAgreementLineId($value)
	{
		$this->__AgreementLineId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementStartDate
	 */
	public function getAgreementStartDate()
	{
		if($this->__AgreementStartDate == null)
		{
			$this->__AgreementStartDate = new B3it_XmlBind_Opentrans21_Bmecat_AgreementStartDate();
		}
	
		return $this->__AgreementStartDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementStartDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setAgreementStartDate($value)
	{
		$this->__AgreementStartDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementEndDate
	 */
	public function getAgreementEndDate()
	{
		if($this->__AgreementEndDate == null)
		{
			$this->__AgreementEndDate = new B3it_XmlBind_Opentrans21_Bmecat_AgreementEndDate();
		}
	
		return $this->__AgreementEndDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementEndDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setAgreementEndDate($value)
	{
		$this->__AgreementEndDate = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Agreement_Bmecat_Datetime and add it to list
	 * @return B3it_XmlBind_Opentrans21_Agreement_Bmecat_Datetime
	 */
	public function getDatetime()
	{
		$res = new B3it_XmlBind_Opentrans21_Agreement_Bmecat_Datetime();
		$this->__DatetimeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Agreement_Bmecat_Datetime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setDatetime($value)
	{
		$this->__DatetimeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Agreement_Bmecat_Datetime[]
	 */
	public function getAllDatetime()
	{
		return $this->__DatetimeA;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementDescr
	 */
	public function getAgreementDescr()
	{
		if($this->__AgreementDescr == null)
		{
			$this->__AgreementDescr = new B3it_XmlBind_Opentrans21_Bmecat_AgreementDescr();
		}
	
		return $this->__AgreementDescr;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setAgreementDescr($value)
	{
		$this->__AgreementDescr = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Agreement
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AGREEMENT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AGREEMENT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AgreementId != null){
			$this->__AgreementId->toXml($xml);
		}
		if($this->__AgreementLineId != null){
			$this->__AgreementLineId->toXml($xml);
		}
		if($this->__AgreementStartDate != null){
			$this->__AgreementStartDate->toXml($xml);
		}
		if($this->__AgreementEndDate != null){
			$this->__AgreementEndDate->toXml($xml);
		}
		if($this->__DatetimeA != null){
			foreach($this->__DatetimeA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__AgreementDescr != null){
			$this->__AgreementDescr->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
