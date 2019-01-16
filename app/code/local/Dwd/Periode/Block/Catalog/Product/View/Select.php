<?php

/**
 * Class Dwd_Periode_Block_Catalog_Product_View_Select
 *
 * @category  Dwd
 * @package   Dwd_Periode
 * @author    Holger Kögel <h.koegel@b3-it.de>
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Periode_Block_Catalog_Product_View_Select extends Mage_Catalog_Block_Product_View_Abstract
{
    //alle zeiten für ein Produkt als array
    private $_perioden = NULL;

    public function showInfo() {
        return count($this->getPerioden()) == 1;
    }

    protected function getPerioden() {
        if ($this->_perioden == NULL) {
            $this->_perioden = array();
            $product_id = $this->getProduct()->getId();
            if ($product_id) {
                $collection = Mage::getModel('periode/periode')->getCollection();
                $collection->getSelect()->where('product_id=?', intval($product_id));
                $collection->setStoreId($this->getStoreId());
                foreach ($collection->getItems() as $item) {
                    $this->_perioden[] = $item;
                }
            }

        }

        return $this->_perioden;
    }

    public function getStoreId() {
        return Mage::app()->getStore()->getStoreId();
    }

    public function showSelect() {
        return count($this->getPerioden()) > 1;
    }

    public function show() {
        return count($this->getPerioden()) > 0;
    }

    public function getFormatedPeriodePrice($periode) {

        $_html = Mage::helper('core')->formatPrice($periode->getFinalPrice($this->getProduct()), false);
        $_html = $this->_getAdditionalPriceInfo($_html);

        return $_html;
    }

    public function getPrice($periode) {
        $product = $this->getProduct();
        return $periode->getFinalPrice($product);
    }

    public function getFormatedFinalPrice($periode) {
        $product = $this->getProduct();
        if ($periode->getCustomerTierPrice()) {
            $_price = $periode->getFinalPrice($product);
        } else {
            $_price = Mage::helper('tax')->getPrice($product, $product->getPrice());
            $_price += $periode->getFinalPrice($product);
        }
        $_html = Mage::helper('core')->formatPrice($_price, false);

        $_html = $this->_getAdditionalPriceInfo($_html);

        return $_html;
    }

    protected function _getAdditionalPriceInfo($html) {
        if (Mage::helper('core')->isModuleEnabled('Egovs_Ready')) {
            $_htmlObject = new Varien_Object();
            $_htmlObject->setParentHtml($html);
            $_infoBlock = $this->getLayout()->createBlock('egovsready/catalog_product_price_info')
                ->setProduct($this->getProduct());

            $_htmlTemplate = $_infoBlock
                ->setIsIncludingShippingCosts(false)
                ->setPriceDisplayType(Mage::helper('tax')->getPriceDisplayType())
                ->setDisableShippingInfo(true)
                ->toHtml();
            $_htmlTemplate = preg_replace('/((?<=\>)[\s]+)|([\s]+(?=\<))/i', '', $_htmlTemplate);
            $_htmlObject->setHtml('&nbsp;(' . $_htmlTemplate . ')');

            Mage::dispatchEvent('dwd_periode_select_after_product_price',
                array(
                    'html_obj' => $_htmlObject,
                    'block' => $this,
                )
            );

            $html = $_htmlObject->getPrefix();
            $html .= $_htmlObject->getParentHtml();
            $html .= $_htmlObject->getHtml();
            $html .= $_htmlObject->getSuffix();
        }

        return $html;
    }
}