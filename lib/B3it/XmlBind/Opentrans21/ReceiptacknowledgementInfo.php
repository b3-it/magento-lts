<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ReceiptacknowledgementInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ReceiptacknowledgementId */
	private $__ReceiptacknowledgementId = null;

	/* @var B3it_XmlBind_Opentrans21_ReceiptacknowledgementDate */
	private $__ReceiptacknowledgementDate = null;

	/* @var B3it_XmlBind_Opentrans21_ReceiptDate */
	private $__ReceiptDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Language */
	private $__LanguageA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeRoot */
	private $__MimeRoot = null;

	/* @var B3it_XmlBind_Opentrans21_Parties */
	private $__Parties = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerIdref */
	private $__BuyerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_ShipmentPartiesReference */
	private $__ShipmentPartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_DocexchangePartiesReference */
	private $__DocexchangePartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_HeaderUdx */
	private $__HeaderUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementId
	 */
	public function getReceiptacknowledgementId()
	{
		if($this->__ReceiptacknowledgementId == null)
		{
			$this->__ReceiptacknowledgementId = new B3it_XmlBind_Opentrans21_ReceiptacknowledgementId();
		}
	
		return $this->__ReceiptacknowledgementId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptacknowledgementId
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
	 */
	public function setReceiptacknowledgementId($value)
	{
		$this->__ReceiptacknowledgementId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementDate
	 */
	public function getReceiptacknowledgementDate()
	{
		if($this->__ReceiptacknowledgementDate == null)
		{
			$this->__ReceiptacknowledgementDate = new B3it_XmlBind_Opentrans21_ReceiptacknowledgementDate();
		}
	
		return $this->__ReceiptacknowledgementDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptacknowledgementDate
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
	 */
	public function setReceiptacknowledgementDate($value)
	{
		$this->__ReceiptacknowledgementDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptDate
	 */
	public function getReceiptDate()
	{
		if($this->__ReceiptDate == null)
		{
			$this->__ReceiptDate = new B3it_XmlBind_Opentrans21_ReceiptDate();
		}
	
		return $this->__ReceiptDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptDate
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
	 */
	public function setReceiptDate($value)
	{
		$this->__ReceiptDate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
	 */
	public function setShipmentPartiesReference($value)
	{
		$this->__ShipmentPartiesReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
	 */
	public function setDocexchangePartiesReference($value)
	{
		$this->__DocexchangePartiesReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementInfo
	 */
	public function setHeaderUdx($value)
	{
		$this->__HeaderUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RECEIPTACKNOWLEDGEMENT_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ReceiptacknowledgementId != null){
			$this->__ReceiptacknowledgementId->toXml($xml);
		}
		if($this->__ReceiptacknowledgementDate != null){
			$this->__ReceiptacknowledgementDate->toXml($xml);
		}
		if($this->__ReceiptDate != null){
			$this->__ReceiptDate->toXml($xml);
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
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__BuyerIdref != null){
			$this->__BuyerIdref->toXml($xml);
		}
		if($this->__ShipmentPartiesReference != null){
			$this->__ShipmentPartiesReference->toXml($xml);
		}
		if($this->__DocexchangePartiesReference != null){
			$this->__DocexchangePartiesReference->toXml($xml);
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
