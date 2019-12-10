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
class Gka_Checkout_Model_Type_Singlepage_State extends Mage_Checkout_Model_Type_Multishipping_State
{

  
	const STEP_START 			= 'singlepage_addresses';
	//const STEP_SHIPPING         = 'singlepage_shipping';
	//const STEP_BILLING          = 'singlepage_billing';
	const STEP_OVERVIEW         = 'singlepage_overview';
	const STEP_SUCCESS          = 'singlepage_success';
	
	
	
	
    public function __construct()
    {
        
        $this->_steps = array(
            self::STEP_START => new Varien_Object(array(
                'label' => Mage::helper('checkout')->__('Addresses')
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

        $this->_checkout = Mage::getSingleton('gkacheckout/type_singlepage');
        $this->_steps[$this->getActiveStep()]->setIsActive(true);
    }
    
    public function getActiveStep()
    {
    	$step = $this->getCheckoutSession()->getCheckoutState();
    	if (isset($this->_steps[$step])) {
    		return $step;
    	}
    	return self::STEP_START;
    }
    
    
    public function resetState()
    {
    	
    	foreach ($this->_steps as $step) {
    		$step->setIsComplete(false);
    		$step->setIsActive(false);
    	}
    	$this->_steps[self::STEP_START]->setIsActive(true);
    	return $this;
    }
    
    public function next($next, $current = null)
    {
    	if($current == null){
    		$current = $this->getActiveStep();
    	}
    	if(isset($this->_steps[$current]) && (($this->_steps[$current]->getIsActive())) ){
    		
    		$this->_steps[$current]
    			->setIsActive(false)
    			->setIsComplete(true);
    		
    		$this->_steps[$next]
    			->setIsActive(true)
    			->setIsComplete(false);
    	
    	}
    	
    	throw new Exception('Wrong State!');
    	
    }

}