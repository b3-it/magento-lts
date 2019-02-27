<?php

/**
 * Multipage checkout controller
 *
 *
 */
class Egovs_Checkout_MultipageController extends Mage_Checkout_Controller_Action
{

    protected $_checkout = null;
    protected $_storeid = null;

    /**
     * Retrieve checkout model
     *
     * @return Egovs_Checkout_Model_Multipage
     */
    protected function _getCheckout()
    {
    	if ($this->_checkout == null) {
        	$this->_checkout = Mage::getSingleton('mpcheckout/multipage');
    	}

    	return $this->_checkout;
    }


    protected function getStoreId() {
    	if ($this->_storeid == null) {
    		$this->_storeid = $this->_getCheckout()->getStoreId();
    	}

    	return $this->_storeid;
    }

    /**
     * Retrieve checkout state model
     *
     * @return Egovs_Checkout_Model_State
     */
    protected function _getState()
    {
        return Mage::getSingleton('mpcheckout/state');
    }

    /**
     * Retrieve checkout url heler
     *
     * @return Egovs_Checkout_Helper_Url
     */
    protected function _getHelper()
    {
        return Mage::helper('mpcheckout/url');
    }

    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     *
     * @return Egovs_Checkout_multipageController
     */
    public function preDispatch()
    {

        parent::preDispatch();

        //warenkorb begrenzung
        try
        {
        	$quote = $this->_getCheckout()->getQuote();

        	Mage::dispatchEvent('checkout_entry_before', array('quote'=>$quote));
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            $this->_redirect('checkout/cart', array('_secure' => $this->getRequest()->isSecure()));
            return $this;
        } catch(Exception $ex) {
        	Mage::getSingleton('checkout/session')->addException(
                $ex,
                $ex->getMessage()
            );
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            $this->_redirect('checkout/cart', array('_secure' => $this->getRequest()->isSecure()));
            return $this;
        }


		$method = $this->_getCheckout()->getCheckoutMethod();
		if (preg_match('#^(guest|register)#', $method)) return $this;
        $action = $this->getRequest()->getActionName();


     	if ($action == 'successview' && $this->_getCheckout()->getCheckoutSession()->getDisplaySuccess()) {
     		return $this;
        }

        if ($action != 'newaddress') {
        	Mage::getSingleton('customer/session')->unsetData('addresspostdata');
        }

        if ($action != 'shipping') {
        	Mage::getSingleton('customer/session')->unsetData('shippingaddresspostdata');
        }

        $this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(false);

        if (!preg_match('#^(login|register)#', $action)) {
            if (!Mage::getSingleton('customer/session')->authenticate($this, $this->_getHelper()->getMPLoginUrl())) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            }

        } else {
        	return $this;
        }

        if (!$this->_preDispatchValidateCustomer()) {
            return $this;
        }

        if (Mage::getSingleton('checkout/session')->getCartWasUpdated(true)
            && !in_array($action, array('index', 'login', 'register', 'addresses', 'successview'))
        ) {
            $this->_redirectUrl($this->_getHelper()->getCartUrl());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }



