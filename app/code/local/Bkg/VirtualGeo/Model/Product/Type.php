<?php

class Bkg_VirtualGeo_Model_Product_Type extends Mage_Bundle_Model_Product_Type
{
	/**
	 * Type ID
	 *
	 * Muss mit XML übereinstimmen!!
	 *
	 * @var string
	 */
	const TYPE_CODE = 'virtualgeo';
	
    protected $_RapRelationCollection = NULL;
    protected $_resultParent = NULL;

    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) {
        $this->_resultParent = parent::_prepareProduct($buyRequest, $product, $processMode);

        if (is_string($this->_resultParent)) {
            return $this->_resultParent;
        }
  
        $_result = $this->_processTypesOfUse($buyRequest, $product, $processMode);
        if (is_string($_result)) {
            return $_result;
        }
    
        $_result = $this->_processCrs($buyRequest, $product, $processMode);
        if (is_string($_result)) {
            return $_result;
        }
    
        return $this->_resultParent;
    	}
    	
    /**
     * Verarbeitet das übergebene Coordinate Reference System (CRS)
     *
     * @param \Varien_Object $buyRequest
     * @param                $product
     * @param                $processMode
     *
     * @return self
     */
    protected function _processCrs(Varien_Object $buyRequest, $product, $processMode) {
        $crs = $buyRequest->getData('virtualgeo-components-georef');

        if (empty($crs) || !is_array($crs)) {
            return Mage::helper('checkout')->__('CRS is missing!');
        }

        $crs = $crs[0];

        if (!isset($this->_resultParent[0])) {
            return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
        }

        $this->_resultParent[0]
            ->addCustomOption('virtualgeo_georef', intval($crs))
        ;

        return $this;
    }

    protected function _processTypesOfUse(Varien_Object $buyRequest, $product, $processMode) {
        $typesOfUse = array();
    	$toll = $buyRequest->getData('virtualgeo-components-toll');
    	
        if (isset($toll['int']['use'])) {
            $typesOfUse[] = 'int';
    	}
        if (isset($toll['ext']['use'])) {
            $typesOfUse[] = 'ext';
    	}
    	
        //TODO :: Use dynamic price
    	$price = 100;
    	
    	//alle verfügbaren Entgelte abholen
    	$fees = $sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
        foreach ($typesOfUse as $usage) {
            foreach ($fees as $fee) {
                $raprel = $this->_getRapRelation($product, $fee['ident'], $usage);
                $taxraprel = $this->_getRapRelation($product, $fee['ident'], $usage . '_tax');
	    			
                $rapId = $raprel ? $raprel->getRapId() : NULL;
                $rapIdTax = $taxraprel ? $taxraprel->getRapId() : NULL;
	    			
                $raps = Mage::helper('regionallocation')->getRapProducts($rapId, $rapIdTax, $price, $fee['ident'], $usage);
	    			
	    			
                foreach ($raps as $rap) {
				    	$_result = $rap->getTypeInstance(true)->prepareForCart($buyRequest, $rap);
				    	if (is_string($_result) && !is_array($_result)) {
				    		return $_result;
				    	}
				    	
				    	if (!isset($_result[0])) {
				    		return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
				    	}
				    	
				    	
                    $this->_resultParent[] = $_result[0]->setParentProductId($product->getId())
				    		->addCustomOption('fee',$rap->getFee())
				    		->addCustomOption('usage',$rap->getUsage())
				    		->addCustomOption('kst_id',$rap->getKst()->getId())
                        ->addCustomOption('kst_portions', serialize($rap->getPortions()));;
	    			}
	    	}
    	}
    	
        return $this;
    }
    
    
    /**
     * Ein array aller Reginallocations für das Produkt
     *
     * @param Mage_Catalog_Model_Product $product
     * 
     * @return array[fee][usage]
     */
    protected function _getRapRelationCollection($product, $usage) {
    	$expr = new Zend_Db_Expr("`usage` = '".$usage."' OR `usage` = '".$usage."_tax'");
        if ($this->_RapRelationCollection == NULL) {
    		$collection = Mage::getModel('virtualgeo/components_regionallocation')->getCollection();
    		$collection->getSelect()
    		->order('fee')
    		->where($expr)
    		->where('parent_id = '.intval($product->getId()));
    		$this->_RapRelationCollection = array();
    		foreach($collection->getItems() as $item){
    			$this->_RapRelationCollection[$item->getFee()][$item->getUsage()] = $item;
    		}
    		
    	}
    
    	return $this->_RapRelationCollection;
    }
  
    
    public function isSalable($product = null)
    {
    	$salable = parent::isSalable($product);
    	if (!is_null($salable)) {
    		return $salable;
    	}
    
    	$storageCollection = Mage::getModel('virtualgeo/components_storageproduct')->getComponents4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId());
    	
    	
    
    	if (!count($storageCollection->getItems())) {
    		return false;
    	}
    
    	
    
    	foreach ($storageCollection->getItems() as $storage) {
    		$storageProduct = Mage::getModel('catalog/product')->load($storage->getTransportProductId());
    		if($storageProduct->isSalable()){
    			return true;
    		}
    	}
    
    	return false;
    }
    
    
    
    protected function _getRapRelation($product, $fee, $usage)
    {
    	$items = $this->_getRapRelationCollection($product, $usage);
    	
    	if(isset($items[$fee])){
    		if(isset($items[$fee][$usage])){
    			return $items[$fee][$usage];
    		}
    	}
    	
        return NULL;
    }
    
    
    /**
     * Check if product can be configured
     *
     * @param Mage_Catalog_Model_Product $product
     *
     * @return bool
     */
    public function canConfigure($product = NULL) {
    	return $product instanceof Mage_Catalog_Model_Product
    	&& $product->isAvailable();
    }
    
   
    /**
     * Before save type related data
     *
     * @param Mage_Catalog_Model_Product $product
     */
    public function beforeSave($product = NULL) {
    	parent::beforeSave($product);
    	$product->setPriceType(Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC);
    	return $this;
    }

    
    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart() {
    	return Mage::getSingleton('checkout/cart');
    }
   
   
}
