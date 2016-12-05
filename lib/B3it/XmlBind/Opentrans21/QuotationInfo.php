<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	QuotationInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_QuotationInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_QuotationId */
	private $__QuotationId = null;

	/* @var B3it_XmlBind_Opentrans21_QuotationDate */
	private $__QuotationDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate */
	private $__ValidStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate */
	private $__ValidEndDate = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryDate */
	private $__DeliveryDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Language */
	private $__LanguageA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeRoot */
	private $__MimeRoot = null;

	/* @var B3it_XmlBind_Opentrans21_Parties */
	private $__Parties = null;

	/* @var B3it_XmlBind_Opentrans21_OrderPartiesReference */
	private $__OrderPartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_DocexchangePartiesReference */
	private $__DocexchangePartiesReference = null;

	
	/* @var B3it_XmlBind_Opentrans21_Agreement */
	private $__AgreementA = array();

	/* @var B3it_XmlBind_Opentrans21_CatalogReference */
	private $__CatalogReference = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Currency */
	private $__Currency = null;

	/* @var B3it_XmlBind_Opentrans21_Payment */
	private $__Payment = null;

	/* @var B3it_XmlBind_Opentrans21_TermsAndConditions */
	private $__TermsAndConditions = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Transport */
	private $__Transport = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions */
	private $__InternationalRestrictionsA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_HeaderUdx */
	private $__HeaderUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationId
	 */
	public function getQuotationId()
	{
		if($this->__QuotationId == null)
		{
			$this->__QuotationId = new B3it_XmlBind_Opentrans21_QuotationId();
		}
	
		return $this->__QuotationId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationId
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setQuotationId($value)
	{
		$this->__QuotationId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationDate
	 */
	public function getQuotationDate()
	{
		if($this->__QuotationDate == null)
		{
			$this->__QuotationDate = new B3it_XmlBind_Opentrans21_QuotationDate();
		}
	
		return $this->__QuotationDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationDate
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setQuotationDate($value)
	{
		$this->__QuotationDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate
	 */
	public function getValidStartDate()
	{
		if($this->__ValidStartDate == null)
		{
			$this->__ValidStartDate = new B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate();
		}
	
		return $this->__ValidStartDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setValidStartDate($value)
	{
		$this->__ValidStartDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate
	 */
	public function getValidEndDate()
	{
		if($this->__ValidEndDate == null)
		{
			$this->__ValidEndDate = new B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate();
		}
	
		return $this->__ValidEndDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setValidEndDate($value)
	{
		$this->__ValidEndDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryDate
	 */
	public function getDeliveryDate()
	{
		if($this->__DeliveryDate == null)
		{
			$this->__DeliveryDate = new B3it_XmlBind_Opentrans21_DeliveryDate();
		}
	
		return $this->__DeliveryDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryDate
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setDeliveryDate($value)
	{
		$this->__DeliveryDate = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Language and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Language
	 */
	public function getLanguage()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Language();
		$this->__LanguageA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Language
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setLanguage($value)
	{
		$this->__LanguageA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Language[]
	 */
	public function getAllLanguage()
	{
		return $this->__LanguageA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeRoot
	 */
	public function getMimeRoot()
	{
		if($this->__MimeRoot == null)
		{
			$this->__MimeRoot = new B3it_XmlBind_Opentrans21_Bmecat_MimeRoot();
		}
	
		return $this->__MimeRoot;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeRoot
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setMimeRoot($value)
	{
		$this->__MimeRoot = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Parties
	 */
	public function getParties()
	{
		if($this->__Parties == null)
		{
			$this->__Parties = new B3it_XmlBind_Opentrans21_Parties();
		}
	
		return $this->__Parties;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Parties
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setParties($value)
	{
		$this->__Parties = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderPartiesReference
	 */
	public function getOrderPartiesReference()
	{
		if($this->__OrderPartiesReference == null)
		{
			$this->__OrderPartiesReference = new B3it_XmlBind_Opentrans21_OrderPartiesReference();
		}
	
		return $this->__OrderPartiesReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderPartiesReference
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setOrderPartiesReference($value)
	{
		$this->__OrderPartiesReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DocexchangePartiesReference
	 */
	public function getDocexchangePartiesReference()
	{
		if($this->__DocexchangePartiesReference == null)
		{
			$this->__DocexchangePartiesReference = new B3it_XmlBind_Opentrans21_DocexchangePartiesReference();
		}
	
		return $this->__DocexchangePartiesReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DocexchangePartiesReference
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setDocexchangePartiesReference($value)
	{
		$this->__DocexchangePartiesReference = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Agreement and add it to list
	 * @return B3it_XmlBind_Opentrans21_Agreement
	 */
	public function getAgreement()
	{
		$res = new B3it_XmlBind_Opentrans21_Agreement();
		$this->__AgreementA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Agreement
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setAgreement($value)
	{
		$this->__AgreementA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Agreement[]
	 */
	public function getAllAgreement()
	{
		return $this->__AgreementA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_CatalogReference
	 */
	public function getCatalogReference()
	{
		if($this->__CatalogReference == null)
		{
			$this->__CatalogReference = new B3it_XmlBind_Opentrans21_CatalogReference();
		}
	
		return $this->__CatalogReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CatalogReference
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setCatalogReference($value)
	{
		$this->__CatalogReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Currency
	 */
	public function getCurrency()
	{
		if($this->__Currency == null)
		{
			$this->__Currency = new B3it_XmlBind_Opentrans21_Bmecat_Currency();
		}
	
		return $this->__Currency;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Currency
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setCurrency($value)
	{
		$this->__Currency = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function getPayment()
	{
		if($this->__Payment == null)
		{
			$this->__Payment = new B3it_XmlBind_Opentrans21_Payment();
		}
	
		return $this->__Payment;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Payment
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setPayment($value)
	{
		$this->__Payment = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TermsAndConditions
	 */
	public function getTermsAndConditions()
	{
		if($this->__TermsAndConditions == null)
		{
			$this->__TermsAndConditions = new B3it_XmlBind_Opentrans21_TermsAndConditions();
		}
	
		return $this->__TermsAndConditions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TermsAndConditions
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setTermsAndConditions($value)
	{
		$this->__TermsAndConditions = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport
	 */
	public function getTransport()
	{
		if($this->__Transport == null)
		{
			$this->__Transport = new B3it_XmlBind_Opentrans21_Bmecat_Transport();
		}
	
		return $this->__Transport;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Transport
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setTransport($value)
	{
		$this->__Transport = $value;
		return $this;
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
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
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
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Territory and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Territory();
		$this->__TerritoryA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Territory
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setTerritory($value)
	{
		$this->__TerritoryA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->__TerritoryA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Remarks and add it to list
	 * @return B3it_XmlBind_Opentrans21_Remarks
	 */
	public function getRemarks()
	{
		$res = new B3it_XmlBind_Opentrans21_Remarks();
		$this->__RemarksA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Remarks
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setRemarks($value)
	{
		$this->__RemarksA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Remarks[]
	 */
	public function getAllRemarks()
	{
		return $this->__RemarksA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_HeaderUdx
	 */
	public function getHeaderUdx()
	{
		if($this->__HeaderUdx == null)
		{
			$this->__HeaderUdx = new B3it_XmlBind_Opentrans21_HeaderUdx();
		}
	
		return $this->__HeaderUdx;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_HeaderUdx
	 * @return B3it_XmlBind_Opentrans21_QuotationInfo
	 */
	public function setHeaderUdx($value)
	{
		$this->__HeaderUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('QUOTATION_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__QuotationId != null){
			$this->__QuotationId->toXml($xml);
		}
		if($this->__QuotationDate != null){
			$this->__QuotationDate->toXml($xml);
		}
		if($this->__ValidStartDate != null){
			$this->__ValidStartDate->toXml($xml);
		}
		if($this->__ValidEndDate != null){
			$this->__ValidEndDate->toXml($xml);
		}
		if($this->__DeliveryDate != null){
			$this->__DeliveryDate->toXml($xml);
		}
		if($this->__LanguageA != null){
			foreach($this->__LanguageA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeRoot != null){
			$this->__MimeRoot->toXml($xml);
		}
		if($this->__Parties != null){
			$this->__Parties->toXml($xml);
		}
		if($this->__OrderPartiesReference != null){
			$this->__OrderPartiesReference->toXml($xml);
		}
		if($this->__DocexchangePartiesReference != null){
			$this->__DocexchangePartiesReference->toXml($xml);
		}
		if($this->__AgreementA != null){
			foreach($this->__AgreementA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CatalogReference != null){
			$this->__CatalogReference->toXml($xml);
		}
		if($this->__Currency != null){
			$this->__Currency->toXml($xml);
		}
		if($this->__Payment != null){
			$this->__Payment->toXml($xml);
		}
		if($this->__TermsAndConditions != null){
			$this->__TermsAndConditions->toXml($xml);
		}
		if($this->__Transport != null){
			$this->__Transport->toXml($xml);
		}
		if($this->__InternationalRestrictionsA != null){
			foreach($this->__InternationalRestrictionsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__TerritoryA != null){
			foreach($this->__TerritoryA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__RemarksA != null){
			foreach($this->__RemarksA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__HeaderUdx != null){
			$this->__HeaderUdx->toXml($xml);
		}


		return $xml;
	}

}
