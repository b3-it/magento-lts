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
 * Multishipping checkout state model
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Model_State extends Varien_Object
{
    const STEP_ADDRESS 			= 'multipage_addresses';
    const STEP_SHIPPING         = 'multipage_shipping';
    const STEP_SHIPPING_DETAILS = 'multipage_shipping_details';
    const STEP_BILLING          = 'multipage_billing';
    const STEP_BILLING_DETAILS  = 'multipage_billing_details';
    const STEP_OVERVIEW         = 'multipage_overview';
    const STEP_SUCCESS          = 'multipage_success';

    /**
     * Allow steps array
     *
     * @var array
     */
    protected $_steps;

    /**
     * Checkout model
     *
     * @var Mage_Checkout_Model_Type_Multishipping
     */
    protected $_checkout;

    /**
     * Init model, steps
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_steps = array(
            self::STEP_ADDRESS => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Select Address')
            )),
            self::STEP_SHIPPING => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Shipping Information')
            )),
            self::STEP_SHIPPING_DETAILS => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Shipping Methods')
            )),
            self::STEP_BILLING => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Payment Method')
            )),
            self::STEP_BILLING_DETAILS => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Payment Information')
            )),
            self::STEP_OVERVIEW => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Place Order')
            )),
            self::STEP_SUCCESS => new Varien_Object(array(
                'label' => Mage::helper('mpcheckout')->__('Order Success')
            )),
        );

        foreach ($this->_steps as $step) {
            $step->setIsComplete(false);
        }

        $this->_checkout = Mage::getSingleton('mpcheckout/multipage');
        $this->_steps[$this->getActiveStep()]->setIsActive(true);
    }

    /**
     * Retrieve checkout model
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function getCheckout()
    {
        return $this->_checkout;
    }

    /**
     * Retrieve available checkout steps
     *
     * @return array
     */
    public function getSteps()
    {
        return $this->_steps;
    }

    /**
     * Retrieve active step code
     *
     * @return string
     */
    public function getActiveStep()
    {
        $step = $this->getCheckoutSession()->getCheckoutState();
        if (isset($this->_steps[$step])) {
            return $step;
        }
        return self::STEP_ADDRESS;
    }

    public function setActiveStep($step)
    {
        if (isset($this->_steps[$step])) {
            $this->getCheckoutSession()->setCheckoutState($step);
        }
        else {
            $this->getCheckoutSession()->setCheckoutState(self::STEP_ADDRESS);
        }

        // Fix active step changing
        if(!$this->_steps[$step]->getIsActive()) {
            foreach($this->getSteps() as $stepObject) {
                $stepObject->unsIsActive();
            }
            $this->_steps[$step]->setIsActive(true);
        }
        return $this;
    }

    /**
     * Mark step as completed
     *
     * @param string $step
     * @return Mage_Checkout_Model_Type_Multishipping_State
     */
    public function setCompleteStep($step)
    {
        if (isset($this->_steps[$step])) {
            $this->getCheckoutSession()->setStepData($step, 'is_complete', true);
        }
        return $this;
    }

    /**
     * Retrieve step complete status
     *
     * @param string $step
     * @return bool
     */
    public function getCompleteStep($step)
    {
        if (isset($this->_steps[$step])) {
            return $this->getCheckoutSession()->getStepData($step, 'is_complete');
        }
        return false;
    }

    /**
     * Unset complete status from step
     *
     * @param string $step
     * @return Mage_Checkout_Model_Type_Multishipping_State
     */
    public function unsCompleteStep($step)
    {
        if (isset($this->_steps[$step])) {
            $this->getCheckoutSession()->setStepData($step, 'is_complete', false);
        }
        return $this;
    }

    public function canSelectAddresses()
    {

    }

    public function canInputShipping()
    {

    }

    public function canSeeOverview()
    {

    }

    public function canSuccess()
    {

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
