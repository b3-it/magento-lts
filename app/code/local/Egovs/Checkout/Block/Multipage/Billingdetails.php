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
 * Multishipping billing information
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Block_Multipage_Billingdetails extends Mage_Payment_Block_Form_Container
{
    /**
     * Prepare children blocks
     */
    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(
                Mage::helper('checkout')->__('Checkout Procedure'). " - " .Mage::helper('checkout')->__('Billing Information')
            );
        }

        return parent::_prepareLayout();
    }

    
    public function getMethodsForm()
    {
    	$curr = $this->_getPaymentMethode();
    	$methods = parent::getMethods();
    	foreach($methods as $method)
    	{
    		if($method->getCode() == $curr) return $method;
    	}
    	
    	return null;
    }
    
    /**
     * Check and prepare payment method model
     *
     * @return bool
     */
    protected function _canUseMethod($method)
    {
        if (!$method->canUseForMultishipping()) {
            return false;
        }
        return parent::_canUseMethod($method);
    }

    /**
     * Retrieve code of current payment method
     *
     * @return mixed
     */
    public function getSelectedMethodCode()
    {
        if ($method = $this->getQuote()->getPayment()->getMethod()) {
            return $method;
        }
        return false;
    }

    /**
     * Retrieve billing address
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getAddress()
    {
        $address = $this->getData('address');
        if (is_null($address)) {
            $address = Mage::getSingleton('mpcheckout/multipage')->getQuote()->getBillingAddress();
            $this->setData('address', $address);
        }
        return $address;
    }

    private function _getPaymentMethode()
    {
    	return Mage::getSingleton('mpcheckout/multipage')->getPaymentMethod();
    }
    /**
     * Retrieve quote model object
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    /**
     * Retrieve url for select billing address
     *
     * @return string
     */
    public function getSelectAddressUrl()
    {
        return $this->getUrl('*/edit/selectBilling', array('_secure'=>true));
    }

    /**
     * Retrieve data post destination url
     *
     * @return string
     */
    public function getPostActionUrl()
    {
        //return $this->getUrl('*/*/billingPost');
        return $this->getUrl('*/*/overview', array('_secure'=>true));
    }

    /**
     * Retrieve back url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/backToBilling', array('_secure'=>true));
    }
}