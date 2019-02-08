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


class Egovs_Checkout_Model_Multipage extends Mage_Checkout_Model_Type_Abstract
{
	private $_paymentmethod = null;
	
    /**
     * Enter description here...
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Enter description here...
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return $this->getCheckout()->getQuote();
    }

    
   	public function validateMinimumAmount()
    {
        return !(Mage::getStoreConfigFlag('sales/minimum_order/active')
            && Mage::getStoreConfigFlag('sales/minimum_order/multi_address')
            && !$this->getQuote()->validateMinimumAmount());
    }
    
    
    /**
     * Enter description here...
     *
     * @return Mage_Checkout_Model_Type_Onepage
     */
    public function initCheckout()
    {
        $checkout = $this->getCheckout();
        if (is_array($checkout->getStepData())) {
            foreach ($checkout->getStepData() as $step=>$data) {
                if ($step !== 'login' && (!Mage::getSingleton('customer/session')->isLoggedIn() || $step !== 'billing')) {
                    $checkout->setStepData($step, 'allow', false);
                }
            }
        }
        /*
        * want to laod the correct customer information by assiging to address
        * instead of just loading from sales/quote_address
        */
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if ($customer) {
            $this->getQuote()->assignCustomer($customer);
        }
        if ($this->getQuote()->getIsMultiShipping()) {
            $this->getQuote()->setIsMultiShipping(false);
            
        }
        $this->getQuote()->getShippingAddress()->setSameAsBilling(true);
        $this->getQuote()->save();
        return $this;
    }

    /**
     * Enter description here...
     *
     * @param string $method
     * @return array
     */
    public function saveCheckoutMethod($method)
    {
        if (empty($method)) {
        	Mage::throwException(Mage::helper('checkout')->__('Invalid data'));
           return;
        }

        $this->getQuote()->setCheckoutMethod($method)->save();
        $this->getCheckout()->setStepData('billing', 'allow', true);
        return array();
    }
    
  	public function getCheckoutMethod()
    {
        
        return $this->getQuote()->getCheckoutMethod();
  
    }
    
  /**
     * Retrieve customer session vodel
     *
     * @return Mage_Customer_Model_Session
     */
    public function getCustomerSession()
    {
        $customer = $this->getData('customer_session');
        if (is_null($customer)) {
            $customer = Mage::getSingleton('customer/session');
            $this->setData('customer_session', $customer);
        }
        return $customer;
    }

    /**
     * Retrieve customer object
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        return $this->getCustomerSession()->getCustomer();
    }
    
    public function customerHasAddresses()
    {
        return count($this->getCustomer()->getAddresses());
    }
    
 	public function getCustomerDefaultBillingAddress()
    {
        $address = $this->getData('customer_default_billing_address');
        if (is_null($address)) {
            $address = $this->getCustomer()->getDefaultBillingAddress();
            $this->setData('customer_default_billing_address', $address);
        }
        return $address;
    }
    
 /**
     * Retrieve customer default shipping address
     *
     * @return Mage_Customer_Model_Address || false
     */
    public function getCustomerDefaultShippingAddress()
    {
        $address = $this->getData('customer_default_shipping_address');
        if (is_null($address)) {
            $address = $this->getCustomer()->getDefaultShippingAddress();
            if (!$address) {
                foreach ($this->getCustomer()->getAddresses() as $address) {
                    if($address){
                        break;
                    }
                }
            }
            $this->setData('customer_default_shipping_address', $address);
        }
        return $address;
    }
    

    /**
     * Enter description here...
     *
     * @param int $addressId
     * @return Mage_Customer_Model_Address
     */
    public function getAddress($addressId)
    {
        $address = Mage::getModel('customer/address')->load((int)$addressId);
        $address->explodeStreetAddress();
        if ($address->getRegionId()) {
            $address->setRegion($address->getRegionId());
        }
        return $address;
    }

