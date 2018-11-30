<?php

/**
 * Mapseries product type implementation
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bkg_MapSeries_Model_Product_Type_Mapseries extends Mage_Catalog_Model_Product_Type_Grouped
{
    const TYPE_CODE = 'mapseries';
    const TYPE_MAPSERIES = 'mapseries';
    
    public function isMapseries()
    {
    	return true;
    }

    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode)
    {
        $product = $this->getProduct($product);
        $productsInfo = $buyRequest->getSuperGroup();
        $isStrictProcessMode = $this->_isStrictProcessMode($processMode);

        if (!$isStrictProcessMode || (!empty($productsInfo) && is_array($productsInfo))) {
            $products = array();
            $associatedProductsInfo = array();
            $associatedProducts = $this->getAssociatedProducts($product);
            if ($associatedProducts || !$isStrictProcessMode) {
                foreach ($associatedProducts as $subProduct) {
                    $subProductId = $subProduct->getId();
                    if(isset($productsInfo[$subProductId])) {
                        $qty = $productsInfo[$subProductId];
                        if (!empty($qty) && is_numeric($qty)) {

                            $_result = $subProduct->getTypeInstance(true)
                                ->_prepareProduct($buyRequest, $subProduct, $processMode);
                            if (is_string($_result) && !is_array($_result)) {
                                return $_result;
                            }

                            if (!isset($_result[0])) {
                                return Mage::helper('checkout')->__('Cannot process the item.');
                            }

                            if ($isStrictProcessMode) {
                                $_result[0]->setCartQty($qty);
                                $_result[0]->addCustomOption('product_type', self::TYPE_CODE, $product);
                                $_result[0]->addCustomOption('info_buyRequest',
                                    serialize(array(
                                        'super_product_config' => array(
                                            'product_type'  => self::TYPE_CODE,
                                            'product_id'    => $product->getId()
                                        )
                                    ))
                                );
                                $products[] = $_result[0];
                            } else {
                                $associatedProductsInfo[] = array($subProductId => $qty);
                                $product->addCustomOption('associated_product_' . $subProductId, $qty);
                            }
                        }
                    }
                }
            }

            if (!$isStrictProcessMode || count($associatedProductsInfo)) {
                $product->addCustomOption('product_type', self::TYPE_CODE, $product);
                $product->addCustomOption('info_buyRequest', serialize($buyRequest->getData()));

                $products[] = $product;
            }

            if (count($products)) {
                return $products;
            }
        }

        return Mage::helper('catalog')->__('Please specify the quantity of product(s).');
    }
}
