<?php
class Gka_Flexprice_Model_Product_Type extends Mage_Catalog_Model_Product_Type_Virtual
{
	/**
	 * Type ID
	 * 
	 * Muss mit XML übereinstimmen!!
	 * 
	 * @var string
	 */
    const TYPE_CODE = 'flexprice';
    
    
    public function canConfigure($product = null) {
    	return true;
    }
    
    public function isVirtual($product = null)
    {
    	return true;
    }
    
    
    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) 
    {
    	$buyRequest->setQty(1);
    
    	$result = parent::_prepareProduct($buyRequest, $product, $processMode);

      
    	$specialPrice = (float)($buyRequest->getAmount());
    	
		if($specialPrice > 0)
		{
			$this->getProduct($product)->setCustomPrice($specialPrice);
			$this->getProduct($product)->setOriginalCustomPrice($specialPrice);
			$product->setIsSuperMode(true);
			$this->getProduct($product)->addCustomOption('flexprice', $specialPrice );
		}else {
    			return Mage::helper('flexprice')->__('Price is missing!');
    	}
		
		return $result;
    }
    
    
}