    /**
     *
     * @param array $data
     * @param integer $customerAddressId
     * 
     * @return boolean|string
     */
    public function saveBilling($data, $customerAddressId) {
		if (empty ( $data )) {
			Mage::throwException ( Mage::helper ( 'checkout' )->__ ( 'Invalid data' ) );
		}
		
		// der country_id darf nicht NULL sein
		if (isset ( $data ['use_for_shipping'] ) && $data ['use_for_shipping'] == 2) {
			if (! isset ( $data ['country_id'] ))
				$data ['country_id'] = "DE";
		}
		
		$address = $this->getQuote ()->getBillingAddress ();
		$this->getQuote ()->setData ( 'use_for_shipping', $data ['use_for_shipping'] );
		if ((! empty ( $customerAddressId ))) {
			$customerAddress = Mage::getModel ( 'customer/address' )->load ( $customerAddressId );
			if ($customerAddress->getId ()) {
				if ($customerAddress->getCustomerId () != $this->getQuote ()->getCustomerId ()) {
					return Mage::helper ( 'checkout' )->__ ( 'Customer Address is not valid.' );
				}
				
				if (isset ( $data ['use_for_shipping'] ) && $data ['use_for_shipping'] == 1 && ! $this->isVirtual ()) {
					$shippingAddress = $this->getQuote ()->getAddressByCustomerAddressId ( $customerAddressId );
					if ($shippingAddress && $shippingAddress->getVatId()) {
						$this->_validateAddressVat ( $shippingAddress );
					}
					$adrdata = $customerAddress->getData ();
					$addressValidation = Mage::getModel ( 'mpcheckout/validateadr' )->validateShippingAddress ( $adrdata );
					if ($addressValidation !== true) {
						return $addressValidation;
					}
				}
				
				$address->importCustomerAddress ( $customerAddress );
			}
		} else {
			unset ( $data ['address_id'] );
			$data ['customer_address_id'] = null;
			if (! $this->getQuote ()->isVirtual ()) {
				if (isset ( $data ['use_for_shipping'] ) && $data ['use_for_shipping'] == 1) {
					$addressValidation = Mage::getModel ( 'mpcheckout/validateadr' )->validateShippingAddress ( $data );
					if ($addressValidation !== true) {
						return $addressValidation;
					}
				}
			}
			
			if (isset ( $data ['use_for_shipping'] ) && $data ['use_for_shipping'] == 2) {
				$addressValidation = Mage::getModel ( 'mpcheckout/validateadr' )->validatePickupAddress ( $data );
				if ($addressValidation !== true) {
					return $addressValidation;
				}
			} elseif (($validateRes = $this->validateAddress ( $data )) !== true) {
				Mage::throwException ( $validateRes );
			}
			
			if (isset ( $data ['year'] ) && isset ( $data ['month'] ) && isset ( $data ['day'] )) {
				$data ['dob'] = $data ['year'] . '-' . $data ['month'] . '-' . $data ['day'];
			}

			// try to reset with new address object
			$address->importCustomerAddress(Mage::getModel('customer/address'));
			$address->setEmail(null);
			$address->setSaveInAddressBook(null);

			$address->addData($data);
		}
		
		$address->implodeStreetAddress();
		
		if (! $this->getQuote ()->getCustomerId () && Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER == $this->getQuote ()->getCheckoutMethod ()) {
			if ($this->_customerEmailExists ( $address->getEmail (), Mage::app ()->getWebsite ()->getId () )) {
				$tmp = Mage::helper ( 'checkout' )->__ ( 'There is already a customer registered using this email address' ) . '<br/>';
				$tmp .= '<a href="' . Mage::helper ( 'mpcheckout' )->getLoginUrl () . '">' . Mage::helper ( 'checkout' )->__ ( 'Do you can login here.' ) . '</a><br/>';
				$tmp .= '<a href="' . Mage::helper ( 'mpcheckout' )->getForgotPwdUrl () . '">' . Mage::helper ( 'mpcheckout' )->__ ( 'Forgot your password?' ) . '</a>';
				
				Mage::throwException ( $tmp );
			}
		}
		
		if (! $this->getQuote ()->isVirtual ()) {
			/**
			 * Billing address using otions
			 */
			$usingCase = isset ( $data ['use_for_shipping'] ) ? ( int ) $data ['use_for_shipping'] : 0;
			
			switch ($usingCase) {
				case 0 : // billing != shipping
					$shipping = $this->getQuote ()->getShippingAddress ();
					$shipping->setSameAsBilling ( 0 );
					break;
				case 1 : // billing == shipping
					$billing = clone $address;
					$billing->unsAddressId ()->unsAddressType ();
					$shipping = $this->getQuote ()->getShippingAddress ();
					$shippingMethod = $shipping->getShippingMethod ();
					$shipping->addData ( $billing->getData () )->setSameAsBilling ( 1 )->setShippingMethod ( $shippingMethod )->setCollectShippingRates ( true );
					$this->getCheckout ()->setStepData ( 'shipping', 'complete', true );
					break;
				case 2 : // selbstabholung
					$billing = clone $address;
					$billing->unsAddressId ()->unsAddressType ();
					$shipping = $this->getQuote ()->getShippingAddress ();
					$shippingMethod = $shipping->getShippingMethod ();
					$shipping->addData ( $billing->getData () )->setSameAsBilling ( 1 )->setShippingMethod ( $shippingMethod )->setCollectShippingRates ( true );
					$this->getCheckout ()->setStepData ( 'shipping', 'complete', true );
					break;
			}
		}
		
		$this->_processValidateCustomer ( $address );
		
		/*
		 * 20150924::Frank Rochlitzer
		 * Stammadresse für Gäste und neu zu registrienden Kunden setzen!
		 */
		if (!$customerAddressId && !$this->getQuote()->getCustomerId()) {
			$baseAddress = $this->getQuote()->getBaseAddress();
			if ($baseAddress) {
				$baseAddressTmp = clone $address;
				$baseAddressTmp->unsAddressId ()->unsAddressType();
				$baseAddress->addData($baseAddressTmp->getData());
			}
		}
		
		
		$this->getQuote ()->collectTotals ();
		/**
		 * 20161202::Muss doppelt aufgerufen werden um StaLA Discounts korrekt für Versand zu berechnen!
		 * @see Mage_Checkout_Model_Cart::save
		 */
		$this->getQuote()->getBillingAddress();
		$this->getQuote()->getShippingAddress()->setCollectShippingRates(true);
		$this->getQuote()->setTotalsCollectedFlag(false);
		$this->getQuote()->collectTotals();
		$this->getQuote ()->save ();
		
		Mage::dispatchEvent ( 'egovs_mpcheckout_billing_address_set', array (
				'quote' => $this->getQuote () 
		) );
		
		$this->getCheckout ()->setStepData ( 'billing', 'allow', true )->setStepData ( 'billing', 'complete', true )->setStepData ( 'shipping', 'allow', true );
		
		return true;
	}
	
