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
class Egovs_Checkout_Block_Multipage_Newshipping extends Egovs_Checkout_Block_Multipage_Abstract
{
	private $_address = null;
	
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

   public function getShippingtext()
    {
    	return Mage::getModel('mpcheckout/adrtext')->getShippingtext();
    }
    
   public function getAddress()
    {
    	if($this->_address != null) return $this->_address;
    	$res = null;
    	
        if (!$this->isCustomerLoggedIn()) {
            $res = $this->getQuote()->getShippingAddress();
        } else {
            $res = Mage::getModel('sales/quote_address');
        }
        
        $postdata = Mage::getSingleton('customer/session')->getData('shippingaddresspostdata');
        if(($postdata != null) && is_array($postdata))
        {
	        $keys = array_keys($postdata);
	        foreach ($keys as $key)
	        {
	        	//if($res->getData($key)== null) 
	        	$res->setData($key,$postdata[$key]);
	        }
        }
        Mage::getSingleton('customer/session')->unsetData('shippingaddresspostdata');
        $this->_address = $res;
        
        return $res;
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

    public function getAddressShippingMethod($address)
    {
        return $address->getShippingMethod();
    }

    public function getShippingRates($address)
    {
        $groups = $address->getGroupedAllShippingRates();
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
        return $this->getUrl('*/edit/editShipping', array('id'=>$address->getCustomerAddressId()));
    }

    public function getItemsEditUrl()
    {
        return $this->getUrl('*/*/backToAddresses');
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/shippingPost', array('_secure'=>true));
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/*/backtoaddresses', array('_secure'=>true));
    }

    public function getShippingPrice($address, $price, $flag)
    {
        return $address->getQuote()->getStore()->convertPrice($this->helper('tax')->getShippingPrice($price, $flag, $address), true);
    }
    
    
 	public function isFieldRequired($key, $method = null)
    {
    	
    	return parent::isFieldRequired($key,'shipping');
    }
}
