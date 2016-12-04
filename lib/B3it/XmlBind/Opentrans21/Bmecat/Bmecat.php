<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Bmecat
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Bmecat extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Header */
	private $__Header = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog */
	private $__TNewCatalog = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TUpdateProducts */
	private $__TUpdateProducts = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices */
	private $__TUpdatePrices = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Header
	 */
	public function getHeader()
	{
		if($this->__Header == null)
		{
			$this->__Header = new B3it_XmlBind_Opentrans21_Bmecat_Header();
		}
	
		return $this->__Header;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Header
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Bmecat
	 */
	public function setHeader($value)
	{
		$this->__Header = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function getTNewCatalog()
	{
		if($this->__TNewCatalog == null)
		{
			$this->__TNewCatalog = new B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog();
		}
	
		return $this->__TNewCatalog;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Bmecat
	 */
	public function setTNewCatalog($value)
	{
		$this->__TNewCatalog = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TUpdateProducts
	 */
	public function getTUpdateProducts()
	{
		if($this->__TUpdateProducts == null)
		{
			$this->__TUpdateProducts = new B3it_XmlBind_Opentrans21_Bmecat_TUpdateProducts();
		}
	
		return $this->__TUpdateProducts;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TUpdateProducts
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Bmecat
	 */
	public function setTUpdateProducts($value)
	{
		$this->__TUpdateProducts = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices
	 */
	public function getTUpdatePrices()
	{
		if($this->__TUpdatePrices == null)
		{
			$this->__TUpdatePrices = new B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices();
		}
	
		return $this->__TUpdatePrices;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Bmecat
	 */
	public function setTUpdatePrices($value)
	{
		$this->__TUpdatePrices = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:BMECAT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:BMECAT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Header != null){
			$this->__Header->toXml($xml);
		}
		if($this->__TNewCatalog != null){
			$this->__TNewCatalog->toXml($xml);
		}
		if($this->__TUpdateProducts != null){
			$this->__TUpdateProducts->toXml($xml);
		}
		if($this->__TUpdatePrices != null){
			$this->__TUpdatePrices->toXml($xml);
		}


		return $xml;
	}

}
