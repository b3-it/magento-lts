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
    	if($pay_id)
    	{
    		$this->getProduct($product)->addCustomOption('pay_id', $pay_id);
    	}

    	
    	if (is_string($result)) {
    		return $result;
    	}
    	return $result;
    }
    
    
}