	/**
	 * Validate customer data and set some its data for further usage in quote
	 * Will return either true or array with error messages
	 *
	 * @param Mage_Sales_Model_Quote_Address $address        	
	 * @return true|array
	 */
	protected function _processValidateCustomer(Mage_Sales_Model_Quote_Address $address) {
		/* @var $customerForm Mage_Customer_Model_Form */
		$customerForm = Mage::getModel('customer/form');
				
		// set customer date of birth for further usage
		$dob = '';
		if ($address->getDob ()) {
			
			try {
				$dob = $address->getDob (); // Mage::app()->getLocale()->date($address->getDob(), null, null, false)->toString('yyyy-MM-dd');
				if (! Zend_Date::isDate ( $dob, 'yyyy-MM-dd' )) {
					Mage::throwException ( Mage::helper ( 'mpcheckout' )->__ ( 'Invalid Date of Birthday!' ) );
				} else {
					$ZDate = new Zend_Date ();
					$ZDate->setDate ( $dob, 'yyyy-MM-dd' );
					$ZMinDate = new Zend_Date ();
					$ZMinDate->setDate ( '1900-01-01', 'yyyy-MM-dd' );
					if (($ZDate->getTimestamp () < $ZMinDate->getTimestamp ()) || ($ZDate->getTimestamp () > Zend_Date::now ()->getTimestamp ())) {
						Mage::throwException ( Mage::helper ( 'mpcheckout' )->__ ( 'Invalid Date of Birthday!' ) );
					}
				}
			} catch ( Exception $ex ) {
				if ((strlen ( $dob ) > 2) || (Mage::getStoreConfig ( 'customer/address/dob_show' ) == 'req')) {
					Mage::throwException ( Mage::helper ( 'mpcheckout' )->__ ( 'Invalid Date of Birthday!' ) );
				}
			}
			
			$this->getQuote ()->setCustomerDob ( $dob );
		}
		
		$baseAddress = $this->getQuote ()->getBaseAddress ();
		if ($baseAddress && $baseAddress->getVatId() && $this->getQuote ()->hasVirtualItems ()) {
			$this->_validateAddressVat ( $baseAddress );
		}
		
		// invoke customer model, if it is registering
		if (Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER == $this->getQuote ()->getCheckoutMethod ()) {
			$customerForm->setFormCode('checkout_register')
				->setIsAjaxRequest(Mage::app()->getRequest()->isAjax())
			;
			$customer = Mage::getModel ( 'customer/customer' );
			$customerForm->setEntity($customer);
			$customerRequest = $customerForm->prepareRequest($address->getData());
			$customerData = $customerForm->extractData($customerRequest);
			// set customer password hash for further usage
			$this->getQuote ()->setPasswordHash ( $customer->encryptPassword ( $address->getCustomerPassword () ) );
			
			$customerErrors = $customerForm->validateData($customerData);
			if ($customerErrors !== true) {
				$message = implode(', ', $customerErrors);
				Mage::throwException($message);
			}
			
			$customerForm->compactData($customerData);
			
			// set customer password
			$customer->setPassword($customerRequest->getParam('customer_password'));
			$customer->setPasswordConfirmation($customerRequest->getParam('confirm_password'));
			
			$validationResult = $customer->validate ();
			
			if (true !== $validationResult && is_array ( $validationResult )) {
				$validationResult = implode ( ' ', $validationResult );
				Mage::throwException ( $validationResult );
			}
		} elseif (Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST == $this->getQuote ()->getCheckoutMethod ()) {
			if ($this->isFieldRequired ( 'email' )) {
				$email = $address->getData ( 'email' );
				if (! Zend_Validate::is ( $email, 'EmailAddress' )) {
					Mage::throwException ( Mage::helper ( 'checkout' )->__ ( 'Invalid email address "%s"', $email ) );
				}
			}
		}
		
		return true;
	}
    
