<?php
class Gka_InternalPayId_Model_Product_Type_Internalpayid extends Mage_Catalog_Model_Product_Type_Virtual
{
	/**
	 * Type ID
	 * 
	 * Muss mit XML übereinstimmen!!
	 * 
	 * @var string
	 */
    const TYPE_INTERNAL_PAYID = 'internalpayid';
    
    
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

        /**
         * @var string $pay_id Kassenzeichen
         */
    	$pay_id = $buyRequest->getPayId();
        /**
         * @var string $pay_client Bewirtschafter Nr.
         */
    	$pay_client = $buyRequest->getPayClient();
    	$specialPrice = (float)($buyRequest->getAmount());
    	
    	
    	
    	if($pay_id)
    	{
    		$this->getProduct($product)->addCustomOption('pay_id', $pay_id);
    		$this->getProduct($product)->addCustomOption('pay_client', $pay_client);
    		if ($specialPrice > 0) {
    			$this->getProduct($product)->setCustomPrice($specialPrice);
    			$this->getProduct($product)->setOriginalCustomPrice($specialPrice);
    			$product->setIsSuperMode(true);
    		} else {
    			return Mage::helper('internalpayid')->__('Price is missing!');
    		}
    		
    		return $result;
    	}

    	
    	
    	return Mage::helper('internalpayid')->__('Internal Ident Number is missing!');
    }
    
    
}
