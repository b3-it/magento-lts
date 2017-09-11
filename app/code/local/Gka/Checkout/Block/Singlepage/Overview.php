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
 * @category   Mage
 * @package    Mage_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Multishipping checkout overview information
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Gka_Checkout_Block_Singlepage_Overview extends Mage_Sales_Block_Items_Abstract
{
    /**
     * Get multishipping checkout model
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function getCheckout()
    {
         return Mage::getSingleton('gkacheckout/type_singlepage');
    }

    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(
                Mage::helper('checkout')->__('Checkout Procedure'). " - " .$this->__('Review Order')
            );
        }
        return parent::_prepareLayout();
    }

    public function getBillingAddress()
    {
    	$adr = $this->getCheckout()->getQuote();
        return $this->getCheckout()->getQuote()->getBillingAddress();
    }

    public function getPaymentHtml()
    {
        return $this->getChildHtml('payment_info');
    }

  	public function getItems()
    {
		return $this->getCheckout()->getQuote()->getAllVisibleItems();
    }

    public function getTotals()
    {
        return $this->getCheckout()->getQuote()->getTotals();
    }
    
    
    public function getPayment()
    {
        return $this->getCheckout()->getQuote()->getPayment();
    }
    
    public function isCashPayment()
    {
    	return ($this->getPayment()->getMethod() == 'epaybl_cashpayment');
    }
    
    public function getShippingAddress()
    {
        return $this->getCheckout()->getQuote()->getShippingAddress();
    }

    public function getShippingAddressCount()
    {
        $count = $this->getData('shipping_address_count');
        if (is_null($count)) {
            $count = count($this->getShippingAddresses());
            $this->setData('shipping_address_count', $count);
        }
        return $count;
    }

    public function getShippingAddressRate($address)
    {
        if ($rate = $address->getShippingRateByCode($address->getShippingMethod())) {
            return $rate;
        }
        return false;
    }

    public function getShippingPriceInclTax($address)
    {
        $exclTax = $address->getShippingAmount();
        $taxAmount = $address->getShippingTaxAmount();
        return $this->formatPrice($exclTax + $taxAmount);
    }

    public function getShippingPriceExclTax($address)
    {
        return $this->formatPrice($address->getShippingAmount());
    }

    public function formatPrice($price)
    {
        return $this->getQuote()->getStore()->formatPrice($price);
    }

    public function getShippingAddressItems($address)
    {
        return $address->getAllVisibleItems();
    }

    public function getShippingAddressTotals($address)
    {
        $totals = $address->getTotals();
        foreach ($totals as $total) {
            if ($total->getCode()=='grand_total') {
                if ($address->getAddressType() == Mage_Sales_Model_Quote_Address::TYPE_BILLING) {
                    $total->setTitle($this->__('Total'));
                }
                else {
                    $total->setTitle($this->__('Total for this address'));
                }
            }
        }
        return $totals;
    }

    public function getTotal()
    {
        return $this->getCheckout()->getQuote()->getGrandTotal();
    }


    public function getBackUrl()
    {
        return $this->getUrl('*/singlepage/overview',array('_secure'=>true));
    }

    /**
     * Retrieve virtual product edit url
     *
     * @return string
     */
    public function getVirtualProductEditUrl()
    {
        return $this->getUrl('*/cart',array('_secure'=>true));
    }

    public function getPostActionUrl()
    {
    	return $this->getUrl('*/singlepage/overviewPost',array('_secure'=>true));
    }
    
    
    /**
     * Retrieve virtual product collection array
     *
     * @return array
     */
    public function getVirtualItems()
    {
        $items = array();
        foreach ($this->getBillingAddress()->getItemsCollection() as $_item) {
            if ($_item->isDeleted()) {
                continue;
            }
            if ($_item->getProduct()->getIsVirtual() && !$_item->getParentItemId()) {
                $items[] = $_item;
            }
        }
        return $items;
    }

    /**
     * Retrieve quote
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return $this->getCheckout()->getQuote();
    }

    public function isVirtual()
    {
    	return ($this->getQuote()->isVirtual());
    }
    
    public function isStorePickup()
    {
    	$res = $this->getQuote()->getShippingAddress()->getShippingMethod();
    	return $res ==='storepickup_storepickup';
    }
    
    
    public function getBillinAddressTotals()
    {
        $_address = $this->getQuote()->getBillingAddress();
        return $this->getShippingAddressTotals($_address);
    }


    public function renderTotals($totals)
    {
        $colspan = $this->helper('tax')->displayCartBothPrices() ? 5 : 3;
        return $this->getChild('totals')->setTotals($totals)->renderTotals(-1, $colspan);
    }
    
    public function getBaseAddress()
    {
    	return $this->getCheckout()->getQuote()->getBaseAddress();
    }

    public function getCurrencySymbol()
    {
    	if($this->_CurrencySymbol == null)
    	{
    		$this->_CurrencySymbol =  Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    	}
    	return $this->_CurrencySymbol;
    }
}
