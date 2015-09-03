<?php
class Dwd_ConfigurableVirtual_Model_Product_Type_Configurable extends Mage_Catalog_Model_Product_Type_Virtual
{
	/**
	 * Type ID
	 *
	 * Muss mit XML übereinstimmen!!
	 *
	 * @var string
	 */
	const TYPE_CONFIGURABLE_VIRTUAL = 'configvirtual';


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
			
			if(($stockItem['max_sale_qty'] != 1) || (isset($stockItem['use_config_max_sale_qty']) && $stockItem['use_config_max_sale_qty']))
			{
				Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('configvirtual')->__('Maximum saleable quantity is 1'));
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


	protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) {
		
		
		
		//$this->limitMaxSaleQty($product);
		
		if ($this->getProduct($product)->getStationenSet()) {
			$station = $buyRequest->getStation();
			if ($station) {
				$this->getProduct($product)->addCustomOption('station_id', $station);
			}
			else
			{
				return Mage::helper('stationen')->__('Please specify station.');
			}
		}


		$period_id = $buyRequest->getPeriode();
		if($period_id)
		{
			$this->getProduct($product)->addCustomOption('periode_id', $period_id);
			 
		}
		else
		{
			$periode = Mage::getModel('periode/periode');
			$ids = $periode->getProductPeriodeIds($product->getId());
			if(count($ids) > 1)
			{
				return Mage::helper('periode')->__('Please specify periode.');
			}
			else if (count($ids) == 1)
			{
				$periode_id = array_shift($ids);
				$buyRequest->setPeriode($periode_id);
				$this->getProduct($product)->addCustomOption('periode_id', $periode_id);
				 
			}

		}

		$result = parent::_prepareProduct($buyRequest, $product, $processMode);
		 
		if (is_string($result)) {
			return $result;
		}


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

	/**
	 * Limitiert die Höchstbestellmenge auf 1
	 * 
	 * @param Mage_Catalog_Model_Product $product Produkt
	 * 
	 * @return Dwd_ConfigurableVirtual_Model_Product_Type_Configurable
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

	public function getOrderOptions($product = null)
	{
		$options = parent::getOrderOptions($product);
		if ($station = $this->getProduct($product)->getCustomOption('station_id')) {

			$options = array_merge($options, array('station_id' => $station->getValue()));
		}
		 
		return $options;
	}

	public function canConfigure($product = null)
	{
		$set = $this->getReloadedProduct($product)->getStationenSet() != null;
		$periode = Mage::getModel('periode/periode')->getProductHasPeriodeOption($product->getId());
		return $set || ($periode > 1);
		 
	}

	public function hasRequiredOptions($product = null)
	{
		$set = $this->getReloadedProduct($product)->getStationenSet() != null;
		$periode = Mage::getModel('periode/periode')->getProductHasPeriodeOption($product->getId());
		return $set || ($periode > 1);
	}

	/**
	 *
	 * Liefert alle Stationen des Produktes
	 * @return null falls kein Set konfiguiert wurde
	 */
	public function getStationen()
	{
		if($this->_stationen == null)
		{
			if($this->getStationenSet())
			{
				$set = Mage::getModel('stationen/set')->load($this->getStationenSet());
				$this->_stationen = $set->getStationen();
			}
		}
		return $this->_stationen;
	}

}
