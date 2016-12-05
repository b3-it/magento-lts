<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TimeForPayment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TimeForPayment extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_PaymentDate */
	private $__PaymentDate = null;

	/* @var B3it_XmlBind_Opentrans21_Days */
	private $__Days = null;

	/* @var B3it_XmlBind_Opentrans21_DiscountFactor */
	private $__DiscountFactor = null;

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargesFix */
	private $__AllowOrChargesFix = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PaymentDate
	 */
	public function getPaymentDate()
	{
		if($this->__PaymentDate == null)
		{
			$this->__PaymentDate = new B3it_XmlBind_Opentrans21_PaymentDate();
		}
	
		return $this->__PaymentDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PaymentDate
	 * @return B3it_XmlBind_Opentrans21_TimeForPayment
	 */
	public function setPaymentDate($value)
	{
		$this->__PaymentDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Days
	 */
	public function getDays()
	{
		if($this->__Days == null)
		{
			$this->__Days = new B3it_XmlBind_Opentrans21_Days();
		}
	
		return $this->__Days;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Days
	 * @return B3it_XmlBind_Opentrans21_TimeForPayment
	 */
	public function setDays($value)
	{
		$this->__Days = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DiscountFactor
	 */
	public function getDiscountFactor()
	{
		if($this->__DiscountFactor == null)
		{
			$this->__DiscountFactor = new B3it_XmlBind_Opentrans21_DiscountFactor();
		}
	
		return $this->__DiscountFactor;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DiscountFactor
	 * @return B3it_XmlBind_Opentrans21_TimeForPayment
	 */
	public function setDiscountFactor($value)
	{
		$this->__DiscountFactor = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargesFix
	 */
	public function getAllowOrChargesFix()
	{
		if($this->__AllowOrChargesFix == null)
		{
			$this->__AllowOrChargesFix = new B3it_XmlBind_Opentrans21_AllowOrChargesFix();
		}
	
		return $this->__AllowOrChargesFix;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargesFix
	 * @return B3it_XmlBind_Opentrans21_TimeForPayment
	 */
	public function setAllowOrChargesFix($value)
	{
		$this->__AllowOrChargesFix = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('TIME_FOR_PAYMENT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PaymentDate != null){
			$this->__PaymentDate->toXml($xml);
		}
		if($this->__Days != null){
			$this->__Days->toXml($xml);
		}
		if($this->__DiscountFactor != null){
			$this->__DiscountFactor->toXml($xml);
		}
		if($this->__AllowOrChargesFix != null){
			$this->__AllowOrChargesFix->toXml($xml);
		}


		return $xml;
	}

}
