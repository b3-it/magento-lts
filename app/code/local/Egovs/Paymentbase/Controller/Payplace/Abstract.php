<?php
/**
 * Abstract Payplace Payment Controller
 * 
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Controllers_Payplace_Abstract
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Controller_Payplace_Abstract extends Mage_Core_Controller_Front_Action
{
	/**
	 * Aktuelle Order
	 * 
	 * @var Mage_Sales_Model_Order
	 */
	protected $_order = null;

	/**
	 * Get the current order with $_GET['real_order_id'] or the already cached order.
	 * 
	 * @return Mage_Sales_Model_Order
	 */
	protected function _getOrder() {
		if (!$this->_order || is_null($this->_order)) {
			$order = Mage::getModel('sales/order');
	        $order->loadByIncrementId($this->getRequest()->getParam('real_order_id'));
	        
	        $this->_order = $order;
		}
		
		return $this->_order;
	}
	/**
	 * Setzt den HTTP HEADER für Session expired.
	 * 
	 * Falls die aktuelle Quote keine Elemente besitzt, wird diese Maßnahme getroffen.
	 * 
	 * @return void
	 * 
	 */
	protected function _expireAjax() {

        if (! $this->getCheckout()->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1', '403 Session Expired');
            return;
        }
    }
    /**
     * Get singleton of Checkout Session Model
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout() {

        return Mage::getSingleton('checkout/session');
    }    
    
	/**
     * Der Payment-Gateway (Saferpay/Paypage) ruft diese Methode im Erfolgsfall auf
     * 
     * Template method
     * 
     * @return void
     */
    public final function successAction() {    	
    	$order = $this->_getOrder();
    	Mage::log($order->getPayment()->getMethod()."::success action called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$this->getCheckout()->setDisplaySuccess(true);
        
        $startTime = time();
        do {
        	Mage::log($order->getPayment()->getMethod()."::success action : Reload order with ID: {$order->getId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        	$order->load($order->getId());
        	Mage::log($order->getPayment()->getMethod()."::success action : Checking order with ID: {$order->getId()} and state: {$order->getState()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	        if ($order->isCanceled()) {
	        	$this->getCheckout()->setDisplaySuccess(false);
	        	Mage::getSingleton('checkout/session')->addError(Mage::helper($order->getPayment()->getMethod())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper('paymentbase')->getCustomerSupportMail()));
	        	$params = array('_secure' => $this->isSecureUrl());
	        	 
	        	$this->_redirect('checkout/cart', $params);
	        	return;
	        }
	        sleep(1);
	        $diffTime = time() - $startTime;
	        Mage::log($order->getPayment()->getMethod()."::success action : Waiting since $diffTime seconds for order modifications", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        } while ($diffTime < 10 && $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
        

        // everything allright, redirect the user to success page
        //damit verschiedene Checkouts verwendet werden können
        $successaction =  Mage::getStoreConfig('payment_services/paymentbase/successaction') ? Mage::getStoreConfig('payment_services/paymentbase/successaction') : 'egovs_checkout/multipage/successview';
        $this->_redirect($successaction, array('_secure'=>$this->isSecureUrl()));

    }
    /**
     * Modulspezifische Fehlerbehandlung
     * 
     * In der Implementierung muss ein Redirect aufgerufen werden!
     * 
     * @return void
     */
    protected abstract function _successActionRedirectFailure();
    /**
     * Behandelt das Abbrechen der Bestellung
     * 
	 * Eine mögliche Bestellung wird falls möglich storniert.<br>
	 * Es kann eine benutzerspezifische Fehlermeldung geworfen werden.<br>
	 * Am Ende erfolgt ein Redirect zum Warenkorb
	 * 
     * @param string $helper Name
     * @param string $msg    Nachricht
     * @param string $msgArg Argument für Nachricht, z. B. E-Mail für Support
     * 
     * @return void
     */
	protected function _cancel($helper, $msg = "Payment canceled.", $msgArg = null) {
    	if ($this->getCheckout()->getLastOrderId()) {
	    	/* @var $order Mage_Sales_Model_Order */
    		$order = Mage::getModel('sales/order')
	    				->load($this->getCheckout()->getLastOrderId())
	    	;
	    	
	    	if ($order->getId() && $order->canCancel()) {
	        	$order->cancel();
	        }
	        
	        $order->addStatusToHistory($order->getState(), Mage::helper($helper)->__($msg, $msgArg));
	        $order->save();
    	}
    	//TODO : Error sollte nur bei wirklichen Fehler angezeigt werden, bei manuellem abbruch wäre warning besser!
    	Mage::getSingleton('checkout/session')->addError(Mage::helper($helper)->__($msg, $msgArg));
    	$params = array('_secure' => $this->isSecureUrl());
    	
        $this->_redirect('checkout/cart', $params);
    }
    
    /**
     * Gibt an ob im Frontend die SECURE_BASE_URL verwendet werden soll
     * 
     * @return boolean
     */
    public function isSecureUrl() {
    	return Mage::getStoreConfigFlag(Mage_Core_Model_Store::XML_PATH_SECURE_IN_FRONTEND);
    }
    
    /**
     * Diese Action wird in der Funktion getOrderPlaceRedirectUrl aufgerufen.
     *
     * Template Funktion
     * Der State wird auf PENDING_PAYMENT gesetzt
     *
     * @return void
     */
    public final function redirectAction() {
    	 
    	// Get the current cart
    	$session = $this->getCheckout();
    
    	// get the order model
    	// get the order by its number
    	/* @var $order Mage_Sales_Model_Order */
    	$order = Mage::getModel('sales/order')
    		->loadByIncrementId($session->getLastRealOrderId())
    	;
    	$this->_order = $order;
    	
    	if ($order->getState() == ''
    			|| $order->getState() == Mage_Sales_Model_Order::STATE_NEW
    			|| $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT
    	) {
	    	//$order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
	    	// add a message to the history section in order management
	    	/* 2010/10/22 Frank Rochlitzer:
	    	 * States sind NICHT GLEICH Status!!!!!
	    	* Funktioniert hier aber!
	    	*/
	    	$this->_redirectActionAddStatusToHistory($order);
	    
	    	$order->save();
	    	 
	    	// Redirect über Header, unten nur noch Fallback
	    	$shared = $order->getPayment ()->getMethodInstance ();
	    	$url = "";
	    	
	    	try {
	    		$url = $shared->initPayplacePayment();
	    		$this->_redirectUrl($url);
	    	} catch (Zend_Controller_Response_Exception $zcre) {
	    		// a lot of code, but delivers the Block Redirect.php to the users
	    		$this->getResponse()->setBody($this->getLayout()->createBlock($this->_redirectBlockType)->setOrder($order)->toHtml());
	    	} catch (Exception $e) {
	    		Mage::log(sprintf("payplace::redirectAction:%s", $e->getMessage()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
	    		$this->_cancel('paymentbase', "TEXT_PROCESS_ERROR_STANDARD", Mage::helper('paymentbase')->getCustomerSupportMail());
	    	}
	    	return;
    	}
    	
    	Mage::getSingleton('checkout/session')->addError(Mage::helper('paymentbase')->__('This action was already executed!'));
    	$params = array('_secure' => $this->isSecureUrl());
    	 
    	$this->_redirect('checkout/cart', $params);
    }
    
    /**
     * Modulabhängige Statusnachrichten
     *
     * @param Mage_Sales_Model_Order $order Bestellinstanz
     *
     * @return void
     */
    protected abstract function _redirectActionAddStatusToHistory($order);
}