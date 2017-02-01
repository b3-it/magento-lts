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
 * @see Mage_Tax_Block_Checkout_Subtotal
 */
class Egovs_GermanTax_Block_Checkout_Subtotal extends Mage_Tax_Block_Checkout_Subtotal
{
	/**
	 *  Template for the block
	 *
	 * @var string
	 */
	protected $_template = 'egovs/germantax/tax/checkout/subtotal.phtml';
	
	/**
	 * Liefert die Konfiguration für Steuern
	 * 
	 * @return Mage_Tax_Model_Config
	 */
	public function getConfig() {
		return Mage::getSingleton('tax/config');
	}
    
	/**
	 * Sollen Steuern an Preisen angezeigt werden?
	 * 
	 * @return boolean
	 */
    public function displayTax() {
    	return Mage::getStoreConfigFlag('catalog/price/display_block_below_price', $this->getStore());
    }
    
    /**
     * Soll die Zwischensumme zzgl. Steuern angezeigt werden?
     *
     * @return boolean
     */
    public function displayExclTax() {
    	return $this->getConfig()->displayCartSubtotalExclTax($this->getStore()) && $this->displayTax();
    }
    
    /**
     * Soll die Zwischensumme inkl. Steuern angezeigt werden?
     *
     * @return boolean
     */
    public function displayInclTax() {
    	return $this->getConfig()->displayCartSubtotalInclTax($this->getStore()) && $this->displayTax();
    }
}