    /**
     * Validiert die VAT an der Adresse
     * 
     * @param Mage_Sales_Model_Quote_Address $address Adresse deren VAT validiert werden soll
     * 
     * @return Egovs_Checkout_Model_Multipage
     */
    protected function _validateAddressVat(Mage_Sales_Model_Quote_Address $address) {
    	if (!$address) {
    		return $this;
    	}
    	
    	if ($address->getVatIsValid()) {
    		return $this;
    	}
    	$customer = $this->getQuote()->getCustomer();
    	//$customer = Mage::getModel('customer/customer')->load($address->getCustomerId());
    	 
    	if ($customer) {
    		//Ist nur gesetzt wenn neue Adresse angelegt wird!
    		//Taxvat wurde nur in Customer gespeichert, mit GermanTax (Base-Modul) wird sie nur noch in Adresse gespeichert.
    		if ($address->getVatId()) {
    			// set customer tax/vat number for further usage
    			$this->getQuote()->setCustomerTaxvat($address->getVatId());
    			//Wenn die Customer-Taxvat der Adresse gesetzt ist und mit Customer-taxvat übereinstimmt und das Land übereinstimmt,
    			//ist sie auf jeden Fall schon einmal validiert worden!
    			if ($customer->getTaxvat() === $address->getVatId() && stripos(trim($address->getVatId()), $address->getCountryId()) === 0) {
    				$address->setTaxvatValid(true);
    				$customer->setTaxvatValid(true);
    			}
    			//Falls in Adresse neue Taxvat gesetzt wird
    			if ($customer->getTaxvat() !== $address->getVatId() ) {
    				//Es gibt nur eine taxvat am Customer-Object
    				$customer->setTaxvat($address->getVatId());
    			}
    		}
    		 
    		if (($address->getVatId())
    			&& !$address->getVatIsValid()
    			&& Mage::helper('core')->isCountryInEU($address->getCountryId())
    			&& Mage::helper('customer/address')->isVatValidationEnabled($customer->getStore())
    		) {
    			/* @var $customerHelper Mage_Customer_Helper_Data */
				$customerHelper = Mage::helper('customer');

				$result = $customerHelper->checkVatNumber(
						$address->getCountryId(),
						$address->getVatId()
				);
	
				if (Mage::helper('core')->isModuleEnabled('Egovs_Vies')) {
					if (!Mage::app()->getStore()->isAdmin()) {
						$validationMessage = Mage::helper('customer')->getVatValidationUserMessage($address, $customer->getDisableAutoGroupChange(), $result);
						$errorGroup = Mage::getStoreConfig(Mage_Customer_Helper_Data::XML_PATH_CUSTOMER_VIV_ERROR_GROUP);
						if (!$validationMessage->getIsError()) {
							//Mage::getSingleton('customer/session')->addSuccess($validationMessage->getMessage());
							$address->setVatIsValid(true);
							$customer->setTaxvatValid(true);
						} elseif (empty($errorGroup)) {
							//Mage::getSingleton('customer/session')->addError($validationMessage->getMessage());
							$type = 'base';
							if ($address->getAddressType() != 'base_address') {
								$type = $address->getAddressType();
							}
							$text = Mage::helper('checkout')->__("Vat for $type address not valid or could not be validated!");
							$text .= " " . Mage::helper('checkout')->__("Please check and modify your VAT or try again later.");
							if (class_exists('Egovs_Vies_Model_Resource_Exception_VatNotValid')) {
								throw new Egovs_Vies_Model_Resource_Exception_VatNotValid($text);
							} else {
								Mage::throwException($text);
							}
						}
					}
				}
    		}
    	}
    	return $this;
    }

    public function saveShipping($data, $customerAddressId)
    {
    	/*
        if (empty($data)) {
        	 Mage::throwException(Mage::helper('checkout')->__('Customer Address is not valid.'));
        	 return;
        }
        */
        $address = $this->getQuote()->getShippingAddress();

		if (!empty($customerAddressId)) {
            $customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
            if ($customerAddress->getId()) {
                if ($customerAddress->getCustomerId() != $this->getQuote()->getCustomerId()) {
                	 Mage::throwException(Mage::helper('checkout')->__('Customer Address is not valid.'));
                   	return;
                }
                $address->importCustomerAddress($customerAddress);
            }
           
        } else {
            unset($data['address_id']);
            $data ['customer_address_id'] = null;
            //damit alle Felder der Adresse bei addData überschrieben werden können müssen auch alle da sein
            $eav = Mage::getModel('eav/entity_type')->loadByCode('customer_address');
            $attributes = $eav->getAttributeCollection();
            foreach ( $attributes as $attribute)
            {
            	if(!isset($data[$attribute->getAttributeCode()]))
            	{
            		//im Zweifel null
            		$data[$attribute->getAttributeCode()]=null;
            	}
            }
            
         	$addressValidation = Mage::getModel('mpcheckout/validateadr')
            ->validateShippingAddress($data);
             if ($addressValidation !== true) {
                Mage::throwException($addressValidation);
            }

            // try to reset with new address object
            $address->importCustomerAddress(Mage::getModel('customer/address'));
            $address->setEmail(null);
            $address->setSaveInAddressBook(null);

            $address->addData($data);
        }
        $address->implodeStreetAddress();
        $address->setCollectShippingRates(true);

        /*
        if (($validateRes = $address->validate())!==true) {
          if(is_array($validateRes)) $validateRes = implode(',',$validateRes);
        	Mage::throwException($validateRes);
        	return;
        }
*/
        $this->_validateAddressVat($address);
        $this->getQuote()->collectTotals()->save();

         Mage::dispatchEvent('egovs_mpcheckout_shipping_address_set', array('quote'=>$this->getQuote()));
      
        
        $this->getCheckout()
            ->setStepData('shipping', 'complete', true)
            ->setStepData('shipping_method', 'allow', true);

        return array();
    }