        $quote = $this->_getCheckout()->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->_redirect('checkout/cart', array('_secure' => $this->getRequest()->isSecure()));
            return $this;
        }

        if (!$quote->validateMinimumAmount()) {
            $error = Mage::getStoreConfig('sales/minimum_order/error_message');
            Mage::getSingleton('checkout/session')->addError($error);
            $this->_redirect('checkout/cart', array('_secure' => $this->getRequest()->isSecure()));
            return $this;
        }

        return $this;
    }

    /**
     * Index action of multipage checkout
     *
     * @return void
     */
    public function indexAction() {
        Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
        Mage::getSingleton('customer/session')->setBeforeAuthUrl($this->getRequest()->getRequestUri());
        $this->_getCheckout()->initCheckout();

        //$this->loadLayout();
        //$this->_initLayoutMessages('customer/session');
        //$this->getLayout()->getBlock('head')->setTitle($this->__('Checkout'));
        //$this->renderLayout();

        $this->_redirect('egovs_checkout/multipage/addresses', array('_secure'=>true));

    }

    /**
     * multipage checkout login page
     *
     * @return void
     */
    public function loginAction() {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('*/*/', array('_secure'=>true));
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');

        // set account create url
        if ($loginForm = $this->getLayout()->getBlock('customer_form_login')) {
            $loginForm->setCreateAccountUrl($this->_getHelper()->getMPRegisterUrl());
        }
        $this->renderLayout();
    }

    /**
     * multipage checkout login page
     *
     * @return void
     */
    public function registerAction() {
    	try {
    		if ($this->getRequest()->isPost()) {
    			$method = $this->getRequest()->getPost('checkout_method');
    			if ($method == null) {
    				Mage::getSingleton('customer/session')->addError($this->__('Select one option, please!'));
    				$this->_redirect('egovs_checkout/multipage/login');
    				return;
    			}
    			if ($method == 'register' && !Mage::getStoreConfigFlag('checkout/options/checkout_customer_register')) {
    				$this->_redirect('customer/account/create', array('_secure'=>true));
    				return;
    			}

    			$this->_getCheckout()->saveCheckoutMethod($method);
    			$this->_redirect('egovs_checkout/multipage/', array('_secure'=>true));
    			//die();
    		} else {
    			$this->_redirect('checkout/card');
    			return;
    		}
    	} catch (Mage_Core_Exception $e) {
    		Mage::getSingleton('checkout/session')->addError($e->getMessage());
    		$this->_redirect('*/checkout/card');
    		return;
    	} catch (Exception $e) {
    		Mage::getSingleton('checkout/session')->addException(
    		$e,
    		Mage::helper('checkout')->__('Register saving problem')
    		);
    		$this->_redirect('*/checkout/card');
    		return;
    	}

    }

    /**
     * multipage checkout select address page
     *
     * @return void
     */
    public function addressesAction() {
//     	if (Mage::getSingleton('customer/session')->isLoggedIn() && //Gilt nicht für Registrierung (E-Mail notwendig)
//     		$this->_getCheckout()->isVirtual()) {
//     		$this->_getState()->setCompleteStep(Egovs_Checkout_Model_State::STEP_ADDRESS);
//     		$this->_redirect('*/multipage/billing',array('_secure'=>true));
//     		return;
//     	}
        // If customer do not have addresses
        if (!$this->_getCheckout()->customerHasAddresses()) {
            $this->_redirect('*/multipage/newaddress', array('_secure'=>true));
            return;
        }
        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_ADDRESS
        );
        if (!$this->_getCheckout()->validateMinimumAmount()) {
            $message = $this->_getCheckout()->getMinimumAmountDescription();
            $this->_getCheckout()->getCheckoutSession()->addNotice($message);
        }
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }


      /**
     * multipage checkout new address page
     *
     * @return void
     */
    public function newaddressAction() {

        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_ADDRESS
        );
        if (!$this->_getCheckout()->validateMinimumAmount()) {
            $message = $this->_getCheckout()->getMinimumAmountDescription();
            $this->_getCheckout()->getCheckoutSession()->addNotice($message);
        }
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }

    /**
     * multipage checkout process posted addresses
     *
     * @return void
     */
    public function addressesPostAction()
    {
    	$_widget_keys = array('method', 'prefix', 'firstname', 'middlename', 'lastname', 'suffix', 'vat_id');

    	try {
    		if ($this->getRequest()->isPost()) {
    			if (!$this->_validateFormKey()) {
    				$this->_redirect('*/*/addresses');
    				return;
    			}

    			$data = $this->getRequest()->getPost('billing', array());

    			foreach( $_widget_keys AS $post_key ) {
    				$data[$post_key] = $this->getRequest()->getPost($post_key, '');
    			}

    			if(isset($data['base_address'])){ unset($data['base_address']);}
    			$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
    			Mage::getSingleton('customer/session')->setData('addresspostdata', $data);
    			Mage::getSingleton('customer/session')->setData('use_for_shipping', $data['use_for_shipping']);

    			if ($customerAddressId == 'add') {
    				$this->_redirect('*/multipage/newaddress', array('_secure'=>true));
    				return;
    			}

    			$result = $this->_getCheckout()->saveBilling($data, $customerAddressId);
    			if ($result !== true) {
    				Mage::getSingleton('checkout/session')->addError($result);
    				$this->_redirect('*/*/newaddress', array('_secure'=>true));
    				return;
    			}

    			Mage::getSingleton('customer/session')->unsetData('addresspostdata');

    			$this->_getState()->setCompleteStep(Egovs_Checkout_Model_State::STEP_ADDRESS);
    			/* check quote for virtual */
    			if ($this->_getCheckout()->getQuote()->isVirtual()) {
    				$this->_redirect('*/multipage/billing', array('_secure'=>true));
    			} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
    				//rechnungs == versandadresse
    				$this->_getState()->setCompleteStep(Egovs_Checkout_Model_State::STEP_SHIPPING);
    				$this->_redirect('*/multipage/shippingmethod', array('_secure'=>true));
    				return;

    			} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 2) {
    				//selbstabholung
    				$ship = $this->_getCheckout()->getShippingAddress()->getGroupedAllShippingRates();
    				if (!isset($ship)) $ship = array();
    				$ship = array_key_exists('storepickup', $ship);
    				if (!$ship)  Mage::throwException(Mage::helper('mpcheckout')->__('This Shipping Method is not availible using this address!'));
    				$this->_getCheckout()->saveShippingMethod('storepickup_storepickup');

    				$this->_getState()->setActiveStep(
    						Egovs_Checkout_Model_State::STEP_BILLING
    				);
    				$this->_getState()->setCompleteStep(
    						Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS
    				);
    				$this->_redirect('*/multipage/billing', array('_secure'=>true));
    				return;
    			} else {
    				$this->_redirect('*/multipage/shipping', array('_secure'=>true));
    			}
    		}
    	}
    	catch (Egovs_Vies_Model_Resource_Exception_VatNotValid $e) {
    		Mage::getSingleton('checkout/session')->addException(
    		$e,
    		Mage::helper('checkout')->__($e->getMessage()));
    		Mage::log("mpcheckout::".$e->getMessage(), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
    		$this->_redirect('*/*/addresses', array('_secure'=>true));
    		return;
    	} catch (Mage_Core_Exception $e) {
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            $this->_redirect('*/*/newaddress', array('_secure'=>true));
        } catch (Exception $e) {
            Mage::getSingleton('checkout/session')->addException(
                $e,
                Mage::helper('checkout')->__('Data saving problem'));
            Mage::log("mpcheckout::".$e->getMessage(), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);

            $this->_redirect('*/*/newaddress', array('_secure'=>true));
        }


   }

    public function backToAddressesAction() {
        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_ADDRESS
        );
        $this->_getState()->unsCompleteStep(
            Egovs_Checkout_Model_State::STEP_SHIPPING
        );
        $this->_redirect('*/*/addresses', array('_secure'=>true));
    }




    /**
     * multipage checkout shipping information page
     *
     * @return void
     */
    public function shippingAction() {
        if (!$this->_validateMinimumAmount()) {
            return;
        }

        if (!$this->_getState()->getCompleteStep(Egovs_Checkout_Model_State::STEP_ADDRESS)) {
            $this->_redirect('*/*/addresses', array('_secure'=>true));
            return $this;
        }

        if (!$this->_getCheckout()->customerHasAddresses()) {
        	$this->_redirect('*/*/newshipping', array('_secure'=>true));
        	return;
        }

        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_SHIPPING
        );
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }



    public function newshippingAction() {

    	if (!$this->_getState()->getCompleteStep(Egovs_Checkout_Model_State::STEP_ADDRESS)) {
    		$this->_redirect('*/*/addresses', array('_secure'=>true));
    		return $this;
    	}

    	$this->_getState()->setActiveStep(
    			Egovs_Checkout_Model_State::STEP_SHIPPING
    	);

    	$this->loadLayout();
    	$this->_initLayoutMessages('customer/session');
    	$this->_initLayoutMessages('checkout/session');
    	$this->renderLayout();
    }


   	public function shippingPostAction() {
        try {
    		if ($this->getRequest()->isPost()) {
    			if (!$this->_validateFormKey()) {
    				$this->_redirect('*/*/shipping');
    				return;
    			}

    			$data = $this->getRequest()->getPost('shipping', array());
    			if(isset($data['base_address'])){ unset($data['base_address']);}
    			$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);

    			if (!empty($data)) {
    				Mage::getSingleton('customer/session')->setData('shippingaddresspostdata', $data);
    			}


    			if ($customerAddressId == 'add') {
    				$this->_redirect('*/multipage/newshipping', array('_secure'=>true));
    				return;
    			}

                $this->_getCheckout()->saveShipping($data, $customerAddressId);

    			Mage::getSingleton('customer/session')->unsetData('shippingaddresspostdata');
    		}
    	} catch (Mage_Core_Exception $e) {
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            $this->_redirect('*/*/shipping', array('_secure'=>true));
            return;
        } catch (Exception $e) {
            Mage::getSingleton('checkout/session')->addException(
                $e,
                Mage::helper('checkout')->__('Data saving problem')
            );
            $this->_redirect('*/*/shipping', array('_secure'=>true));
            return;
        }

        $this->_getState()->setActiveStep(Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS);
        $this->_getState()->setCompleteStep(Egovs_Checkout_Model_State::STEP_SHIPPING);
        $this->_redirect('*/*/shippingmethod',array('_secure'=>true));

    }

    public function backToShippingAction() {
    	$this->_getState()->setActiveStep(
    			Egovs_Checkout_Model_State::STEP_SHIPPING
    	);
    	$this->_getState()->unsCompleteStep(
    			Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS
    	);
    	$this->_redirect('*/*/shipping', array('_secure'=>true));
    }

    /**
     * multipage checkout shipping information page
     *
     * @return void
     */
    public function shippingmethodAction() {
        if (!$this->_validateMinimumAmount()) {
            return;
        }

        if (!$this->_getState()->getCompleteStep(Egovs_Checkout_Model_State::STEP_SHIPPING)) {
            $this->_redirect('*/*/shipping', array('_secure'=>true));
            return $this;
        }

        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS
        );

        $this->loadLayout();


        //weiterleiten falls nur eine Versandart
        $back = $this->getRequest()->getParam('back');
        if((Mage::getStoreConfig('checkout/progress/skip_shipping_method')) && ( $back == null))
        {
        	$block = $this->getLayout()->getBlock('checkout_shipping');
        	$methods = $block->getAllShippingMethods();
        	if(count($methods) == 1)
        	{
        		$method = array_shift($methods);
        		try {
        			Mage::dispatchEvent(
        			'checkout_controller_multishipping_shipping_post',
        			array('request'=>$this->getRequest(), 'quote'=>$this->_getCheckout()->getQuote())
        			);

        			$this->_getCheckout()->saveShippingMethod($method);

        			$this->_getState()->setActiveStep(
        					Egovs_Checkout_Model_State::STEP_BILLING
        			);
        			$this->_getState()->setCompleteStep(
        					Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS
        			);
        			$this->_redirect('*/*/billing', array('_secure'=>true));
        			return ;
        		}
        		catch (Exception $e){
        			Mage::getSingleton('checkout/session')->addError($e->getMessage());
        			$this->_redirect('*/*/addresses', array('_secure'=>true));
        		}




        	}
        }






        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }



    public function backToShippingmethodAction() {
        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS
        );
        $this->_getState()->unsCompleteStep(
            Egovs_Checkout_Model_State::STEP_BILLING
        );
        $this->_redirect('*/*/shippingmethod', array('_secure'=>true,'back'=>true));
    }





    public function shippingmethodPostAction()
    {
    	if (!$this->_validateFormKey()) {
    		$this->_redirect('*/*/shippingmethod');
    		return;
    	}

        $shippingMethod = $this->getRequest()->getPost('shipping_method');
        if (is_array($shippingMethod)) {
            $shippingMethod = array_shift($shippingMethod);
        }
        $path = '*/*/shippingmethod';
        try {
            /* Liefert leeres Array bei Erfolg */
            $result = $this->_getCheckout()->saveShippingMethod($shippingMethod);
            if (!$result) {
                Mage::dispatchEvent(
                    'checkout_controller_multishipping_shipping_post',
                    array(
                        'request' => $this->getRequest(),
                        'quote' => $this->_getCheckout()->getQuote()
                    )
                );

                $this->_getState()->setActiveStep(
                    Egovs_Checkout_Model_State::STEP_BILLING
                );
                $this->_getState()->setCompleteStep(
                    Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS
                );
                $path = '*/*/billing';
            }
        } catch (Exception $e){
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
        }
        $this->_getCheckout()->getQuote()->collectTotals()->save();
        $this->_redirect($path, array('_secure'=>true));
    }

    /**
     * multipage checkout billing information page
     *
     * @return void
     */
    public function billingAction()
    {

    	if ($this->_getCheckout()->getQuote()->isVirtual()) {
    		if (!$this->_getState()->getCompleteStep(Egovs_Checkout_Model_State::STEP_ADDRESS)) {
	            $this->_redirect('*/*/addresses', array('_secure'=>true));
	            return $this;
	        }
    	} else {
	       	if (!$this->_getState()->getCompleteStep(Egovs_Checkout_Model_State::STEP_SHIPPING_DETAILS)) {
	            $this->_redirect('*/*/shipping', array('_secure'=>true));
	            return $this;
	        }
    	}
        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_BILLING
        );

        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }


    public function billingPostAction() {

    	if (!$this->_validateFormKey()) {
    		$this->_redirect('*/*/billing');
    		return;
    	}

        $paymentMethods = $this->getRequest()->getPost('payment');

        try {

            $this->_getCheckout()->setPaymentMethod($paymentMethods);
            $this->_getCheckout()->setPaymentMethodDetails();
            $this->_getState()->setActiveStep(
                Egovs_Checkout_Model_State::STEP_BILLING_DETAILS
            );

            $this->_getState()->setCompleteStep(
                Egovs_Checkout_Model_State::STEP_BILLING
            );

           $paymentinfo = Mage::helper('payment')
           		->getMethodInstance($paymentMethods['method'])
          		->getInfoBlockType();

           if ($paymentinfo != 'paymentbase/noinfo') {
            	$this->_redirect('*/*/billingdetails', array('_secure'=>true));
           } else {
           		$this->_redirect('*/*/overview', array('_secure'=>true));
           }

           //$this->_redirect('*/*/billingdetails',array('_secure'=>true));
        } catch (Egovs_Paymentbase_Exception_Validation $e) {
        	if ($msgs = $e->getMessages(Mage_Core_Model_Message::ERROR)) {
        		foreach ($msgs as $msg) {
        			/* @var $msg Mage_Core_Model_Message_Abstract */
        			Mage::getSingleton('checkout/session')->addError($msg->getText());
        		}
        	} else {
        		Mage::getSingleton('checkout/session')->addNotice($e->getMessage());
        	}
        	$this->_redirect('*/*/billingdetails', array('_secure'=>true));
        } catch (Exception $e){
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            $this->_redirect('*/*/billing', array('_secure'=>true));
        }

    }



    public function billingdetailsAction() {
        /*
    	if (!$this->_validateBilling()) {
            return;
        }
		*/
        if (!$this->_validateMinimumAmount()) {
            return;
        }


        if (!$this->_getState()->getCompleteStep(Egovs_Checkout_Model_State::STEP_BILLING)) {
            $this->_redirect('*/*/billing', array('_secure'=>true));
            return $this;
        }

        $catched = false;
        try {
            $this->loadLayout();
            $this->_initLayoutMessages('customer/session');
            $this->_initLayoutMessages('checkout/session');
            $this->renderLayout();
        } catch (Egovs_Paymentbase_Exception_Validation $ve) {
            $this->_getCheckout()->getCheckoutSession()->addMessages($ve->getMessages());
            $catched = true;
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getCheckout()->getCheckoutSession()->addError($this->__('Internal server error occurred, please try again later.'));
            $catched = true;
        }

        if ($catched) {
            $this->_redirect('*/*/billing', array('_secure'=>true));
            return $this;
        }

        return $this;
    }



    /**
     * Validation of selecting of billing address
     *
     * @return boolean
     */
    protected function _validateBilling() {
    	if (!$this->_getCheckout()->getQuote()->getBillingAddress()->getFirstname()) {
    		$this->_redirect('*/edit/selectBilling', array('_secure'=>true));
    		return false;
    	}
    	return true;
    }

    public function backToBillingAction() {
    	$paymentMethod = $this->_getCheckout()->getCheckoutSession()->getPaymentmethod();
    	if ($paymentMethod == 'freepayment' || $paymentMethod == 'free') {
    		$this->backToAddressesAction();
    		return;
    	}

        $this->_getState()->setActiveStep(
            Egovs_Checkout_Model_State::STEP_BILLING
        );
        $this->_getState()->unsCompleteStep(
            Egovs_Checkout_Model_State::STEP_OVERVIEW
        );
        $this->_redirect('*/*/billing', array('_secure'=>true));
    }

    /**
     * multipage checkout place order page
     *
     * @return void;
     */
    public function overviewAction()
    {
        if (!$this->_validateMinimumAmount()) {
            return;
        }

        $this->_getState()->setActiveStep(Egovs_Checkout_Model_State::STEP_OVERVIEW);

        try {
            $payment = $this->getRequest()->getPost('payment');
            $payment = $this->_getCheckout()->setPaymentMethodDetails($payment);
            //$this->_getCheckout()->getQuote()->getPayment()->importData($payment);

            $this->_getState()->setCompleteStep(
                Egovs_Checkout_Model_State::STEP_BILLING
            );

            $this->loadLayout();
            $this->_initLayoutMessages('checkout/session');
            $this->_initLayoutMessages('customer/session');
            $this->renderLayout();
        } catch (Egovs_Paymentbase_Exception_Validation $e) {
        	if ($msgs = $e->getMessages(Mage_Core_Model_Message::ERROR)) {
        		foreach ($msgs as $msg) {
        			/* @var $msg Mage_Core_Model_Message_Abstract */
        			Mage::getSingleton('checkout/session')->addError($msg->getText());
        		}
        	} else {
        		Mage::getSingleton('checkout/session')->addNotice($e->getMessage());
        	}
        	$this->_redirect('*/*/billingdetails', array('_secure'=>true));
        } catch (Mage_Core_Exception $e) {

            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            $this->_redirect('*/*/billing', array('_secure'=>true));
        } catch (Exception $e) {

            Mage::logException($e);
            Mage::getSingleton('checkout/session')->addException($e, $this->__('Internal server error occurred, please try again later.'));
            $this->_redirect('*/*/billing', array('_secure'=>true));
        }
    }

    public function overviewPostAction()
    {
    	if (!$this->_validateFormKey()) {
    		$this->_redirect('*/*/overview');
    		return;
    	}

    	$quote = $this->_getCheckout()->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->_redirect('checkout/cart', array('_secure' => $this->getRequest()->isSecure()));
            return;
        }

        if (!$this->_validateMinimumAmount()) {
            return;
        }

        try {
        	if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    Mage::getSingleton('checkout/session')->addError($this->__('Please agree to all terms and conditions before placing the order.'));
                    $this->_redirect('*/*/overview', array('_secure' => true));
                    return;
                }
            }


         	if ($requiredAgreements = Mage::getModel('mpcheckout/cmsblock')->loadAgreementIdsFromQuote($this->_getCheckout()->getQuote(), $this->getStoreId())) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreementtext', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    Mage::getSingleton('checkout/session')->addError($this->__('Please agree to all additional conditions before placing the order.'));
                    $this->_redirect('*/*/overview',array('_secure'=>true));
                    return;
                }
            }

            $email = $this->getRequest()->getPost('sendOrderEmail');
            $this->_getCheckout()->saveOrder($email != null);
            $redirectUrl = $this->_getCheckout()->getCheckout()->getRedirectUrl();

            $this->_getState()->setActiveStep(
                Egovs_Checkout_Model_State::STEP_SUCCESS
            );

            $this->_getState()->setCompleteStep(
                Egovs_Checkout_Model_State::STEP_OVERVIEW
            );

            $this->_getCheckout()->getCheckoutSession()->clear();
            $this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(true);

            $quote->save();

	        if (isset($redirectUrl)) {
	            $this->_redirectUrl($redirectUrl);
	        } else {
    			$this->_redirect('*/*/successview', array('_secure'=>true));
	        }
        }
        catch (Mage_Core_Exception $e) {
            Mage::helper('checkout')->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'multi-page');
            if ($e->getCode() == Egovs_Helper::EXCEPTION_CODE_PUBLIC) {
                Mage::getSingleton('checkout/session')->addError($this->__($e->getMessage()));
            } else {
                Mage::logException($e);
                Mage::getSingleton('checkout/session')->addError($this->__("Internal server error occurred, please try again later."));
            }
            $this->_redirect('*/*/overview', array('_secure'=>true));
        }
        catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('checkout/session')->addError($this->__("Internal server error occurred, please try again later."));
            Mage::helper('checkout')->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'multi-page');
            $this->_redirect('*/*/overview', array('_secure'=>true));
        }
    }


    private function __isDebug()
    {
    	$file = realpath(__DIR__.DS."..".DS."etc".DS.'debug.flag');
    	return file_exists($file);
    }

    public function successviewAction() {
    	$lastQuoteId = $this->_getCheckout()->getCheckout()->getLastQuoteId();
    	$lastOrderId = $this->_getCheckout()->getCheckout()->getLastOrderId();

    	$msg = "successviewAction [lastQuoteId: $lastQuoteId; lastOrderId: $lastOrderId;].";
    	Mage::log("mpcheckout::".$msg, Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);

    	if (!$lastQuoteId || !$lastOrderId) {
    		$this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(false);
    		$this->_redirect('checkout/cart', array('_secure' => $this->getRequest()->isSecure()));
    		return;
    	}

    	$this->loadLayout();
    	$this->_initLayoutMessages('checkout/session');
    	//erst am Ende deaktivieren
    	if(!$this->__isDebug()){
    		$this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(false);
    	}
    	Mage::dispatchEvent('checkout_onepage_controller_success_action');
    	$this->renderLayout();

    }

    protected function _validateMinimumAmount() {
    	if (!$this->_getCheckout()->validateMinimumAmount()) {
    		$error = $this->_getCheckout()->getMinimumAmountError();
    		$this->_getCheckout()->getCheckoutSession()->addError($error);
    		$this->_forward('backToAddresses');
    		return false;
    	}
    	return true;
    }
}
