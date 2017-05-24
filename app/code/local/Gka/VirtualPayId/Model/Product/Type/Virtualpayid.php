<?php
class Gka_VirtualPayId_Model_Product_Type_Virtualpayid extends Mage_Catalog_Model_Product_Type_Virtual
{
	/**
	 * Type ID
	 * 
	 * Muss mit XML übereinstimmen!!
	 * 
	 * @var string
	 */
    const TYPE_VIRTUAL_PAYID = 'virtualpayid';
    
    
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
    			
    	$pay_id = $buyRequest->getPayId();
    	$specialPrice = (float)($buyRequest->getAmount());
    	
    	
    	
    	if($pay_id)
    	{
    		$this->getProduct($product)->addCustomOption('pay_id', $pay_id);
    		if ($specialPrice > 0) {
    			$this->getProduct($product)->setCustomPrice($specialPrice);
    			$this->getProduct($product)->setOriginalCustomPrice($specialPrice);
    			$product->setIsSuperMode(true);
    		}else{
    			return Mage::helper('virtualpayid')->__('Price is missing!');
    		}
    		
    		return $result;
    	}

    	
    	
    	return Mage::helper('virtualpayid')->__('Payment ID is missing!');
    }
    
    
}
