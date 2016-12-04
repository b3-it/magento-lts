<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderresponseInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderresponseInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderId */
	private $__OrderId = null;

	/* @var B3it_XmlBind_Opentrans21_OrderresponseDate */
	private $__OrderresponseDate = null;

	/* @var B3it_XmlBind_Opentrans21_OrderDate */
	private $__OrderDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_AltCustomerOrderId */
	private $__AltCustomerOrderIdA = array();

	/* @var B3it_XmlBind_Opentrans21_SupplierOrderId */
	private $__SupplierOrderId = null;

	/* @var B3it_XmlBind_Opentrans21_OrderchangeSequenceId */
	private $__OrderchangeSequenceId = null;

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

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Currency */
	private $__Currency = null;

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_HeaderUdx */
	private $__HeaderUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderId
	 */
	public function getOrderId()
	{
		if($this->__OrderId == null)
		{
			$this->__OrderId = new B3it_XmlBind_Opentrans21_OrderId();
		}
	
		return $this->__OrderId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderId
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setOrderId($value)
	{
		$this->__OrderId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderresponseDate
	 */
	public function getOrderresponseDate()
	{
		if($this->__OrderresponseDate == null)
		{
			$this->__OrderresponseDate = new B3it_XmlBind_Opentrans21_OrderresponseDate();
		}
	
		return $this->__OrderresponseDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderresponseDate
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setOrderresponseDate($value)
	{
		$this->__OrderresponseDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderDate
	 */
	public function getOrderDate()
	{
		if($this->__OrderDate == null)
		{
			$this->__OrderDate = new B3it_XmlBind_Opentrans21_OrderDate();
		}
	
		return $this->__OrderDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderDate
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setOrderDate($value)
	{
		$this->__OrderDate = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_AltCustomerOrderId and add it to list
	 * @return B3it_XmlBind_Opentrans21_AltCustomerOrderId
	 */
	public function getAltCustomerOrderId()
	{
		$res = new B3it_XmlBind_Opentrans21_AltCustomerOrderId();
		$this->__AltCustomerOrderIdA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AltCustomerOrderId
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setAltCustomerOrderId($value)
	{
		$this->__AltCustomerOrderIdA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AltCustomerOrderId[]
	 */
	public function getAllAltCustomerOrderId()
	{
		return $this->__AltCustomerOrderIdA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_SupplierOrderId
	 */
	public function getSupplierOrderId()
	{
		if($this->__SupplierOrderId == null)
		{
			$this->__SupplierOrderId = new B3it_XmlBind_Opentrans21_SupplierOrderId();
		}
	
		return $this->__SupplierOrderId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SupplierOrderId
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setSupplierOrderId($value)
	{
		$this->__SupplierOrderId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderchangeSequenceId
	 */
	public function getOrderchangeSequenceId()
	{
		if($this->__OrderchangeSequenceId == null)
		{
			$this->__OrderchangeSequenceId = new B3it_XmlBind_Opentrans21_OrderchangeSequenceId();
		}
	
		return $this->__OrderchangeSequenceId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderchangeSequenceId
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setOrderchangeSequenceId($value)
	{
		$this->__OrderchangeSequenceId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setDocexchangePartiesReference($value)
	{
		$this->__DocexchangePartiesReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setCurrency($value)
	{
		$this->__Currency = $value;
		return $this;
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
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
	 * @return B3it_XmlBind_Opentrans21_OrderresponseInfo
	 */
	public function setHeaderUdx($value)
	{
		$this->__HeaderUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDERRESPONSE_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderId != null){
			$this->__OrderId->toXml($xml);
		}
		if($this->__OrderresponseDate != null){
			$this->__OrderresponseDate->toXml($xml);
		}
		if($this->__OrderDate != null){
			$this->__OrderDate->toXml($xml);
		}
		if($this->__AltCustomerOrderIdA != null){
			foreach($this->__AltCustomerOrderIdA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SupplierOrderId != null){
			$this->__SupplierOrderId->toXml($xml);
		}
		if($this->__OrderchangeSequenceId != null){
			$this->__OrderchangeSequenceId->toXml($xml);
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
		if($this->__Currency != null){
			$this->__Currency->toXml($xml);
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
