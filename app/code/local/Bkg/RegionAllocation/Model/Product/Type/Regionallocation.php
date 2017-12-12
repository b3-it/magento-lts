<?php
class Bkg_RegionAllocation_Model_Product_Type_Regionallocation extends Mage_Catalog_Model_Product_Type_Virtual
{
	/**
	 * Type ID
	 *
	 * Muss mit XML übereinstimmen!!
	 *
	 * @var string
	 */
	const TYPE_CODE = 'regionallocation';



	private $_reloadedProduct = null;

	/**
	 *
	 * @param Mage_Catalog_Model_Product $product
	 *
	 * @return Bkg_RegionAllocation_Model_Product_Type_Regionallocation
	 */
	public function Save($product = null)
	{
		if ($this->getProduct($product)->getStockData()) {
			$stockItem = $this->getProduct($product)->getStockData();
			
			if((isset($stockItem['max_sale_qty']) &&($stockItem['max_sale_qty'] != 1)) || (isset($stockItem['use_config_max_sale_qty']) && $stockItem['use_config_max_sale_qty']))
			{
				Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('regionallocation')->__('Maximum saleable quantity is 1'));
			}
		}
		
		
		$this->limitMaxSaleQty($product);

		parent::beforeSave($product);

		
		return $this;
	}

	
	/**
	 * Limitiert die Höchstbestellmenge auf 1
	 *
	 * @param Mage_Catalog_Model_Product $product Produkt
	 *
	 * @return Bkg_RegionAllocation_Model_Product_Type_Regionallocation
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
	
	
	public function isSalable($product = null)
	{
		return true;
	}

	protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) {
		
		$buyRequest->setQty(1);
		
		
		$result = parent::_prepareProduct($buyRequest, $product, $processMode);
			
		if (is_string($result)) {
			return $result;
		}
	
		
		$portions = $this->getProduct($product)->getPortions();
		
		$this->getProduct($product)->addCustomOption('region_portions', serialize($portions) );
		
		

		return $result;


	}

	protected function getReloadedProduct($product)
	{
		if($this->_reloadedProduct == null)
		{
			$this->_reloadedProduct = Mage::getModel('catalog/product')->load($product->getId());
		}
		return $this->_reloadedProduct;
	}

	

	public function getOrderOptions($product = null)
	{
		$options = parent::getOrderOptions($product);
		
		 
		return $options;
	}

	public function canConfigure($product = null)
	{
		return false;
		 
	}

	public function hasRequiredOptions($product = null)
	{
		return false;
	}

	

}
