<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Opentrans
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Opentrans extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Rfq */
	private $__Rfq = null;

	/* @var B3it_XmlBind_Opentrans21_Quotation */
	private $__Quotation = null;

	/* @var B3it_XmlBind_Opentrans21_Order */
	private $__Order = null;

	/* @var B3it_XmlBind_Opentrans21_Orderchange */
	private $__Orderchange = null;

	/* @var B3it_XmlBind_Opentrans21_Orderresponse */
	private $__Orderresponse = null;

	/* @var B3it_XmlBind_Opentrans21_Dispatchnotification */
	private $__Dispatchnotification = null;

	/* @var B3it_XmlBind_Opentrans21_Receiptacknowledgement */
	private $__Receiptacknowledgement = null;

	/* @var B3it_XmlBind_Opentrans21_Invoice */
	private $__Invoice = null;

	/* @var B3it_XmlBind_Opentrans21_Invoicelist */
	private $__Invoicelist = null;

	/* @var B3it_XmlBind_Opentrans21_Remittanceadvice */
	private $__Remittanceadvice = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Rfq
	 */
	public function getRfq()
	{
		if($this->__Rfq == null)
		{
			$this->__Rfq = new B3it_XmlBind_Opentrans21_Rfq();
		}
	
		return $this->__Rfq;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Rfq
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setRfq($value)
	{
		$this->__Rfq = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Quotation
	 */
	public function getQuotation()
	{
		if($this->__Quotation == null)
		{
			$this->__Quotation = new B3it_XmlBind_Opentrans21_Quotation();
		}
	
		return $this->__Quotation;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Quotation
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setQuotation($value)
	{
		$this->__Quotation = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Order
	 */
	public function getOrder()
	{
		if($this->__Order == null)
		{
			$this->__Order = new B3it_XmlBind_Opentrans21_Order();
		}
	
		return $this->__Order;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Order
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setOrder($value)
	{
		$this->__Order = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Orderchange
	 */
	public function getOrderchange()
	{
		if($this->__Orderchange == null)
		{
			$this->__Orderchange = new B3it_XmlBind_Opentrans21_Orderchange();
		}
	
		return $this->__Orderchange;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Orderchange
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setOrderchange($value)
	{
		$this->__Orderchange = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Orderresponse
	 */
	public function getOrderresponse()
	{
		if($this->__Orderresponse == null)
		{
			$this->__Orderresponse = new B3it_XmlBind_Opentrans21_Orderresponse();
		}
	
		return $this->__Orderresponse;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Orderresponse
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setOrderresponse($value)
	{
		$this->__Orderresponse = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Dispatchnotification
	 */
	public function getDispatchnotification()
	{
		if($this->__Dispatchnotification == null)
		{
			$this->__Dispatchnotification = new B3it_XmlBind_Opentrans21_Dispatchnotification();
		}
	
		return $this->__Dispatchnotification;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Dispatchnotification
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setDispatchnotification($value)
	{
		$this->__Dispatchnotification = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Receiptacknowledgement
	 */
	public function getReceiptacknowledgement()
	{
		if($this->__Receiptacknowledgement == null)
		{
			$this->__Receiptacknowledgement = new B3it_XmlBind_Opentrans21_Receiptacknowledgement();
		}
	
		return $this->__Receiptacknowledgement;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Receiptacknowledgement
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setReceiptacknowledgement($value)
	{
		$this->__Receiptacknowledgement = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Invoice
	 */
	public function getInvoice()
	{
		if($this->__Invoice == null)
		{
			$this->__Invoice = new B3it_XmlBind_Opentrans21_Invoice();
		}
	
		return $this->__Invoice;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Invoice
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setInvoice($value)
	{
		$this->__Invoice = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Invoicelist
	 */
	public function getInvoicelist()
	{
		if($this->__Invoicelist == null)
		{
			$this->__Invoicelist = new B3it_XmlBind_Opentrans21_Invoicelist();
		}
	
		return $this->__Invoicelist;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Invoicelist
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setInvoicelist($value)
	{
		$this->__Invoicelist = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Remittanceadvice
	 */
	public function getRemittanceadvice()
	{
		if($this->__Remittanceadvice == null)
		{
			$this->__Remittanceadvice = new B3it_XmlBind_Opentrans21_Remittanceadvice();
		}
	
		return $this->__Remittanceadvice;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Remittanceadvice
	 * @return B3it_XmlBind_Opentrans21_Opentrans
	 */
	public function setRemittanceadvice($value)
	{
		$this->__Remittanceadvice = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('OPENTRANS');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Rfq != null){
			$this->__Rfq->toXml($xml);
		}
		if($this->__Quotation != null){
			$this->__Quotation->toXml($xml);
		}
		if($this->__Order != null){
			$this->__Order->toXml($xml);
		}
		if($this->__Orderchange != null){
			$this->__Orderchange->toXml($xml);
		}
		if($this->__Orderresponse != null){
			$this->__Orderresponse->toXml($xml);
		}
		if($this->__Dispatchnotification != null){
			$this->__Dispatchnotification->toXml($xml);
		}
		if($this->__Receiptacknowledgement != null){
			$this->__Receiptacknowledgement->toXml($xml);
		}
		if($this->__Invoice != null){
			$this->__Invoice->toXml($xml);
		}
		if($this->__Invoicelist != null){
			$this->__Invoicelist->toXml($xml);
		}
		if($this->__Remittanceadvice != null){
			$this->__Remittanceadvice->toXml($xml);
		}


		return $xml;
	}

}
