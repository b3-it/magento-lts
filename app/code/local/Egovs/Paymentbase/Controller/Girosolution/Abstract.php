<?php
/**
 * Abstract Payment Controller für Girosolution
 * 
 * !!!!Achtung!!!!: 
 * Die Funktion aktiviereTempKassenzeichen() wird über _callSoapClientImpl(...) aufgerufen.
 * Die Funktion _callSoapClientImpl(...) wird jedoch nur in der NOTIFY ACTION aufgerufen, welche
 * direkt vom Zahlungsprovider aus angesprochen wird.
 * Änderungen an der ORDER werden nur in der NOTIFY ACTION vorgenommen.
 * 
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Controllers_Girosolution_Abstract
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Controller_Girosolution_Abstract extends Mage_Core_Controller_Front_Action
{
	/**
	 * Aktuelle Order
	 * 
	 * @var Mage_Sales_Model_Order
	 */
	protected $_order = null;
	
	/**
	 * Liefert den Modulnamen
	 * 
	 * Modulspezifische Implementierung
	 * 
	 * @return string
	 */
	protected abstract function _getModuleName();
	
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
	 * Deaktiviert den Securityfilter für die Saferpay-Aufrufe
	 * 
	 * Der Filter zerstört sonst die Saferpay IDP Messages<br>
	 * Der Filter wird automatisch wieder aktiviert.
	 * 
	 * @return Mage_Core_Controller_Front_Action 
	 *  
	 * @see Mage_Core_Controller_Front_Action::preDispatch()
	 * 
	 */
    public function preDispatch() {
    	/* 20110408 Frank Rochlitzer
    	 * We have to disable the Security Filter to let payment providers work correct
    	 * The filter is enabled in success view again
    	 */
    	if (Mage::helper('paymentbase')->isModuleEnabled('Egovs_Base')) {
    		Egovs_Base_Model_Security_Filter::enableXMLFilter(false);
    		Egovs_Base_Model_Security_Filter::enableSpecialCharFilter(false);
    	}
    	//Die Session ID soll nicht neu generiert werden!
    	$this->setFlag('', 'no_regenerate_id', true);
    	return parent::preDispatch();
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
     * Liefert Debug-Flag
     *
     * @return boolean
     */
    public abstract function getDebug();
    
    /**
     * Modulabhängige Statusnachrichten
     * 
     * @param Mage_Sales_Model_Order $order Bestellinstanz
     * 
     * @return void
     */
    protected abstract function _redirectActionAddStatusToHistory($order);
    
	/**
     * Der Zahlungsprovider ruft diese Aktion zur Bestätigung der Transaktion auf.
     * 
     * Vom Kunden unabhängige Bestätigung der Transkation durch Zahlungsprovider
     * 
     * @return void
     */
    public function notifyAction() {
    	//Dieser Teil muss in weniger als 10 Sekunden abgearbeitet sein,
    	//da sonst ein erneutes NOTIFY ausgelöst wird.
    	
    	$module = $this->_getModuleName();
    	
    	Mage::log("$module::notify action called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	
    	// do nothing, if not a GET request
    	if (!$this->getRequest()->isGet()) {
    		$this->norouteAction();
    		Mage::log("$module::The request was not a GET request!", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
    		return;
    	}
    	
    	// clear response
    	$this->getResponse()->clearAllHeaders()->clearBody();
		
    	//Order muss später unbedingt neu geladen werden!
    	$this->_order = null;    	
    	
    	$realOrderID = $this->getRequest()->getParam('real_order_id', 'not set');
    	Mage::log(sprintf("$module::NOTIFY_ACTION:Real order ID is %s", $realOrderID), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	
    	if ($this->getDebug()) {
	    	//TODO: Debug to force second notify!
	    	Mage::log("$module::SLEEP for 10 seconds to force second NOTIFY from payment provider!", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	    	sleep(10);
    	}
    	
    	// check if the response is valid
        $status = $this->_callCheckReturnedMessageImpl();
        
        if ($status == true) {
        	$this->getResponse()->setHttpResponseCode(200);
        	$this->getResponse()->sendResponse();
        } else {
        	$this->getResponse()->setHttpResponseCode(400);
        	$this->getResponse()->sendResponse();
        }
        Mage::log("$module::...notify action finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        
        exit;
    }
    
	/**
     * Der Payment-Gateway (Saferpay/Paypage) ruft diese Methode im Erfolgsfall auf
     * 
     * Template method
     * 
     * @return void
     */
    public final function successAction() {    	
		Mage::log($this->_getModuleName()."::success action called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$this->getCheckout()->setDisplaySuccess(true);
        // check if the response is valid
        sleep(1);
        $status = $this->_callCheckReturnedMessageImpl();
        
        $order = $this->_getOrder();
        $startTime = time();
        do {
        	Mage::log($this->_getModuleName()."::success action : Reload order with ID: {$order->getId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        	$order->load($order->getId());
        	Mage::log($this->_getModuleName()."::success action : Checking order with ID: {$order->getId()} and state: {$order->getState()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	        if ($order->isCanceled()) {
	        	$this->getCheckout()->setDisplaySuccess(false);
	        	$this->getCheckout()->setQuoteId($order->getQuoteId());
	        	$this->getCheckout()->setLoadInactive(true);
	        	$this->getCheckout()->getQuote()->setIsActive(true)->save();
	        	$params = array('_secure' => $this->isSecureUrl());
	        	 
	        	$this->_redirect('checkout/cart', $params);
	        	return;
	        }
	        sleep(1);
	        $diffTime = time() - $startTime;
	        Mage::log($this->_getModuleName()."::success action : Waiting since $diffTime seconds for order modifications", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        } while ($diffTime < 10 && ($order->getState() == Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW || $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT));
        
        if ($status) {
            // everything allright, redirect the user to success page
            //damit verschiedene Checkouts verwendet werden können
            $successaction =  Mage::getStoreConfig('payment_services/paymentbase/successaction') ? Mage::getStoreConfig('payment_services/paymentbase/successaction') : 'egovs_checkout/multipage/successview';
            $this->_redirect($successaction, array('_secure'=>$this->isSecureUrl()));
        } else {
            /*
			 * something was wrong with either the command line tool or someone
			 * tried to fake the response, so we redirect to failure page
			 */
        	
            $this->_successActionRedirectFailure();
        }
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
     * Ruft die Standard- bzw Modulimplementation zum Prüfen der Nachricht auf
     * 
     * @return boolean
     * 
     * @see Egovs_Paymentbase_Controller_Abstract::__checkReturnedMessage
     */
	protected function _callCheckReturnedMessageImpl() {
    	return $this->_checkReturnedMessage();
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
     * Validiert die Antwort des Zahlungsproviders -- Template Method --
     * 
     * @return boolean
     * 
     */
    protected function _checkReturnedMessage() {
    	$module = $this->_getModuleName();
    	Mage::log("$module::_checkReturnedMessage called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	
    	$order = $this->_getOrder();
    	if (!$order || $order->isEmpty()) {
    		Mage::log("$module::No order available.", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    		return false;
    	}
    	
    	/* !Wichtig! Initialisiert Girosolution API! */
    	/** @var $paymentMethod Egovs_Paymentbase_Model_Girosolution **/
    	$paymentMethod = $order->getPayment()->getMethodInstance();
    	
    		
    	//Retrieves the project password.
    	$projectPassword = $paymentMethod->getProjectPassword();
    	
    	try {
    		//Get the notification
    		$notify = new GiroCheckout_SDK_Notify($paymentMethod->getTransactionType());
    		$notify->setSecret($projectPassword);
    		$notify->parseNotification($this->getRequest()->getParams());
    		
    		if (!$notify->paymentSuccessful()) {
                $iReturnCode = intval($notify->getResponseParam("gcResultPayment"));
    			switch ($iReturnCode) {
    				/* Giropay
    				 * 4001 	giropay Bank offline
    				 * 4002 	Online Banking Zugang ungültig
    				 * 4500 	Zahlungsausgang unbekannt
    				 */
    				case 4001:
    					$msg = Mage::helper("egovs_girosolution")->__("giropay Bank offline");
    					break;
    				case 4002:
    					$msg = Mage::helper("egovs_girosolution")->__("Online banking account invalid");
    					break;
    				case 4500:
    					$msg = Mage::helper("egovs_girosolution")->__("Payment result unknown");
    					break;
    				//Kreditkarte
    				case 4101:
    					$msg = Mage::helper("egovs_girosolution")->__("Country of creditcard not accepted or unknown");
    					break;
    				case 4102:
    					$msg = Mage::helper("egovs_girosolution")->__("3D-Secure authorization unsuccessful");
    					break;
    				case 4103:
    					$msg = Mage::helper("egovs_girosolution")->__("Date of expiry exceeded");
    					break;
    				case 4104:
    					$msg = Mage::helper("egovs_girosolution")->__("Type of creditcard is not valid or unknown");
    					break;
    				case 4107:
    					$msg = Mage::helper("egovs_girosolution")->__("Card stolen, suspicious or marked for drawing");
    					break;
    				//Allgemein
    				case 4501:
    					$msg = Mage::helper("egovs_girosolution")->__("Timeout / No user action");
    					break;
    				case 4502:
    					$msg = Mage::helper("egovs_girosolution")->__("Abort by customer");
    					break;
    				case 4503:
    					$msg = Mage::helper("egovs_girosolution")->__("Duplicate transactions");
    					break;
    				case 4504:
    					$msg = Mage::helper("egovs_girosolution")->__("Fraud suspicion or payment method is temporary disabled");
    					break;
    				case 4505:
    					$msg = Mage::helper("egovs_girosolution")->__("Payment method locked or denied");
    					break;
    				case 4900:
    					$msg = Mage::helper("egovs_girosolution")->__("Transaction unsuccessful");
    					break;
    				default:
                        $msg = $notify->getResponseMessage($iReturnCode, Mage::helper('egovs_girosolution')->getLanguageCode());
    			}

    			if (!$msg) {
                    $msg = Mage::helper("egovs_girosolution")->__("Can't validate Girosolution message or message was invalid!");
                }

    			$data = var_export($notify->getResponseParams(), true);
    			Mage::log(sprintf("$module:: Girosolution payment unsuccessful : %s\r\n%s", $msg, $data), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    			
    			$orderFound = $paymentMethod->modifyOrderAfterPayment(
    					false,
    					$this->getRequest()->getParam('gcMerchantTxId', ''),
    					true,
    					$msg,
    					true,
    					false,
    					'',
    					$notify->getResponseParam('gcReference'),
    					$notify->getResponseParams()
    			);
    			
    			Mage::log("$module::... _checkReturnedMessage finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    			
    			return false;
    		} else {
    			Mage::log(sprintf("$module::... _checkReturnedMessage with valid DATA called:\r\n%s...", var_export($notify->getResponseParams(), true)), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    			
    			$msg = Mage::helper("egovs_girosolution")->__('Customer successfully granted by Girosolution<br /><strong>Transaction ID: %s</strong>', $notify->getResponseParam('gcReference'));
    			$orderFound = $paymentMethod->modifyOrderAfterPayment(
    					true,
    					$this->getRequest()->getParam('gcMerchantTxId', ''),
    					true,
    					$msg,
    					true,
    					true,
    					'',
    					$notify->getResponseParam('gcReference'),
    					$notify->getResponseParams()
    			);
    			
    			Mage::log("$module::... _checkReturnedMessage finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    			
    			return $orderFound;
    		}
    	} catch (Exception $e) {
    		Mage::logException($e);
    	}
    	Mage::log("$module::... _checkReturnedMessage finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	return false;
    }
}