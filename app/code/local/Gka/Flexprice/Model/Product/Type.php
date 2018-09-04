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

    /**
     * Check if product is configurable
     *
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    public function canConfigure($product = null) {
    	return true;
    }

    /**
     * Check is virtual product
     *
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    public function isVirtual($product = null)
    {
    	return true;
    }

    /**
     * @param  Mage_Catalog_Model_Product $product
     * @param  Varien_Object $buyRequest
     * @return array|string
     */
    public function processBuyRequest($product, $buyRequest)
    {
    	$options = parent::processBuyRequest($product,$buyRequest);
    	$options['felxprice'] = $buyRequest->getAmount();
    	return $options;
    }

    /**
     * Prepare product and its configuration to be added to some products list.
     * Perform standard preparation process and then prepare options belonging to specific product type.
     *
     * @param  Varien_Object $buyRequest
     * @param  Mage_Catalog_Model_Product $product
     * @param  string $processMode
     * @return array|string
     */
    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode)
    {

        //$buyRequest->setQty(1);

    	$result = parent::_prepareProduct($buyRequest, $product, $processMode);

    	$specialPrice = Gka_Flexprice_Helper_Data::parseFloat($buyRequest->getAmount());

        if( ($specialPrice > 0) || ($specialPrice >= 0 && $product->getAllowPriceZero() )) {
			$this->getProduct($product)->setCustomPrice($specialPrice);
			$this->getProduct($product)->setOriginalCustomPrice($specialPrice);
            $this->getProduct($product)->addCustomOption('flexprice', $specialPrice );
			$product->setIsSuperMode(true);
		}
        else {
            return Mage::helper('flexprice')->__('Price is missing!');
    	}
		return $result;
    }
}
