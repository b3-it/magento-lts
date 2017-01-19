<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Contactaddress
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Contactaddress extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Addresstype */
	private $__Addresstype = null;

	/* @var B3it_XmlBind_Wms13_Address */
	private $__Address = null;

	/* @var B3it_XmlBind_Wms13_City */
	private $__City = null;

	/* @var B3it_XmlBind_Wms13_Stateorprovince */
	private $__Stateorprovince = null;

	/* @var B3it_XmlBind_Wms13_Postcode */
	private $__Postcode = null;

	/* @var B3it_XmlBind_Wms13_Country */
	private $__Country = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Addresstype
	 */
	public function getAddresstype()
	{
		if($this->__Addresstype == null)
		{
			$this->__Addresstype = new B3it_XmlBind_Wms13_Addresstype();
		}
	
		return $this->__Addresstype;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Addresstype
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function setAddresstype($value)
	{
		$this->__Addresstype = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Address
	 */
	public function getAddress()
	{
		if($this->__Address == null)
		{
			$this->__Address = new B3it_XmlBind_Wms13_Address();
		}
	
		return $this->__Address;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Address
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function setAddress($value)
	{
		$this->__Address = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_City
	 */
	public function getCity()
	{
		if($this->__City == null)
		{
			$this->__City = new B3it_XmlBind_Wms13_City();
		}
	
		return $this->__City;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_City
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function setCity($value)
	{
		$this->__City = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Stateorprovince
	 */
	public function getStateorprovince()
	{
		if($this->__Stateorprovince == null)
		{
			$this->__Stateorprovince = new B3it_XmlBind_Wms13_Stateorprovince();
		}
	
		return $this->__Stateorprovince;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Stateorprovince
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function setStateorprovince($value)
	{
		$this->__Stateorprovince = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Postcode
	 */
	public function getPostcode()
	{
		if($this->__Postcode == null)
		{
			$this->__Postcode = new B3it_XmlBind_Wms13_Postcode();
		}
	
		return $this->__Postcode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Postcode
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function setPostcode($value)
	{
		$this->__Postcode = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Country
	 */
	public function getCountry()
	{
		if($this->__Country == null)
		{
			$this->__Country = new B3it_XmlBind_Wms13_Country();
		}
	
		return $this->__Country;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Country
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function setCountry($value)
	{
		$this->__Country = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ContactAddress');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Addresstype != null){
			$this->__Addresstype->toXml($xml);
		}
		if($this->__Address != null){
			$this->__Address->toXml($xml);
		}
		if($this->__City != null){
			$this->__City->toXml($xml);
		}
		if($this->__Stateorprovince != null){
			$this->__Stateorprovince->toXml($xml);
		}
		if($this->__Postcode != null){
			$this->__Postcode->toXml($xml);
		}
		if($this->__Country != null){
			$this->__Country->toXml($xml);
		}


		return $xml;
	}

}
