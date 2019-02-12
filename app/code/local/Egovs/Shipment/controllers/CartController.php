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
 * Shopping cart controller
 */
class Egovs_Shipment_CartController extends Mage_Core_Controller_Front_Action
{
   
    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
    	return $this->_getSession()->getQuote();
        //return $this->_getCart()->getQuote();
    }

    public function preDispatch() {
    	//Die Session ID soll nicht neu generiert werden!
    	$this->setFlag('', 'no_regenerate_id', true);
    	return parent::preDispatch();
    }
    
    
    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {
        $returnUrl = $this->getRequest()->getParam('return_url');
        if ($returnUrl) {
            // clear layout messages in case of external url redirect
            if ($this->_isUrlInternal($returnUrl)) {
                $this->_getSession()->getMessages(true);
            }
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()
        ) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            $this->_redirect('checkout/cart');
        }
        return $this;
    }

   
    /**
     * Initialize shipping information
     */
    public function estimatePostAction()
    {
      	$this->_estimate();
        $this->_goBack();
    }

    
    public function estimateAction()
    {
    	$this->_estimate();
    	
    	$this->loadLayout();
    	
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('egovsshipment/cart_estimate')->toHtml()
    	);
    }
    
    
    public function totalsAction()
    {
    	
    	$this->loadLayout();

    	//$block = $this->getLayout()->createBlock('checkout/cart_totals');
    	$block = $this->getLayout()->getBlock('checkout.cart.totals');
    	//$block->setTemplate('checkout/cart/totals.phtml');
    	$this->getResponse()->setBody(
    			$block->toHtml()
    	);
    }
    
    private function _estimate()
    {
    	$quote = $this->_getQuote();
    	$country    = (string) $this->getRequest()->getParam('country_id');
    	$postcode   = (string) $this->getRequest()->getParam('estimate_postcode');
    	$city       = (string) $this->getRequest()->getParam('estimate_city');
    	$regionId   = (string) $this->getRequest()->getParam('region_id');
    	$region     = (string) $this->getRequest()->getParam('region');
    	
    	$quote->getShippingAddress()
    	->setCountryId($country)
    	->setCity($city)
    	->setPostcode($postcode)
    	->setRegionId($regionId)
    	->setRegion($region)
    	->setCollectShippingRates(true)
    	->setQuote($quote)
    	->save();
    	
    	$code = (string) $this->getRequest()->getParam('estimate_method');
    	if(empty($code) && $postcode != null)
    	{
    		$code = $this->getDefaultShippingMethod($quote->getShippingAddress());
    	}
    	if (!empty($code)) {
    		$quote->getShippingAddress()->setShippingMethod($code);///*->collectTotals()*/->save();
    	}
    	
    	$quote->getShippingAddress()->save();
    	
    	
    	if ($quote->getItemsCount()) {
    		$this->_getCart()->save();
    		//$this->_getQuote()->collectTotals();
    	}
    	
    	$quote->save();
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
    
    	if(count($res) > 0) return $res[$max];
    
    	return $groups;
    }
    
    public function getShippingRates($address) {
    	$groups = $address->getGroupedAllShippingRates();
    	/*
    	 if ($this->hasCashpaymentOnly()) {
    	if (array_key_exists('storepickup', $groups)) {
    	return array('storepickup'=>$groups['storepickup']);
    	}
    	Mage::log("Wrong Configuration: cashpayment without storepickup", Zend_Log::ALERT, Egovs_Helper::LOG_FILE);
    	return false;
    	} else */
    	{
    		if (array_key_exists('freeshipping', $groups)) {
    			return array('freeshipping'=>$groups['freeshipping']);
    		}
    	}
    
    
    	return $this->filterRank($groups);
    }
    
    
    public function getDefaultShippingMethod($address = null)
    {
    	
    	if($address != null)
    	{
    		$rates = $this->getShippingRates($address);
    	
    		if(count($rates) == 1)
    		{
    			$rates = array_shift($rates);
    			$rates = $rates[0];
    			return $rates->getCode();
    		}
    	}
    	
    	//else 
    	{
	    	if ($name = Mage::getStoreConfig('shipping/estimate_costs/default_shipping_method')) {
	    		return $name;
	    	}
    	}
    	return null;
    }
    
    /*
    
    public function estimateUpdatePostAction()
    {
        $code = (string) $this->getRequest()->getParam('estimate_method');
        if (!empty($code)) {
            $this->_getQuote()->getShippingAddress()->setShippingMethod($code)
            //->collectTotals()
            ->save();
        }
        $this->_goBack();
    }
*/
        
    
}
