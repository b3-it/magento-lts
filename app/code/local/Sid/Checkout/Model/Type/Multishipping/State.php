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
 * Multishipping checkout state model
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Checkout_Model_Type_Multishipping_State extends Mage_Checkout_Model_Type_Multishipping_State
{

  
    public function __construct()
    {
        parent::__construct();
        $this->_steps = array(
            self::STEP_SELECT_ADDRESSES => new Varien_Object(array(
                'label' => Mage::helper('checkout')->__('Select Addresses')
            )),
        	self::STEP_SHIPPING => new Varien_Object(array(
        		'label' => Mage::helper('checkout')->__('Shipping Information')
        	)),
        	self::STEP_BILLING => new Varien_Object(array(
        		'label' => Mage::helper('checkout')->__('Billing Information')
        	)),
            self::STEP_OVERVIEW => new Varien_Object(array(
                'label' => Mage::helper('checkout')->__('Place Order')
            )),
            self::STEP_SUCCESS => new Varien_Object(array(
                'label' => Mage::helper('checkout')->__('Order Success')
            )),
        );

        foreach ($this->_steps as $step) {
            $step->setIsComplete(false);
        }

        $this->_checkout = Mage::getSingleton('checkout/type_multishipping');
        $this->_steps[$this->getActiveStep()]->setIsActive(true);
    }

 
  

 

    /**
     * Retrieve checkout session
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckoutSession()
    {
        return Mage::getSingleton('checkout/session');
    }
}
