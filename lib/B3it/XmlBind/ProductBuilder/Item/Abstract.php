<?php

/**
 * 
 *  Basisklasse für ein BMECat Produkt
 *  @category Egovs
 *  @package  B3it_XmlBind_ProductBuilder_Item_Abstract
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class  B3it_XmlBind_ProductBuilder_Item_Abstract
{
	/**
	 * die aus dem xml erzeugte Klasse 
	 */
	protected $_xmlProduct = null;
	

	/**
	 * die artikel nummer des Lieferanten
	 */
	protected $_sku = null;
	
	protected $_productType = 'simple';
	
	
	/**
	 * der Builder dem das Item hinzu gefügt wird
	 * @var B3it_XmlBind_ProductBuilder_Abstract
	 */
	protected $_builder = null;
	   
	/**
	 * der Builder
	 * @return B3it_XmlBind_ProductBuilder_Abstract
	 */
	public function getBuilder() 
	{
	  return $this->_builder;
	}
	
	public function setBuilder($value) 
	{
	  $this->_builder = $value;
	}
	
	public function isBundle()
	{
		return false;
	}
	
	public function hasPriceAmount() {
		return true;
	}
	
	/**
	 * entity_id des Produktes
	 * @var int
	 */
	private $_entity_id;
	    
	public function getEntityId() 
	{
	  return $this->_entity_id;
	}
	
	public function setEntityId($value) 
	{
	  $this->_entity_id = $value;
	  return $this;
	}
	
	public function __construct($xml){
		$this->_xmlProduct = $xml;
	}
	
	/**
	 * Liefert der Magento Produkttype
	 * @return string
	 */
	public function getProductType()
	{
		return $this->_productType;
	}

	/**
	 * MimeInfo ermitteln
	 */
	public abstract function getMediaData();
	
	/**
	 * Produktattribute ermitteln
	 */
	public abstract function getAttributeRow();
	
	/**
	 * Steuersatz des Produktes ermitteln
	 */
	public abstract function getTaxRate();
	
	
	
	/**
	 * Lagermenge als int
	 */
	public abstract function getStockQuantity();
	
	
	/**
	 * Zubehör ermitteln
	 */
	public function getRelatedProducts()
	{
		return array();
	}
	
	/**
	 * die Lieferanten Sku ermitteln
	 */
	protected abstract function _getSku();
	
	
	/**
	 * Prefix+Lieferanten Sku ermitteln
	 * @param string $prefix
	 * @return string
	 */
	public function getSku($prefix)
	{
		if($this->_sku == null){
			$this->_sku = $prefix.$this->_getSku();
		}
		return $this->_sku;
	}
	
	
	
	
}
