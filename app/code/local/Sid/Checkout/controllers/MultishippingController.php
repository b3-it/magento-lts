<?php
/**
 * Multishipping checkout controller
 *
 * @category   	Sid
 * @package    	Sid_Checkout
 * @author		Holger K�gel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Checkout_MultishippingController extends Mage_Checkout_Controller_Action
{
    /**
     * Retrieve checkout model
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    protected function _getCheckout()
    {
        return Mage::getSingleton('sidcheckout/type_multishipping');
    }

    /**
     * Retrieve checkout state model
     *
     * @return Mage_Checkout_Model_Type_Multishipping_State
     */
    protected function _getState()
    {
        return Mage::getSingleton('sidcheckout/type_multishipping_state');
    }

    /**
     * Retrieve checkout url heler
     *
     * @return Mage_Checkout_Helper_Url
     */
    protected function _getHelper()
    {
        return Mage::helper('checkout/url');
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
        /**
         * Catch index action call to set some flags before checkout/type_multishipping model initialization
         */
        if ($action == 'index') {
            $checkoutSessionQuote->setIsMultiShipping(true);
            $this->_getCheckoutSession()->setCheckoutState(
                Mage_Checkout_Model_Session::CHECKOUT_STATE_BEGIN
            );
        } 
        
        /*
        elseif (!$checkoutSessionQuote->getIsMultiShipping() &&
            !in_array($action, array('login', 'register','addresses','takeItem', 'putbackItem','addresses' 'success'))) 
        {
            $this->_redirect('././index');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return $this;
        }
*/
        if (!in_array($action, array('login', 'register'))) {
            if (!Mage::getSingleton('customer/session')->authenticate($this, $this->_getHelper()->getMSLoginUrl())) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            }
			/*
            if (!Mage::helper('checkout')->isMultishippingCheckoutAvailable()) {
                $error = $this->_getCheckout()->getMinimumAmountError();
                $this->_getCheckoutSession()->addError($error);
                $this->_redirectUrl($this->_getHelper()->getCartUrl());
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
                return $this;
            }
            */
        }

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if (!Sid_Roles_Model_Customer_Authority::getIsAuthorizedOrderer($customer)) {
//         	Mage::getSingleton('customer/session')->addError($this->__('You are not authorized to create orders.'));
        	$this->_getCheckoutSession()->addError($this->__('You are not authorized to create orders.'));
        	$this->_redirect('sidcheckout/cart');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return $this;
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
        $this->_redirect('*/*/addresses', array('_secure'=>true));
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
     * Multishipping checkout login page
     * 
     * @return void
     */
    public function registerAction()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirectUrl($this->_getHelper()->getMSCheckoutUrl(), array('_secure'=>true));
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');

        if ($registerForm = $this->getLayout()->getBlock('customer_form_register')) {
            $registerForm->setShowAddressFields(true)
                ->setBackUrl($this->_getHelper()->getMSLoginUrl())
                ->setSuccessUrl($this->_getHelper()->getMSShippingAddressSavedUrl())
                ->setErrorUrl($this->_getHelper()->getCurrentUrl());
        }

        $this->renderLayout();
    }

    /**
     * Multishipping checkout select address page
     * 
     * @return void
     */
    public function addressesAction()
    {
    	$this->_getCheckout()->resetAssigned();
    	
    	if($this->_getState()->getActiveStep() == Mage_Checkout_Model_Type_Multishipping_State::STEP_OVERVIEW)
    	{
    		$this->_redirect('*/cart', array('_secure'=>true));
            return;
    	}
     
    	
        // If customer do not have addresses
        if (!$this->_getCheckout()->getCustomerDefaultShippingAddress()) {
            $this->_redirect('sidcheckout/multishipping_address/newShipping', array('_secure'=>true));
            return;
        }

        $this->_getState()->unsCompleteStep(
            Mage_Checkout_Model_Type_Multishipping_State::STEP_SHIPPING
        );

        $this->_getState()->setActiveStep(
            Mage_Checkout_Model_Type_Multishipping_State::STEP_SELECT_ADDRESSES
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
     * Multishipping checkout process posted addresses
     * 
     * @return void
     */
    public function addressesPostAction()
    {
    	
        if (!$this->_getCheckout()->getCustomerDefaultShippingAddress()) {
            $this->_redirect('*/multishipping_address/newShipping', array('_secure'=>true));
            return;
        }
        try {
            if ($this->getRequest()->getParam('continue', false)) {
            	$this->_getCheckout()->moveAssignedItemsToQuote();
            	$this->_getCheckout()->setShippingMethods();
            	$this->_getCheckout()->setPaymentMethod();
            	
                $this->_getCheckout()->setCollectRatesFlag(true);
                $this->_getState()->setActiveStep(
                    Mage_Checkout_Model_Type_Multishipping_State::STEP_OVERVIEW
                );
                $this->_getState()->setCompleteStep(
                    Mage_Checkout_Model_Type_Multishipping_State::STEP_SELECT_ADDRESSES
                );
                $this->_getCheckout()->resetAssigned();
				$this->_redirect('*/*/overview', array('_secure'=>true));
				
            } elseif ($this->getRequest()->getParam('new_address')) {
                $this->_redirect('*/multishipping_address/newShipping', array('_secure'=>true));
            } else {
                $this->_redirect('*/*/addresses', array('_secure'=>true));
            }
            
            /*
            if ($shipToInfo = $this->getRequest()->getPost('ship')) {
                $this->_getCheckout()->setShippingItemsInformation($shipToInfo);
            }
            */
        }
        catch (Mage_Core_Exception $e) {
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/*/addresses', array('_secure'=>true));
        }
        catch (Exception $e) {
            $this->_getCheckoutSession()->addException(
                $e,
                Mage::helper('checkout')->__('Data saving problem')
            );
            $this->_redirect('*/*/addresses', array('_secure'=>true));
        }
    }

 
    /**
     * Z�ruck zur Adressangabe
     * 
     * @return void
     * 
     */
    public function backToAddressesAction()
    {
        $this->_getState()->setActiveStep(
            Mage_Checkout_Model_Type_Multishipping_State::STEP_SELECT_ADDRESSES
        );
        $this->_getState()->unsCompleteStep(
            Mage_Checkout_Model_Type_Multishipping_State::STEP_SHIPPING
        );
        $this->_redirect('*/*/addresses', array('_secure'=>true));
    }

    /**
     * Multishipping checkout remove item action
     * 
     * @return void
     */
    public function removeItemAction()
    {
        $itemId     = $this->getRequest()->getParam('id');
        $addressId  = $this->getRequest()->getParam('address');
        if ($addressId && $itemId) {
            $this->_getCheckout()->setCollectRatesFlag(true);
            $this->_getCheckout()->removeAddressItem($addressId, $itemId);
        }
        $this->_redirect('*/*/addresses', array('_secure'=>true));
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
     * @return void
     */
    public function overviewAction()
    {
        if (!$this->_validateMinimumAmount()) {
            return $this;
        }

        $this->_getState()->setActiveStep(Mage_Checkout_Model_Type_Multishipping_State::STEP_OVERVIEW);

        try {
        	
        	$this->_getCheckout()->splitFrameContracts();
        	//$this->_getCheckout()->setShippingMethods();
            $this->loadLayout();
            $this->_initLayoutMessages('checkout/session');
            $this->_initLayoutMessages('customer/session');
            $this->renderLayout();
        }
        catch (Mage_Core_Exception $e) {
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/*/billing', array('_secure'=>true));
        }
        catch (Exception $e) {
            Mage::logException($e);
            $this->_getCheckoutSession()->addException($e, $this->__('Cannot open the overview page'));
            $this->_redirect('*/*/addresses', array('_secure'=>true));
        }
    }

    public function overviewPostAction()
    {
        if (!$this->_validateMinimumAmount()) {
            return;
        }

        try {
            if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    $this->_getCheckoutSession()->addError($this->__('Please agree to all Terms and Conditions before placing the order.'));
                    $this->_redirect('*/*/overview', array('_secure'=>true));
                    return;
                }
            }

            $nummern = $this->getRequest()->getParam('vergabenummer', false);
            $this->_getCheckout()->setVergabenummern($nummern);
            //$this->_getCheckout()->setShippingMethods();
            $this->_getCheckout()->setPaymentMethod();
            $this->_getCheckout()->createOrders();
            $this->_getState()->setActiveStep(
                Mage_Checkout_Model_Type_Multishipping_State::STEP_SUCCESS
            );
            $this->_getState()->setCompleteStep(
                Mage_Checkout_Model_Type_Multishipping_State::STEP_OVERVIEW
            );
            $this->_getCheckout()->getCheckoutSession()->clear();
            $this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(true);
            $this->_redirect('*/*/success', array('_secure'=>true));
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $message = $e->getMessage();
            if (!empty($message) ) {
                $this->_getCheckoutSession()->addError($message);
            }
            $this->_redirect('*/*/overview', array('_secure'=>true));
        } catch (Mage_Checkout_Exception $e) {
            Mage::helper('checkout')
                ->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'multi-shipping');
            $this->_getCheckout()->getCheckoutSession()->clear();
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/cart', array('_secure'=>true));
        }
        catch (Mage_Core_Exception $e){
            Mage::helper('checkout')
                ->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'multi-shipping');
            $this->_getCheckoutSession()->addError($e->getMessage());
            $this->_redirect('*/*/overview', array('_secure'=>true));
        } catch (Exception $e){
            Mage::logException($e);
            Mage::helper('checkout')
                ->sendPaymentFailedEmail($this->_getCheckout()->getQuote(), $e->getMessage(), 'multi-shipping');
            $this->_getCheckoutSession()->addError($this->__('Order place error.'));
        }
    }

    /**
     * Multishipping checkout succes page
     * 
     * @return void
     */
    public function successAction()
    {
        if (!$this->_getState()->getCompleteStep(Mage_Checkout_Model_Type_Multishipping_State::STEP_OVERVIEW)) {
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
    
    public function takeItemAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	$adr = $this->getRequest()->getParam('adrid');
    	$qty = $this->getRequest()->getParam('qty');
    	$this->_getCheckout()->takeItems($id,$adr,$qty);
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('sidcheckout/multishipping_quoteitems')->toHtml());
    }
    
    public function putbackItemAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	$adr = $this->getRequest()->getParam('adrid');
    	$qty = $this->getRequest()->getParam('qty');
    	$this->_getCheckout()->putbackItems($id,$adr,$qty);
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('sidcheckout/multishipping_quoteitems')->toHtml());
    }
    
    
}
