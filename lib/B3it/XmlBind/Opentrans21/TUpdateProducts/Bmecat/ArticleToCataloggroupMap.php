<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TUpdateProducts_Bmecat_ArticleToCataloggroupMap
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_ArticleToCataloggroupMap extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArtId */
	private $__ArtId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupId */
	private $__CatalogGroupId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleToCataloggroupMapOrder */
	private $__ArticleToCataloggroupMapOrder = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArtId
	 */
	public function getArtId()
	{
		if($this->__ArtId == null)
		{
			$this->__ArtId = new B3it_XmlBind_Opentrans21_Bmecat_ArtId();
		}
	
		return $this->__ArtId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArtId
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_ArticleToCataloggroupMap
	 */
	public function setArtId($value)
	{
		$this->__ArtId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_ArticleToCataloggroupMap
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupId
	 */
	public function getCatalogGroupId()
	{
		if($this->__CatalogGroupId == null)
		{
			$this->__CatalogGroupId = new B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupId();
		}
	
		return $this->__CatalogGroupId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupId
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_ArticleToCataloggroupMap
	 */
	public function setCatalogGroupId($value)
	{
		$this->__CatalogGroupId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleToCataloggroupMapOrder
	 */
	public function getArticleToCataloggroupMapOrder()
	{
		if($this->__ArticleToCataloggroupMapOrder == null)
		{
			$this->__ArticleToCataloggroupMapOrder = new B3it_XmlBind_Opentrans21_Bmecat_ArticleToCataloggroupMapOrder();
		}
	
		return $this->__ArticleToCataloggroupMapOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleToCataloggroupMapOrder
	 * @return B3it_XmlBind_Opentrans21_TUpdateProducts_Bmecat_ArticleToCataloggroupMap
	 */
	public function setArticleToCataloggroupMapOrder($value)
	{
		$this->__ArticleToCataloggroupMapOrder = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_TO_CATALOGGROUP_MAP');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_TO_CATALOGGROUP_MAP');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ArtId != null){
			$this->__ArtId->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__CatalogGroupId != null){
			$this->__CatalogGroupId->toXml($xml);
		}
		if($this->__ArticleToCataloggroupMapOrder != null){
			$this->__ArticleToCataloggroupMapOrder->toXml($xml);
		}


		return $xml;
	}

}
