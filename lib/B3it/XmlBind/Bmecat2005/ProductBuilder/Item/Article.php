<?php
/**
 * 
 *  Daten für die Produkterstellung aus bmecat2005/Artikel liefern
 *  @category Egovs
 *  @package  B3it_XmlBind_Bmecat2005_Builder_Item_Article
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class  B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Article extends B3it_XmlBind_ProductBuilder_Item_Abstract
{
	//
	/**
	 * die aus dem xml erzeugte Klasse
	 *  @var B3it_XmlBind_Bmecat2005_TNewCatalog_Article 
	 *  */ 
	protected $_xmlProduct = null;

	/**
	 * Konstruktor mit der bmecat2005/Artikel xml Struktur
	 * @param B3it_XmlBind_Bmecat2005_TNewCatalog_Article $xml
	 */
	public function __construct($xml, $bindXml = false){
		if($bindXml){
			$model = new B3it_XmlBind_Bmecat2005_TNewCatalog_Article();
			$model->bindXml($xml);
			$this->_xmlProduct = $model;
		}
		else{
			$this->_xmlProduct = $xml;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see B3it_XmlBind_Bmecat2005_Builder_Item_Abstract::_getSku()
	 */
	protected function _getSku(){
		$sku = $this->_xmlProduct->getSupplierAid()->getValue();
		return $sku;
	}
	
	
	
	
	public function getMediaData()
	{
		$res = array();
		
		foreach($this->_xmlProduct->getMimeInfo()->getAllMime() as $mime)
		{
			$img = array();
			
			$name = array();
			foreach ($mime->getAllMimeDescr() as $value)
			{
				$name[] = $value->getValue();
			}
			$img['label'] = implode(' ', $name);
			
			$name = array();
			foreach ($mime->getAllMimeSource() as $value)
			{
				$name[] = $value->getValue();
			}
			$img['source'] = implode(' ', $name);
			
			$name = array();
			foreach ($mime->getAllMimeAlt() as $value)
			{
				$name[] = $value->getValue();
			}
			
			$img['alt'] = implode(' ', $name);
			
			if($mime->getMimePurpose()->getValue() == 'thumbnail'){
				$img['purpose'] = 'thumbnail';
			}
			else if($mime->getMimePurpose()->getValue() == 'normal'){
				$img['purpose'] = 'image';
			}
			else {
				$img['purpose'] = 'small_image';
			}
			
			$res[] = $img;
		}
		
		return $res;
	}
	
	
	public function getAttributeRow($default = array())
	{
		$name = array();
		foreach ($this->_xmlProduct->getArticleDetails()->getAllDescriptionShort() as $value)
		{
			$name[] = $value->getValue();
		}
		
		$default['name'] = implode(' ', $name);
		$default['short_description'] = implode(' ', $name);
		
		$name = array();
		foreach ($this->_xmlProduct->getArticleDetails()->getAllDescriptionLong() as $value)
		{
			$name[] = $value->getValue();
		}
		
		$default['description'] = implode(' ', $name);
		$default['manufacturer_name'] = $this->_xmlProduct->getArticleDetails()->getManufacturerName()->getValue();
		$default['weight'] = 0;
		$default['supplier_sku'] = $this->_xmlProduct->getSupplierAid()->getValue();
		$default['ean'] = $this->_xmlProduct->getArticleDetails()->getEan()->getValue();
				
		foreach($this->_xmlProduct->getAllArticlePriceDetails() as $detail)
		{
			foreach($detail->getAllArticlePrice() as $price)
			{
				$default['price'] = $price->getPriceAmount()->getValue();
			}
		}
		
		return $default;
	}
	
	/**
	 * zubehör
	 * @return string[]|unknown[]
	 */
	public function getRelatedProducts()
	{
		$linked = array();
		foreach($this->_xmlProduct->getAllArticleReference() as $ref)
		{
			$link = $ref->getArtIdTo()->getValue();
			if(!empty($link)){
				$attr = $ref->getAttribute('type');
				$linked[] = $link;
			}
		}
		
		return $linked;
	}
	
	/**
	 * Steuersatz des Produktes ermitteln
	 */
	public function getTaxRate()
	{
		foreach($this->_xmlProduct->getAllArticlePriceDetails() as $detail)
		{
			foreach($detail->getAllArticlePrice() as $price)
			{
				return $price->getTax()->getValue();
			}
		}
	}
	
}