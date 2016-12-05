<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	SupplierOrderReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_SupplierOrderReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_SupplierOrderId */
	private $__SupplierOrderId = null;

	/* @var B3it_XmlBind_Opentrans21_SupplierOrderItemId */
	private $__SupplierOrderItemId = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_SupplierOrderReference
	 */
	public function setSupplierOrderId($value)
	{
		$this->__SupplierOrderId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SupplierOrderItemId
	 */
	public function getSupplierOrderItemId()
	{
		if($this->__SupplierOrderItemId == null)
		{
			$this->__SupplierOrderItemId = new B3it_XmlBind_Opentrans21_SupplierOrderItemId();
		}
	
		return $this->__SupplierOrderItemId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SupplierOrderItemId
	 * @return B3it_XmlBind_Opentrans21_SupplierOrderReference
	 */
	public function setSupplierOrderItemId($value)
	{
		$this->__SupplierOrderItemId = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('SUPPLIER_ORDER_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SupplierOrderId != null){
			$this->__SupplierOrderId->toXml($xml);
		}
		if($this->__SupplierOrderItemId != null){
			$this->__SupplierOrderItemId->toXml($xml);
		}


		return $xml;
	}

}
