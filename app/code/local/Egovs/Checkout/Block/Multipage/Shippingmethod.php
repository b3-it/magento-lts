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
 * Mustishipping checkout shipping
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Block_Multipage_Shippingmethod extends Mage_Sales_Block_Items_Abstract
{
    /**
     * Get multishipping checkout model
     *
     * @return Egovs_Checkout_Model_Multipage
     */
    public function getCheckout()
    {
        return Mage::getSingleton('mpcheckout/multipage');
    }

    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(Mage::helper('checkout')->__('Checkout Procedure'). " - " .Mage::helper('checkout')->__('Shipping Methods'));
        }
        return parent::_prepareLayout();
    }

    public function getAddresses()
    {
        return $this->getCheckout()->getQuote()->getAllShippingAddresses();
    }

    public function getAddressCount()
    {
        $count = $this->getData('address_count');
        if (is_null($count)) {
            $count = count($this->getAddresses());
            $this->setData('address_count', $count);
        }
        return $count;
    }

    public function getAddressItems($address)
    {
        $items = array();
        foreach ($address->getAllItems() as $item) {
            if ($item->getParentItemId()) {
                continue;
            }
            $item->setQuoteItem($this->getCheckout()->getQuote()->getItemById($item->getQuoteItemId()));
            $items[] = $item;
        }
        $itemsFilter = new Varien_Filter_Object_Grid();
        $itemsFilter->addFilter(new Varien_Filter_Sprintf('%d'), 'qty');
        return $itemsFilter->filter($items);
    }

    
    public function getAllShippingMethods()
    {
    	$res = array();
    	foreach ($this->getAddresses() as $_index => $_address)
    	{
	    	$shippingRateGroups = $this->getShippingRates($_address);
	   		foreach ($shippingRateGroups as $code => $_rates)
	   		{
	    		foreach ($_rates as $_rate)
	    		{
	    			$res[] = $_rate->getCode();
	    		}
	    	}
    	}
    	return $res;
    }
    
    
    public function getAddressShippingMethod($address)
    {  	
        $methods =  $address->getShippingMethod();
    	return $methods;
    }

    protected function _canUseMethod($method)
    {
        if (!$method->canUseForCountry($this->getCheckout()->getQuote()->getBillingAddress()->getCountry())) {
            return false;
        }

        if (!$method->canUseForCurrency(Mage::app()->getStore()->getBaseCurrencyCode())) {
            return false;
        }

        /**
         * Checking for min/max order total for assigned payment method
         */
        $total = $this->getCheckout()->getQuote()->getBaseGrandTotal();
        $minTotal = Mage::app()->getLocale()->getNumber($method->getConfigData('min_order_total'));
        $maxTotal = Mage::app()->getLocale()->getNumber($method->getConfigData('max_order_total'));

        if ((!empty($minTotal) && ($total < $minTotal)) || (!empty($maxTotal) && ($total > $maxTotal))) {
            return false;
        }
        return true;
    }
    
    private function hasCashpaymentOnly()
    {
    	/*
    	$customer = $this->getCheckout()->getCustomer();
    	if(isset($customer))
    	{
    		$group= Mage::getSingleton('customer/group')->load($customer->getGroupId());
    		if(isset($group)){
    			$payments = $group->getAllowedPaymentMethods();
    		}
    	}
    	*/
        $store = $this->getCheckout()->getQuote() ? $this->getCheckout()->getQuote()->getStoreId() : null;
        $methods = $this->helper('payment')->getStoreMethods($store, $this->getCheckout()->getQuote());
        $cashpayment = false;
        foreach ($methods as $key => $method) {
                if (($this->_canUseMethod($method))
                	&& get_class($method) == 'Egovs_Cashpayment_Model_PaymentLogic') {
                    $cashpayment = true;
                }
            }
    	//if(!isset($methods)) $methods = array();
    	//$cashpayment = array_search('cashpayment',$methods);
    	
    	return (($cashpayment !== false) && (count($methods)== 1));
    }
    
    public function getShippingRates($address) {
        $groups = $address->getGroupedAllShippingRates();
        if ($this->hasCashpaymentOnly()) {
        	if (array_key_exists('storepickup', $groups)) {
        		return array('storepickup'=>$groups['storepickup']);
        	}
        	Mage::log("Wrong Configuration: cashpayment without storepickup", Zend_Log::ALERT, Egovs_Helper::LOG_FILE);
         	//Mage::throwException(Mage::helper('mpcheckout')->__('Falsche Konfiguration!'));
			return false;
        } else {
        	if (array_key_exists('freeshipping', $groups)) {
        		return array('freeshipping'=>$groups['freeshipping']);
        	}
        }
        
       	
        return $this->filterRank($groups);
    }

    
    private function filterRank($groups)
    {
    	$res = array();
    	$max = 0;
    	foreach ($groups as $key=>$value) {
    		$rank = Mage::getStoreConfig('carriers/'.$key.'/rank');
    		if(!$rank) $rank = 0;
    		if(!isset($res[$rank])) $res[$rank] = array();
    		$res[$rank][$key]= $value;
    		if($rank > $max) $max = $rank;
    	}
    	
    	if (count($res) > 0 && (isset($res[$max]))){
    		return $res[$max];
    	}
    	
    	return $groups;
    }
    
    
    public function getCarrierName($carrierCode)
    {
        if ($name = Mage::getStoreConfig('carriers/'.$carrierCode.'/title')) {
            return $name;
        }
        return $carrierCode;
    }

    public function getAddressEditUrl($address)
    {
        return $this->getUrl('*/edit/editShipping', array('id'=>$address->getCustomerAddressId(),'_secure'=>true));
    }

    public function getItemsEditUrl()
    {
        return $this->getUrl('*/*/backToAddresses', array('_secure'=>true));
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/shippingmethodPost', array('_secure'=>true));
    }

    public function getBackUrl()
    {
    	$data = Mage::getSingleton('customer/session')->getData('use_for_shipping');
    	
    	if (isset($data) && $data == 0) {
        	return $this->getUrl('*/*/backtoshipping', array('_secure'=>true));
    	}
        return $this->getUrl('*/*/backtoaddresses', array('_secure'=>true));
    }

    /**
     * @param $address      Address
     * @param $price        Price
     * @param $includingTax Including Tax
     *
     * @return mixed
     */
    public function getShippingPrice($address, $price, $includingTax) {
    	$price = $this->_getShippingPrice($price, $includingTax, $address);
        return $address->getQuote()->getStore()->convertPrice($price, true);
    }
    
	/**
     * Get shipping price
     *
     * @return float
     * 
     * @see Mage_Tax_Helper_Data::getShippingPrice
     */
    protected function _getShippingPrice($price, $includingTax = null, $shippingAddress = null, $ctc = null, $store = null) {
        $pseudoProduct = new Varien_Object();
        $shippingTaxClass = Mage::helper('tax')->getShippingTaxClass($store);
        if (Mage::helper('core')->isModuleEnabled('Egovs_GermanTax')) {
        	$shippingTaxClass = Mage::getSingleton('germantax/calculation')->getShippingTaxClass($shippingTaxClass, $shippingAddress);
        } elseif (Mage::helper('core')->isModuleEnabled('Egovs_ShippingTax')) {
        	$shippingTaxClass = Mage::getSingleton('egovs_shippingtax/calculation')->getShippingTaxClass($shippingTaxClass, $shippingAddress);
        }
        
        $pseudoProduct->setTaxClassId($shippingTaxClass);

        $billingAddress = false;
        if ($shippingAddress && $shippingAddress->getQuote() && $shippingAddress->getQuote()->getBillingAddress()) {
            $billingAddress = $shippingAddress->getQuote()->getBillingAddress();
        }

        $price = Mage::helper('tax')->getPrice(
            $pseudoProduct,
            $price,
            $includingTax,
            $shippingAddress,
            $billingAddress,
            $ctc,
            $store,
            Mage::helper('tax')->shippingPriceIncludesTax($store)
        );
        return $price;
    }
}
