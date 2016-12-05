<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Supplier
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Supplier extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierId */
	private $__SupplierIdA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierName */
	private $__SupplierName = null;

	/* @var B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address */
	private $__Address = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_SupplierId and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierId
	 */
	public function getSupplierId()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_SupplierId();
		$this->__SupplierIdA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Supplier
	 */
	public function setSupplierId($value)
	{
		$this->__SupplierIdA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierId[]
	 */
	public function getAllSupplierId()
	{
		return $this->__SupplierIdA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierName
	 */
	public function getSupplierName()
	{
		if($this->__SupplierName == null)
		{
			$this->__SupplierName = new B3it_XmlBind_Opentrans21_Bmecat_SupplierName();
		}
	
		return $this->__SupplierName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Supplier
	 */
	public function setSupplierName($value)
	{
		$this->__SupplierName = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address
	 */
	public function getAddress()
	{
		if($this->__Address == null)
		{
			$this->__Address = new B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address();
		}
	
		return $this->__Address;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Supplier
	 */
	public function setAddress($value)
	{
		$this->__Address = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Supplier
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:SUPPLIER');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:SUPPLIER');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SupplierIdA != null){
			foreach($this->__SupplierIdA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SupplierName != null){
			$this->__SupplierName->toXml($xml);
		}
		if($this->__Address != null){
			$this->__Address->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
