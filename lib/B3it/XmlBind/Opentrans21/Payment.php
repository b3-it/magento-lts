<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Payment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Payment extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Card */
	private $__Card = null;

	
	/* @var B3it_XmlBind_Opentrans21_Account */
	private $__AccountA = array();

	/* @var B3it_XmlBind_Opentrans21_Debit */
	private $__Debit = null;

	/* @var B3it_XmlBind_Opentrans21_Check */
	private $__Check = null;

	/* @var B3it_XmlBind_Opentrans21_Cash */
	private $__Cash = null;

	/* @var B3it_XmlBind_Opentrans21_CentralRegulation */
	private $__CentralRegulation = null;

	/* @var B3it_XmlBind_Opentrans21_PaymentTerms */
	private $__PaymentTerms = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Card
	 */
	public function getCard()
	{
		if($this->__Card == null)
		{
			$this->__Card = new B3it_XmlBind_Opentrans21_Card();
		}
	
		return $this->__Card;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Card
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setCard($value)
	{
		$this->__Card = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Account and add it to list
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function getAccount()
	{
		$res = new B3it_XmlBind_Opentrans21_Account();
		$this->__AccountA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Account
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setAccount($value)
	{
		$this->__AccountA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Account[]
	 */
	public function getAllAccount()
	{
		return $this->__AccountA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Debit
	 */
	public function getDebit()
	{
		if($this->__Debit == null)
		{
			$this->__Debit = new B3it_XmlBind_Opentrans21_Debit();
		}
	
		return $this->__Debit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Debit
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setDebit($value)
	{
		$this->__Debit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Check
	 */
	public function getCheck()
	{
		if($this->__Check == null)
		{
			$this->__Check = new B3it_XmlBind_Opentrans21_Check();
		}
	
		return $this->__Check;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Check
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setCheck($value)
	{
		$this->__Check = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Cash
	 */
	public function getCash()
	{
		if($this->__Cash == null)
		{
			$this->__Cash = new B3it_XmlBind_Opentrans21_Cash();
		}
	
		return $this->__Cash;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Cash
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setCash($value)
	{
		$this->__Cash = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CentralRegulation
	 */
	public function getCentralRegulation()
	{
		if($this->__CentralRegulation == null)
		{
			$this->__CentralRegulation = new B3it_XmlBind_Opentrans21_CentralRegulation();
		}
	
		return $this->__CentralRegulation;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CentralRegulation
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setCentralRegulation($value)
	{
		$this->__CentralRegulation = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PaymentTerms
	 */
	public function getPaymentTerms()
	{
		if($this->__PaymentTerms == null)
		{
			$this->__PaymentTerms = new B3it_XmlBind_Opentrans21_PaymentTerms();
		}
	
		return $this->__PaymentTerms;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PaymentTerms
	 * @return B3it_XmlBind_Opentrans21_Payment
	 */
	public function setPaymentTerms($value)
	{
		$this->__PaymentTerms = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PAYMENT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Card != null){
			$this->__Card->toXml($xml);
		}
		if($this->__AccountA != null){
			foreach($this->__AccountA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Debit != null){
			$this->__Debit->toXml($xml);
		}
		if($this->__Check != null){
			$this->__Check->toXml($xml);
		}
		if($this->__Cash != null){
			$this->__Cash->toXml($xml);
		}
		if($this->__CentralRegulation != null){
			$this->__CentralRegulation->toXml($xml);
		}
		if($this->__PaymentTerms != null){
			$this->__PaymentTerms->toXml($xml);
		}


		return $xml;
	}

}
