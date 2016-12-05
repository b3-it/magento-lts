<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Buyer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Buyer extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerId */
	private $__BuyerId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_BuyerName */
	private $__BuyerName = null;

	/* @var B3it_XmlBind_Opentrans21_Buyer_Bmecat_Address */
	private $__Address = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerId
	 */
	public function getBuyerId()
	{
		if($this->__BuyerId == null)
		{
			$this->__BuyerId = new B3it_XmlBind_Opentrans21_Bmecat_BuyerId();
		}
	
		return $this->__BuyerId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_BuyerId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Buyer
	 */
	public function setBuyerId($value)
	{
		$this->__BuyerId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_BuyerName
	 */
	public function getBuyerName()
	{
		if($this->__BuyerName == null)
		{
			$this->__BuyerName = new B3it_XmlBind_Opentrans21_Bmecat_BuyerName();
		}
	
		return $this->__BuyerName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_BuyerName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Buyer
	 */
	public function setBuyerName($value)
	{
		$this->__BuyerName = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Buyer_Bmecat_Address
	 */
	public function getAddress()
	{
		if($this->__Address == null)
		{
			$this->__Address = new B3it_XmlBind_Opentrans21_Buyer_Bmecat_Address();
		}
	
		return $this->__Address;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Buyer_Bmecat_Address
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Buyer
	 */
	public function setAddress($value)
	{
		$this->__Address = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:BUYER');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:BUYER');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__BuyerId != null){
			$this->__BuyerId->toXml($xml);
		}
		if($this->__BuyerName != null){
			$this->__BuyerName->toXml($xml);
		}
		if($this->__Address != null){
			$this->__Address->toXml($xml);
		}


		return $xml;
	}

}
