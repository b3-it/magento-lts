<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TNewCatalog_Bmecat_ProductToCataloggroupMap
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProdId */
	private $__ProdId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupId */
	private $__CatalogGroupId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductToCataloggroupMapOrder */
	private $__ProductToCataloggroupMapOrder = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProdId
	 */
	public function getProdId()
	{
		if($this->__ProdId == null)
		{
			$this->__ProdId = new B3it_XmlBind_Opentrans21_Bmecat_ProdId();
		}
	
		return $this->__ProdId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProdId
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap
	 */
	public function setProdId($value)
	{
		$this->__ProdId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap
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
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap
	 */
	public function setCatalogGroupId($value)
	{
		$this->__CatalogGroupId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductToCataloggroupMapOrder
	 */
	public function getProductToCataloggroupMapOrder()
	{
		if($this->__ProductToCataloggroupMapOrder == null)
		{
			$this->__ProductToCataloggroupMapOrder = new B3it_XmlBind_Opentrans21_Bmecat_ProductToCataloggroupMapOrder();
		}
	
		return $this->__ProductToCataloggroupMapOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductToCataloggroupMapOrder
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap
	 */
	public function setProductToCataloggroupMapOrder($value)
	{
		$this->__ProductToCataloggroupMapOrder = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_TO_CATALOGGROUP_MAP');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_TO_CATALOGGROUP_MAP');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ProdId != null){
			$this->__ProdId->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__CatalogGroupId != null){
			$this->__CatalogGroupId->toXml($xml);
		}
		if($this->__ProductToCataloggroupMapOrder != null){
			$this->__ProductToCataloggroupMapOrder->toXml($xml);
		}


		return $xml;
	}

}
