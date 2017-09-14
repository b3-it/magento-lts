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
     * @return Gka_Checkout_Model_Type_Singlepage_State
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

    
    private function __isDebug()
    {
    	$file = realpath(__DIR__.DS."..".DS."etc".DS.'debug.flag');
    	return file_exists($file);
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

        if ($action == 'PdfInvoice') {
        	return $this;
        }
        
        if ($this->_getCheckoutSession()->getCartWasUpdated(true) &&
            !in_array($action, array('index', 'login', 'register', 'addresses', 'success','overview','start'))
        ) {
            $this->_redirectUrl($this->_getHelper()->getCartUrl());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }

        if ($action == 'success' && $this->_getCheckout()->getCheckoutSession()->getDisplaySuccess(true)) {
            return $this;
        }

        //nur zum testen der success view, später entfernen
        //return $this;
        
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
        $this->_redirect('*/*/overview', array('_secure'=>true));
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
    	//die('ccc');
    		$this->_redirect('*/singlepage/overview', array('_secure'=>true));
            return;
    	
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

        
        $this->_getState()->setActiveStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW);
        $this->_getState()->setCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START);
        
        try {
        	//$quote = $this->_getCheckout()->getQuote();
        	//$quote->removeAllAddresses();
         	$this->_getCheckout()->setShippingMethod();
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
            $this->_redirect('*/cart', array('_secure'=>true));
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

        
        $billing = $this->getRequest()->getPost('billing', array());
        $payment = $this->getRequest()->getPost('payment', array());;
        
        
        try {
            
        	
        	
        	if(!isset($payment['method'])){
        		//Mage::getSingleton('core/session')->addError('Payment Method not set!');
        		Mage::getSingleton('core/session')->addError($this->__("Payment Method not set!"));
        		$this->_redirect('*/*/overview', array('_secure'=>true));
        		return;
        	}
        	
        	
          
        	if (!$this->_getState()->getCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_START)) {
        		$this->_redirect('*/*/overview', array('_secure'=>true));
        		return $this;
        	}

        	$this->_getCheckout()->setShippingMethod();
        	$this->_getCheckout()->setBillingAddress($billing);
        	$this->_getCheckout()->setShippingAddress($billing);
        	$this->_getCheckout()->setPaymentMethod($payment['method']);
            $givenamount = $this->getRequest()->getParam('givenamount', false);
            $this->_getCheckout()->createOrder($givenamount);
            
            $this->_getCheckout()->getCheckoutSession()->clear();
            $this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(true);
            $redirectUrl = $this->_getCheckout()->getCheckout()->getRedirectUrl();
            $this->_getState()->setActiveStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_SUCCESS);
            $this->_getState()->setCompleteStep(Gka_Checkout_Model_Type_Singlepage_State::STEP_OVERVIEW);
            
            
            if (isset($redirectUrl)) {
            	$this->_redirectUrl($redirectUrl);
            } else {
            	$this->_redirect('*/*/success', array('_secure'=>true));
            }
            
            
            
          
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
        
       
        $id = Mage::getSingleton('checkout/session')->getLastOrderId();
        if($id){
        	$order = Mage::getModel('sales/order')->load($id);
        }else{
        	$order = new Varien_Object();
        }
        Mage::register('current_order', $order);
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $ids = $this->_getCheckout()->getOrderIds();
        Mage::dispatchEvent('checkout_multishipping_controller_success_action', array('order_ids' => $ids));
        $this->renderLayout();
    }
    
    
    public function paymentAdditionalFormAction()
    {
    	$method = $this->getRequest()->getParam('method');
    	$out = "";
    	if($method == 'epaybl_cashpayment')
    	{
	    	$block = $this->getLayout()->createBlock(
	    			'Gka_Checkout_Block_Singlepage_Givenamount',
	    			'add_payment',
	    			array('template' => 'checkout/singlepage/givenamount.phtml')
	    			);
	       $out = $block->toHtml();
    	}
    	$this->getResponse()->setBody($out);
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
    
	 /***
	  * Rechnung als Pdf Anzeigen
	  * @return Mage_Adminhtml_Controller_Action
	  */
    public function PdfInvoiceAction()
    {
    	$orderId = $this->getRequest()->getParam('order_id');
    	$flag = false;
    	
    	/** @var $invoices Mage_Sales_Model_Resource_Order_Invoice_Collection */
    	$invoices = Mage::getResourceModel('sales/order_invoice_collection')
    	->setOrderFilter($orderId);
    	
    	//sicherstellen das der Kunde auch seine Rechnung druckt
    	$customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
    	$invoices->getSelect()
    		->join(array('order'=>$invoices->getTable('sales/order')),'main_table.order_id = order.entity_id AND customer_id='.$customer_id);
    	
    	$invoices->load();
    	if ($invoices->getSize()){
    		$flag = true;
    		if (!isset($pdf)){
    			$pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
    		} else {
    			$pages = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
    			$pdf->pages = array_merge ($pdf->pages, $pages->pages);
    		}
    	}
    	
    	if ($flag) {
    		return $this->_prepareDownloadResponse(
    				'docs'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf',
    				$pdf->render(), 'application/pdf'
    				);
    	} else {
    		Mage::getSingleton('customer/session')->addError($this->__('There are no printable documents related to selected orders.'));
    		$this->_redirect('*/*/');
    	}
    }
    
}