    public function saveShippingMethod($shippingMethod)
    {
        if (empty($shippingMethod)) {
        	Mage::throwException(Mage::helper('checkout')->__('Please select a shipping method!'));
        }
        

        
       
     	if($shippingMethod != 'storepickup_storepickup')
        {
          	$rate = $this->getQuote()->getShippingAddress()->getShippingRateByCode($shippingMethod);
	        if (!$rate) {
	        	Mage::throwException(Mage::helper('checkout')->__('Please select a shipping method!'));
	        }
	        $data = $this->getQuote()->getShippingAddress()->getData();
            $addressValidation = Mage::getModel('mpcheckout/validateadr')
            ->validateShippingAddress($data);
             if ($addressValidation !== true) {
                Mage::throwException($addressValidation);
            }
           
        }
        
        
        
        $this->getQuote()->getShippingAddress()->setShippingMethod($shippingMethod);
        $this->getQuote()->collectTotals()->save();

        $this->getCheckout()
            ->setStepData('shipping_method', 'complete', true)
            ->setStepData('payment', 'allow', true);

        return array();
    }

    
    public function getShippingAddress()
    {
    	return $this->getQuote()->getShippingAddress();
    }
    
    public function setPaymentMethod($payment = null)
    {
        if (!$payment) {
            Mage::throwException(Mage::helper('checkout')->__('Please select a payment method!'));
        }
        
    	if (!isset($payment['method'])) {
            Mage::throwException(Mage::helper('checkout')->__('Please select a payment method!'));
        }
        //TODO: Methode überprüfen
        
        $this->_paymentmethod = $payment['method'];
        Mage::getSingleton('checkout/session')->setData('paymentmethod',$this->_paymentmethod);    
        return $this;
    }
    
    public function getPaymentMethod()
    {
        if($this->_paymentmethod == null)
        {
        	$this->_paymentmethod = Mage::getSingleton('checkout/session')->getData('paymentmethod');
        }
        return $this->_paymentmethod;
    }
    
    public function setPaymentMethodDetails($paymentdata = null)
    {
    	if (!$paymentdata) {
            $paymentdata = array();
        }
    	$paymentdata['method'] = $this->getPaymentMethod();
        if (!isset($paymentdata['method'])) {
            Mage::throwException(Mage::helper('checkout')->__('Please select a payment method!'));
        }
        
        
        $payment = $this->getQuote()->getPayment();
        $payment->importData($paymentdata);

        $this->getQuote()->getShippingAddress()->setPaymentMethod($payment->getMethod());
        ///20110908::Frank Rochlitzer
        ///siehe Ticket #769#comment:2
        ///http://www.kawatest.de:8080/trac/ticket/769#comment:2
        //$this->getQuote()->collectTotals()->save();
        
        ///20110909::Frank Rochlitzer
        ///Die Quote muss gespeichert werden!
        $this->getQuote()->save();
        
        return $paymentdata;
    }
    
    public function savePayment($data)
    {
        if (empty($data)) {
            $res = array(
                'error' => -1,
                'message' => Mage::helper('checkout')->__('Invalid data')
            );
            return $res;
        }
        $payment = $this->getQuote()->getPayment();
        $payment->importData($data);

        $this->getQuote()->getShippingAddress()->setPaymentMethod($payment->getMethod());
        $this->getQuote()->collectTotals()->save();

        $this->getCheckout()
            ->setStepData('payment', 'complete', true)
            ->setStepData('review', 'allow', true);

        return array();
    }

