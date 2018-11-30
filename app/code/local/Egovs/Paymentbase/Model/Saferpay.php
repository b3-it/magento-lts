<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im Saferpay-Verfahren (Kreditkarte/Giropay).
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Saferpay extends Egovs_Paymentbase_Model_Abstract
{
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
	 * Daten die an Saferpay übergeben werden sollen
	 * 
	 * @var <array, null>
	 */
	protected $_fieldsArr = null;
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
	 * Aktuelle Order
	 *
	 * @return Mage_Sales_Model_Order
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Abstract::_getOrder()} instead
	 */
	public function getOrder() {
		return $this->_getOrder();
	}
	
	/**
	 * Get Customer Id
	 *
	 * @return string
	 */
	public function getAccountId() {
		$accountId =  Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/account_id' );
		
		if (empty($accountId)) {
			if (!array_key_exists('accid', $this->_errors)) {
				$helper = Mage::helper($this->getCode());
				$helper->sendMailToAdmin("{$this->getCode()}::AccountId fehlt in Saferpaykonfiguration.", 'Saferpay Fehler:', $this->getCode());
			
				$sModul = strtoupper(substr($this->getCode(), 0, 1));
				$sModul .= substr($this->getCode(), 1);
			
				Mage::log($this->getCode()."::".$helper->__("$sModul AccountId fehlt in Saferpaykonfiguration. Bitte kontaktieren Sie den Shopbetreiber"), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['accid'] = true;
			}
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
		}
		
		return $accountId;
	}
	
	/**
	 * Get currency that is accepted by Saferpay account
	 *
	 * @return string
	 */
	public function getAcceptedCurrency() {
		return Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/currency' );
	}
	/**
	 * This is the function that gets called if button "Place Order" is pressed
	 * in the checkout process.
	 *
	 * @return string the URL to be redirected to
	 */
	public function getOrderPlaceRedirectUrl() {
		return Mage::getUrl("{$this->getCode()}/{$this->getCode()}/redirect");
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
	 * @return Egovs_Paymentbase_Model_Saferpay
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
	 * @return Egovs_Paymentbase_Model_Saferpay
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::_authorize()
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		//Validate
		$this->getAccountId();
		
		//20110801 :  Frank Rochlitzer : Doppelte Kassenzeichen vermeiden
        if (!$this->hasKassenzeichen($payment)) {
        	$Kassenzeichen = $this->_anlegenKassenzeichen($this->_saferpay_type);
        } else {
        	$Kassenzeichen = $payment->getKassenzeichen();
        	Mage::log("saferpay::KASSENZEICHEN BEREITS VORHANDEN:$Kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);        	
        }
        
        //TODO : Kann eigentlich entfernt werden, da $this->_anlegenKassenzeichen(...) die Fehlerbehandlung macht!
        if (substr($Kassenzeichen, 0, 6) == 'ERROR:') {
        	switch (intval(substr($Kassenzeichen, 6))) {
        		case -611:
        			Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR_-0611', Mage::helper('paymentbase')->getCustomerSupportMail()));
        		default :
        			$base = 'TEXT_PROCESS_'. $Kassenzeichen;
        			$translate = Mage::helper('saferpay')->__($base, Mage::helper('paymentbase')->getCustomerSupportMail());
        			if ($base == $translate) {
        				Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR:UNKNOWN CURL ERROR', Mage::helper('paymentbase')->getCustomerSupportMail()));
        			} else Mage::throwException($translate);
        	}	
        }
        
		Mage::log("saferpay::KASSENZEICHEN ANGELEGT:$Kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
        $payment->setData('kassenzeichen', $Kassenzeichen);
        
        //Verhindert im Kommentarverlauf den grünen Haken für die Kundenbenachrichtigung.
        $order = $this->getOrder();
        if ($order) {
        	$order->setCustomerNoteNotify(false);
        }
		
        return $this;
	}
	
	/**
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
	 * @param string $saferpayType Type
	 * 
	 * @return int Kassenzeichen
	 */
	protected function _anlegenKassenzeichen($saferpayType) {

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
			$this->_getKassenzeichen()
		);
	
		Mage::log("{$this->getCode()}::pre::objSOAPClientBfF->anlegenKassenzeichen(" . var_export($this->_getMandantNr(), true) . ", " . var_export($this->_getECustomerId(), true) . ", " . var_export($objBuchungsliste, true) . ", null, null, $saferpayType)", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	
		$objResult = null;
		try {
			$objResult = $this->_getSoapClient()->anlegenKassenzeichenMitZahlverfahrenlisteMitBLP(
					$this->_getECustomerId(),
					$objBuchungsliste,
					null,
					$this->_getPayerNote(),
					$saferpayType,
					$this->getBuchungsListeParameter($this->_getOrder()->getPayment(), (float) $this->_getOrder()->getGrandTotal())
			);			
			if ($objResult instanceof SoapFault && $objResult->faultcode == 'Client' && $objResult->code == '0' && stripos($objResult->faultstring, self::SOAP_METHOD_NOT_AVAILABLE) > 0) {
				//Fallback zu alter Methode
				Mage::log($this->getCode().'::Fallback new Method MitBLP not available try old method without parameter list.', Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
				$objResult = $this->_getSoapClient()->anlegenKassenzeichen($this->_getMandantNr(), $this->_getECustomerId(), $objBuchungsliste, null, null, $saferpayType);
			}
		} catch (Exception $e) {
			Mage::log(sprintf('Message:%s\nTrace:\n%s', $e->getMessage(), $e->getTraceAsString()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		$this->validateSoapResult($objResult, $objBuchungsliste, "anlegenKassenzeichen");
		
		$this->loeschenKunde();	
		
//		Mage::log("{$this->getCode()}::post::objSOAPClientBfF->anlegenKassenzeichen(" . var_export($this->_getMandantNr(), true) . ", " . var_export($this->_getECustomerId(), true) . ", " . var_export($objResult->buchungsListe, true) . ", null, null, $saferpay_type)", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		return $objResult->buchungsListe->kassenzeichen;
	}
	
	/**
	 * Capture payment
	 * 
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return Egovs_Paymentbase_Model_Saferpay
	 */
	public function capture(Varien_Object $payment, $amount) {
		parent::capture($payment, $amount);
		
		//Ticket #705
		//http://www.kawatest.de:8080/trac/ticket/705
		if (!$this->hasKassenzeichen($payment)) {
			$this->authorize($payment, $amount);
		}
		
		$order = $this->getOrder();
		
		if (!$order->getPayment()->getSaferpayTransactionId()) {
			Mage::throwException(
					Mage::helper('paymentbase')->__('Payment not confirmed from payment gateway. In most cases you have to cancel the invoice and order.')
			);
		}
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
	 * Override this to modify $this->_fieldsArr for Saferpay
	 * 
	 * @return string
	 * 
	 */
	protected abstract function _getSaferpayUrl();
	
	/**
	 * Liefert die PayerNote
	 * 
	 * Falls es keine PayerNote gibt wird:
	 * <ul>
	 * 	<li>Beschreibung</li>
	 * 	<li>Titel</li>
	 * 	<li>Zahlung per Saferpay</li>
	 * </ul>
	 * als Alternative geliefert.
	 * 
	 * @return string
         */
	protected function _getPayerNote() {
		if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/payernote")) <= 0) {
			//Wenn Payernote nicht gefüllt ist
			if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/description")) <= 0) {
				//Wenn Description nicht gefüllt
	        	if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/title")) <= 0) {
	        		$desc = "Zahlung per Saferpay";
	        	} else {
	        		$desc = Mage::getStoreConfig("payment/{$this->getCode()}/title");
	        	}
	        } else {
	        	$desc = Mage::getStoreConfig("payment/{$this->getCode()}/description");
	        }
		} else {
			$desc = Mage::getStoreConfig("payment/{$this->getCode()}/payernote");
		}
		
		return $desc;
	}
	/**
	 * Prepariert die Argumente die an Saferpay übertragen werden sollen
	 *
	 * Template method
	 *
	 * Childrens müssen _getSaferpayUrl() überschreiben!
	 *
	 * @return array
	 */
	public final function getSaferpayUrl() {

        $this->_fieldsArr = array ();
        /*
         * 20130403::Frank Rochlitzer
         * URL Encode findet in Egovs_Paymentbase_Model_Curl::getResponse statt siehe #1582 ZVM844
         */
		$this->_fieldsArr ['AMOUNT'] = ($this->_getOrder ()->getTotalDue() * 100);
		$this->_fieldsArr ['CURRENCY'] = $this->_getOrder()->getOrderCurrencyCode();

		$desc = $this->_getPayerNote();

		$this->_fieldsArr ['DESCRIPTION'] = htmlentities($desc);
		
        $this->_fieldsArr ['ALLOWCOLLECT'] = 'no';
		$this->_fieldsArr ['DELIVERY'] = 'no';
		
		$providerset = Mage::getStoreConfig("payment/{$this->getCode()}/providerset");
		if ($providerset) {
			if (strpos($providerset, '102') !== false
				|| strpos($providerset, '104') !== false
				|| strpos($providerset, '631') !== false
				|| strpos($providerset, '1341') !== false
				|| strpos($providerset, '90') !== false
				|| strpos($providerset, '634') !== false)
			{
				//Visa
				$providerset = str_replace(102, 2, $providerset);
				//Master
				$providerset = str_replace(104, 1, $providerset);
				//Giropay
				$providerset = str_replace(631, 17, $providerset);
				$providerset = str_replace(1341, 17, $providerset);
				//Testkarte
				$providerset = str_replace(90, 6, $providerset);
				$providerset = str_replace(634, 6, $providerset);
			}
		}
		
		$providerset
			? $this->_fieldsArr ['PAYMENTMETHODS'] = htmlentities($providerset)
			: $this->_fieldsArr ['PAYMENTMETHODS'] = ''
		;
		Mage::getStoreConfig("payment/{$this->getCode()}/karteninhaber")
			? $this->_fieldsArr ['CCNAME'] = 'yes'
			: $this->_fieldsArr ['CCNAME'] = 'no'
		;
		
		$this->_fieldsArr ['ACCOUNTID'] = Mage::helper ( 'core' )->decrypt ( $this->getAccountId());
		$this->_fieldsArr ['SUCCESSLINK'] = '"'.$this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/success"). '?real_order_id='.$this->_getOrder()->getRealOrderId().'"';
		$this->_fieldsArr ['NOTIFYURL'] = '"'.$this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/notify"). '?real_order_id='.$this->_getOrder()->getRealOrderId().'"';
		$this->_fieldsArr ['BACKLINK'] = '"'.$this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/cancel" ).'"';
		$this->_fieldsArr ['FAILLINK'] = '"'.$this->_getLinkUrl("{$this->getCode()}/{$this->getCode()}/failure" ).'"';
		
		//Neue Konfigurationen nach Saferpay-Update
		Mage::getStoreConfig("payment/{$this->getCode()}/address")
			? $this->_fieldsArr ['ADDRESS'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/address"))
			: $this->_fieldsArr ['ADDRESS'] = ''
		;
		Mage::getStoreConfig("payment/{$this->getCode()}/langid")
			? $this->_fieldsArr ['LANGID'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/langid"))
			: $this->_fieldsArr ['LANGID'] = ''
		;
		Mage::getStoreConfig("payment/{$this->getCode()}/showlanguages")
			? $this->_fieldsArr ['SHOWLANGUAGES'] = 'yes'
			: $this->_fieldsArr ['SHOWLANGUAGES'] = 'no'
		;
		Mage::getStoreConfig("payment/{$this->getCode()}/agburl")
			? $this->_fieldsArr ['TERMSURL'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/agburl"))
			: $this->_fieldsArr ['TERMSURL'] = ''
		;
		Mage::getStoreConfig("payment/{$this->getCode()}/agbcheckboxactive")
			? $this->_fieldsArr ['TERMSCHECKBOXACTIVE'] = 'yes'
			: $this->_fieldsArr ['TERMSCHECKBOXACTIVE'] = 'no'
		;
		
		Mage::getStoreConfig("payment/{$this->getCode()}/vtconfig")
			? $this->_fieldsArr ['VTCONFIG'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/vtconfig"))
			: $this->_fieldsArr ['VTCONFIG'] = ''
		;
		
		$this->_fieldsArr ['AUTOCLOSE'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/autoclose"));
		$this->_fieldsArr ['ORDERID'] = '"'.$this->_getBewirtschafterNr().'/'.$this->getInfoInstance()->getKassenzeichen().'"'; //ORDERID eigentlich OPTIONAL und max 12 Zeichen lang
		
		//Call to the implementation method for childrens
		$this->_getSaferPayUrl();
				
		if ($this->getDebug ()) {
			//TODO Eigene Konfiguration vorsehen
			//$this->_fieldsArr ['NOTIFYURL'] = rtrim($this->_fieldsArr ['NOTIFYURL'], '"');
			//$this->_fieldsArr ['NOTIFYURL'] .= '&XDEBUG_SESSION_START"';
			/*
			 * build a xml-like form of the attributes that get stored in
			* saferpay_api_debug table
			*/
			$request = '';
			foreach ( $this->_fieldsArr as $k => $v ) {
				$request .= '<' . $k . '>' . $v . '</' . $k . '>';
			}
			
			Mage::log(sprintf('%s::debug: %s', $this->getCode(), $request), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			//$this->_fieldsArr ['saferpayOption1'] = $this->_fieldsArr ['ORDERID'];
		}
       	
		$url = Mage::helper($this->getCode())->getSaferpayServiceUrl() . 'CreatePayInit.asp';
        $url = Egovs_Paymentbase_Model_Curl::getResponse($url, $this->_fieldsArr);
       	
		return $url;
	}
	
	/**
	 * Liefert Debug-Flag
	 *
	 * @return string
	 */
	public function getDebug() {
		return Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/debug_flag' );
	}
	
	/**
	 * Gibt den Redirect-Block-Type zurück
	 *
	 * @return string
	 */
	public function getRedirectBlockType() {
		return $this->_redirectBlockType;
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
}