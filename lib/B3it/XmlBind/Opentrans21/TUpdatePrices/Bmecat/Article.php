<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TUpdatePrices_Bmecat_Article
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierAid */
	private $__SupplierAid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails */
	private $__ArticlePriceDetailsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions */
	private $__UserDefinedExtensions = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierAid
	 */
	public function getSupplierAid()
	{
		if($this->__SupplierAid == null)
		{
			$this->__SupplierAid = new B3it_XmlBind_Opentrans21_Bmecat_SupplierAid();
		}
	
		return $this->__SupplierAid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierAid
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article
	 */
	public function setSupplierAid($value)
	{
		$this->__SupplierAid = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->__SupplierIdref == null)
		{
			$this->__SupplierIdref = new B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref();
		}
	
		return $this->__SupplierIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function getArticlePriceDetails()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails();
		$this->__ArticlePriceDetailsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article
	 */
	public function setArticlePriceDetails($value)
	{
		$this->__ArticlePriceDetailsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails[]
	 */
	public function getAllArticlePriceDetails()
	{
		return $this->__ArticlePriceDetailsA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->__UserDefinedExtensions == null)
		{
			$this->__UserDefinedExtensions = new B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions();
		}
	
		return $this->__UserDefinedExtensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->__UserDefinedExtensions = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SupplierAid != null){
			$this->__SupplierAid->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__ArticlePriceDetailsA != null){
			foreach($this->__ArticlePriceDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__UserDefinedExtensions != null){
			$this->__UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}

}
