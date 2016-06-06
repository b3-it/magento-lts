<?php
/**
 * 
 *  Produkt-Detailansicht; Überschreibt Bundle um die Verfügbarkeit als ProductStockAlert abzuspeichern 
 *  @category Egovs
 *  @package  Egovs_EventBundle
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Block_Catalog_Product_View_EventBundle extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle
{
 
 public function getJsonConfig()
    {
        Mage::app()->getLocale()->getJsPriceFormat();
        $optionsArray = $this->getOptions();
        $options      = array();
        $selected     = array();
        $currentProduct = $this->getProduct();
        /* @var $coreHelper Mage_Core_Helper_Data */
        $coreHelper   = Mage::helper('core');
        /* @var $bundlePriceModel Mage_Bundle_Model_Product_Price */
        $bundlePriceModel = Mage::getModel('eventbundle/product_price');

        if ($preConfiguredFlag = $currentProduct->hasPreconfiguredValues()) {
            $preConfiguredValues = $currentProduct->getPreconfiguredValues();
            $defaultValues       = array();
        }

        foreach ($optionsArray as $_option) {
            /* @var $_option Mage_Bundle_Model_Option */
            if (!$_option->getSelections()) {
                continue;
            }
            //continue;
            $optionId = $_option->getId();
            $option = array (
                'selections' => array(),
                'title'      => $_option->getTitle(),
                'isMulti'    => in_array($_option->getType(), array('multi', 'checkbox'))
            );

            $selectionCount = count($_option->getSelections());

            foreach ($_option->getSelections() as $_selection) {
                /* @var $_selection Mage_Catalog_Model_Product */
                $selectionId = $_selection->getSelectionId();
                $_qty = !($_selection->getSelectionQty() * 1) ? '1' : $_selection->getSelectionQty() * 1;
                // recalculate currency
                $tierPrices = $_selection->getTierPrice();
                foreach ($tierPrices as &$tierPriceInfo) {
                    $tierPriceInfo['price'] = $coreHelper->currency($tierPriceInfo['price'], false, false);
                }
                unset($tierPriceInfo); // break the reference with the last element

                $itemPrice = $bundlePriceModel->getSelectionFinalTotalPrice($currentProduct, $_selection,
                        $currentProduct->getQty(), $_selection->getQty(), false);

                $canApplyMAP = false;

                /* @var $taxHelper Mage_Tax_Helper_Data */
                $taxHelper = Mage::helper('tax');

                $_priceInclTax = $taxHelper->getPrice($_selection, $itemPrice, true);
                $_priceExclTax = $taxHelper->getPrice($_selection, $itemPrice);

                if ($currentProduct->getPriceType() == Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED) {
                    $_priceInclTax = $taxHelper->getPrice($currentProduct, $itemPrice, true);
                    $_priceExclTax = $taxHelper->getPrice($currentProduct, $itemPrice);
                }

                $_selection = Mage::helper('eventbundle')->loadStockItem($_selection);
 		
                
                $price = $_selection->getFinalPrice();
                if($taxHelper->displayPriceIncludingTax())
                {
                	$price = $taxHelper->getPrice($_selection, $price, true);
                }
                
                
 		 		if($_selection->getStockItem()->getIsInStock())
 				{
	                $selection = array (
	                    'qty'              => $_qty,
	                    'customQty'        => $_selection->getSelectionCanChangeQty(),
	                   // 'price'            => $coreHelper->currency($_selection->getFinalPrice(), false, false),
	                    'price'            => $coreHelper->currency($price, false, false),
	                    'priceInclTax'     => $coreHelper->currency($_priceInclTax, false, false),
	                    'priceExclTax'     => $coreHelper->currency($_priceExclTax, false, false),
	                    'priceValue'       => $coreHelper->currency($_selection->getSelectionPriceValue(), false, false),
	                    'priceType'        => $_selection->getSelectionPriceType(),
	                    'tierPrice'        => $tierPrices,
	                    'name'             => $_selection->getName(),
	                    'plusDisposition'  => 0,
	                    'minusDisposition' => 0,
	                    'canApplyMAP'      => $canApplyMAP
	                );
 				}else
 				{
 					$selection = array (
	                    'qty'              => $_qty,
	                    'customQty'        => 0,//$_selection->getSelectionCanChangeQty(),
	                    'price'            => 0,//$coreHelper->currency($_selection->getFinalPrice(), false, false),
	                    'priceInclTax'     => 0,//$coreHelper->currency($_priceInclTax, false, false),
	                    'priceExclTax'     => 0,//$coreHelper->currency($_priceExclTax, false, false),
	                    'priceValue'       => 0,//$coreHelper->currency($_selection->getSelectionPriceValue(), false, false),
	                    'priceType'        => $_selection->getSelectionPriceType(),
	                    'tierPrice'        => $tierPrices,
	                    'name'             => $_selection->getName(),
	                    'plusDisposition'  => 0,
	                    'minusDisposition' => 0,
	                    'canApplyMAP'      => $canApplyMAP
	                );
 				}

                $responseObject = new Varien_Object();
                $args = array('response_object' => $responseObject, 'selection' => $_selection);
                Mage::dispatchEvent('bundle_product_view_config', $args);
                if (is_array($responseObject->getAdditionalOptions())) {
                    foreach ($responseObject->getAdditionalOptions() as $o => $v) {
                        $selection[$o] = $v;
                    }
                }
                $option['selections'][$selectionId] = $selection;

                if (($_selection->getIsDefault() || ($selectionCount == 1 && $_option->getRequired() == 1))
                    && $_selection->isSalable()
                ) {
                    $selected[$optionId][] = $selectionId;
                }
            }
            $options[$optionId] = $option;

            // Add attribute default value (if set)
            if ($preConfiguredFlag) {
                $configValue = $preConfiguredValues->getData('bundle_option/' . $optionId);
                if ($configValue) {
                    $defaultValues[$optionId] = $configValue;
                }
            }
        }

        $config = array(
            'options'       => $options,
            'selected'      => $selected,
            'bundleId'      => $currentProduct->getId(),
            'priceFormat'   => Mage::app()->getLocale()->getJsPriceFormat(),
            'basePrice'     => $coreHelper->currency($currentProduct->getPrice(), false, false),
            'priceType'     => $currentProduct->getPriceType(),
            'specialPrice'  => $currentProduct->getSpecialPrice(),
            'includeTax'    => Mage::helper('tax')->priceIncludesTax() ? 'true' : 'false',
            'isFixedPrice'  => $this->getProduct()->getPriceType() == Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED,
            'isMAPAppliedDirectly' => Mage::helper('catalog')->canApplyMsrp($this->getProduct(), null, false)
        );

        if ($preConfiguredFlag && !empty($defaultValues)) {
            $config['defaultValues'] = $defaultValues;
        }

        return $coreHelper->jsonEncode($config);
    }

    /**
     * Anzeige trotz "nicht auf Lager"
     * @see Mage_Bundle_Block_Catalog_Product_View_Type_Bundle::getOptions()
     */
    public function getOptions()
    {
    	if (!$this->_options) {
    		$product = $this->getProduct();
    		$typeInstance = $product->getTypeInstance(true);
    		$typeInstance->setStoreFilter($product->getStoreId(), $product);
    
    		$optionCollection = $typeInstance->getOptionsCollection($product);
    
    		$selectionCollection = $typeInstance->getSelectionsCollection(
    				$typeInstance->getOptionsIds($product),
    				$product
    		);
    
    		$this->_options = $optionCollection->appendSelections($selectionCollection, false, true);
    	}
    
    	return $this->_options;
    }
   
}
