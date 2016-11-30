<?php
/**
 * 
 *  Daten für die Produkterstellung aus bmecat2005/Artikel liefern
 *  @category Egovs
 *  @package  B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Product
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class  B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Product extends B3it_XmlBind_ProductBuilder_Item_Abstract
{
	//
	/**
	 * die aus dem xml erzeugte Klasse
	 *  @var B3it_XmlBind_Bmecat2005_TNewCatalog_Product
	 *  */ 
	protected $_xmlProduct = null;

	
	
	/**
	 * Konstruktor mit der bmecat2005/Artikel xml Struktur
	 * @param B3it_XmlBind_Bmecat2005_TNewCatalog_Product $xml
	 */
	public function __construct($xml, $bindXml = false){
		if($bindXml){
			$model = new B3it_XmlBind_Bmecat2005_TNewCatalog_Product();
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
		$sku = $this->_xmlProduct->getSupplierPid()->getValue();
		return $sku;
	}
	
	
	/**
	 * Liefert der Magento Produkttype
	 * @return string
	 */
	public function getProductType()
	{
		if($this->isBundle())
		{
			return 'bundle';
		}
		return $this->_productType;
	}
	
	
	
	/**
	 * feststellen ob Bundleprodukt
	 * @see B3it_XmlBind_ProductBuilder_Item_Abstract::isBundle()
	 */
	public function isBundle()
	{
		//return false;
		
		
		return (count($this->_xmlProduct->getProductConfigDetails()->getAllConfigStep()) > 0);
	}
	
	
	
	/**
	 * 
	 * @param B3it_XmlBind_ProductBuilder_Item_Abstract $item
	 * @return array[]
	 */
	public function getBundleOptions($item)
	{
		$options = array();
		$k =0;
		foreach($this->_xmlProduct->getProductConfigDetails()->getAllConfigStep() as $step)
		{
			$required = (intval($step->getMinOccurance()->getValue()) > 0);

			$count = intval(count($step->getConfigParts()->getAllPartAlternative()));
			$max = intval($step->getMaxOccurance()->getValue());

			if ($max == 1 && $count == 1) {
				$type = "checkbox";
			} else if ($max == 1) {
				$type = "radio";
			} else {
				$type = "checkbox";
			}

			$label = "";
			foreach($step->getAllStepHeader() as $h){
				$label .= $h->getValue(). ' ';
			}
			$option = array();
			$option['label'] = trim($label);
			$option['type'] = $type; 
			$option['required'] = $required;

			$k++;
			$order = ($step->getStepOrder()->getValue());

			$option['position'] = $order === "" ? $k : intval($order);

			$option['selections'] = array();
			
			$n = 0;
			foreach($step->getConfigParts()->getAllPartAlternative() as $part)
			{
				$product_item = $item->getBuilder()->getItemBySku($part->getSupplierPidref()->getValue());
				if($product_item){
					$bind = array();
					$bind['parent_product_id'] = $item->getEntityId();
					$bind['product_id'] = $product_item->getEntityId();
					$bind['position'] = $n++;
					if ($part->getDefaultFlag()->getValue() === "true") {
						$bind['is_default'] = true;
					}
					$bind['selection_price_type'] = 0;
					$bind['selection_price_value'] = 0;
					$bind['selection_qty'] = 1;
					$bind['selection_can_change_qty'] = 0;
					$option['selections'][] = $bind;
				}
			}
			
			$options[] = $option;
		}
		
		return $options;
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
	
	
	/**
	 * Die Attribute aus der XML Struktur lesen und als Array zurückgeben
	 */
	public function getAttributeRow($default = array())
	{
		$name = array();
		foreach ($this->_xmlProduct->getProductDetails()->getAllDescriptionShort() as $value)
		{
			$name[] = $value->getValue();
		}
		
		$default['name'] = implode(' ', $name);
		$default['short_description'] = implode(' ', $name);
		
		$name = array();
		foreach ($this->_xmlProduct->getProductDetails()->getAllDescriptionLong() as $value)
		{
			$name[] = $value->getValue();
		}
		
		$default['description'] = implode(' ', $name);
		$default['manufacturer_name'] = $this->_xmlProduct->getProductDetails()->getManufacturerName()->getValue();
		$default['weight'] = 0;
		$default['supplier_sku'] = $this->_xmlProduct->getSupplierPid()->getValue();
		$default['ean'] = $this->_xmlProduct->getProductDetails()->getEan()->getValue();
					
		foreach($this->_xmlProduct->getAllProductPriceDetails() as $detail)
		{
			foreach($detail->getAllProductPrice() as $price)
			{
				$default['price'] = $price->getPriceAmount()->getValue();
			}
		}
		
		$default['price_type'] = $this->isBundle() ? 0 : 1;

		return $default;
	}
	
	
	
	public function getStockQuantity()
	{
		return intval($this->_xmlProduct->getProductOrderDetails()->getQuantityMax()->getValue());
	}
	
	/**
	 * zubehör
	 * @return string[]|unknown[]
	 */
	public function getRelatedProducts()
	{
		$linked = array();
		foreach($this->_xmlProduct->getAllProductReference() as $ref)
		{
			$link = $ref->getProdIdTo()->getValue();
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
		foreach($this->_xmlProduct->getAllProductPriceDetails() as $detail)
		{
			foreach($detail->getAllProductPrice() as $price)
			{
				return $price->getTax()->getValue();
			}
		}
	}
	
}