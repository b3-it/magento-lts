<?php
class Bkg_VirtualAccess_Model_Product_Type extends Mage_Catalog_Model_Product_Type_Virtual
{
	/**
	 * Type ID
	 *
	 * Muss mit XML übereinstimmen!!
	 *
	 * @var string
	 */
	const TYPE_CODE = 'virtualaccess';


	private $_stationen = null;
	private $_reloadedProduct = null;

	/**
	 * Save Product downloadable information (links and samples)
	 *
	 * @param Mage_Catalog_Model_Product $product
	 *
	 * @return Mage_Downloadable_Model_Product_Type
	 */
	public function save($product = null)
	{
		if ($this->getProduct($product)->getStockData()) {
			$stockItem = $this->getProduct($product)->getStockData();
			
			if((isset($stockItem['max_sale_qty']) && ($stockItem['max_sale_qty'] != 1)) || (isset($stockItem['use_config_max_sale_qty']) && $stockItem['use_config_max_sale_qty']))
			{
				Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('virtualaccess')->__('Maximum saleable quantity is 1'));
			}
		}
		
		
		$this->limitMaxSaleQty($product);
		parent::save($product);

		$product = $this->getProduct($product);
		/* @var Mage_Catalog_Model_Product $product */

		if ($data = $product->getConfigvirtualData()) {
			foreach ($data as $attributeCode => $value) {
				$objectData = new Varien_Object();
				$objectData->setData($product->getIdFieldName(), $product->getId());
				$objectData->setData($attributeCode, $value);
				$product->getResource()->saveAttribute($objectData, $attributeCode);
			}
		}
		 
		return $this;
	}




	protected function getReloadedProduct($product)
	{
		if($this->_reloadedProduct == null)
		{
			$this->_reloadedProduct = Mage::getModel('catalog/product')->load($product->getId());
		}
		return $this->_reloadedProduct;
	}

	/**
	 * Limitiert die Höchstbestellmenge auf 1
	 * 
	 * @param Mage_Catalog_Model_Product $product Produkt
	 * 
	 * @return Bkg_VirtualAccess_Model_Product_Type
	 */
	public function limitMaxSaleQty($product) {
		/* @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
		if ($this->getProduct($product)->getStockItem()) {
			$stockItem = $this->getProduct($product)->getStockItem();
			$stockItem->setMaxSaleQty(1);
			$stockItem->setUseConfigMaxSaleQty(false);
		}
		
		if ($this->getProduct($product)->getStockData()) {
			$stockItem = $this->getProduct($product)->getStockData();
			$stockItem['max_sale_qty'] = 1;
			$stockItem['use_config_max_sale_qty'] = false;
			$this->getProduct($product)->setStockData($stockItem);
		}
		
		return $this;
	}




}
