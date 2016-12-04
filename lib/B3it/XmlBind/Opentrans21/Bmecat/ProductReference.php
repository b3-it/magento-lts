<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ProductReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ProductReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProdIdTo */
	private $__ProdIdTo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogId */
	private $__CatalogId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion */
	private $__CatalogVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr */
	private $__ReferenceDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProdIdTo
	 */
	public function getProdIdTo()
	{
		if($this->__ProdIdTo == null)
		{
			$this->__ProdIdTo = new B3it_XmlBind_Opentrans21_Bmecat_ProdIdTo();
		}
	
		return $this->__ProdIdTo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProdIdTo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function setProdIdTo($value)
	{
		$this->__ProdIdTo = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->__CatalogId == null)
		{
			$this->__CatalogId = new B3it_XmlBind_Opentrans21_Bmecat_CatalogId();
		}
	
		return $this->__CatalogId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function setCatalogId($value)
	{
		$this->__CatalogId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->__CatalogVersion == null)
		{
			$this->__CatalogVersion = new B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion();
		}
	
		return $this->__CatalogVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function setCatalogVersion($value)
	{
		$this->__CatalogVersion = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr
	 */
	public function getReferenceDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr();
		$this->__ReferenceDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function setReferenceDescr($value)
	{
		$this->__ReferenceDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr[]
	 */
	public function getAllReferenceDescr()
	{
		return $this->__ReferenceDescrA;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductReference
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_REFERENCE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_REFERENCE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ProdIdTo != null){
			$this->__ProdIdTo->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__CatalogId != null){
			$this->__CatalogId->toXml($xml);
		}
		if($this->__CatalogVersion != null){
			$this->__CatalogVersion->toXml($xml);
		}
		if($this->__ReferenceDescrA != null){
			foreach($this->__ReferenceDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
