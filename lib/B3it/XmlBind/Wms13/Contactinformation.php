<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Contactinformation
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Contactinformation extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Contactpersonprimary */
	private $__Contactpersonprimary = null;

	/* @var B3it_XmlBind_Wms13_Contactposition */
	private $__Contactposition = null;

	/* @var B3it_XmlBind_Wms13_Contactaddress */
	private $__Contactaddress = null;

	/* @var B3it_XmlBind_Wms13_Contactvoicetelephone */
	private $__Contactvoicetelephone = null;

	/* @var B3it_XmlBind_Wms13_Contactfacsimiletelephone */
	private $__Contactfacsimiletelephone = null;

	/* @var B3it_XmlBind_Wms13_Contactelectronicmailaddress */
	private $__Contactelectronicmailaddress = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactpersonprimary
	 */
	public function getContactpersonprimary()
	{
		if($this->__Contactpersonprimary == null)
		{
			$this->__Contactpersonprimary = new B3it_XmlBind_Wms13_Contactpersonprimary();
		}
	
		return $this->__Contactpersonprimary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactpersonprimary
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function setContactpersonprimary($value)
	{
		$this->__Contactpersonprimary = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactposition
	 */
	public function getContactposition()
	{
		if($this->__Contactposition == null)
		{
			$this->__Contactposition = new B3it_XmlBind_Wms13_Contactposition();
		}
	
		return $this->__Contactposition;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactposition
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function setContactposition($value)
	{
		$this->__Contactposition = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactaddress
	 */
	public function getContactaddress()
	{
		if($this->__Contactaddress == null)
		{
			$this->__Contactaddress = new B3it_XmlBind_Wms13_Contactaddress();
		}
	
		return $this->__Contactaddress;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactaddress
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function setContactaddress($value)
	{
		$this->__Contactaddress = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactvoicetelephone
	 */
	public function getContactvoicetelephone()
	{
		if($this->__Contactvoicetelephone == null)
		{
			$this->__Contactvoicetelephone = new B3it_XmlBind_Wms13_Contactvoicetelephone();
		}
	
		return $this->__Contactvoicetelephone;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactvoicetelephone
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function setContactvoicetelephone($value)
	{
		$this->__Contactvoicetelephone = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactfacsimiletelephone
	 */
	public function getContactfacsimiletelephone()
	{
		if($this->__Contactfacsimiletelephone == null)
		{
			$this->__Contactfacsimiletelephone = new B3it_XmlBind_Wms13_Contactfacsimiletelephone();
		}
	
		return $this->__Contactfacsimiletelephone;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactfacsimiletelephone
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function setContactfacsimiletelephone($value)
	{
		$this->__Contactfacsimiletelephone = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactelectronicmailaddress
	 */
	public function getContactelectronicmailaddress()
	{
		if($this->__Contactelectronicmailaddress == null)
		{
			$this->__Contactelectronicmailaddress = new B3it_XmlBind_Wms13_Contactelectronicmailaddress();
		}
	
		return $this->__Contactelectronicmailaddress;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactelectronicmailaddress
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function setContactelectronicmailaddress($value)
	{
		$this->__Contactelectronicmailaddress = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ContactInformation');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Contactpersonprimary != null){
			$this->__Contactpersonprimary->toXml($xml);
		}
		if($this->__Contactposition != null){
			$this->__Contactposition->toXml($xml);
		}
		if($this->__Contactaddress != null){
			$this->__Contactaddress->toXml($xml);
		}
		if($this->__Contactvoicetelephone != null){
			$this->__Contactvoicetelephone->toXml($xml);
		}
		if($this->__Contactfacsimiletelephone != null){
			$this->__Contactfacsimiletelephone->toXml($xml);
		}
		if($this->__Contactelectronicmailaddress != null){
			$this->__Contactelectronicmailaddress->toXml($xml);
		}


		return $xml;
	}

}
