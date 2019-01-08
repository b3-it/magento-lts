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
 * Checkout url helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Helper_Url extends Mage_Core_Helper_Url
{
    /**
     * Retrieve shopping cart url
     *
     * @return string
     */
    public function getCartUrl()
    {
        return $this->_getUrl('checkout/cart', array('_secure' => $this->_getRequest()->isSecure()));
    }


    /**
     * Multi Shipping (MS) checkout urls
     */

    /**
     * Retrieve multishipping checkout url
     *
     * @return string
     */
    public function getMSCheckoutUrl()
    {
        return $this->_getUrl('checkout/multishipping');
    }

    public function getMPLoginUrl()
    {
        return $this->_getUrl('egovs_checkout/multipage/login', array('_secure'=>true, '_current'=>true));
    }

    public function getMPAddressesUrl()
    {
        return $this->_getUrl('egovs_checkout/multipage/addresses');
    }

    public function getMPShippingAddressSavedUrl()
    {
        return $this->_getUrl('egovs_checkout/multipage_address/shippingSaved');
    }

    public function getMPRegisterUrl()
    {
        return $this->_getUrl('egovs_checkout/multipage/register');
    }

    /**
     * One Page (OP) checkout urls
     */
    public function getOPCheckoutUrl()
    {
        return $this->_getUrl('checkout/onepage');
    }


    public function getCheckoutAddress()
    {
    	if(Mage::getStoreConfig('checkout/options/checkout_type') == Egovs_Checkout_Model_Checkouttype::TYPE_ONEPAGE)
    	{
    		return 'checkout/onepage';
    	}

    	return 'egovs_checkout/multipage';
    }

    public function getCheckoutUrl()
    {
    	return $this->_getUrl($this->getCheckoutAddress(), array('_secure'=>true, '_current'=>true));
    }

}
