<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderHistory
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderHistory extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderId */
	private $__OrderId = null;

	
	/* @var B3it_XmlBind_Opentrans21_AltCustomerOrderId */
	private $__AltCustomerOrderIdA = array();

	/* @var B3it_XmlBind_Opentrans21_SupplierOrderId */
	private $__SupplierOrderId = null;

	/* @var B3it_XmlBind_Opentrans21_OrderDate */
	private $__OrderDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_OrderDescr */
	private $__OrderDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_DeliverynoteId */
	private $__DeliverynoteId = null;

	/* @var B3it_XmlBind_Opentrans21_DeliverynoteDate */
	private $__DeliverynoteDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_Agreement */
	private $__AgreementA = array();

	/* @var B3it_XmlBind_Opentrans21_CatalogReference */
	private $__CatalogReference = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setOrderId($value)
	{
		$this->__OrderId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
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
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setSupplierOrderId($value)
	{
		$this->__SupplierOrderId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setOrderDate($value)
	{
		$this->__OrderDate = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_OrderDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_OrderDescr
	 */
	public function getOrderDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_OrderDescr();
		$this->__OrderDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderDescr
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setOrderDescr($value)
	{
		$this->__OrderDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderDescr[]
	 */
	public function getAllOrderDescr()
	{
		return $this->__OrderDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliverynoteId
	 */
	public function getDeliverynoteId()
	{
		if($this->__DeliverynoteId == null)
		{
			$this->__DeliverynoteId = new B3it_XmlBind_Opentrans21_DeliverynoteId();
		}
	
		return $this->__DeliverynoteId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliverynoteId
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setDeliverynoteId($value)
	{
		$this->__DeliverynoteId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliverynoteDate
	 */
	public function getDeliverynoteDate()
	{
		if($this->__DeliverynoteDate == null)
		{
			$this->__DeliverynoteDate = new B3it_XmlBind_Opentrans21_DeliverynoteDate();
		}
	
		return $this->__DeliverynoteDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliverynoteDate
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setDeliverynoteDate($value)
	{
		$this->__DeliverynoteDate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
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
	 * @return B3it_XmlBind_Opentrans21_OrderHistory
	 */
	public function setCatalogReference($value)
	{
		$this->__CatalogReference = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDER_HISTORY');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderId != null){
			$this->__OrderId->toXml($xml);
		}
		if($this->__AltCustomerOrderIdA != null){
			foreach($this->__AltCustomerOrderIdA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SupplierOrderId != null){
			$this->__SupplierOrderId->toXml($xml);
		}
		if($this->__OrderDate != null){
			$this->__OrderDate->toXml($xml);
		}
		if($this->__OrderDescrA != null){
			foreach($this->__OrderDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DeliverynoteId != null){
			$this->__DeliverynoteId->toXml($xml);
		}
		if($this->__DeliverynoteDate != null){
			$this->__DeliverynoteDate->toXml($xml);
		}
		if($this->__AgreementA != null){
			foreach($this->__AgreementA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CatalogReference != null){
			$this->__CatalogReference->toXml($xml);
		}


		return $xml;
	}

}
