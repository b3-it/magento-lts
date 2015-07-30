<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        	Egovs
 * @package			Egovs_Ready
 * @name            	Egovs_Ready_Block_Catalog_Product_Price
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Ready_Block_Bundle_Catalog_Product_Price extends Mage_Bundle_Block_Catalog_Product_Price
{	
	protected function _loadTaxCalculationRate(Mage_Catalog_Model_Product $product) {
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
				$_request = $_calculation->getRateRequest(null, null, $_customerTaxClassId, $_store);
				$_taxPercent = $_calculation->getRate($_request->setProductClassId($_taxClassId));
			}
		}
	
		if ($_taxPercent) {
			return $_taxPercent;
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
	
	public function getFormattedTaxRate() {
		if ($this->getTaxRate() === null || $this->getProduct()->getTypeId() == 'bundle') {
			return '';
		}
	
		$_locale = Mage::app()->getLocale()->getLocaleCode();
		$_taxRate = Zend_Locale_Format::toFloat($this->getTaxRate(), array('locale' => $_locale));
	
		return $this->__('%s%%', $_taxRate);
	}
	
	public function priceIncludesTax() {
		if (!$this->getData('price_includes_tax')) {
			$includesTax = Mage::getStoreConfig('tax/sales_display/price');
			$this->setData('price_includes_tax', $includesTax);
		}
	
		return $this->getData('price_includes_tax');
	}
	
	public function showShippingLink() {
		return !$this->getProduct()->isVirtual();
	}
	
	public function getDisplayProductWeight() {
		return Mage::getStoreConfigFlag('catalog/price/display_product_weight');
	}
	
	public function getFormattedWeight() {
		return sprintf("%s %s", floatval($this->getProduct()->getWeight()), Mage::getStoreConfig('catalog/price/weight_unit'));
	}
	
	public function _toHtml()
	{
		$_html = trim(parent::_toHtml());
	
		if (empty($_html) || !Mage::getStoreConfigFlag('catalog/price/display_block_below_price')) {
			return $_html;
		}
		
		$_htmlObject = new Varien_Object();
		$_htmlObject->setParentHtml($_html);
		$_htmlTemplate = $this->getLayout()->createBlock('core/template')
			->setTemplate('egovsready/catalog/product/price/info.phtml')
			->setProduct($this->getProduct())
			->setFormattedTaxRate($this->getFormattedTaxRate())
			->setShowShippingLink($this->showShippingLink())
			->setPriceDisplayType(Mage::helper('tax')->getPriceDisplayType())
			->setDisplayProductWeight($this->getDisplayProductWeight())
			->setFormattedWeight($this->getFormattedWeight())
			->toHtml()
		;
		$_htmlObject->setHtml($_htmlTemplate);

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