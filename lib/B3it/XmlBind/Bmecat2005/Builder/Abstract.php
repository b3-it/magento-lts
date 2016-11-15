<?php
abstract class  B3it_XmlBind_Bmecat2005_Builder_Abstract
{
	/**
	 * die aus dem xml erzeugte Klasse 
	 */
	protected $_xmlProduct = null;
	
	/**
	 * @var Mage_Catalog_Model_Product
	 */
	protected $_product = null;
	
	
	protected $_newSku = array();
	
	public function __construct($xml){
		$this->_xmlProduct = $xml;
	}
	
	public abstract function build();
	
	
	/**
	 * Mage Produkt erzeugen
	 * @return Mage_Catalog_Model_Product
	 */
	protected function _getProduct()
	{
		if($this->_product == null)
		{
			$this->_product = Mage::getModel('catalog/product');
		}
					
		return $this->_product;
	}
	
	protected function getAttributeSetId()
	{
		return 4;
	}
	
	protected function getEntityTypeId()
	{
		
	}
	
	
	/**
	 * Update and insert data in entity table.
	 *
	 * @param array $entityRowsIn Row for insert
	 * @return Mage_ImportExport_Model_Import_Entity_Product
	 */
	protected function _saveProductEntity(array $entityRowsIn)
	{
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
				$this->_newSku[$sku]['entity_id'] = $newId;
			}
		}
		return $this;
	}
	
	
	
}
