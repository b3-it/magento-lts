<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im Payplace-Verfahren (Kreditkarte/Giropay).
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Payplace extends Egovs_Paymentbase_Model_Abstract
{
	const PAYPLACE_INTERFACE_VERSION = "1.6";
	/**
     * Wichtig um eigene States und Statuse setzen zu können
     * 
     * @var boolean $_isInitializeNeeded
     */
    protected $_isInitializeNeeded      = true;
	
	/**
	 * Aktuelles Kassenzeichen
	 * 
	 * @var string
	 */
	protected $_Kassenzeichen;
	/**
	 * Daten die an Payplace übergeben werden sollen
	 * 
	 * @var Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request
	 */
	protected $_xmlApiRequest = null;
	/**
	 * Aktuelle Order
	 * 
	 * @var Mage_Sales_Model_Order
	 */
	protected $_order;
	
	/**
	 * Array zum vermeiden doppelter Fehlermeldungen
	 * @var array
	 */
	protected $_errors = array();
	
	/**
	 * eShopTAN
	 * 
	 * @var string
	 */
	protected $_eShopTan = '';
	
	/**
	 * Liefert eine eShopTan
	 * 
	 * Die TAN ist base16 kodiert und ist maximal 17 Zeichen lang.
	 * 
	 * @return string
	 */
	protected function _geteShopTan() {
		if (empty($this->_eShopTan)) {
			/*
			 * 20151201::Frank Rochlitzer
			 * #2327 Unterschiedliche eShopTANs bei Payplace 
			 */
			if (($eShopTAN = $this->_getOrder()->getPayment()->getAdditionalInformation('eshop_tan'))) {
				$this->_eShopTan = $eShopTAN;
				return $this->_eShopTan;
			}
			$orderId = (int)$this->_getOrder()->getId();
			$mandant = $this->_getMandantNr();
			
			$mandant = strtoupper($mandant);
			$length = strlen($mandant);
			$ord = 0;
			for ($i = 0; $i < $length; $i++) {
				$ord += max(0, (int)ord($mandant[$i]) - 48);
			}
			
			$tan = $orderId + time() + $ord;
			$tan = base_convert($tan, 10, 16);
			$this->_eShopTan = substr($tan, 0, 17);
			$this->_getOrder()->getPayment()->setAdditionalInformation('eshop_tan', $this->_eShopTan);
		}
		return $this->_eShopTan;
	}
	/**
     * Return true if the method can be used at this time
     * 
     * @param Mage_Sales_Model_Quote $quote Warenkorb
     *
     * @return boolean
     */
    public function isAvailable($quote=null) {
        if (isset($quote) && $total = $quote->getGrandTotal()) {
	        if ($total <= 0.00001) {
	        	return false;
	        }
    	}
    	
    	return parent::isAvailable($quote);
    }	
	
	/**
	 * Get Merchant ID
	 *
	 * @return string
	 */
	public function getMerchantId() {
		$merchantId =  Mage::helper('core')->decrypt(Mage::getStoreConfig ( 'payment_services/payplace/merchant_id' ));
		
		if (empty($merchantId)) {
			if (!isset($this->_errors['mcid'])) {
				$helper = Mage::helper($this->getCode());
				$msg = $helper->__("Merchant ID is missing for Payplace configuartion");
				$helper->sendMailToAdmin("{$this->getCode()}::".$msg, $helper->__("Payplace Error:"), $this->getCode());
			
				$sModul = strtoupper(substr($this->getCode(), 0, 1));
				$sModul .= substr($this->getCode(), 1);
			
				Mage::log($this->getCode()."::$sModul ".$msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['mcid'] = true;
			}
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
		}
		
		return $merchantId;
	}
	
	/**
	 * Get Merchant ID
	 *
	 * @return string
	 */
	public function getMerchantName() {
		$merchantName =  Mage::getStoreConfig ('payment_services/payplace/merchant_name');
	
		$template = Mage::getModel('core/email_template_filter');
		
		$variables = new Varien_Object();
		
		$template->setVariables(array('egovs'=>$variables));
		
		$merchantName = $template->filter($merchantName);
	
		return $merchantName;
	}
	
	/**
	 * Get currency that is accepted by Payplace account
	 *
	 * @return string
	 */
	public function getAcceptedCurrency() {
		return Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/currency' );
	}

	/**
	 * Gibt eine absolute URL zum übergebenen Pfad zurück
	 * 
	 * @param string $url Relativer Pfad
	 * 
	 * @return string URL
	 */
	protected function _getLinkUrl($url) {
		$store = Mage::app()->getStore();
		$secure = Mage::getStoreConfigFlag(Mage_Core_Model_Store::XML_PATH_SECURE_IN_FRONTEND);
		$newUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, $secure).$url;
		return $newUrl;
	}
	
	/**
	 * Behandelt die unterschiedlichen Payment Actions
	 *
	 * Setzt unter anderem den State der Bestellung.<br>
	 *
	 * @param string        $paymentAction Die Payment-Action
	 * @param Varien_Object $stateObject   Das State Object
	 *
	 * @return Egovs_Paymentbase_Model_Payplace
	 *
	 * @see Mage_Payment_Model_Method_Abstract::initialize()
	 */
	public function initialize($paymentAction, $stateObject) {
		if ($paymentAction != self::ACTION_AUTHORIZE) {
			Mage::throwException(
				Mage::helper($this->getCode())->__('This payment action is not available!').' Action: '.$paymentAction
			);
		}
		$payment = $this->getInfoInstance();
		$order = $payment->getOrder();		
		
		$this->authorize($this->getInfoInstance(), $order->getBaseTotalDue());
		
		$this->setAmountAuthorized($order->getTotalDue());
		$this->setBaseAmountAuthorized($order->getBaseTotalDue());
						
		$state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
		$stateObject->setState($state);
		$stateObject->setStatus(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
		$stateObject->setIsNotified(false);
		
		return $this;
	}
	
	/**
	 * Authorize
	 * 
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return Egovs_Paymentbase_Model_Payplace
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::_authorize()
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		//Validate
		$this->getMerchantId();
		
		//20110801 :  Frank Rochlitzer : Doppelte Kassenzeichen vermeiden
        if (!$this->hasKassenzeichen($payment)) {
        	$kassenzeichen = $this->_anlegenKassenzeichen($this->_type);
        	Mage::log("{$this->getCode()}::KASSENZEICHEN ANGELEGT:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
        	$payment->setKassenzeichen($kassenzeichen);
        } else {
        	$kassenzeichen = $payment->getKassenzeichen();
        	Mage::log("{$this->getCode()}::KASSENZEICHEN BEREITS VORHANDEN:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
        }
        
        //Verhindert im Kommentarverlauf den grünen Haken für die Kundenbenachrichtigung.
        $order = $this->getOrder();
        if ($order) {
        	$order->setCustomerNoteNotify(false);
        }
		
        return $this;
	}
	
	/**
	 * Liefert null oder ein generiertes Kassenzeichen
	 * 
	 * Darf nur bei zahlpartnerkonten einen Wert != null liefern
	 * Liefert Hier immer null
	 * 
	 * @return NULL
	 */
	protected function _getKassenzeichen() {
		return null;
	}
	
	/**
	 * Legt den Kunden und die Buchungsliste am ePayment an und löscht den Kunden nach erhalt des Kassenzeichens wieder.
	 *  
	 * @param string $type Type (UEBERWEISUNGVOR', 'UEBERWEISUNGNACH', 'LASTSCHRIFTMIT', 'LASTSCHRIFTOHNE', 'GIROPAY', 'KREDITKARTE' und 'SEPASDD')
	 * 
	 * @return int Kassenzeichen
	 */
	protected function _anlegenKassenzeichen($type) {

		// prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert
		$this->createCustomerForPayment();
	
		//Buchungsliste erstellen
		$arrBuchungsliste = $this->createAccountingListParts();
		
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			$arrBuchungsliste = new Egovs_Paymentbase_Model_Webservice_Types_BuchungList($arrBuchungsliste);
		}
	
		// Objekt für Buchungsliste erstellen
		$objBuchungsliste = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe(
			// Gesamtsumme
			(float) $this->_getOrder()->getGrandTotal(),
			// derzeit wird nur EUR vom ePayment-Server unterstützt
			'EUR',
			// Fälligkeit heute
			strftime('%Y-%m-%dT%H:%M:%SZ'),
			// Buchungsliste
			$arrBuchungsliste,
			// Bewirtschafter
			$this->_getBewirtschafterNr(),
			// Kennzeichen Mahnverfahren aus Konfiguration
			$this->getKennzeichenMahnverfahren($this->_getOrder()->getPayment(), (float) $this->_getOrder()->getGrandTotal()),
			// Kassenzeichen wird normalerweise vom ePayment-Server generiert
			$this->_getKassenzeichen(),
			//eShopTAN
			$this->getCode() == 'payplacepaypage' ? $this->_geteShopTan() : null
		);
	
		Mage::log("{$this->getCode()}::pre::objSOAPClientBfF->anlegenKassenzeichen(" . var_export($this->_getMandantNr(), true) . ", " . var_export($this->_getECustomerId(), true) . ", " . var_export($objBuchungsliste, true) . ", null, null, $type)", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	
		$objResult = null;
		$buchungsListeParameter = $this->getBuchungsListeParameter($this->_getOrder()->getPayment(), (float) $this->_getOrder()->getGrandTotal());
		
		try {
			$objResult = $this->_getSoapClient()->anlegenKassenzeichenMitZahlverfahrenlisteMitBLP(
					$this->_getECustomerId(),
					$objBuchungsliste,
					null,
					null,
					$type,
					$buchungsListeParameter
			);
		} catch (Exception $e) {
			Mage::log(sprintf('Message:%s\nTrace:\n%s', $e->getMessage(), $e->getTraceAsString()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		$this->validateSoapResult($objResult, $objBuchungsliste, "anlegenKassenzeichen");
		
		$this->loeschenKunde();	
		
//		Mage::log("{$this->getCode()}::post::objSOAPClientBfF->anlegenKassenzeichen(" . var_export($this->_getMandantNr(), true) . ", " . var_export($this->_getECustomerId(), true) . ", " . var_export($objResult->buchungsListe, true) . ", null, null, $saferpay_type)", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		return $objResult->buchungsListe->kassenzeichen;
	}
	
	/**
	 * Liefert ein assoziatives Array mit Buchungslistenparametern
	 *
	 * @param Mage_Sales_Model_Order_Payment $payment Payment
	 * @param float                          $amount  Betrag
	 *
	 * @return array
	 */
	public function getBuchungsListeParameter($payment, $amount) {
		$buchungsListeParameter = parent::getBuchungsListeParameter($payment, $amount);
		
		/*
		 * Aus ePayBL FSpec v16 Final Payplace
		 * Um die Nachbearbeitung von Kreditkartenzahlungen sicherzustellen, ist es notwendig,
		 * dass die Art der Kreditkartentransaktion an der Buchungsliste gespeichert wird.
		 * Dazu wird beim Anlegen eines Kassenzeichens via Webservice bzw. nach der Zahlverfahrensauswahl
		 * ein Buchungslistenparameter „ppCCaction“ mit dem Wert „preauthorization“ für die Buchungsliste
		 * in der Datenbank gespeichert, wenn am Bewirtschafter die Option „Payplace-Buchung in zwei Schritten“
		 * aktiviert ist. Ist die Option nicht aktiviert der Buchungslistenparameter „ppCCaction“
		 * mit dem Wert „authorization“ für die Buchungsliste  in der Datenbank gespeichert.
		 *
		 * TODO Muss mit Aufruf in xmlApiRequest übereinstimmen
		 */
		$buchungsListeParameter['ppCCaction'] = Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AUTHORIZATION;
		
		return $buchungsListeParameter;
	}
	
	/**
	 * Capture payment
	 * 
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return Egovs_Paymentbase_Model_Payplace
	 */
	public function capture(Varien_Object $payment, $amount) {
		parent::capture($payment, $amount);
		
		//Ticket #705
		//http://www.kawatest.de:8080/trac/ticket/705
		if (!$this->hasKassenzeichen($payment)) {
			$this->authorize($payment, $amount);
		}
		
		$order = $this->_getOrder();
		
		/*if (!$order->getPayment()->getSaferpayTransactionId()) {
			Mage::throwException(
					Mage::helper('paymentbase')->__('Payment not confirmed from payment gateway. In most cases you have to cancel the invoice and order.')
			);
		}*/
		if ($order 
			&& ($order->getState() == Mage_Sales_Model_Order::STATE_NEW
				|| $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT)
		) {
			if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
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
		}
		
		if ($order
			&& ($order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING
				|| $order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE)
		) {
			$order->sendOrderUpdateEmail(true, Mage::helper('paymentbase')->__('Your payment has been received'));
			// we add a status message to the message-section in admin
			$order->addStatusToHistory($order->getStatus(), Mage::helper('paymentbase')->__('Successfully received payment from customer'), true);
		}
		
		return $this;
	}
	
	/**
	 * Override this to modify initialization for Payplace
	 * 
	 * @return void
	 */
	protected abstract function _initPayplacePayment();
	
	/**
	 * This is the function that gets called if button "Place Order" is pressed
	 * in the checkout process.
	 * 
	 * @return string
	 */
	public function getOrderPlaceRedirectUrl() {
		return Mage::getUrl("{$this->getCode()}/{$this->getCode()}/redirect");
	}
	/**
	 * Prepariert die Argumente die an Payplace übertragen werden sollen
	 * 
	 * This is the function that gets called if button "Place Order" is pressed
	 * in the checkout process.
	 * 
	 * Template method
	 * 
	 * Childrens müssen _getOrderPlaceRedirectUrl() überschreiben!
	 * 
	 * @return string
	 */
	public final function initPayplacePayment() {
        
		$_error = $this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/failure");
		
		$this->_xmlApiRequest = new Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request();
		$this->_xmlApiRequest->setVersion(self::PAYPLACE_INTERFACE_VERSION);
				
		$_formServiceRequest = new Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request();
		$this->_xmlApiRequest->setFormServiceRequest($_formServiceRequest);
		$_formServiceRequest->setMerchantId($this->getMerchantId());
		//Order ID muss mit übertragen werden um im Callback die Richtige Order zu laden
		$_formServiceRequest->setAdditionalData($this->_getOrder()->getId());
		//Muss eindeutig und unique sein --> daher sollte hier nicht das Kassenzeichen genommen werden Zahlpartnerkonten!!
		//Für Kreditkarten wird base16 string genutzt
		//Für Giropay OrderID
		$_formServiceRequest->setEventExtId($this->_geteShopTan());
		$_formServiceRequest->setBasketId($this->_getBewirtschafterNr().'/'.$this->getInfoInstance()->getKassenzeichen());
		$_formServiceRequest->setCurrency($this->_getOrder()->getBaseCurrencyCode());
		//Amount in Cent bei EUR
		$_formServiceRequest->setAmount($this->_getOrder()->getBaseGrandTotal() * 100);
		
		$_formData = new Egovs_Paymentbase_Model_Payplace_Types_Form_Data();
		$_formServiceRequest->setFormData($_formData);
		$_formData->setLocale(Mage::getStoreConfig("payment_services/payplace/locale"));
		/*
		 * Formular Version Aktuell '1.6' oder '1.6m' für Mobile-Version : Laut SST 1.8.2
		 * 20141212::Frank Rochlitzer:Version 1.8 notwendig damit Element <brand> mit Informationen zum Kreditkartentyp im notify enthalten ist!
		 */
		$_formData->setVersion('1.8');
		$_merchantName = $this->getMerchantName();
		$_formData->setMerchantName($_merchantName);
		if ($this->getDebugFlag()) {
			$_formData->setLabel(new Egovs_Paymentbase_Model_Payplace_Types_Label($this->__('Submit').'(DEBUG)', 'submit'));
		}
		
		$_callbackData = new Egovs_Paymentbase_Model_Payplace_Types_Callback_Data();
		$_formServiceRequest->setCallbackData($_callbackData);
		$_callbackData->setNotifyURL($this->_getLinkUrl("paymentbase/payplace_api_v2_soap"));
		
		$_credentials = new Egovs_Paymentbase_Model_Payplace_Types_Credentials();
		$_callbackData->setCredentials($_credentials);
		/* @var $_apiUser Mage_Api_Model_User */
		$_apiUser = Mage::getModel('api/user')->load(Mage::getStoreConfig('payment_services/payplace/api_user'));
		if (!$_apiUser->getIsActive()) {
			Mage::log(sprintf("%s::API User is not active!", $this->getCode()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return $_error;
		}
		$_apiKey = Mage::helper('core')->decrypt(Mage::getStoreConfig('payment_services/payplace/api_password'));
		if (!Mage::helper('core')->validateHash($_apiKey, $_apiUser->getApiKey())) {
			Mage::log(sprintf("%s::API User password didn't match password in payplace settings!", $this->getCode()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return $_error;
		}
		$_credentials->setLogin($_apiUser->getUsername());
		$_credentials->setPassword($_apiKey);
		
		$_customerContinuation = new Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation();
		$_formServiceRequest->setCustomerContinuation($_customerContinuation);
		$_customerContinuation->setSuccessURL($this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/success"). '?real_order_id='.$this->_getOrder()->getRealOrderId());
		$_customerContinuation->setErrorURL($this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/failure" ));
		$_customerContinuation->setNotificationFailedURL($this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/cancel" ));
		$_customerContinuation->setRedirect(true);
		
		//Call to the implementation method for childrens
		$this->_initPayplacePayment();
		
		//ID erst am Ende aus zu übertragenden Daten generieren
		/* @var $hash Egovs_Paymentbase_Helper_Payplace_Hash */
		$hash = Mage::helper('paymentbase/payplace_hash');
		$requestId = $hash->getHash4Order($this->_getOrder());
		
		//Muss mit Buchstaben anfangen
		$this->_xmlApiRequest->setId('id'.hash('sha256', $requestId.'_1'));
		$_formServiceRequest->setId($requestId);
		
		//$this->_xmlApiRequest->setHttpHeader('Cookie', "ECLIPSE_DBGP");
		/* @var $payplaceSoapApi Egovs_Paymentbase_Model_Payplace_Soap_Service */
		$payplaceSoapApi = Mage::getModel('paymentbase/payplace_soap_service');
		if ($payplaceSoapApi->process($this->_xmlApiRequest) === false) {
			//TODO Fehlerbehebung
			$error = $payplaceSoapApi->getLastError();
			$error = array_pop($error);
			if ($error instanceof SoapFault) {
				Mage::logException($error);
			}
			$_lastRequest = $payplaceSoapApi->getLastRequest();
			$_lastResponse = $payplaceSoapApi->getLastResponse();
			Mage::log(sprintf("%s::XML Request:\n%s\nXML Response:\n%s", $this->getCode(), $_lastRequest, $_lastResponse), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return $_error;
		} elseif ($this->getDebugFlag()) {
			$_lastRequest = $payplaceSoapApi->getLastRequest();
			$_lastResponse = $payplaceSoapApi->getLastResponse();
			Mage::log(sprintf("%s::XML Request:\n%s\nXML Response:\n%s", $this->getCode(), $_lastRequest, $_lastResponse), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}
		$_xmlApiResponse = $payplaceSoapApi->getResult();
		
		$expectedHash = 'id'.hash('sha256', $requestId.'_1');
		if ($_xmlApiResponse->getRef() != $expectedHash) {
			Mage::log(sprintf("%s::API response ref is not equal to expected hash!", $this->getCode()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return $_error;
		}
		$_formServiceResponse = $_xmlApiResponse->getFormServiceResponse();
		if (!$_formServiceResponse) {
			$_paymentResponse = $_xmlApiResponse->getPaymentResponse();
			if (!$_paymentResponse) {
				Mage::log(sprintf("%s::Unknown error: Payment response not set!", $this->getCode()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				return $_error;
			}
			if (is_array($_paymentResponse) && isset($_paymentResponse[0])) {
				$_paymentResponse = $_paymentResponse[0];
			}
			if (!($_paymentResponse instanceof Egovs_Paymentbase_Model_Payplace_Types_Payment_Response)) {
				Mage::log(sprintf("%s::Payment response is not type of Egovs_Paymentbase_Model_Payplace_Types_Payment_Response!", $this->getCode()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				return $_error;
			}
			
			switch ($_paymentResponse->getRc()) {
				//Vorgangsnummer schon vergeben. (108/ )
				case '3110':
					Mage::getSingleton('checkout/session')->addError(Mage::helper('payplacepaypage')->__('eShopTAN already in use. Please try again.'));
					break;
			}
			$msg = sprintf("{$this->getCode()}::REFID:%s\nrc:%s message:%s", $_xmlApiResponse->getRef(), $_paymentResponse->getRc(), $_paymentResponse->getMessage());
			Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return $_error;
		}
		if (is_array($_formServiceResponse) && isset($_formServiceResponse[0])) {
			$_formServiceResponse = $_formServiceResponse[0];
		}
		
		if ($_formServiceResponse->getRef() != $requestId) {
			Mage::log(sprintf("%s::Form service response ref is not equal to expected hash!", $this->getCode()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return $_error;
		}
		if (!($_formServiceResponse instanceof Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response)) {
			Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD'));
		}
		
        $url = $_formServiceResponse->getRedirectURL();
       	
		return $url;
	}
	
	/**
	 * Gibt an ob dieses Zahlmodul nur Offline-Erstattungen erlaubt
	 *
	 * Da es über die ePayBL nicht möglich ist Gutschriften und Stornos zu übermitteln, entfällt die Online-Funktionalität.
	 * Diese Funktion gibt immer true zurück
	 * Siehe dazu auch #1626 bzw. ZVM848
	 *
	 * @return boolean
	 */
	public function getSupportsOnlyOfflineCreditmemo() {
		return true;
	}
	
	public abstract function aktiviereKassenzeichen($wId, $refId, $providerId);
}