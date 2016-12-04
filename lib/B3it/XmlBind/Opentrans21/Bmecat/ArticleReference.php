<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ArticleReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ArticleReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArtIdTo */
	private $__ArtIdTo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogId */
	private $__CatalogId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion */
	private $__CatalogVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceDescr */
	private $__ReferenceDescrA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArtIdTo
	 */
	public function getArtIdTo()
	{
		if($this->__ArtIdTo == null)
		{
			$this->__ArtIdTo = new B3it_XmlBind_Opentrans21_Bmecat_ArtIdTo();
		}
	
		return $this->__ArtIdTo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArtIdTo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
	 */
	public function setArtIdTo($value)
	{
		$this->__ArtIdTo = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
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







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_REFERENCE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_REFERENCE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ArtIdTo != null){
			$this->__ArtIdTo->toXml($xml);
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


		return $xml;
	}

}
