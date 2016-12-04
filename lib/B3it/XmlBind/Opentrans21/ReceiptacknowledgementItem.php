<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ReceiptacknowledgementItem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_ProductId */
	private $__ProductId = null;

	/* @var B3it_XmlBind_Opentrans21_Quantity */
	private $__Quantity = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_OrderUnit */
	private $__OrderUnit = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryCompleted */
	private $__DeliveryCompleted = null;

	/* @var B3it_XmlBind_Opentrans21_ReceiptDate */
	private $__ReceiptDate = null;

	/* @var B3it_XmlBind_Opentrans21_OrderReference */
	private $__OrderReference = null;

	/* @var B3it_XmlBind_Opentrans21_SupplierOrderReference */
	private $__SupplierOrderReference = null;

	/* @var B3it_XmlBind_Opentrans21_CustomerOrderReference */
	private $__CustomerOrderReference = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryReference */
	private $__DeliveryReference = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryIdref */
	private $__DeliveryIdref = null;

	/* @var B3it_XmlBind_Opentrans21_FinalDeliveryIdref */
	private $__FinalDeliveryIdref = null;

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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setProductId($value)
	{
		$this->__ProductId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setOrderUnit($value)
	{
		$this->__OrderUnit = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setDeliveryCompleted($value)
	{
		$this->__DeliveryCompleted = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setReceiptDate($value)
	{
		$this->__ReceiptDate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setCustomerOrderReference($value)
	{
		$this->__CustomerOrderReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryIdref
	 */
	public function getDeliveryIdref()
	{
		if($this->__DeliveryIdref == null)
		{
			$this->__DeliveryIdref = new B3it_XmlBind_Opentrans21_DeliveryIdref();
		}
	
		return $this->__DeliveryIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryIdref
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setDeliveryIdref($value)
	{
		$this->__DeliveryIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_FinalDeliveryIdref
	 */
	public function getFinalDeliveryIdref()
	{
		if($this->__FinalDeliveryIdref == null)
		{
			$this->__FinalDeliveryIdref = new B3it_XmlBind_Opentrans21_FinalDeliveryIdref();
		}
	
		return $this->__FinalDeliveryIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_FinalDeliveryIdref
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setFinalDeliveryIdref($value)
	{
		$this->__FinalDeliveryIdref = $value;
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
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
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function setItemUdx($value)
	{
		$this->__ItemUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RECEIPTACKNOWLEDGEMENT_ITEM');
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
		if($this->__Quantity != null){
			$this->__Quantity->toXml($xml);
		}
		if($this->__OrderUnit != null){
			$this->__OrderUnit->toXml($xml);
		}
		if($this->__DeliveryCompleted != null){
			$this->__DeliveryCompleted->toXml($xml);
		}
		if($this->__ReceiptDate != null){
			$this->__ReceiptDate->toXml($xml);
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
		if($this->__DeliveryReference != null){
			$this->__DeliveryReference->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__DeliveryIdref != null){
			$this->__DeliveryIdref->toXml($xml);
		}
		if($this->__FinalDeliveryIdref != null){
			$this->__FinalDeliveryIdref->toXml($xml);
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
