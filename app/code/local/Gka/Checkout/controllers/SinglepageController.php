<?php
/**
 * Multishipping checkout controller
 *
 * @category   	Sid
 * @package    	Gka_Checkout
 * @author		Holger K�gel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Checkout_SinglepageController extends Mage_Checkout_Controller_Action
{
    /**
     * Retrieve checkout model
     *
     * @return Gka_Checkout_Model_Type_Singlepage
     */
    protected function _getCheckout()
    {
        return Mage::getSingleton('gkacheckout/type_singlepage');
    }

    /**
     * Retrieve checkout state model
     *
     * @return Mage_Checkout_Model_Type_Singlepage_State
     */
    protected function _getState()
    {
        return Mage::getSingleton('gkacheckout/type_singlepage_state');
    }

    /**
     * Retrieve checkout url heler
     *
     * @return Mage_Checkout_Helper_Url
     */
    protected function _getHelper()
    {
        return Mage::helper('gkacheckout/url');
    }

    /**
     * Retrieve checkout session
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckoutSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     *
     * @return Mage_Checkout_MultishippingController
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if ($this->getFlag('', 'redirectLogin')) {
            return $this;
        }

        $action = $this->getRequest()->getActionName();

        $checkoutSessionQuote = $this->_getCheckoutSession()->getQuote();
       
        if (!in_array($action, array('login', 'register'))) {
            if (!Mage::getSingleton('customer/session')->authenticate($this, $this->_getHelper()->getMSLoginUrl())) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            }
        }

        if (!$this->_preDispatchValidateCustomer()) {
            return $this;
        }

        if ($this->_getCheckoutSession()->getCartWasUpdated(true) &&
            !in_array($action, array('index', 'login', 'register', 'addresses', 'success'))
        ) {
            $this->_redirectUrl($this->_getHelper()->getCartUrl());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }

        if ($action == 'success' && $this->_getCheckout()->getCheckoutSession()->getDisplaySuccess(true)) {
            return $this;
        }

        
        $quote = $this->_getCheckout()->getQuote();
        $a = $quote->hasItems();
        $b = $quote->getHasError();
        $c = $quote->isVirtual();
        if (!$quote->hasItems() || $quote->getHasError() ) {
            $this->_redirectUrl($this->_getHelper()->getCartUrl());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return;
        }

        return $this;
    }

    /**
     * Index action of Multishipping checkout
     * 
     * @return void
     */
    public function indexAction()
    {
        $this->_getCheckoutSession()->setCartWasUpdated(false);
        $this->_redirect('*/*/start', array('_secure'=>true));
    }

    /**
     * Multishipping checkout login page
     * 
     * @return void
     */
    public function loginAction()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('*/*/', array('_secure'=>true));
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');

        // set account create url
        if ($loginForm = $this->getLayout()->getBlock('customer_form_login')) {
            $loginForm->setCreateAccountUrl($this->_getHelper()->getMSRegisterUrl());
        }
        $this->renderLayout();
    }

    /**
     * Singlepage checkout input address + payment method page
     * 
     * @return void
     */
    public function startAction()
    {
    	//$this->_getCheckout()->resetAssigned();
    	
    	if($this->_getState()->getActiveStep() == Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW)
    	{
    		$this->_redirect('*/cart', array('_secure'=>true));
            return;
    	}

    	$this->_getState()->resetState();
    	
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
     * Singlepage checkout process posted
     * save overview Form, invoke next Step
     * @return Gka_Checkout_SinglepageController
     */
    public function startPostAction()
    {
    	
    	$billing = $this->getRequest()->getPost('billing', array());
    	$payment = $this->getRequest()->getPost('payment', array());;
    	
    	if(!isset($payment['method'])){
    		Mage::getSingleton('core/session')->addError('Payment Method not set!');
    		$this->_redirect('*/*/start', array('_secure'=>true));
    		return;
    	}
    	$quote = $this->_getCheckout()->getQuote();
    	
    	
    	try{
    		$this->_getCheckout()->setBillingAddress($billing);
    		$this->_getCheckout()->setPaymentMethod($payment['method']);
    		//$this->_getState()->unsCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START);
    		$this->_getState()->setActiveStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW);
    		$this->_getState()->setCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START);
    	}
    	catch(Exception $e) {
            $this->_getCheckoutSession()->addException(
                $e,
                Mage::helper('checkout')->__('Data saving problem')
            );
            $this->_redirect('*/*/start', array('_secure'=>true));
            return $this;
        }
    	
        //$this->_getCheckout()->resetAssigned();
        $this->_redirect('*/*/overview', array('_secure'=>true));
    	return $this;
       
    }

 
   

 

    protected function _validateMinimumAmount()
    {
        if (!$this->_getCheckout()->validateMinimumAmount()) {
            $error = $this->_getCheckout()->getMinimumAmountError();
            $this->_getCheckout()->getCheckoutSession()->addError($error);
            $this->_forward('backToAddresses');
            return false;
        }
        return true;
    }

 

 
    /**
     * Multishipping checkout place order page
     * 
     * @return Gka_Checkout_SinglepageController
     */
    public function overviewAction()
    {
        if (!$this->_validateMinimumAmount()) {
            return $this;
        }

        if (!$this->_getState()->getCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START)) {
        	$this->_redirect('*/*/start', array('_secure'=>true));
        	return $this;
        }
        
        
        $this->_getState()->setActiveStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW);
        $this->_getState()->setCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START);
        
        try {
         	//$this->_getCheckout()->setShippingMethods();
            $this->loadLayout();
            $this->_initLayoutMessages('checkout/session');
            $this->_initLayoutMessages('customer/session');
            $this->renderLayout();
        }
        catch (Mage_Core_Exception $e) {
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/*/card', array('_secure'=>true));
        }
        catch (Exception $e) {
            Mage::logException($e);
            $this->_getCheckoutSession()->addException($e, $this->__('Cannot open the overview page'));
            $this->_redirect('*/*/card', array('_secure'=>true));
        }
    }

    /**
     * create order
     * @return Gka_Checkout_SinglepageController
     *
     */
    public function overviewPostAction()
    {
        if (!$this->_validateMinimumAmount()) {
            return;
        }

        try {
            
          
        	if (!$this->_getState()->getCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START)) {
        		$this->_redirect('*/*/overview', array('_secure'=>true));
        		return $this;
        	}

        	$this->_getCheckout()->setShippingMethod();
            //$this->_getCheckout()->setPaymentMethod();
            $this->_getCheckout()->createOrders();
           
            $this->_getCheckout()->getCheckoutSession()->clear();
            $this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(true);
            
            $this->_getState()->setActiveStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_SUCCESS);
            $this->_getState()->setCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW);
            
            
            $this->_redirect('*/*/success', array('_secure'=>true));
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $message = $e->getMessage();
            if (!empty($message) ) {
                $this->_getCheckoutSession()->addError($message);
            }
            $this->_redirect('*/*/overview', array('_secure'=>true));
        } catch (Mage_Checkout_Exception $e) {
            Mage::helper('checkout')
                ->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'singlepage');
            $this->_getCheckout()->getCheckoutSession()->clear();
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/cart', array('_secure'=>true));
        }
        catch (Mage_Core_Exception $e){
            Mage::helper('checkout')
                ->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'singlepage');
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/*/overview', array('_secure'=>true));
        } catch (Exception $e){
            Mage::logException($e);
            Mage::helper('checkout')
                ->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'singlepage');
            $this->_getCheckoutSession()->addError($this->__('Order place error.'));
            $this->_redirect('*/cart', array('_secure'=>true));
        }
        return $this;
    }

    /**
     * Multishipping checkout succes page
     * 
     * @return void
     */
    public function successAction()
    {
        if (!$this->_getState()->getCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW)) {
            $this->_redirect('*/*/addresses', array('_secure'=>true));
            return $this;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $ids = $this->_getCheckout()->getOrderIds();
        Mage::dispatchEvent('checkout_multishipping_controller_success_action', array('order_ids' => $ids));
        $this->renderLayout();
    }

    /**
     * Redirect to login page
     *
     * @return void
     */
    public function redirectLogin()
    {
        $this->setFlag('', 'no-dispatch', true);
        Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*', array('_secure'=>true)));

        $this->getResponse()->setRedirect(
            Mage::helper('core/url')->addRequestParam(
                $this->_getHelper()->getMSLoginUrl(),
                array('context' => 'checkout')
            )
        );
        $this->setFlag('', 'redirectLogin', true);
    }
    
 
    
}
