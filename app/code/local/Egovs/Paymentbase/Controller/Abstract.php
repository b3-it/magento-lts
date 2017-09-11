<?php
/**
 * Abstract Payment Controller
 * 
 * !!!!Achtung!!!!: 
 * Die Funktion aktiviereTempXXXKassenzeichen() wird über _callSoapClientImpl(...) aufgerufen.
 * Die Funktion _callSoapClientImpl(...) wird jedoch nur in der NOTIFY_ACTION aufgerufen, welche
 * direkt von Saferpay aus angesprochen wird.
 * Änderungen an der ORDER werden nur in der NOTIFY_ACTION vorgenommen.
 * 
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Controllers_Abstract
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Controller_Abstract extends Mage_Core_Controller_Front_Action
{
	/**
	 * Aktuelle Order
	 * 
	 * @var Mage_Sales_Model_Order
	 */
	protected $_order = null;
	/**
	 * IDP Message von Saferpay
	 * 
	 * @var string
	 */
	protected $_saferpayIDP = null;
	/**
	 * Signature von Saferpay-Message
	 * 
	 * @var string
	 */
	protected $_signature = null;
	/**
	 * Gibt die aktuelle Signatur zurück
	 * 
	 * Falls die Signatur zum ersten mal benötigt wird, wird diese aus dem Request geholt.
	 * 
	 * @return string
	 */
	protected function _getSignature() {
		if (!$this->_signature) {
			$this->_signature = $this->getRequest()->get('SIGNATURE');
		}
		
		return $this->_signature;
	}
	/**
	 * Gibt die aktuelle IDP Message zurück
	 * 
	 * Falls die IDP zum ersten mal benötigt wird, wird diese aus dem Request geholt.
	 * 
	 * @return string
	 */
	protected function _getSaferPayIDP() {
		if (is_null($this->_saferpayIDP) || !$this->_saferpayIDP) {
			$data = $this->getRequest()->get('DATA');
			$dom = new domDocument();
	        if (!$dom->loadXML($data)) {
	        	return false;
	        }
	        
	        $idp = $dom->getElementsByTagName('IDP')->item(0);
	        $this->_saferpayIDP = $idp;
		}
		
		return $this->_saferpayIDP;
	}
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
    	 * We have to disable the Security Filter to let Saferpay work correct
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
                
        $this->_redirectAction($session);
        
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
	        $order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
	        // add a message to the history section in order management
	        /* 2010/10/22 Frank Rochlitzer:
	         * States sind NICHT GLEICH Status!!!!!
	         * Funktioniert hier aber!
	         */
	        $this->_redirectActionAddStatusToHistory($order);
	        
	        $order->save();
	       
	        // Redirect über Header, unten nur noch Fallback
	        $shared = $order->getPayment ()->getMethodInstance ();
	        $url = $shared->getSaferpayUrl();
	        try {
	        	$this->_redirectUrl($url);
	        } catch (Zend_Controller_Response_Exception $zcre) {
	        	// a lot of code, but delivers the Block Redirect.php to the users
	        	$this->getResponse()->setBody($this->getLayout()->createBlock($this->_redirectBlockType)->setOrder($order)->toHtml());
	        }
	        return;
        }
        
        Mage::getSingleton('checkout/session')->addError(Mage::helper('paymentbase')->__('This action was already executed!'));
    	$params = array('_secure' => $this->isSecureUrl());
    	
        $this->_redirect('checkout/cart', $params);
    }
    
    /**
     * Einige implementations spezifische Befehle
     *  
     * @param Mage_Checkout_Model_Session &$session Checkout Session
     * 
     * @return void
     */
    protected function _redirectAction(&$session) {
    	$session->setSaferpayQuoteId($session->getQuoteId());
    	$session->setSaferpayRealOrderId($session->getLastRealOrderId());
    }
    
    /**
     * Modulabhängige Statusnachrichten
     * 
     * @param Mage_Sales_Model_Order $order Bestellinstanz
     * 
     * @return void
     */
    protected abstract function _redirectActionAddStatusToHistory($order);
    
	/**
     * Saferpay calls this action if confirmation page is displayed.
     * 
     * User independant confirmation to the shop
     * Saferpay calls this again after a timeout of 10 seconds.
     * 
     * @return void
     */
    public function notifyAction() {
    	//Dieser Teil muss in weniger als 10 Sekunden abgearbeitet sein,
    	//da sonst ein erneutes NOTIFY ausgelöst wird.
    	//=======================================================================================================
    	if (function_exists('microtime')) {
    		$startTime = microtime(true);
    	} else {
    		$startTime = time();
    	}
    	
    	$module = $this->_getModuleName();
    	
    	Mage::log("$module::notify action called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        
    	/*
    	 * 20150122::Frank Rochlitzer
    	 * Setzen des mutex via APC schlägt mit CGI fehl
    	 */
    	$cgiMode = false;
    	$sapiType = php_sapi_name();
    	if (strtolower(substr($sapiType, 0, 3)) == 'cgi') {
    		Mage::log("$module::notify in CGI mode", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    		$cgiMode = true;
    	}
    	/*
    	 * 20110804:Frank Rochlitzer
    	 * Die mehrfache Ausführung dieser Funktion muss verhindert werden!
    	 * Durch die BSI-Restriktionen kann die Session ID nicht an die NOTIFY URL angehängt werden,
    	 * da der Saferpay-Aufruf eine andere IP besitzt als der Kunde der entsprechenden Bestellung.
    	 * Jeder Aufruf der NOTIFY_ACTION von Saferpay wird als eigene Session behandelt, da in der URL keine
    	 * SID enthalten ist.
    	 * 
    	 * Der einzige Parameter ist die REAL_ORDER_ID mit der die entsprechende Order identifiziert werden kann.
    	 * Es kann also nur ein Flag an der Order zur Kontrolle verwendet werden!
    	 * Diese Aktionen sind jedoch nicht atomar und bieten somit keine 100% Sicherheit.
    	 * 
    	 * Die konsequente Lösung wäre die Benutzung eines Semaphores, diese sind in PHP aber nur unter Linux/Unix
    	 * verfügbar und sind standarmäßig deaktiviert.
    	 */
    	
//    	Mage::log(sprintf("$module::Saferpay notify get order with ID %s!", $this->_getOrder()->getId()), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    	if (function_exists('apc_add') && function_exists('apc_fetch') && !$cgiMode) {
    		$apcKey = 'roi_mutex'.$this->getRequest()->getParam('real_order_id');
    		if (apc_fetch($apcKey)) {
    			Mage::log("$module::NOTIFY_ACTION:APC_FETCH:Saferpay notify already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    			return;
    		}
    		//dauert ca. 1msec
    		//TTL = 180s = 3Min
    		$apcAdded = apc_add($apcKey, true, 180);
    	}
    	//20150126::Frank Rochlitzer:Wir setzen den Status immer => falls APC fehlschlägt
    	//Sobald der Status nicht mehr PENDING_PAYMENT ist, wurde die Order schon behandelt!
    	//Der Status ist mit dem State identisch benannt.
    	if ($this->_getOrder()->isEmpty()) {
    		Mage::log("$module::NOTIFY_ACTION:Order is empty, omitting!", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
    		return;
    	}
    	if ($this->_getOrder()->getData('status') != Mage_Sales_Model_Order::STATE_PENDING_PAYMENT) {
    		Mage::log("$module::NOTIFY_ACTION:Saferpay notify already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    		return;
    	}
    	//dauert ca. 340msec
    	//$this->_getOrder()->setData('status', 'notify')->save();
    	//dauert ca. 32msec
    	$this->_getOrder()->setData('status', 'notify');
    	$resource = $this->_getOrder()->getResource();
    	$resource->saveAttribute($this->_getOrder(), 'status');
    	
    	if (function_exists('microtime')) {
    		$endTime = microtime(true);
    	} else {
    		$endTime = time();
    	}
    	$runTime = $endTime - $startTime;
    	if ($runTime > 8) {
    		Mage::log("$module::NOTIFY_ACTION:Server seems to be under heavy load, it's not possible to assure a second try to activate the Kassenzeichen!", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
    	} else {
    		Mage::log(sprintf("$module::NOTIFY_ACTION:Measured runtime for MUTEX was %s seconds.", $runTime), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	}
		//=======================================================================================================
		
    	//Order muss später unbedingt neu geladen werden!
    	$this->_order = null;    	
    	
    	$realOrderID = $this->getRequest()->getParam('real_order_id', 'not set');
    	Mage::log(sprintf("$module::NOTIFY_ACTION:Real order ID is %s", $realOrderID), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	
    	if ($this->getDebug()) {
	    	//TODO: Debug to force second Saferpay notify!
	    	Mage::log("$module::SLEEP for 10 seconds to force second NOTIFY from Saferpay!", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	    	sleep(10);
    	}
    	
    	// check if the response is valid
        $status = $this->_callCheckReturnedMessageImpl();
        
    	if ($status) {
    		$this->_prepareOrder();
    		
            /*// get the order information
            $session = $this->getCheckout();
            $session->getQuote()->setIsActive(false)->save();   */         
        } else {
        	/*
			 * something was wrong with either the command line tool or someone
			 * tried to fake the response, so we redirect to failure page
			 */
            $order = $this->_getOrder();
	    		    	
	    	if ($order->getId() && $order->canCancel()) {
	        	$order->cancel();
	        }
	        $msg = "Can't validate Saferpay message or message was invalid!";
	        $order->addStatusToHistory($order->getState(), Mage::helper($module)->__($msg));
	        $order->save();
        }
        Mage::log("$module::...notify action finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    }
    
    /**
     * Präpariert die Order für den weiteren Prozess
     * 
     * <ul>
     * 	<li>Aktiviert das Kassenzeichen</li>
     * 	<li>Erstellt die nötige Rechnung</li>
     * 	<li>Setzt den State mit Status</li>
     * </ul>
     * 
     * @return void
     */
    protected function _prepareOrder() {
    	Mage::log("saferpay::_prepareOrder called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	/*
		 * if everything is alright with the payment, (it should be as saferpay
		 * called the success url, the result from the command line payment confirm
		 * process should be an xml-element as well
		 * so we create a new domDocument
		 */
        $idp = $this->_getSaferPayIDP();
        $module = $this->_getModuleName();
        
        if (!$idp) {
        	Mage::log("saferpay::No IDP available aborting!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
        	$this->_successActionRedirectFailure();
        }
        
        if ($this->getDebug()) {
            $debugResponse = array();
            $debugResponse['MSGTYPE'] = $idp->getAttribute('MSGTYPE');
            $debugResponse['KEYID'] = $idp->getAttribute('KEYID');
            $debugResponse['ID'] = $idp->getAttribute('ID');
            $debugResponse['AMOUNT'] = $idp->getAttribute('AMOUNT');
            $debugResponse['CURRENCY'] = $idp->getAttribute('CURRENCY');
            $debugResponse['PROVIDERID'] = $idp->getAttribute('PROVIDERID');
            $debugResponse['PROVIDERNAME'] = $idp->getAttribute('PROVIDERNAME');
            $debugResponse['ORDERID'] = $idp->getAttribute('ORDERID');
            $debugResponse['ACCOUNTID'] = $idp->getAttribute('ACCOUNTID');
            $debugResponse['ECI'] = $idp->getAttribute('ECI');
            $debugResponse['CCCOUNTRY'] = $idp->getAttribute('CCCOUNTRY');
            $debugResponse['SIGNATURE'] = $this->_getSignature();
            
            $tmp = '';
            foreach ($debugResponse as $k => $v) {
                $tmp .= '<' .$k .'>' .$v .'</' .$k .'>';
            }
            Mage::log("saferpay::\n$tmp", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        }
        
        $order = $this->_getOrder();
        
        $paymentInst = $order->getPayment()->getMethodInstance();
        
        if ($idp->getAttribute('MSGTYPE') =='PayConfirm') {
            /*
			 * now we are sure that the payment was successful as the result xml
			 * element from the command line tool contains an attribute MSGTYPE
			 * with value PayConfirm. We process the payment.
			 */
        	
	        /*
	         * 20110802 : Frank Rochlitzer
	         * Die notify Action wird direkt von Saferpay aufgerufen (URL wird vorher übergeben)
	         * 
	         */
	        Mage::log("$module::NOTIFY_ACTION:WS aktiviereTempKassenzeichen() kann aufgerufen werden", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
	        $_providerId = intval($idp->getAttribute('PROVIDERID'));
	        switch ($_providerId) {
	        	case 102:
	        	case 2:
	        		$_providerName = "Visa";
	        		break;
	        	case 104:
	        	case 1:
	        		$_providerName = "Master";
	        		break;
	        	case 77:
	        	default:
	        		$_providerName = 'AMEX';
	        }

			// so, jetzt Zugriff auf SOAP-Schnittstelle beim eGovernment
			$objSOAPClient = Mage::helper('paymentbase')->getSoapClient();
			$objResult = null;
			for ($i = 0; $i < 3 && !($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis) && (!$objResult || !$objResult->isOk()); $i++) {
				Mage::log(sprintf("$module::NOTIFY_ACTION:Try %s to activate kassenzeichen...", $i+1), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				try {
					//Aktiviert z. B. das Kassenzeichen
					$objResult = $this->_callSoapClientImpl($objSOAPClient, $idp, Mage::helper('paymentbase')->getMandantNr(), $_providerName);
				} catch (Exception $e) {
					Mage::log(sprintf("$module::NOTIFY_ACTION:Activating Kassenzeichen failed: %s", $e->getMessage()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				}
			}
			Mage::log(sprintf("$module::NOTIFY_ACTION:Tried to activate Kassenzeichen, validating result...", $i+1), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
						
			// wenn Web-Service nicht geklappt hat
			if (!$objResult || !$objResult->isOk()) {
				$kassenzeichen = 'empty';
				$subject = "$module::NOTIFY_ACTION:WS aktiviereTempKassenzeichen() nicht erfolgreich";
				$sMailText = '';
				if ($order->getPayment()->hasData('kassenzeichen')) {
					$kassenzeichen = $order->getPayment()->getKassenzeichen();
				
					Mage::log("$subject!\n\nKassenzeichen:$kassenzeichen\n\n".var_export($objResult, true), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
					$sMailText = "Während der Kommunikation mit dem ePayment-Server trat ein Fehler auf!\n\nKassenzeichen:$kassenzeichen\n";
					$sMailText .= "Falls das jeweilige Kassenzeichen bereits aktiviert wurde, kann dieser Fehler ignoriert werden.\n";
					$sMailText .= "Überprüfen Sie hierzu die entsprechenden Protokolldateien (Logfiles)!\n\n";
					if ($objResult) {
						$sMailText .= "ObjResult:\n".var_export($objResult, true);
					}
				} else {
					Mage::log("$subject\n\n".var_export($objResult, true), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
					$sMailText = "Während der Kommunikation mit dem ePayment-Server trat ein Fehler auf!\n\n";
					$sMailText .= "Überprüfen Sie hierzu die entsprechenden Protokolldateien (Logfiles)!\n\n";
					if ($objResult) {
						$sMailText .= "ObjResult:\n".var_export($objResult, true);
					}
				}
				Mage::helper("paymentbase")->sendMailToAdmin($sMailText, $subject);
			} else {
				$kassenzeichen = 'empty';
				if ($order->getPayment()->hasData('kassenzeichen')) {
					$kassenzeichen = $order->getPayment()->getKassenzeichen();
					Mage::log("$module::NOTIFY_ACTION:Using Kassenzeichen: $kassenzeichen", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				} else {
					Mage::log("$module::Fehler:WS kein Kassenzeichen im Payment enthalten", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
					$sMailText = "WS kein Kassenzeichen im Payment enthalten!";
									
					Mage::helper("paymentbase")->sendMailToAdmin($sMailText);
				}
				Mage::log("$module::WS Kassenzeichen successfully activated : $kassenzeichen", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			}
			
            $invoicable = false;
            //20131113::Frank Rochlitzer
            //Bei Verbindungsfehler während aktivierenKassenzeichen wurde trotzdem die Order auf bezahlt gesetzt!
            if ($order->canInvoice() && $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT
            	&& $objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis && $objResult->isOk()
            ) {
                // it's a valid order
                Mage::log("$module::Order is valid, preparing invoice...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
                $invoicable = true;
                		        
                $order->getPayment()->setData('saferpay_transaction_id', $idp->getAttribute('ID'));
                $paymentInst->setTransactionId($idp->getAttribute('ID'));
                
                if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
                	//Magento 1.3
	                $orderState = $order->getIsVirtual()
	                            ? Mage_Sales_Model_Order::STATE_COMPLETE
	                            : Mage_Sales_Model_Order::STATE_PROCESSING;
                } else {
                	//STATE_COMPLETE ist in Magento 1.6 geschützt
                	//wird für Virtuelle Produkte aber automatisch gesetzt
                	$orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
                }
                $order->setState($orderState);
                
                $orderStatus = Mage::getStoreConfig("payment/$module/order_status");
                
	            if (!$orderStatus || $order->getIsVirtual()) {
	                $orderStatus = $order->getConfig()->getStateDefaultStatus($orderState);
	            }
	            
	            $order->sendNewOrderEmail();
                // we add a status message to the message-section in admin
                $order->addStatusToHistory($orderStatus, Mage::helper("$module")->__('Customer successfully granted by Saferpay<br /><strong>Transaction ID: %s</strong>', $idp->getAttribute('ID')), true);
                
                $invoice = $order->prepareInvoice();
                
                $invoice->register();
                if ($paymentInst->canCapture()) {
                	$invoice->capture();
                }
                $order->addRelatedObject($invoice);
                $invoice->setOrder($order);
                $invoice->save();
                Mage::log("$module::NOTIFY_ACTION:dispatching event:egovs_paymentbase_saferpay_sales_order_invoice_after_pay", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
                Mage::dispatchEvent('egovs_paymentbase_saferpay_sales_order_invoice_after_pay', array('invoice'=>$invoice));
                Mage::log("$module::NOTIFY_ACTION:dispatched event:egovs_paymentbase_saferpay_sales_order_invoice_after_pay", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
                Mage::log("$module::NOTIFY_ACTION:...invoice created", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            }

            //Nur in der notify action wird der state verändert!
            if (!$invoicable && !$order->hasInvoices()) {
                /*
				 * payment was not successfull. this code should not be executed
				 * to make it safe, we redirect to failure action
				 */
            	$msg= Mage::helper("$module")->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper('paymentbase')->getCustomerSupportMail());
                Mage::log("$module::NOTIFY_ACTION:NOT INVOICABLE NO EXISTING INVOICES : $msg", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
                $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED, $msg, true);
                if ($order->canCancel()) {
                	$order->cancel();
                }
                $order->sendOrderUpdateEmail(true, Mage::helper("$module")->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper('paymentbase')->getCustomerSupportMail()));
                $this->getResponse()->setHeader('HTTP/1.1', '500 Internal Server Error', true);
            } else {
            	$order->addStatusToHistory($order->getState(), Mage::helper($module)->__('Order is now ready for processing'));
            }
	        $order->save();
            Mage::log("$module::NOTIFY_ACTION:order saved!", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        } else {
            /*
			 * payment was not successfull. this code should not be executed
			 * to make it safe, we redirect to failure action
			 */
            
        	Mage::log("$module::NOTIFY_ACTION:Error: 'MSGTYPE' != 'PayConfirm' : ".Mage::helper("$module")->__('Customer was rejected by Saferpay'), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED, Mage::helper("$module")->__('Customer was rejected by Saferpay'));
            $this->_successActionRedirectFailure();
        }
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
        $status = $this->_callCheckReturnedMessageImpl();
        
        $order = $this->_getOrder();
        $startTime = time();
        do {
        	Mage::log($this->_getModuleName()."::success action : Reload order with ID: {$order->getId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        	$order->load($order->getId());
        	Mage::log($this->_getModuleName()."::success action : Checking order with ID: {$order->getId()} and state: {$order->getState()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	        if ($order->isCanceled()) {
	        	$this->getCheckout()->setDisplaySuccess(false);
	        	Mage::getSingleton('checkout/session')->addError(Mage::helper($this->_getModuleName())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper('paymentbase')->getCustomerSupportMail()));
	        	$params = array('_secure' => $this->isSecureUrl());
	        	 
	        	$this->_redirect('checkout/cart', $params);
	        	return;
	        }
	        sleep(1);
	        $diffTime = time() - $startTime;
	        Mage::log($this->_getModuleName()."::success action : Waiting since $diffTime seconds for order modifications", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        } while ($diffTime < 10 && $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
        
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
     * Behandelt das Abbrechen der Bestellung
     * 
	 * Eine mögliche Bestellung wird falls möglich storniert.<br>
	 * Es kann eine benutzerspezifische Fehlermeldung geworfen werden.<br>
	 * Am Ende erfolgt ein Redirect zum Warenkorb
	 * 
     * @param string $helper Name
     * @param string $msg    Nachricht
     * 
     * @return void
     */
	protected function _cancel($helper, $msg = "Payment canceled.") {
    	if ($this->getCheckout()->getLastOrderId()) {
	    	/* @var $order Mage_Sales_Model_Order */
    		$order = Mage::getModel('sales/order')
	    				->load($this->getCheckout()->getLastOrderId())
	    	;
	    	
	    	if ($order->getId() && $order->canCancel()) {
	        	$order->cancel();
	        }
	        
	        //TODO : Error sollte nur bei wirklichen Fehler angezeigt werden, bei manuellem abbruch wäre warning besser!
	        $order->addStatusToHistory($order->getState(), Mage::helper($helper)->__($msg));
	        $order->save();
    	}
    	
    	Mage::getSingleton('checkout/session')->addError(Mage::helper($helper)->__($msg));
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
     * Ruft die Standard- bzw Modulimplementation des cURL-Aufrufs auf
     * 
     * @param string $payconfirm_url URL
     * @param array  $fields         Parameter
     * 
     * @return string URL
     * 
     * @see Egovs_Paymentbase_Model_Curl::getResponse
     */
	protected function _callCurlImpl($payconfirm_url, $fields = array()) {
    	return Egovs_Paymentbase_Model_Curl::getResponse($payconfirm_url, $fields);
    }
    
    /**
     * SOAP-Aufruf am ePayment-Server
     * 
     * Modulspzifische Implementation des Aufrufs
     * 
     * @param object $objSOAPClient SOAPClient
	 * @param object $idp           Saferpay-Nachrichten-Objekt
	 * @param string $mandantNr     Mandanten Nr.
	 * @param string $_providerName Gilt nur für Kreditkarten
	 * 
	 * @return Egovs_Paymentbase_Controller_Abstract Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
     * 
     * @throws Exception
     */
    protected abstract function _callSoapClientImpl($objSOAPClient, $idp, $mandantNr, $_providerName);
    
    /**
     * Validiert die Antwort von Saferpay -- Template Method --
     * 
     * @return boolean
     * 
     * @see Egovs_Paymentbase_Controller_Abstract::_callCurlImpl
     */
    protected function _checkReturnedMessage() {
    	$module = $this->_getModuleName();
    	Mage::log("$module::_checkReturnedMessage called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        $signature = $this->getRequest()->get('SIGNATURE');
        $this->_signature = $signature;
        $data = $this->getRequest()->get('DATA');
        
        // $data contains an xml element, so create an xml object of it
        $dom = new DOMDocument();
        if (empty($data) || !$dom->loadXML($data)) {
        	$msg = Mage::helper('paymentbase')->__("Can't create XML DOM for Saferpay data\n%s", $data);
        	Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
        	Mage::helper('paymentbase')->sendMailToAdmin($msg, Mage::helper('paymentbase')->__("Can't create XML DOM for Saferpay data"));
        	Mage::log("$module::... _checkReturnedMessage finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        	return false;
        }
        Mage::log(sprintf("$module::... _checkReturnedMessage with valid DATA called:\r\n%s...", $data), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        $idp = $dom->getElementsByTagName('IDP')->item(0);
        $this->_saferpayIDP = $idp;
        
        $saferpay_payconfirm_gateway = Mage::helper($this->_getModuleName())->getSaferpayServiceUrl() . "VerifyPayConfirm.asp";

        // * catch magic_quotes_gpc is set to yes in PHP.ini
        if (substr($data, 0, 15) =="<IDP MSGTYPE=\\\"") {
            $data = stripslashes($data);
        }
        
        // **************************************************
        // * Put all attributes together and create hosting PayConfirm URL 
        // * For hosting: each attribute which could have non-url-conform characters inside should be urlencoded before
        // **************************************************        
        $fields = array();
        $fields['DATA'] = urlencode($data);
        $fields['SIGNATURE'] = urlencode($signature);
        $verification = $this->_callCurlImpl($saferpay_payconfirm_gateway, $fields);
        
        Mage::log("$module::... _checkReturnedMessage finished.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        if (strtoupper(substr($verification, 0, 3)) !="OK:") {
            
            /*
			 * something was wrong with either the command line tool or someone
			 * tried to fake the response, so we redirect to failure page
			 */
        	$msg = Mage::helper('paymentbase')->__("Can't validate Saferpay\nReturned verification:%s\nData:\n%s\nSignature:%s", $verification, $data, $signature);
        	Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
        	Mage::helper('paymentbase')->sendMailToAdmin($msg, Mage::helper('paymentbase')->_("Can't validate Saferpay data"));
            return false;
        }
        
        return true;
    }
}