<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DispatchnotificationInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DispatchnotificationInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationId */
	private $__DispatchnotificationId = null;

	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationDate */
	private $__DispatchnotificationDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Language */
	private $__LanguageA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeRoot */
	private $__MimeRoot = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryDate */
	private $__DeliveryDate = null;

	/* @var B3it_XmlBind_Opentrans21_Parties */
	private $__Parties = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref */
	private $__BuyerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_ShipmentPartiesReference */
	private $__ShipmentPartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_ShipmentId */
	private $__ShipmentId = null;

	/* @var B3it_XmlBind_Opentrans21_TrackingTracingUrl */
	private $__TrackingTracingUrl = null;

	/* @var B3it_XmlBind_Opentrans21_DocexchangePartiesReference */
	private $__DocexchangePartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_LogisticDetailsInfo */
	private $__LogisticDetailsInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions */
	private $__InternationalRestrictionsA = array();

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_HeaderUdx */
	private $__HeaderUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationId
	 */
	public function getDispatchnotificationId()
	{
		if($this->__DispatchnotificationId == null)
		{
			$this->__DispatchnotificationId = new B3it_XmlBind_Opentrans21_DispatchnotificationId();
		}
	
		return $this->__DispatchnotificationId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationId
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setDispatchnotificationId($value)
	{
		$this->__DispatchnotificationId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationDate
	 */
	public function getDispatchnotificationDate()
	{
		if($this->__DispatchnotificationDate == null)
		{
			$this->__DispatchnotificationDate = new B3it_XmlBind_Opentrans21_DispatchnotificationDate();
		}
	
		return $this->__DispatchnotificationDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationDate
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setDispatchnotificationDate($value)
	{
		$this->__DispatchnotificationDate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setMimeRoot($value)
	{
		$this->__MimeRoot = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setDeliveryDate($value)
	{
		$this->__DeliveryDate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setParties($value)
	{
		$this->__Parties = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref
	 */
	public function getBuyerIdref()
	{
		if($this->__BuyerIdref == null)
		{
			$this->__BuyerIdref = new B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref();
		}
	
		return $this->__BuyerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setBuyerIdref($value)
	{
		$this->__BuyerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ShipmentPartiesReference
	 */
	public function getShipmentPartiesReference()
	{
		if($this->__ShipmentPartiesReference == null)
		{
			$this->__ShipmentPartiesReference = new B3it_XmlBind_Opentrans21_ShipmentPartiesReference();
		}
	
		return $this->__ShipmentPartiesReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ShipmentPartiesReference
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setShipmentPartiesReference($value)
	{
		$this->__ShipmentPartiesReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ShipmentId
	 */
	public function getShipmentId()
	{
		if($this->__ShipmentId == null)
		{
			$this->__ShipmentId = new B3it_XmlBind_Opentrans21_ShipmentId();
		}
	
		return $this->__ShipmentId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ShipmentId
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setShipmentId($value)
	{
		$this->__ShipmentId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TrackingTracingUrl
	 */
	public function getTrackingTracingUrl()
	{
		if($this->__TrackingTracingUrl == null)
		{
			$this->__TrackingTracingUrl = new B3it_XmlBind_Opentrans21_TrackingTracingUrl();
		}
	
		return $this->__TrackingTracingUrl;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TrackingTracingUrl
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setTrackingTracingUrl($value)
	{
		$this->__TrackingTracingUrl = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setDocexchangePartiesReference($value)
	{
		$this->__DocexchangePartiesReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_LogisticDetailsInfo
	 */
	public function getLogisticDetailsInfo()
	{
		if($this->__LogisticDetailsInfo == null)
		{
			$this->__LogisticDetailsInfo = new B3it_XmlBind_Opentrans21_LogisticDetailsInfo();
		}
	
		return $this->__LogisticDetailsInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_LogisticDetailsInfo
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setLogisticDetailsInfo($value)
	{
		$this->__LogisticDetailsInfo = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationInfo
	 */
	public function setHeaderUdx($value)
	{
		$this->__HeaderUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DISPATCHNOTIFICATION_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DispatchnotificationId != null){
			$this->__DispatchnotificationId->toXml($xml);
		}
		if($this->__DispatchnotificationDate != null){
			$this->__DispatchnotificationDate->toXml($xml);
		}
		if($this->__LanguageA != null){
			foreach($this->__LanguageA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeRoot != null){
			$this->__MimeRoot->toXml($xml);
		}
		if($this->__DeliveryDate != null){
			$this->__DeliveryDate->toXml($xml);
		}
		if($this->__Parties != null){
			$this->__Parties->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__BuyerIdref != null){
			$this->__BuyerIdref->toXml($xml);
		}
		if($this->__ShipmentPartiesReference != null){
			$this->__ShipmentPartiesReference->toXml($xml);
		}
		if($this->__ShipmentId != null){
			$this->__ShipmentId->toXml($xml);
		}
		if($this->__TrackingTracingUrl != null){
			$this->__TrackingTracingUrl->toXml($xml);
		}
		if($this->__DocexchangePartiesReference != null){
			$this->__DocexchangePartiesReference->toXml($xml);
		}
		if($this->__LogisticDetailsInfo != null){
			$this->__LogisticDetailsInfo->toXml($xml);
		}
		if($this->__InternationalRestrictionsA != null){
			foreach($this->__InternationalRestrictionsA as $item){
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
