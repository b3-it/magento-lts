<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderParties
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderParties extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_BuyerParty */
	private $__BuyerParty = null;

	/* @var B3it_XmlBind_Opentrans21_SupplierParty */
	private $__SupplierParty = null;

	/* @var B3it_XmlBind_Opentrans21_InvoiceParty */
	private $__InvoiceParty = null;

	/* @var B3it_XmlBind_Opentrans21_ShipmentParties */
	private $__ShipmentParties = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_BuyerParty
	 */
	public function getBuyerParty()
	{
		if($this->__BuyerParty == null)
		{
			$this->__BuyerParty = new B3it_XmlBind_Opentrans21_BuyerParty();
		}
	
		return $this->__BuyerParty;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_BuyerParty
	 * @return B3it_XmlBind_Opentrans21_OrderParties
	 */
	public function setBuyerParty($value)
	{
		$this->__BuyerParty = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SupplierParty
	 */
	public function getSupplierParty()
	{
		if($this->__SupplierParty == null)
		{
			$this->__SupplierParty = new B3it_XmlBind_Opentrans21_SupplierParty();
		}
	
		return $this->__SupplierParty;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SupplierParty
	 * @return B3it_XmlBind_Opentrans21_OrderParties
	 */
	public function setSupplierParty($value)
	{
		$this->__SupplierParty = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceParty
	 */
	public function getInvoiceParty()
	{
		if($this->__InvoiceParty == null)
		{
			$this->__InvoiceParty = new B3it_XmlBind_Opentrans21_InvoiceParty();
		}
	
		return $this->__InvoiceParty;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceParty
	 * @return B3it_XmlBind_Opentrans21_OrderParties
	 */
	public function setInvoiceParty($value)
	{
		$this->__InvoiceParty = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ShipmentParties
	 */
	public function getShipmentParties()
	{
		if($this->__ShipmentParties == null)
		{
			$this->__ShipmentParties = new B3it_XmlBind_Opentrans21_ShipmentParties();
		}
	
		return $this->__ShipmentParties;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ShipmentParties
	 * @return B3it_XmlBind_Opentrans21_OrderParties
	 */
	public function setShipmentParties($value)
	{
		$this->__ShipmentParties = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ORDER_PARTIES');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__BuyerParty != null){
			$this->__BuyerParty->toXml($xml);
		}
		if($this->__SupplierParty != null){
			$this->__SupplierParty->toXml($xml);
		}
		if($this->__InvoiceParty != null){
			$this->__InvoiceParty->toXml($xml);
		}
		if($this->__ShipmentParties != null){
			$this->__ShipmentParties->toXml($xml);
		}


		return $xml;
	}

}
