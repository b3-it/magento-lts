<?php

/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category           Egovs
 * @package            Egovs_Ready
 * @name                Egovs_Ready_Block_Catalog_Product_Price
 * @author             Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright          Copyright (c) 2010 - 2018 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license            http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @method bool getDisableShippingInfo()
 * @method setDisableShippingInfo($disable)
 * @method $this setPriceDisplayType($getPriceDisplayType)
 */
class Egovs_Ready_Block_Catalog_Product_Price_Info extends Mage_Core_Block_Template
{
    protected $_tierPriceDefaultTemplates = array(
            'catalog/product/view/tierprices.phtml',
    );

    public function __construct(array $args = array()) {
        parent::__construct($args);
    }

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

        // grouped are composite too, but fail on Bundle above
        // isGrouped is hardcoded for only grouped, not for derivated classes
        $grouped = $product->isGrouped() || $_priceModel instanceof Mage_Catalog_Model_Product_Type_Grouped_Price;

        if ($grouped) {
            return $this->_isGroupedTax($product);
        } else if ($product->isComposite() && $product->getPriceType() != 1) {
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
        } else {
            $_taxPercent = $product->getTaxPercent();

            if ($_taxPercent === NULL) {
                $_taxClassId = $product->getTaxClassId();
                if ($_taxClassId) {
                    $_store = Mage::app()->getStore();
                    $_groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                    $_group = Mage::getModel('customer/group')->load($_groupId);
                    $_customerTaxClassId = $_group->getTaxClassId();

                    /* @var $calculation Mage_Tax_Model_Calculation */
                    $_calculation = Mage::getSingleton('tax/calculation');
                    $_request = $_calculation->getRateRequest(null, null, $_customerTaxClassId, $_store);
                    $_taxPercent = $_calculation->getRate($_request->setProductClassId($_taxClassId));
                }
            }

            if ($_taxPercent) {
                return $_taxPercent;
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
     * Return true if block is displayed without tax rate
     * Return 0 if block is tax free
     * Return string if block is displayed with tax rate
     *
     * @return bool|int|string
     */
    public function getFormattedTaxRate() {
        $_taxRate = $this->getTaxRate();
        if ($this->getProduct()->getTypeId() == 'bundle') {
            return false;
        }

        // sanify boolean values
        if (is_bool($_taxRate) || is_null($_taxRate)) {
            return boolval($_taxRate);
        }

        $_locale = Mage::app()->getLocale()->getLocaleCode();
        $_taxRate = Zend_Locale_Format::toFloat($_taxRate, array('locale' => $_locale));

        if (($_taxRate <= 0.01 && !Mage::getStoreConfigFlag('catalog/price/display_zero_tax_below_price'))
            || !Mage::getStoreConfigFlag('catalog/price/display_tax_below_price')
        ) {
            return false;
        }
        //Reihenfolge wichtig!
        if ($_taxRate <= 0.01 && Mage::getStoreConfigFlag('catalog/price/display_zero_tax_below_price')) {
            return 0;
        }
        if (!Mage::getStoreConfigFlag('catalog/price/display_formatted_tax_rate_below_price')) {
            return true;
        }

        return $this->__('%s%%', $_taxRate);
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

    public function getIsIncludingShippingCosts() {
        return $this->isIncludingShippingCosts();
    }

    /**
     * Gibt den Text für Ohne Versandkosten zurück
     *
     * Der String wird bereits Escaped
     *
     * @return bool|string
     */
    public function getWithoutShippingCostsText() {
        if ($this->getDisableShippingInfo()) {
            return false;
        }
        $text = Mage::getStoreConfig('catalog/price/without_shipping_costs_text');
        if (empty($text) || strlen($text) < 1) {
            return false;
        }

        return $this->escapeHtml($text);
    }

    /**
     * @return bool
     */
    public function showShippingLink() {
        if ($this->getDisableShippingInfo()) {
            return false;
        }
        return !$this->getProduct()->isVirtual();
    }

    /**
     * @return bool
     */
    public function getShowShippingLink() {
        return $this->showShippingLink();
    }

    /**
     * @return bool
     */
    public function isVirtual() {
        return $this->getProduct()->isVirtual();
    }

    public function getDisplayProductWeight() {
        return !$this->isVirtual() && Mage::getStoreConfigFlag('catalog/price/display_product_weight');
    }

    public function getFormattedWeight() {
        return sprintf("%s %s", (float)$this->getProduct()->getWeight(), Mage::getStoreConfig('catalog/price/weight_unit'));
    }

    public function getPriceDisplayType() {
        return Mage::helper('tax')->getPriceDisplayType();
    }

    public function getTemplate() {
        if (empty($this->_template)) {
            $this->setTemplate('egovs/ready/catalog/product/price/info.phtml');
        }
        return parent::getTemplate(); // TODO: Change the autogenerated stub
    }

    public function getParentTemplate() {
        if (!$this->getParentBlock()) {
            return null;
        }

        return $this->getParentBlock()->getTemplate();
    }

    /**
     * @return null|\Mage_Catalog_Model_Product
     */
    public function getProduct() {
        if (!$this->hasData('product')) {
            $product = null;
            if ($this->getParentBlock() && $this->getParentBlock()->getProduct()) {
                $product = $this->getParentBlock()->getProduct();
            } elseif (Mage::registry('current_product')) {
                $product = Mage::registry('current_product');
            } elseif (Mage::registry('product')) {
                $product = Mage::registry('product');
            }
            if ($product) {
                $this->setProduct($product);
            }
        }

        return $this->getData('product');
    }

    protected function _toHtml()
    {
        if (!Mage::getStoreConfigFlag('catalog/price/display_block_below_price')) {
            return '';
        }

        $_html = trim(parent::_toHtml());

        if (empty($_html)) {
            return $_html;
        }

        if (in_array($this->getParentTemplate(), $this->_tierPriceDefaultTemplates)) {
            return $_html;
        }

        $_html = preg_replace('/((?<=\>)[\s]+)|([\s]+(?=\<))/i', '', $_html);
        $_htmlObject = new Varien_Object();
        $_htmlObject->setHtml($_html);

        $this->_addDeliveryTimeHtml($_htmlObject);

        Mage::dispatchEvent('egovsready_after_product_price_info',
                array(
                        'html_obj' => $_htmlObject,
                        'block'    => $this,
                )
        );

        $_html = $_htmlObject->getPrefix();
        $_html .= $_htmlObject->getHtml();
        $_html .= $_htmlObject->getSuffix();

        return $_html;
    }

    public function __() {
        $args = func_get_args();
        $expr = new Mage_Core_Model_Translate_Expr(array_shift($args), 'Mage_Catalog');
        array_unshift($args, $expr);

        return Mage::app()->getTranslator()->translate($args);
    }

    public function setIncludeContainer($flag = true) {
        $this->setExcludeContainer(!$flag);

        return $this;
    }

    protected function _isGroupedTax(Mage_Catalog_Model_Product $product) {
        // a grouped product get their tax from the children
        // because a tax rate can't be returned that way, only check if one of the children has tax
        if ($product->hasCustomOptions()) {
            /* @var $typeInstance Mage_Catalog_Model_Product_Type_Grouped */
            $typeInstance = $product->getTypeInstance(true);
            $associatedProducts = $typeInstance->setStoreFilter($product->getStore(), $product)
            ->getAssociatedProducts($product);
            foreach ($associatedProducts as $childProduct) {
                /* @var $childProduct Mage_Catalog_Model_Product */
                $option = $product->getCustomOption('associated_product_' . $childProduct->getId());
                if (!$option) {
                    continue;
                }
                $childQty = $option->getValue();
                if (!$childQty) {
                    continue;
                }

                // check childProduct for possible tax rate
                if ($this->_loadTaxCalculationRate($childProduct)) {
                    return true;
                }
            }
        }
        return false;
    }
}