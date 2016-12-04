<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	PaymentTerms
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_PaymentTerms extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_PaymentTerm */
	private $__PaymentTermA = array();

	
	/* @var B3it_XmlBind_Opentrans21_TimeForPayment */
	private $__TimeForPaymentA = array();

	/* @var B3it_XmlBind_Opentrans21_ValueDate */
	private $__ValueDate = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_PaymentTerm and add it to list
	 * @return B3it_XmlBind_Opentrans21_PaymentTerm
	 */
	public function getPaymentTerm()
	{
		$res = new B3it_XmlBind_Opentrans21_PaymentTerm();
		$this->__PaymentTermA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PaymentTerm
	 * @return B3it_XmlBind_Opentrans21_PaymentTerms
	 */
	public function setPaymentTerm($value)
	{
		$this->__PaymentTermA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PaymentTerm[]
	 */
	public function getAllPaymentTerm()
	{
		return $this->__PaymentTermA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TimeForPayment and add it to list
	 * @return B3it_XmlBind_Opentrans21_TimeForPayment
	 */
	public function getTimeForPayment()
	{
		$res = new B3it_XmlBind_Opentrans21_TimeForPayment();
		$this->__TimeForPaymentA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TimeForPayment
	 * @return B3it_XmlBind_Opentrans21_PaymentTerms
	 */
	public function setTimeForPayment($value)
	{
		$this->__TimeForPaymentA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TimeForPayment[]
	 */
	public function getAllTimeForPayment()
	{
		return $this->__TimeForPaymentA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_ValueDate
	 */
	public function getValueDate()
	{
		if($this->__ValueDate == null)
		{
			$this->__ValueDate = new B3it_XmlBind_Opentrans21_ValueDate();
		}
	
		return $this->__ValueDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ValueDate
	 * @return B3it_XmlBind_Opentrans21_PaymentTerms
	 */
	public function setValueDate($value)
	{
		$this->__ValueDate = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PAYMENT_TERMS');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PaymentTermA != null){
			foreach($this->__PaymentTermA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__TimeForPaymentA != null){
			foreach($this->__TimeForPaymentA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ValueDate != null){
			$this->__ValueDate->toXml($xml);
		}


		return $xml;
	}

}
