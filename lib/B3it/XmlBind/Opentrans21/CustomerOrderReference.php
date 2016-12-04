<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	CustomerOrderReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_CustomerOrderReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderId */
	private $__OrderId = null;

	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_OrderDate */
	private $__OrderDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_OrderDescr */
	private $__OrderDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_CustomerIdref */
	private $__CustomerIdref = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
	 */
	public function setOrderId($value)
	{
		$this->__OrderId = $value;
		return $this;
	}
	
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
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
	 */
	public function setLineItemId($value)
	{
		$this->__LineItemId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
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
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
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
	 * @return B3it_XmlBind_Opentrans21_CustomerIdref
	 */
	public function getCustomerIdref()
	{
		if($this->__CustomerIdref == null)
		{
			$this->__CustomerIdref = new B3it_XmlBind_Opentrans21_CustomerIdref();
		}
	
		return $this->__CustomerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CustomerIdref
	 * @return B3it_XmlBind_Opentrans21_CustomerOrderReference
	 */
	public function setCustomerIdref($value)
	{
		$this->__CustomerIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('CUSTOMER_ORDER_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderId != null){
			$this->__OrderId->toXml($xml);
		}
		if($this->__LineItemId != null){
			$this->__LineItemId->toXml($xml);
		}
		if($this->__OrderDate != null){
			$this->__OrderDate->toXml($xml);
		}
		if($this->__OrderDescrA != null){
			foreach($this->__OrderDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CustomerIdref != null){
			$this->__CustomerIdref->toXml($xml);
		}


		return $xml;
	}

}