    protected function validateOrder($sendOrderEmail)
    {
        $helper = Mage::helper('checkout');
        if ($this->getQuote()->getIsMultiShipping()) {
            Mage::throwException($helper->__('Invalid checkout type.'));
        }
        
        if(($sendOrderEmail) && (Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST == $this->getQuote()->getCheckoutMethod()))
        {
        	$email = $this->getQuote()->getBillingAddress()->getEmail();
        	if (!Zend_Validate::is($email, 'EmailAddress'))
        	{
        		Mage::throwException($helper->__('You can get a order confirmation with valid e-Mail Address only.'));
        	}
        }

        if (!$this->getQuote()->isVirtual())
        {
            $address = $this->getQuote()->getShippingAddress();
            $method= $address->getShippingMethod();
            if($method != 'storepickup_storepickup')
            {
            	/*
	            $addressValidation = $address->validate();
	            if ($addressValidation !== true) {
	                Mage::throwException($helper->__('Please check shipping address information.'));
	            }
	            */
	            $addressValidation = Mage::getModel('mpcheckout/validateadr')
	            	->validateShippingAddress($address);
             	if ($addressValidation !== true) {
	                Mage::throwException($addressValidation);
	            }
	            
	            $method= $address->getShippingMethod();
	            $rate  = $address->getShippingRateByCode($method);
	            if (!$this->getQuote()->isVirtual() && (!$method || !$rate)) {
	                Mage::throwException($helper->__('Please specify shipping method.'));
	            }
            }
        }

        /*
        $addressValidation = $this->getQuote()->getBillingAddress()->validate();
        if ($addressValidation !== true) {
            Mage::throwException($helper->__('Please check billing address information.'));
        }
*/
        if (!($this->getQuote()->getPayment()->getMethod())) {
            Mage::throwException($helper->__('Please select valid payment method.'));
        }
    }

    
    
