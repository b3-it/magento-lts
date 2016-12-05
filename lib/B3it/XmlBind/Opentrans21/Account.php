<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Account
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Account extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Holder */
	private $__Holder = null;

	/* @var B3it_XmlBind_Opentrans21_BankAccount */
	private $__BankAccount = null;

	/* @var B3it_XmlBind_Opentrans21_BankCode */
	private $__BankCode = null;

	/* @var B3it_XmlBind_Opentrans21_BankName */
	private $__BankName = null;

	/* @var B3it_XmlBind_Opentrans21_BankCountry */
	private $__BankCountry = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Holder
	 */
	public function getHolder()
	{
		if($this->__Holder == null)
		{
			$this->__Holder = new B3it_XmlBind_Opentrans21_Holder();
		}
	
		return $this->__Holder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Holder
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function setHolder($value)
	{
		$this->__Holder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_BankAccount
	 */
	public function getBankAccount()
	{
		if($this->__BankAccount == null)
		{
			$this->__BankAccount = new B3it_XmlBind_Opentrans21_BankAccount();
		}
	
		return $this->__BankAccount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_BankAccount
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function setBankAccount($value)
	{
		$this->__BankAccount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_BankCode
	 */
	public function getBankCode()
	{
		if($this->__BankCode == null)
		{
			$this->__BankCode = new B3it_XmlBind_Opentrans21_BankCode();
		}
	
		return $this->__BankCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_BankCode
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function setBankCode($value)
	{
		$this->__BankCode = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_BankName
	 */
	public function getBankName()
	{
		if($this->__BankName == null)
		{
			$this->__BankName = new B3it_XmlBind_Opentrans21_BankName();
		}
	
		return $this->__BankName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_BankName
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function setBankName($value)
	{
		$this->__BankName = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_BankCountry
	 */
	public function getBankCountry()
	{
		if($this->__BankCountry == null)
		{
			$this->__BankCountry = new B3it_XmlBind_Opentrans21_BankCountry();
		}
	
		return $this->__BankCountry;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_BankCountry
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function setBankCountry($value)
	{
		$this->__BankCountry = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ACCOUNT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Holder != null){
			$this->__Holder->toXml($xml);
		}
		if($this->__BankAccount != null){
			$this->__BankAccount->toXml($xml);
		}
		if($this->__BankCode != null){
			$this->__BankCode->toXml($xml);
		}
		if($this->__BankName != null){
			$this->__BankName->toXml($xml);
		}
		if($this->__BankCountry != null){
			$this->__BankCountry->toXml($xml);
		}


		return $xml;
	}

}
