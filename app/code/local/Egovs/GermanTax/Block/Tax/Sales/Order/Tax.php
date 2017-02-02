<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 * Subtotal Total Row Renderer
 *
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 *
 * @see Mage_Tax_Block_Sales_Order_Tax
 */
class Egovs_GermanTax_Block_Tax_Sales_Order_Tax extends Mage_Tax_Block_Sales_Order_Tax
{
	/**
	 * Sollen Steuern an Preisen angezeigt werden?
	 *
	 * @return boolean
	 */
	protected function _displayTax() {
		return Mage::getStoreConfigFlag('catalog/price/display_block_below_price', $this->getStore());
	}
	
	protected function _initSubtotal() {
		parent::_initSubtotal();
		
		$store  = $this->getStore();
		$parent = $this->getParentBlock();
		$subtotal = $parent->getTotal('subtotal');
		if (!$subtotal || !$this->_displayTax()) {
			return $this;
		}
		if ($this->_config->displaySalesSubtotalExclTax($store)) {
			$subtotal->setLabel($this->__('Subtotal (Excl.Tax)'));
		} elseif ($this->_config->displaySalesSubtotalInclTax($store)) {
			$subtotal->setLabel($this->__('Subtotal (Incl.Tax)'));
		}
		
		return $this;
	}
}