    /**
     * Enter description here...
     *
     * @return array
     */
    public function saveOrder($sendOrderEmail)
    {
    	$this->getQuote()->collectTotals()->save();
        $this->validateOrder($sendOrderEmail);
        $billing = $this->getQuote()->getBillingAddress();
        if (!$this->getQuote()->isVirtual()) {
            $shipping = $this->getQuote()->getShippingAddress();
        }
        switch ($this->getQuote()->getCheckoutMethod()) {
	        case Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST:
	            if (!$this->getQuote()->isAllowedGuestCheckout()) {
	                Mage::throwException(Mage::helper('checkout')->__('Sorry, guest checkout is not enabled. Please try again or contact store owner.'));
	            }
	            Mage::helper('core')->copyFieldset('customer_account', 'to_quote', $billing, $this->getQuote());
	            $this->getQuote()->setCustomerId(null)
	                ->setCustomerEmail($billing->getEmail())
	                ->setCustomerIsGuest(true)
	                ->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
	            break;
	
	        case Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER:
	            $customer = Mage::getModel('customer/customer');
	            /* @var $customer Mage_Customer_Model_Customer */
	
	            $customerBilling = $billing->exportCustomerAddress();
	            
	            $customer->addAddress($customerBilling);
	
	            if (!$this->getQuote()->isVirtual() && !$shipping->getSameAsBilling()) {
	                $customerShipping = $shipping->exportCustomerAddress();
	                $customer->addAddress($customerShipping);
	            }
	
	            if ($this->getQuote()->getCustomerDob() && !$billing->getCustomerDob()) {
	                $billing->setCustomerDob($this->getQuote()->getCustomerDob());
	            }
	
	            //TODO : taxvat : Ist das noch relevant?
	            if ($this->getQuote()->getCustomerTaxvat() && !$billing->getCustomerTaxvat()) {
	                $billing->setCustomerTaxvat($this->getQuote()->getCustomerTaxvat());
	            }
	
	            Mage::helper('core')->copyFieldset('checkout_onepage_billing', 'to_customer', $billing, $customer);
	
	            $customer->setPassword($customer->decryptPassword($this->getQuote()->getPasswordHash()));
	            $customer->setPasswordHash($customer->hashPassword($customer->getPassword()));
	
	            $this->getQuote()->setCustomer($customer)
	            	->setCustomerId(true);
                $this->getQuote()->setPasswordHash('');
	            break;
	
	        default:
	            $customer = Mage::getSingleton('customer/session')->getCustomer();
	
	            if (!$billing->getCustomerId() || $billing->getSaveInAddressBook()) {
	                $customerBilling = $billing->exportCustomerAddress();
	                $customer->addAddress($customerBilling);
	            }
	            if (!$this->getQuote()->isVirtual() &&
	                ((!$shipping->getCustomerId() && !$shipping->getSameAsBilling()) ||
	                (!$shipping->getSameAsBilling() && $shipping->getSaveInAddressBook()))) {
	
	                $customerShipping = $shipping->exportCustomerAddress();
	                $customer->addAddress($customerShipping);
	            }
	            $customer->setSavedFromQuote(true);
	            $customer->save();
	
	            $changed = false;
	            if (isset($customerBilling) && !$customer->getDefaultBilling()) {
	                $customer->setDefaultBilling($customerBilling->getId());
	                $changed = true;
	            }
	            if (!$this->getQuote()->isVirtual() && isset($customerBilling) && !$customer->getDefaultShipping() && $shipping->getSameAsBilling()) {
	                $customer->setDefaultShipping($customerBilling->getId());
	                $changed = true;
	            }
	            elseif (!$this->getQuote()->isVirtual() && isset($customerShipping) && !$customer->getDefaultShipping()){
	                $customer->setDefaultShipping($customerShipping->getId());
	                $changed = true;
	            }
	
	            if ($changed) {
	                $customer->save();
	            }
        }
        
        $service = Mage::getModel('sales/service_quote', $this->getQuote());
        $service->submitAll();

        if ($this->getQuote()->getCheckoutMethod() == Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER) {
            if ($this->_customerEmailExists($customer->getEmail(), Mage::app()->getWebsite()->getId())) {
                Mage::throwException(Mage::helper('checkout')->__('There is already a customer registered using this email address'));
            }
        }
        
        $this->getCheckout()->setLastQuoteId($this->getQuote()->getId())
        	->setLastSuccessQuoteId($this->getQuote()->getId())
        	->clearHelperData();
        
        Mage::getSingleton('customer/session')->unsetData('addresspostdata');
        Mage::getSingleton('customer/session')->unsetData('shippingaddresspostdata');
        	
        $order = $service->getOrder();
        if ($order) {
        	Mage::dispatchEvent('checkout_type_onepage_save_order_after',
        			array('order'=>$order, 'quote'=>$this->getQuote()));
        	
        	$redirectUrl = $this->getQuote()->getPayment()->getOrderPlaceRedirectUrl();
	        /**
	         * we only want to send to customer about new order when there is no redirect to third party
	         */
	        if (!$redirectUrl && $order->getCanSendNewEmailFlag() && $sendOrderEmail) {
	        	try {
	        		$order->queueNewOrderEmail();
	        	} catch (Exception $e) {
	        		Mage::logException($e);
	        	}
	        }
	        
	        // add order information to the session
	        $this->getCheckout()->setLastOrderId($order->getId())
	        	->setRedirectUrl($redirectUrl)
	        	->setLastRealOrderId($order->getIncrementId());
	        
	        // as well a billing agreement can be created
	        $agreement = $order->getPayment()->getBillingAgreement();
	        if ($agreement) {
	        	$this->getCheckout()->setLastBillingAgreementId($agreement->getId());
	        }
	    }
		
        if ($this->getQuote()->getCheckoutMethod() == Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER) {
        	$customerBilling->setIsDefaultBilling(true);
        	$customerBilling->setIsDefaultBaseAddress(true);
        	if (!isset($customerShipping)) {
        		$customerBilling->setIsDefaultShipping(true);
        	} else {
        		$customerShipping->setIsDefaultShipping(true);
        	}
            $customer->save();

            $this->getQuote()->setCustomerId($customer->getId());

            $order->setCustomerId($customer->getId());
            Mage::helper('core')->copyFieldset('customer_account', 'to_order', $customer, $order);

            $billing->setCustomerId($customer->getId())->setCustomerAddressId($customerBilling->getId());
            if (!$this->getQuote()->isVirtual()) {
                $shipping->setCustomerId($customer->getId())->setCustomerAddressId(isset($customerShipping) ? $customerShipping->getId() : $customerBilling->getId());
            }

            if ($customer->isConfirmationRequired()) {
                $customer->sendNewAccountEmail('confirmation');
            }
            else {
                $customer->sendNewAccountEmail();
            }
            
            if ($this->getQuote()->getCheckoutMethod(true)==Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER
            		&& !Mage::getSingleton('customer/session')->isLoggedIn()) {
            	/**
            	 * we need to save quote here to have it saved with Customer Id.
            	 * so when loginById() executes checkout/session method loadCustomerQuote
            	 * it would not create new quotes and merge it with old one.
            	 */
            	$this->getQuote()->save();
            	if ($customer->isConfirmationRequired()) {
            		Mage::getSingleton('checkout/session')->addSuccess(Mage::helper('customer')->__('Account confirmation is required. Please, check your e-mail for confirmation link. To resend confirmation email please <a href="%s">click here</a>.',
            				Mage::helper('customer')->getEmailConfirmationUrl($customer->getEmail())
            				));
            	} else {
            		Mage::getSingleton('customer/session')->loginById($customer->getId());
            	}
            }
        }
        
        $profiles = null;
        Mage::dispatchEvent(
        		'checkout_submit_all_after',
        		array('order' => $order, 'quote' => $this->getQuote(), 'recurring_profiles' => $profiles)
        );

        return $this;
    }

