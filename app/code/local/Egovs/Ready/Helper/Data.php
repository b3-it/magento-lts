<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        	Egovs
 * @package         	Egovs_Ready
 * @name            	Egovs_Ready_Helper_Data
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Ready_Helper_Data extends Mage_Core_Helper_Data
{
	public function getShippingCostUrl() {
		/** @var $cmsPage Mage_Cms_Model_Page */
		$cmsPage = Mage::getModel('cms/page')
			->setStoreId(Mage::app()->getStore()->getId())
			->load(Mage::getStoreConfig('catalog/price/cms_page_shipping'))
		;
	
		if (!$cmsPage->getId() || !$cmsPage->getIsActive()) {
			return '';
		}
	
		return Mage::helper('cms/page')->getPageUrl($cmsPage->getId());
	}
	
	
	
	protected $_translator = null;
	
	/**
	 * Translate
	 *
	 * Es werden mindestens 2 Parameter erwartet, der erste gibt das Modul an (z. B. 'sales'), der zweite den zu übersetzenden String.
	 *
	 * @return string
	 */
	public function _translate() {
		$args = func_get_args();
		if (isset($args[0]) && is_array($args[0]) && count($args) == 1) {
			$args = $args[0];
		}
		if (isset($args[0]) && is_array($args[0]) && count($args) > 1) {
			Mage::throwException('egovslocale::If the first parameter is an array, there is only one parameter allowed!');
		}
		if (count($args) < 2) {
			Mage::throwException('egovslocale::It reuqires at least 2 arguments.');
		}
		if (isset($args[0])) {
			$helper = Mage::helper($args[0]);
			$class = get_class($helper);
			$moduleName = substr($class, 0, strpos($class, '_Helper'));
			unset($args[0]);
		}
		$expr = new Mage_Core_Model_Translate_Expr(array_shift($args), $moduleName);
		array_unshift($args, $expr);
	
		if (!$this->_translator) {
			$this->_translator = Mage::app()->getTranslator()->init('adminhtml', true);
		}
	
		return $this->_translator->translate($args);
	}

    /**
     * Display additional price info (like tax, shipping cost etc.)
     *
     * @param null $store
     *
     * @return bool
     */
	public function displayAdditionalPriceBlock($store = null) {
        return Mage::getStoreConfigFlag('catalog/price/display_block_below_price', $store);
    }
	
}