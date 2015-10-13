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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cehckout type abstract class
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
abstract class Sid_Checkout_Model_Type_Abstract extends Mage_Checkout_Model_Type_Abstract
{
	const SHIPPING_DEFAULT = 'freeshipping_freeshipping';
	const PAYMENT_DEFAULT = 'purchaseorder';
	
 	protected $_shippingmethod = null;
	protected $_paymentmethod = null;
	
    public function getCheckoutSession()
    {
        $checkout = $this->getData('sidcheckout_session');
        if (is_null($checkout)) {
            $checkout = Mage::getSingleton('checkout/session');
            $this->setData('sidcheckout_session', $checkout);
        }
        return $checkout;
    }
    
	public function getPaymentMethod() {
		if ($this->_paymentmethod == null) {
			$this->_paymentmethod = Mage::getStoreConfig('sid_checkout/invoice/invoice_paymentmethod');
			if (!is_string($this->_paymentmethod)) {
				$this->_paymentmethod = self::PAYMENT_DEFAULT;
			}
		}
		return $this->_paymentmethod;
	}
	
	public function getShippingMethod() {
		if ($this->_shippingmethod == null) {
			$this->_shippingmethod = Mage::getStoreConfig('sid_checkout/invoice/invoice_shippingmethod');
			if (!is_string($this->_shippingmethod)) {
				$this->_shippingmethod = self::SHIPPING_DEFAULT;
			}
		}
		return $this->_shippingmethod;
	}
	
	protected function removeItemFromAddress($address,Mage_Sales_Model_Quote_Item $item)
	{
		 foreach ($address->getItemsCollection() as $adrItem) 
		 {
		 	if($adrItem->getQuoteItemId() == $item->getItemId())
		 	{
		 		$adrItem->isDeleted(true);
		 		return;
		 	}
		 }
		
		/*
		$address->removeItem($item->getId());
		//$address->removeItem($item->getId())->save();
        //$item->delete()->save();
        $address->getItemsCollection()
        	->removeItemByKey($item->getId())
        	->save();
        $address->unsetData('cached_items_nominal')
        		->unsetData('cached_items_nonominal')
        		->unsetData('cached_items_all')
        		->save();
        		*/
	}
}