    /**
     * Check if customer email exists
     *
     * @param string $email
     * @param int $websiteId
     * @return false|Mage_Customer_Model_Customer
     */
    protected function _customerEmailExists($email, $websiteId = null)
    {
        $customer = Mage::getModel('customer/customer');
        if ($websiteId) {
            $customer->setWebsiteId($websiteId);
        }
        $customer->loadByEmail($email);
        if ($customer->getId()) {
            return $customer;
        }
        return false;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getLastOrderId()
    {
        
        $order = Mage::getModel('sales/order');
        $order->load($this->getCheckout()->getLastOrderId());
        $orderId = $order->getIncrementId();
        return $orderId;
    }
    
	public function isFieldRequired($key,$method = null)
    {
    	if($method == null) $method = $this->getQuote()->getCheckoutMethod();
    	return (Mage::helper('mpcheckout/config')->isFieldRequired($key,$method));
    }
    
    /**
     * Prüft ob der Warenkorb nur virtuelle Produkt enthält
     * 
     * @return TRUE|FALSE
     */
    public function isVirtual() {
    	/* @var $checkout Mage_Checkout_Model_Session */
    	$checkout = $this->getCheckout();
    	
    	if (!$checkout) {
    		return false;
    	}
    	
    	/* @var $quote Mage_Sales_Model_Quote */
    	$quote = $checkout->getQuote();
    	if (!$quote) {
    		return false;
    	}
    	
    	return $quote->isVirtual();
    }
    
    protected function isValid(&$data, $key, $method = null)
    {
    	if($method == null) $method = $this->getQuote()->getCheckoutMethod();
    	
    	//falls das feld nicht gesetzt wurde braucht es nicht geprüft werden
    	if(!isset($data[$key])) return true;
    	
    	$value = $data[$key];
    	if(is_string($value)){
    		$value = trim($value);
    	}
    	
    	if((strlen($value) < 1))
    	{
    		if($this->isFieldRequired($key,$method)) return false;
    		else 
    		{
    			//unset($data[$key]);
    			return true;
    		}
    	}
    	return true;
    }
    
    protected function validateAddress(&$data,$method = null)
    {
    	// Ermitteln der CustomerID anhand der Session
    	// ein Gast hat keine ID und muß daher eine gültige eMail eingeben
    	$customer = $this->getQuote()->getCustomer();
    	$customer_id = ( $customer->getId() ? $customer->getId() : 0 );

        /**
         * @var Mage_Directory_Helper_Data $directoryHelper
         */
        $directoryHelper = Mage::helper("directory");

    	if($method == null){
    		$method = $this->getQuote()->getCheckoutMethod();
    	}
    	
    	$errors = array();
    	
    	if(!$this->isValid($data,'firstname',$method)) $errors[] = Mage::helper('mpcheckout')->__('Please enter first name.');
    	if(!$this->isValid($data,'lastname',$method)) $errors[] = Mage::helper('mpcheckout')->__('Please enter last name.');
    	/*
    	if(!$this->isValid($data,'lastname',$method) && !$this->isValid($data,'company',$method))
    		$errors[] = Mage::helper('mpcheckout')->__('Please enter last name or company name.');
    	*/
    	if($this->isFieldRequired('street',$method))
    	{
    		$adr = $data['street'];
    		if (is_array($adr)) $adr = implode('',$adr);
    		if(strlen(trim($adr)) < 1) $errors[] = Mage::helper('mpcheckout')->__('Please enter street.');
    	}
    	    	
    	if(!$this->isValid($data,'city',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter city.');
    	if(!$this->isValid($data,'telephone',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter telephone.');
    	if(!$this->isValid($data,'postcode',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter zip/postal code.');
    	if(!$this->isValid($data,'country_id',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter country.');
    	//if(!$this->isValid($data,'region_id'))$errors[] = Mage::helper('mpcheckout')->__('Please enter region.');
    	//if(!$this->isValid($data,'email',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter email.');
    	
    	// eMail-Validierung nur durchführen, wenn keine CustomerID vorhanden ist
    	// TODO Überprüfung durch ein Falg ersetzen (2014-03-27)
    	if($this->isFieldRequired('email') && $customer_id <= 0)
    	{
    		if(!isset($data['email']))
    		{
    			$errors[] = Mage::helper('mpcheckout')->__('e-Mail address is empty.');
    		}
	    	elseif(!Zend_Validate::is($data['email'], 'EmailAddress'))
	    	{
	    		$errors[] = Mage::helper('mpcheckout')->__('e-Mail address is not valid.');
	    	}
    	}
    	
    	
    	if(!$this->isValid($data,'company',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter company.');
    	if(!$this->isValid($data,'fax',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter fax.');
        if((isset($data['country_id'])) && ($this->isFieldRequired('region',$method)))
        {
            // directory says that region is required for Country
            if ($directoryHelper->isRegionRequired($data['country_id']) && $data['region'] == '') {
                $errors[] = Mage::helper('mpcheckout')->__('Please enter region.');
            }
        }

        // zip code valid only for germany for now
    	if((isset($data['country_id'])) && ($data['country_id']=='DE'))
    	{
    		if(isset($data['postcode']) && (strlen($data['postcode'])>0))
    		{
    			$data['postcode'] = trim(str_replace('D-','',$data['postcode']));
    			if(preg_match("/^[0-9]{5}$/",$data['postcode'])==0)
    			{
    				$errors[] = Mage::helper('mpcheckout')->__('Please enter valid zip/postal code.');
    			}
    		}
    		
    	}
    	if(count($errors)> 0 )	return implode(' ',$errors);
    	return true;
    }
    
}
