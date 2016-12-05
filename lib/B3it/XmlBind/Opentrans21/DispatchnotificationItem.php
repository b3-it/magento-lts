<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DispatchnotificationItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DispatchnotificationItem extends B3it_XmlBind_Opentrans21_XmlObject
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

	/* @var B3it_XmlBind_Opentrans21_PartialDeliveryList */
	private $__PartialDeliveryList = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryCompleted */
	private $__DeliveryCompleted = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryReference */
	private $__DeliveryReference = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_OrderReference */
	private $__OrderReference = null;

	/* @var B3it_XmlBind_Opentrans21_SupplierOrderReference */
	private $__SupplierOrderReference = null;

	/* @var B3it_XmlBind_Opentrans21_CustomerOrderReference */
	private $__CustomerOrderReference = null;

	/* @var B3it_XmlBind_Opentrans21_ShipmentPartiesReference */
	private $__ShipmentPartiesReference = null;

	/* @var B3it_XmlBind_Opentrans21_LogisticDetails */
	private $__LogisticDetails = null;

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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setOrderUnit($value)
	{
		$this->__OrderUnit = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setPartialDeliveryList($value)
	{
		$this->__PartialDeliveryList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryCompleted
	 */
	public function getDeliveryCompleted()
	{
		if($this->__DeliveryCompleted == null)
		{
			$this->__DeliveryCompleted = new B3it_XmlBind_Opentrans21_DeliveryCompleted();
		}
	
		return $this->__DeliveryCompleted;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryCompleted
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setDeliveryCompleted($value)
	{
		$this->__DeliveryCompleted = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryReference
	 */
	public function getDeliveryReference()
	{
		if($this->__DeliveryReference == null)
		{
			$this->__DeliveryReference = new B3it_XmlBind_Opentrans21_DeliveryReference();
		}
	
		return $this->__DeliveryReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryReference
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setDeliveryReference($value)
	{
		$this->__DeliveryReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderReference
	 */
	public function getOrderReference()
	{
		if($this->__OrderReference == null)
		{
			$this->__OrderReference = new B3it_XmlBind_Opentrans21_OrderReference();
		}
	
		return $this->__OrderReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderReference
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setOrderReference($value)
	{
		$this->__OrderReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SupplierOrderReference
	 */
	public function getSupplierOrderReference()
	{
		if($this->__SupplierOrderReference == null)
		{
			$this->__SupplierOrderReference = new B3it_XmlBind_Opentrans21_SupplierOrderReference();
		}
	
		return $this->__SupplierOrderReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SupplierOrderReference
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setSupplierOrderReference($value)
	{
		$this->__SupplierOrderReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
	 */
	public function getCustomerOrderReference()
	{
		if($this->__CustomerOrderReference == null)
		{
			$this->__CustomerOrderReference = new B3it_XmlBind_Opentrans21_CustomerOrderReference();
		}
	
		return $this->__CustomerOrderReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CustomerOrderReference
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setCustomerOrderReference($value)
	{
		$this->__CustomerOrderReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setShipmentPartiesReference($value)
	{
		$this->__ShipmentPartiesReference = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function getLogisticDetails()
	{
		if($this->__LogisticDetails == null)
		{
			$this->__LogisticDetails = new B3it_XmlBind_Opentrans21_LogisticDetails();
		}
	
		return $this->__LogisticDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_LogisticDetails
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setLogisticDetails($value)
	{
		$this->__LogisticDetails = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
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
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function setItemUdx($value)
	{
		$this->__ItemUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DISPATCHNOTIFICATION_ITEM');
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
		if($this->__PartialDeliveryList != null){
			$this->__PartialDeliveryList->toXml($xml);
		}
		if($this->__DeliveryCompleted != null){
			$this->__DeliveryCompleted->toXml($xml);
		}
		if($this->__DeliveryReference != null){
			$this->__DeliveryReference->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__OrderReference != null){
			$this->__OrderReference->toXml($xml);
		}
		if($this->__SupplierOrderReference != null){
			$this->__SupplierOrderReference->toXml($xml);
		}
		if($this->__CustomerOrderReference != null){
			$this->__CustomerOrderReference->toXml($xml);
		}
		if($this->__ShipmentPartiesReference != null){
			$this->__ShipmentPartiesReference->toXml($xml);
		}
		if($this->__LogisticDetails != null){
			$this->__LogisticDetails->toXml($xml);
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
