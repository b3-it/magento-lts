<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package			Egovs_Ready
 * @name            Egovs_Ready_Block_Bundle_Catalog_Product_Price
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2018 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Ready_Block_Bundle_Catalog_Product_Price extends Mage_Bundle_Block_Catalog_Product_Price
{
	protected function _addDeliveryTimeHtml($htmlObject) {
		if (!Mage::getStoreConfigFlag('catalog/price/display_delivery_time_on_categories')) {
			return;
		}

		$pathInfo = Mage::app()->getRequest()->getPathInfo();
		if (strpos($pathInfo, 'catalog/category/view') !== false
				|| strpos($pathInfo, 'catalogsearch/result') !== false
		) {
			if ($this->getProduct()->getDeliveryTime()) {
				$html = '<p class="delivery-time time1">';
				$html .= $this->__('Delivery Time') . ': ' . $this->getProduct()->getDeliveryTime();
				$html .= '</p>';
				$htmlObject->setSuffix($html);
			}
		}
	}

    /**
     * @param \Mage_Catalog_Model_Product $product
     *
     * @return bool|float|int
     * @throws \Mage_Core_Model_Store_Exception
     */
	protected function _loadTaxCalculationRate(Mage_Catalog_Model_Product $product) {
        /**
         * @var $_priceModel Mage_Bundle_Model_Product_Price
         */
        $_priceModel  = $product->getPriceModel();

        if ($product->getPriceType() == 1) {
            $_taxPercent = $product->getTaxPercent();

            if (is_null($_taxPercent)) {
                $_taxClassId = $product->getTaxClassId();
                if ($_taxClassId) {
                    $_store = Mage::app()->getStore();
                    $_groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                    $_group = Mage::getModel('customer/group')->load($_groupId);
                    $_customerTaxClassId = $_group->getTaxClassId();

                    /* @var $calculation Mage_Tax_Model_Calculation */
                    $_calculation = Mage::getSingleton('tax/calculation');
                    $_request = $_calculation->getRateRequest(NULL, NULL, $_customerTaxClassId, $_store);
                    $_taxPercent = $_calculation->getRate($_request->setProductClassId($_taxClassId));
                }
            }

            if ($_taxPercent) {
                return $_taxPercent;
            }
        } else {
            list($_minimalPrice, $_maximalPrice) = $_priceModel->getTotalPrices($product, null, false, false);
            //We have to unset min max price to get price with tax
            $min_price = $product->getData('min_price');
            $max_price = $product->getData('max_price');
            $product->unsetData('min_price');
            $product->unsetData('max_price');
            list($_minimalPriceInclTax, $_maximalPriceInclTax) = $_priceModel->getTotalPrices($product, null, true, false);
            $product->setData('min_price', $min_price);
            $product->setData('max_price', $max_price);
            if ($_maximalPrice != $_maximalPriceInclTax) {
                return true;
            }
        }
	
		return 0;
	}
	
	public function getTaxRate() {
		$_taxRateKey = 'tax_rate_' . $this->getProduct()->getId();
		if (!$this->getData($_taxRateKey)) {
			$this->setData($_taxRateKey, $this->_loadTaxCalculationRate($this->getProduct()));
		}
	
		return $this->getData($_taxRateKey);
	}
	
    /**
     * Return false if block is not to be displayed
     * Return 0 if block is tax free
     * Return empty string if disabled
     * Forced return true to display block without tax rate
     *
     * @return bool|int|string
     */
	public function getFormattedTaxRate() {
		if ($this->getTaxRate() === null || $this->displayBothPrices()) {
			return '';
		}
	
		$_locale = Mage::app()->getLocale()->getLocaleCode();
		$_taxRate = Zend_Locale_Format::toFloat($this->getTaxRate(), array('locale' => $_locale));
	
		if (($_taxRate <= 0.01 && !Mage::getStoreConfigFlag('catalog/price/display_zero_tax_below_price'))
            || !Mage::getStoreConfigFlag('catalog/price/display_tax_below_price')
        ) {
		    return false;
        }
        //Reihenfolge wichtig!
        if ($_taxRate <= 0.01 && Mage::getStoreConfigFlag('catalog/price/display_zero_tax_below_price')) {
            return 0;
        }

        return true;
	}
	
	public function priceIncludesTax() {
		if (!$this->getData('price_includes_tax')) {
			$includesTax = Mage::helper('tax')->priceIncludesTax();
			$this->setData('price_includes_tax', $includesTax);
		}
	
		return $this->getData('price_includes_tax');
	}
	
	public function isIncludingShippingCosts() {
		if (!$this->getData('is_including_shipping_costs')) {
			$this->setData('is_including_shipping_costs', Mage::getStoreConfig('catalog/price/including_shipping_costs')
			);
		}

		return $this->getData('is_including_shipping_costs');
	}

    /**
     * Gibt den Text für Ohne Versandkosten zurück
     *
     * Der String wird bereits Escaped
     *
     * @return bool|string
     */
	public function getWithoutShippingCostsText() {
        $text = Mage::getStoreConfig('catalog/price/without_shipping_costs_text');
        if (empty($text) || strlen($text) < 1) {
            return false;
        }

        return $this->escapeHtml($text);
    }

	public function showShippingLink() {
		return !$this->getProduct()->isVirtual();
	}
	
	public function isVirtual() {
        return $this->getProduct()->isVirtual();
    }

	public function getDisplayProductWeight() {
		return Mage::getStoreConfigFlag('catalog/price/display_product_weight');
	}
	
	public function getFormattedWeight() {
		return sprintf("%s %s", floatval($this->getProduct()->getWeight()), Mage::getStoreConfig('catalog/price/weight_unit'));
	}
	
	protected function _toHtml()
	{
		$_html = trim(parent::_toHtml());
	
		if (empty($_html) || !Mage::getStoreConfigFlag('catalog/price/display_block_below_price')) {
			return $_html;
		}
		
		$_htmlObject = new Varien_Object();
		$_htmlObject->setParentHtml($_html);
		$_infoBlock = $this->getLayout()->createBlock('core/template')
			->setTemplate('egovs/ready/catalog/product/price/info.phtml')
			->setProduct($this->getProduct())
			->setFormattedTaxRate($this->getFormattedTaxRate())
			;

		$_htmlTemplate = $_infoBlock
            ->setIsIncludingShippingCosts($this->isIncludingShippingCosts())
            ->setWithoutShippingCostsText($this->getWithoutShippingCostsText())
			->setShowShippingLink($this->showShippingLink())
			->setPriceDisplayType(Mage::helper('tax')->getPriceDisplayType())
			->setDisplayProductWeight($this->getDisplayProductWeight())
			->setFormattedWeight($this->getFormattedWeight())
			->toHtml()
		;
		$_htmlObject->setHtml($_htmlTemplate);

        $this->_addDeliveryTimeHtml($_htmlObject);

		Mage::dispatchEvent('egovsready_after_bundle_product_price',
				array(
						'html_obj' => $_htmlObject,
						'block'    => $this,
				)
		);

		$_html = $_htmlObject->getPrefix();
		$_html .= $_htmlObject->getParentHtml();
		$_html .= $_htmlObject->getHtml();
		$_html .= $_htmlObject->getSuffix();
	
		return $_html;
	}
	
	public function __() {
		$args = func_get_args();
		$expr = new Mage_Core_Model_Translate_Expr(array_shift($args), 'Mage_Bundle');
		array_unshift($args, $expr);
	
		return Mage::app()->getTranslator()->translate($args);
	}
}