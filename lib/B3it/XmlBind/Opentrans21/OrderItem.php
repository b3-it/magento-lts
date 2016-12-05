<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderItem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_ProductId */
	private $__ProductId = null;

	/* @var B3it_XmlBind_Opentrans21_ProductFeatures */
	private $__ProductFeatures = null;

	/* @var B3it_XmlBind_Opentrans21_ProductComponents */
	private $__ProductComponents = null;

	/* @var B3it_XmlBind_Opentrans21_Quantity */
	private $__Quantity = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_OrderUnit */
	private $__OrderUnit = null;

	/* @var B3it_XmlBind_Opentrans21_ProductPriceFix */
	private $__ProductPriceFix = null;

	/* @var B3it_XmlBind_Opentrans21_PriceLineAmount */
	private $__PriceLineAmount = null;

	/* @var B3it_XmlBind_Opentrans21_PartialShipmentAllowed */
	private $__PartialShipmentAllowed = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryDate */
	private $__DeliveryDate = null;

	/* @var B3it_XmlBind_Opentrans21_PartialDeliveryList */
	private $__PartialDeliveryList = null;

	/* @var B3it_XmlBind_Opentrans21_SourcingInfo */
	private $__SourcingInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_CustomerOrderReference */
	private $__CustomerOrderReferenceA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo */
	private $__AccountingInfo = null;

	/* @var B3it_XmlBind_Opentrans21_ShipmentPartiesReference */
	private $__ShipmentPartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Transport */
	private $__Transport = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_InternationalRestrictions */
	private $__InternationalRestrictionsA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass */
	private $__SpecialTreatmentClassA = array();

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
	private $__MimeInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Remarks */
	private $__RemarksA = array();

	/* @var B3it_XmlBind_Opentrans21_ItemUdx */
	private $__ItemUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_LineItemId
	 */
	public function getLineItemId()
	{
		if($this->__LineItemId == null)
		{
			$this->__LineItemId = new B3it_XmlBind_Opentrans21_LineItemId();
		}
	
		return $this->__LineItemId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_LineItemId
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setLineItemId($value)
	{
		$this->__LineItemId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function getProductId()
	{
		if($this->__ProductId == null)
		{
			$this->__ProductId = new B3it_XmlBind_Opentrans21_ProductId();
		}
	
		return $this->__ProductId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductId
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setProductId($value)
	{
		$this->__ProductId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function getProductFeatures()
	{
		if($this->__ProductFeatures == null)
		{
			$this->__ProductFeatures = new B3it_XmlBind_Opentrans21_ProductFeatures();
		}
	
		return $this->__ProductFeatures;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductFeatures
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setProductFeatures($value)
	{
		$this->__ProductFeatures = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductComponents
	 */
	public function getProductComponents()
	{
		if($this->__ProductComponents == null)
		{
			$this->__ProductComponents = new B3it_XmlBind_Opentrans21_ProductComponents();
		}
	
		return $this->__ProductComponents;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductComponents
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setProductComponents($value)
	{
		$this->__ProductComponents = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Quantity
	 */
	public function getQuantity()
	{
		if($this->__Quantity == null)
		{
			$this->__Quantity = new B3it_XmlBind_Opentrans21_Quantity();
		}
	
		return $this->__Quantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Quantity
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setQuantity($value)
	{
		$this->__Quantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_OrderUnit
	 */
	public function getOrderUnit()
	{
		if($this->__OrderUnit == null)
		{
			$this->__OrderUnit = new B3it_XmlBind_Opentrans21_Bmecat_OrderUnit();
		}
	
		return $this->__OrderUnit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_OrderUnit
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setOrderUnit($value)
	{
		$this->__OrderUnit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function getProductPriceFix()
	{
		if($this->__ProductPriceFix == null)
		{
			$this->__ProductPriceFix = new B3it_XmlBind_Opentrans21_ProductPriceFix();
		}
	
		return $this->__ProductPriceFix;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductPriceFix
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setProductPriceFix($value)
	{
		$this->__ProductPriceFix = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PriceLineAmount
	 */
	public function getPriceLineAmount()
	{
		if($this->__PriceLineAmount == null)
		{
			$this->__PriceLineAmount = new B3it_XmlBind_Opentrans21_PriceLineAmount();
		}
	
		return $this->__PriceLineAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PriceLineAmount
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setPriceLineAmount($value)
	{
		$this->__PriceLineAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PartialShipmentAllowed
	 */
	public function getPartialShipmentAllowed()
	{
		if($this->__PartialShipmentAllowed == null)
		{
			$this->__PartialShipmentAllowed = new B3it_XmlBind_Opentrans21_PartialShipmentAllowed();
		}
	
		return $this->__PartialShipmentAllowed;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PartialShipmentAllowed
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setPartialShipmentAllowed($value)
	{
		$this->__PartialShipmentAllowed = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setDeliveryDate($value)
	{
		$this->__DeliveryDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PartialDeliveryList
	 */
	public function getPartialDeliveryList()
	{
		if($this->__PartialDeliveryList == null)
		{
			$this->__PartialDeliveryList = new B3it_XmlBind_Opentrans21_PartialDeliveryList();
		}
	
		return $this->__PartialDeliveryList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PartialDeliveryList
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setPartialDeliveryList($value)
	{
		$this->__PartialDeliveryList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SourcingInfo
	 */
	public function getSourcingInfo()
	{
		if($this->__SourcingInfo == null)
		{
			$this->__SourcingInfo = new B3it_XmlBind_Opentrans21_SourcingInfo();
		}
	
		return $this->__SourcingInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SourcingInfo
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setSourcingInfo($value)
	{
		$this->__SourcingInfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_CustomerOrderReference and add it to list
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
	 */
	public function getCustomerOrderReference()
	{
		$res = new B3it_XmlBind_Opentrans21_CustomerOrderReference();
		$this->__CustomerOrderReferenceA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CustomerOrderReference
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setCustomerOrderReference($value)
	{
		$this->__CustomerOrderReferenceA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference[]
	 */
	public function getAllCustomerOrderReference()
	{
		return $this->__CustomerOrderReferenceA;
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setAccountingInfo($value)
	{
		$this->__AccountingInfo = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setShipmentPartiesReference($value)
	{
		$this->__ShipmentPartiesReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
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
	 * @return B3it_XmlBind_Opentrans21_OrderItem
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
	 * @return B3it_XmlBind_Opentrans21_ItemUdx
	 */
	public function getItemUdx()
	{
		if($this->__ItemUdx == null)
		{
			$this->__ItemUdx = new B3it_XmlBind_Opentrans21_ItemUdx();
		}
	
		return $this->__ItemUdx;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ItemUdx
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function setItemUdx($value)
	{
		$this->__ItemUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDER_ITEM');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__LineItemId != null){
			$this->__LineItemId->toXml($xml);
		}
		if($this->__ProductId != null){
			$this->__ProductId->toXml($xml);
		}
		if($this->__ProductFeatures != null){
			$this->__ProductFeatures->toXml($xml);
		}
		if($this->__ProductComponents != null){
			$this->__ProductComponents->toXml($xml);
		}
		if($this->__Quantity != null){
			$this->__Quantity->toXml($xml);
		}
		if($this->__OrderUnit != null){
			$this->__OrderUnit->toXml($xml);
		}
		if($this->__ProductPriceFix != null){
			$this->__ProductPriceFix->toXml($xml);
		}
		if($this->__PriceLineAmount != null){
			$this->__PriceLineAmount->toXml($xml);
		}
		if($this->__PartialShipmentAllowed != null){
			$this->__PartialShipmentAllowed->toXml($xml);
		}
		if($this->__DeliveryDate != null){
			$this->__DeliveryDate->toXml($xml);
		}
		if($this->__PartialDeliveryList != null){
			$this->__PartialDeliveryList->toXml($xml);
		}
		if($this->__SourcingInfo != null){
			$this->__SourcingInfo->toXml($xml);
		}
		if($this->__CustomerOrderReferenceA != null){
			foreach($this->__CustomerOrderReferenceA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AccountingInfo != null){
			$this->__AccountingInfo->toXml($xml);
		}
		if($this->__ShipmentPartiesReference != null){
			$this->__ShipmentPartiesReference->toXml($xml);
		}
		if($this->__Transport != null){
			$this->__Transport->toXml($xml);
		}
		if($this->__InternationalRestrictionsA != null){
			foreach($this->__InternationalRestrictionsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SpecialTreatmentClassA != null){
			foreach($this->__SpecialTreatmentClassA as $item){
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
		if($this->__ItemUdx != null){
			$this->__ItemUdx->toXml($xml);
		}


		return $xml;
	}

}
