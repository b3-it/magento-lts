<?php
/**
 * 
 *  Basisklasse um BMECat 2005 Produkte in Magento zu importieren
 *  @category Egovs
 *  @package  B3it_XmlBind_Bmecat2005_Builder_Abstract
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class  B3it_XmlBind_ProductBuilder_Abstract
{

	/**
	 * Die xml Produkte
	 * @var array B3it_XmlBind_Bmecat2005_Builder_Item_Abstract
	 */
	protected $_items = array();
	
	protected $_skuPrefix = "";
	
	protected $_eavAttributes = array();
	
	protected $_entityTypeId = null;
	
	protected $_connection   = null;
	
	protected $_webSiteId = 1;
	
	protected $category_id = 1;
	
	/**
	 * ein xml Produkt hinzufügen
	 * @param B3it_XmlBind_Bmecat2005_Builder_Item_Abstract $item
	 */
	public function addItem(B3it_XmlBind_ProductBuilder_Item_Abstract $item )
	{
		$this->_items[$item->getSku($this->_skuPrefix)] = $item;
	}
	
	
	
	public function __construct($skuPrefix = ""){
		$this->_skuPrefix = $skuPrefix;
		$this->_connection      = Mage::getSingleton('core/resource')->getConnection('write');
	}
	
	
	public function setSkuPrefix($skuPrefix)
	{
		$this->_skuPrefix = $skuPrefix;
	}
	/**
	 * Default werte für das Entity, z.B. store_group
	 */
	protected function _getEntityDefaultRow()
	{
		return array();
	}
	
	/**
	 * defaultwerte für die Produktattribute
	 */
	protected function _getAttributeDefaultRow()
	{
		return array();
	}
	
	
	protected abstract function _getTaxClassId($taxRate);
	/**
	 * alle hinzugefügen Artikel Speichern
	 */
	public function save()
	{
		$this->_saveProductEntity();
		$this->_saveProductAttributes();
		$this->_saveStock();
		$this->_saveProductWebsites();
		$this->_saveMediaGallery();
		$this->_saveCategory();
		$this->_saveLinks(Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED);
	}
	
	/**
	 * Update and insert data in entity table.
	 *
	 * @param array $entityRowsIn Row for insert
	 * @return Mage_ImportExport_Model_Import_Entity_Product
	 */
	protected function _saveProductEntity()
	{
		
		//entities speichern
		$entityRowsIn = array();
		/** @var $item B3it_XmlBind_Bmecat2005_Builder_Item_Abstract*/
		foreach($this->_items as $sku => $item)
		{
			$entityRowsDefault = $this->_getEntityDefaultRow();
			$entityRowsDefault['type_id'] 		   = $item->getProductType();
			$entityRowsDefault['sku'] 			   = $sku;
			$entityRowsDefault['entity_type_id']   = $this->_getEntityTypeId();
			$entityRowsDefault['created_at']       = now();
			$entityRowsDefault['updated_at']       = now();
			$entityRowsDefault['attribute_set_id'] = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
			$entityRowsIn[$sku] = $entityRowsDefault;
		}
		
		
		static $entityTable = null;
	
		if (!$entityTable) {
			$entityTable = Mage::getModel('importexport/import_proxy_product_resource')->getEntityTable();
		}
		
		if ($entityRowsIn) {
			$this->_connection->insertMultiple($entityTable, $entityRowsIn);
	
			$newProducts = $this->_connection->fetchPairs($this->_connection->select()
					->from($entityTable, array('sku', 'entity_id'))
					->where('sku IN (?)', array_keys($entityRowsIn))
					);
			foreach ($newProducts as $sku => $newId) { // fill up entity_id for new products
				$item = $this->_items[$sku];
				$item->setEntityId($newId);
			}
		}
		return $this;
	}
	
	
	/**
	 * Retrieve attribute by specified code
	 *
	 * @param string $code
	 * @return Mage_Eav_Model_Entity_Attribute_Abstract
	 */
	protected function _getAttribute($code)
	{
		if(isset($this->_eavAttributes[$code]))
		{
			return $this->_eavAttributes[$code];
		}
		/* @var $attribute Mage_Eav_Model_Entity_Attribute */
		$attribute = Mage::getModel('eav/entity_attribute')->loadByCode($this->_getEntityTypeId(), $code);
		if($attribute->getId() == 0)
		{
			return null;
		}
		$this->_eavAttributes[$code] = $attribute;
		return $attribute;
	}
	
	
	/**
	 * Prepare attributes data
	 *
	 * @param array $rowData
	 * @param int $rowScope
	 * @param array $attributes
	 * @param string|null $rowSku
	 * @param int $rowStore
	 * @return array
	 */
	protected function _prepareAttributes($rowData)
	{
		$attributesInTable = array();
	
		foreach($rowData as $sku => $attValues)
		foreach ($attValues as $attrCode => $attrValue) {
			/* @var $attribute Mage_Eav_Model_Entity_Attribute */
			$attribute = $this->_getAttribute($attrCode);
			if($attribute){
				$table = $attribute->getBackendTable();
				if(!isset($attributesInTable[$table])){
					$attributesInTable[$table] = array();
				}
				
				if(!isset($attributesInTable[$table][$sku]))
				{
					$attributesInTable[$table][$sku] = array();
				}
				
				$attrId = $attribute->getId();
				$attributesInTable[$table][$sku][$attrId] = $attrValue;
			}
		}
	
		return $attributesInTable;
	}
	
	protected function _saveProductAttributes()
	{
		//attribute speichern
		$attributesRowsIn = array();
		/** @var $item B3it_XmlBind_Bmecat2005_Builder_Item_Abstract*/
		foreach($this->_items as $sku => $item)
		{
			$attributesRowsDefault = $this->_getAttributeDefaultRow();
			$attributesRowsIn[$sku] = $item->getAttributeRow($attributesRowsDefault);
			$attributesRowsIn[$sku]['tax_class_id'] = $this->_getTaxClassId($item->getTaxRate());
		}
		
		$attributesData = $this->_prepareAttributes($attributesRowsIn);
		
		
		foreach ($attributesData as $tableName => $skuData) {
			$tableData = array();
	
			foreach ($skuData as $sku => $attributes) {
				$item = $this->_items[$sku];
				$productId = $item->getEntityId();
	
				foreach ($attributes as $attributeId => $storeValue) {
						$tableData[] = array(
								'entity_id'      => $productId,
								'entity_type_id' => $this->_getEntityTypeId(),
								'attribute_id'   => $attributeId,
								'store_id'       => $this->getStoreId(),
								'value'          => $storeValue
						);
					}
				}
			
			$this->_connection->insertMultiple($tableName, $tableData);
			//$this->_connection->insertOnDuplicate($tableName, $tableData, array('value'));
		}
		return $this;
	}
	
	
	protected function _getEntityTypeId()
	{
		if($this->_entityTypeId == null){
			$entityType = Mage::getModel('eav/entity_type')->loadByCode('catalog_product');
			$this->_entityTypeId = $entityType->getId();
		}
		
		return $this->_entityTypeId;
	}
	
	private $_storeid = 0;
	    
	public function getStoreId() 
	{
	  return $this->_storeid;
	}
	
	public function setStoreId($value) 
	{
	  $this->_storeid = $value;
	}
	
	/**
	 * Stock item saving.
	 *
	 * @return Mage_ImportExport_Model_Import_Entity_Product
	 */
	protected function _saveStock()
	{
		$defaultStockData = array(
				'manage_stock'                  => 1,
				'use_config_manage_stock'       => 1,
				'qty'                           => 0,
				'min_qty'                       => 0,
				'use_config_min_qty'            => 1,
				'min_sale_qty'                  => 1,
				'use_config_min_sale_qty'       => 1,
				'max_sale_qty'                  => 10000,
				'use_config_max_sale_qty'       => 1,
				'is_qty_decimal'                => 0,
				'backorders'                    => 0,
				'use_config_backorders'         => 1,
				'notify_stock_qty'              => 1,
				'use_config_notify_stock_qty'   => 1,
				'enable_qty_increments'         => 0,
				'use_config_enable_qty_inc'     => 1,
				'qty_increments'                => 0,
				'use_config_qty_increments'     => 1,
				'is_in_stock'                   => 0,
				'low_stock_date'                => null,
				'stock_status_changed_auto'     => 0,
				'is_decimal_divided'            => 0
		);
	
		$entityTable = Mage::getResourceModel('cataloginventory/stock_item')->getMainTable();

		$data = array();
		foreach($this->_items as $sku => $item){
			$row = array();
			$row['product_id'] = $item->getEntityId();
			$row['stock_id'] = 1;
			$stockData = array_merge($row,$defaultStockData);
			$data[] = $stockData;
		}
	
			

			// Insert rows
			if ($stockData) {
				$this->_connection->insertMultiple($entityTable, $data);
			}
		
		return $this;
	}
	
	protected function _saveProductWebsites()
	{
		static $tableName = null;
	
		if (!$tableName) {
			$tableName = Mage::getModel('importexport/import_proxy_product_resource')->getProductWebsiteTable();
		}
		
		$data = array();
		foreach($this->_items as $sku => $item){
			$row = array();
			$row['product_id'] = $item->getEntityId();
			$row['website_id'] = $this->_webSiteId;
			$data[] = $row;
		}
		
		if ($data) {
				$this->_connection->insertMultiple($tableName, $data);
			}
		
		return $this;
	}
	
	/**
	 * Save product media gallery.
	 *
	 */
	protected function _saveMediaGallery()
	{
		
	
		static $mediaGalleryTableName = null;
		static $mediaValueTableName = null;
		static $mediaGalleryAttribute = null;
		$productId = null;
	
		if (!$mediaGalleryTableName) {
			$mediaGalleryTableName = Mage::getModel('importexport/import_proxy_product_resource')
			->getTable('catalog/product_attribute_media_gallery');
		}
	
		if (!$mediaValueTableName) {
			$mediaValueTableName = Mage::getModel('importexport/import_proxy_product_resource')
			->getTable('catalog/product_attribute_media_gallery_value');
		}
		if(!$mediaGalleryAttribute){
			$attribute = Mage::getModel('eav/entity_attribute')->loadByCode($this->_getEntityTypeId(), 'media_gallery');
			$mediaGalleryAttribute = $attribute->getId();
		}
	
		//foreach ($mediaGalleryData as $productSku => $mediaGalleryRows) {
		/** @var $item B3it_XmlBind_Bmecat2005_Builder_Item_Abstract*/
		foreach($this->_items as $sku => $item){
			$productId = $item->getEntityId();
			$insertedGalleryImgs = array();
			$allAttribute =  array();
			$usedAttribute = array();
			foreach ($item->getMediaData() as $pos => $media){
	
				if (!in_array($media['source'], $insertedGalleryImgs)) {
					$valueArr = array(
							'attribute_id' => $mediaGalleryAttribute,
							'entity_id'    => $productId,
							'value'        => $media['source']
					);
	
					$this->_connection
					->insertOnDuplicate($mediaGalleryTableName, $valueArr, array('entity_id'));
	
					$insertedGalleryImgs[] = $media['source'];
				}
	
				$newMediaValues = $this->_connection->fetchPairs($this->_connection->select()
						->from($mediaGalleryTableName, array('value', 'value_id'))
						->where('entity_id IN (?)', $productId)
						);
	
				if (array_key_exists($media['source'], $newMediaValues)) {
					$value_id = $newMediaValues[$media['source']];
				}
	
				$valueArr = array(
						'value_id' => $value_id,
						'store_id' => Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID,
						'label'    => $media['label'],
						'position' => $pos+1,
						'disabled' => 0
				);
	
				try {
					$this->_connection
					->insertOnDuplicate($mediaValueTableName, $valueArr, array('value_id'));
				} catch (Exception $e) {
					$this->_connection->delete(
							$mediaGalleryTableName, $this->_connection->quoteInto('value_id IN (?)', $newMediaValues)
							);
				}
				
				
				$attribute = $this->_getAttribute($media['purpose']);
				
				//doppelte Attribute vermeiden
				if(array_search($attribute->getId(), $usedAttribute) === false)
				{
					$usedAttribute[] = $attribute->getId();
					$attributeArr = array();
					$attributeArr['attribute_id'] = $attribute->getId();
					$attributeArr['entity_type_id'] = $this->_getEntityTypeId();
					$attributeArr['store_id'] = 0;
					$attributeArr['entity_id'] = $productId;
					$attributeArr['value'] =  $media['source'];
					$allAttribute[] = $attributeArr;
					
					if(!empty($media['label'])){
						$attribute = $this->_getAttribute($media['purpose'].'_label');
						$attributeArr = array();
						$attributeArr['attribute_id'] = $attribute->getId();
						$attributeArr['entity_type_id'] = $this->_getEntityTypeId();
						$attributeArr['store_id'] = 0;
						$attributeArr['entity_id'] = $productId;
						$attributeArr['value'] =  $media['label'];
						$allAttribute[] = $attributeArr;
					}
					$table = $attribute->getBackendTable();
				}
				
			}
			if($table){
				$this->_connection->insertMultiple($table, $allAttribute);
			}
		}
		return $this;
	}
	
	
	/**
	 * Zubehör finden
	 * @return array('parent_id'=>array('child1_id,child2_id));
	 */
	protected function _prepareLinks($linkTypeId)
	{
		$allLinks = array();
		/** @var $item B3it_XmlBind_Bmecat2005_Builder_Item_Abstract*/
		foreach($this->_items as $sku => $item){
			$productId = $item->getEntityId();
			if($linkTypeId == Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED){
				$links = $item->getRelatedProducts();
			}
			foreach($links as $link){
				if(isset($this->_items[$this->_skuPrefix.$link])){
					$linkItem = $this->_items[$this->_skuPrefix.$link];
					$linkId = $linkItem->getEntityId();
					
					if(!isset($allLinks[$productId])){
						$allLinks[$productId] = array();
					}
					
					$allLinks[$productId][] = $linkId;
				}
			}
		}
		
		return $allLinks;
	}
	
	/**
	 * Gather and save information about product links.
	 * Must be called after ALL products saving done.
	 *
	 */
	protected function _saveLinks($linkTypeId = Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED)
	{
		$resource       = Mage::getResourceModel('catalog/product_link');
		$mainTable      = $resource->getMainTable();
		$nextLinkId     = Mage::getResourceHelper('importexport')->getNextAutoincrement($mainTable);
		$adapter = $this->_connection;
	
		
		// pre-load 'position' attributes ID for each link type once
		$select = $adapter->select()
			->from(
					$resource->getTable('catalog/product_link_attribute'),
					array('id' => 'product_link_attribute_id')
					)
					->where('link_type_id = :link_id AND product_link_attribute_code = :position');
					$bind = array(
							':link_id' => $linkTypeId,
							':position' => 'position'
					);
					$positionAttrId = $adapter->fetchOne($select, $bind);

		
		
		$positionRows = array();
		$linkRows = array();
		
		$links = $this->_prepareLinks($linkTypeId);
		
		$rowNum = 0;
		foreach($links as $productId => $link) {
			$pos = 1;
			foreach($link as $linkId){
				
				$linkRows[] = array(
						'link_id'           => $nextLinkId,
						'product_id'        => $productId,
						'linked_product_id' => $linkId,
						'link_type_id'      => $linkTypeId
				);
				
				$positionRows[] = array(
						'link_id'                   => $nextLinkId,
						'product_link_attribute_id' => $positionAttrId,
						'value'                     => $pos++
				);
				
				$nextLinkId++;
			}
			
			
			if ($linkRows) {
				$adapter->insertOnDuplicate(
						$mainTable,
						$linkRows,
						array('link_id')
						);
			}
			if ($positionRows) { // process linked product positions
				$adapter->insertOnDuplicate(
						$resource->getAttributeTypeTable('int'),
						$positionRows,
						array('value')
						);
			}
		
		}
		return $this;
	}
	
	protected function _saveCategory()
	{
		$categoryData = array();
	
		foreach($this->_items as $sku => $item)
		{
			$categoryData[] = array(
					'category_id'   => $this->category_id,
					'product_id'   => $item->getEntityId(),
					'position'     => 1
					);
		}
		
		$tableName = Mage::getModel('importexport/import_proxy_product_resource')->getProductCategoryTable();
		if ($categoryData) {
			$this->_connection->insertMultiple($tableName, $categoryData);
		}
	}
}
