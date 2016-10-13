<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Ready
 * @name            Egovs_Ready_Block_Checkout_Cart_Cartinfo
 * @author          Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright       Copyright (c) 2010 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license         http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Ready_Block_Checkout_Cart_Cartinfo extends Mage_Core_Block_Template
{
    public function getOrderUrl() {
    	if (!Mage::getStoreConfig('checkout/cart/orderurl')) {
    		return null;
    	}
    	return Mage::getUrl(Mage::getStoreConfig('checkout/cart/orderurl'));
    }
    
    public function getRevocationUrl() {
    	if (!Mage::getStoreConfig('checkout/cart/revocationurl')) {
    		return null;
    	}
    	return Mage::getUrl(Mage::getStoreConfig('checkout/cart/revocationurl'));
    }
}
