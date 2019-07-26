<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im Girosolution-Verfahren (Kreditkarte/Giropay).
 *
 * Überschreibt hier nur Egovs_Paymentbase_Helper_Data
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Girosolution extends Egovs_Paymentbase_Model_Abstract
{
    static $dbLockResult = null;

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
	 * Array zum vermeiden doppelter Fehlermeldungen
	 * 
	 * @var array
	 */
	protected $_errors = array();

	protected $_globalStartTime = 0.0;

	/**
	 * Liefert den Transaktionstyp
	 * 
	 * <ul>
	 *  <li>creditcardTransaction</li>
	 *  <li>giropayTransaction</li>
	 * </ul>
	 * 
	 * @return string
	 */
	public abstract function getTransactionType();
	
	public function __construct() {
		$libDIR = Mage::getBaseDir('lib');
		$classPath = $libDIR . '/GiroCheckout_SDK/GiroCheckout_SDK.php';
		if (is_file($classPath)) {
			require_once $classPath;
		}
		
		$config = GiroCheckout_SDK_Config::getInstance();
		$config->setConfig('DEBUG_MODE', $this->getDebug());
		$config->setConfig('DEBUG_PATH', Mage::getBaseDir('var') . DS . 'log');
		//TODO: Pfad zu CA Bundle setzen
		//Pfad muss jetzt vor allem für Windows per INI_SET oder in PHP INI gesetzt werden
		//https://curl.haxx.se/docs/sslcerts.html
		//https://curl.haxx.se/docs/caextract.html
		//curl.cainfo =
		$config->setConfig('CURLOPT_CAINFO', null);
		
		parent::__construct();
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
     * Liefert die Transaktions ID
     * 
     * Wichtig für Zahlpartnerkonten (ZPK), da dort nicht das Kassenzeichen als ID genutzt
     * werden kann!<br>
     * Ohne ZPK wird "BewirtschafterNr/Kassenzeichen" als ID genutzt.
     * 
     * @return string
     */
    public function getTransactionId(Varien_Object $payment = null) {
    	if (!$payment) {
    		$_order = $this->_getOrder();
    		if ($_order) {
    			$payment = $_order->getPayment();
    		} else {
    			$payment = $this->getInfoInstance();
    		}
    	}

    	if (($txId = $payment->getTransactionId()) || ($txId = $payment->getOrder()->getExternesKassenzeichen())) {
            if (preg_match('/[\w]+\/[\w]+$/', $txId)) {
                return $txId;
            }
        }
    	if (!$payment->hasKassenzeichen() || !$payment->getKassenzeichen()) {
    		Mage::throwException($this->__('No kassenzeichen available!'));
    	}
    	return "{$this->_getBewirtschafterNr()}/{$payment->getKassenzeichen()}";
    }
	
	/**
	 * Get Merchant Id
	 *
	 * @return string
	 */
	public function getMerchantId() {
		$merchantId =  Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/merchant_id' );
		$merchantId = Mage::helper('core')->decrypt($merchantId);
		if (empty($merchantId)) {
			if (!array_key_exists('merid', $this->_errors)) {
				$helper = Mage::helper('egovs_girosolution');
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Merchant ID is missing in Girosolution configuration')}", $helper->__('Girosolution Error').':', $this->getCode());
			
				$sModul = ucwords(substr($this->getCode(), 6), '_');
			
				Mage::log($this->getCode()."::".$helper->__("%s Merchant ID is missing in Girosolution configuration. Please contact the shop operator.", $sModul), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['merid'] = true;
			}
			Mage::throwException(Mage::helper('egovs_girosolution')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
		}
		
		return $merchantId;
	}
	
	/**
	 * Get Project Id
	 *
	 * @return string
	 */
	public function getProjectId() {
		$projectId =  Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/project_id' );
		$projectId = Mage::helper('core')->decrypt($projectId);
	
		if (empty($projectId)) {
			if (!array_key_exists('prjid', $this->_errors)) {
				$helper = Mage::helper('egovs_girosolution');
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Project ID is missing in Girosolution configuration')}", $helper->__('Girosolution Error').':', $this->getCode());
					
				$sModul = ucwords(substr($this->getCode(), 6), '_');
					
				Mage::log($this->getCode()."::".$helper->__("%s Project ID is missing in Girosolution configuration. Please contact the shop operator.", $sModul), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['prjid'] = true;
			}
			Mage::throwException(Mage::helper('egovs_girosolution')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
		}
	
		return $projectId;
	}
	
	/**
	 * Get Project password
	 *
	 * @return string
	 */
	public function getProjectPassword() {
		$projectPassword =  Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/project_pwd' );
		$projectPassword = Mage::helper('core')->decrypt($projectPassword);
	
		if (empty($projectPassword)) {
			if (!array_key_exists('prjpwd', $this->_errors)) {
				$helper = Mage::helper('egovs_girosolution');
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Project password is missing in Girosolution configuration')}", $helper->__('Girosolution Error').':', $this->getCode());
					
				$sModul = ucwords(substr($this->getCode(), 6), '_');
					
				Mage::log($this->getCode()."::".$helper->__("%s Project password is missing in Girosolution configuration. Please contact the shop operator.", $sModul), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['prjpwd'] = true;
			}
			Mage::throwException(Mage::helper('egovs_girosolution')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
		}
	
		return $projectPassword;
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
		return $this->getGirosolutionRedirectUrl();
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
	 * Authorize
	 * 
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return Egovs_Paymentbase_Model_Girosolution
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::_authorize()
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		//Validate
		$this->getMerchantId();
		$this->getProjectId();
		$this->getProjectPassword();
		
		//20110801 :  Frank Rochlitzer : Doppelte Kassenzeichen vermeiden
        if (!$this->hasKassenzeichen($payment)) {
        	$kassenzeichen = $this->_anlegenKassenzeichen($this->_epaybl_transaction_type);
        	
        	Mage::log("{$this->getCode()}::KASSENZEICHEN ANGELEGT:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
        	$payment->setKassenzeichen($kassenzeichen);
        	//20160712 :: Frank Rochlitzer : Kassenzeichen auch in Quote ablegen
        	$payment->getOrder()->getQuote()->getPayment()->setKassenzeichen($kassenzeichen);
        	
        	/** @var $payment Mage_Sales_Model_Order_Payment */
        	$payment->setTransactionId($this->getTransactionId($payment));
        } else {
        	$kassenzeichen = $payment->getKassenzeichen();
        	Mage::log("{$this->getCode()}::KASSENZEICHEN BEREITS VORHANDEN:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);        	
        }
        
        //Verhindert im Kommentarverlauf den grünen Haken für die Kundenbenachrichtigung.
        $order = $this->_getOrder();
        if ($order) {
        	$order->setCustomerNoteNotify(false);
        }
        
        //Wichtig für richtigen State und Status
        $payment->setIsTransactionPending(true);
		
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
	 * @param string $transactionType Type
	 * 
	 * @return int Kassenzeichen
	 */
	protected function _anlegenKassenzeichen($transactionType) {

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
	
		Mage::log("{$this->getCode()}::pre::objSOAPClientBfF->anlegenKassenzeichen(" . var_export($this->_getMandantNr(), true) . ", " . var_export($this->_getECustomerId(), true) . ", " . var_export($objBuchungsliste, true) . ", null, null, $transactionType)", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	
		$objResult = null;
		try {
			$objResult = $this->_getSoapClient()->anlegenKassenzeichenMitZahlverfahrenlisteMitBLP(
					$this->_getECustomerId(),
					$objBuchungsliste,
					null,
					$this->_getPayerNote(),
					$transactionType,
					$this->getBuchungsListeParameter($this->_getOrder()->getPayment(), (float) $this->_getOrder()->getGrandTotal())
			);			
			if ($objResult instanceof SoapFault && $objResult->faultcode == 'Client' && $objResult->getCode() == '0' && stripos($objResult->faultstring, self::SOAP_METHOD_NOT_AVAILABLE) > 0) {
				//Fallback zu alter Methode
				Mage::log($this->getCode().'::Fallback new Method MitBLP not available try old method without parameter list.', Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
				$objResult = $this->_getSoapClient()->anlegenKassenzeichen($this->_getMandantNr(), $this->_getECustomerId(), $objBuchungsliste, null, null, $transactionType);
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
		
		$order = $this->_getOrder();

		if (!$order->getPayment()->getTransactionId()) {
			Mage::throwException(
					Mage::helper('paymentbase')->__('Payment not confirmed from payment gateway. In most cases you have to cancel the invoice and order.')
			);
		}

		if ($order
			&& ($order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING
				|| $order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE)
		) {
			$order->sendOrderUpdateEmail(true, Mage::helper('paymentbase')->__('Your payment has been received'));
			// we add a status message to the message-section in admin
			$order->addStatusHistoryComment(Mage::helper('paymentbase')->__('Successfully received payment from customer'));
		}

		return $this;
	}

	/**
	 * Eigene Anpassungen für $this->_fieldsArr für Girosolution
	 * 
	 * @return string
	 * 
	 */
	protected abstract function _getGirosolutionRedirectUrl();
	
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
	        		$desc = "Zahlung per GiroSolution";
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
	 * Prepariert die Argumente die an Girosolution übertragen werden sollen
	 *
	 * Template method
	 *
	 * Abgeleitete Klassen müssen _getGirosolutionRedirectUrl() überschreiben!
	 *
	 * @return string
	 */
	public final function getGirosolutionRedirectUrl() {

        $this->_fieldsArr = array ();

        $this->_fieldsArr['merchantId'] = $this->getMerchantId();
        $this->_fieldsArr['projectId'] = $this->getProjectId();
        
        $_source = $this->_getOrder();
        $_realOrderId = null;
        if (!$_source) {
        	/** @var $_source Mage_Sales_Model_Quote */
        	$_source = $this->getInfoInstance()->getQuote();
        	$this->_fieldsArr['amount'] = ($_source->getGrandTotal() * 100);
        	$this->_fieldsArr['currency'] = $_source->getGlobalCurrencyCode();
        	$_realOrderId = $_source->getReservedOrderId();
        } else {
			$this->_fieldsArr['amount'] = ($_source->getTotalDue() * 100);
			$this->_fieldsArr['currency'] = $_source->getOrderCurrencyCode();

			$_realOrderId = $_source->getRealOrderId();
        }
		
		$controllerName = str_replace('egovs_girosolution_', '', $this->getCode());
		$this->_fieldsArr ['urlRedirect'] = $this->_getLinkUrl("girosolution/$controllerName/success"). '?real_order_id='.$_realOrderId;
		$this->_fieldsArr ['urlNotify'] = $this->_getLinkUrl("girosolution/$controllerName/notify"). '?real_order_id='.$_realOrderId;
		
		$desc = $this->_getPayerNote();
		
        $this->_fieldsArr['merchantTxId'] = $this->getTransactionId();
        
        if (Mage::getStoreConfigFlag("payment/{$this->getCode()}/epa_purpose")) {
        	$this->_fieldsArr['purpose'] = $this->_fieldsArr['merchantTxId'];
        } else {
        	$_order = $this->_getOrder();
        	if ($_order) {
        		$_payment = $_order->getPayment();
        	} else {
        		$_payment = $this->getInfoInstance();
        	}
        	$this->_fieldsArr['purpose'] = mb_substr("{$_payment->getKassenzeichen()} : $desc", 0, 27, "UTF-8");
        }
		
		//Call to the implementation method for childrens
		$this->_getGirosolutionRedirectUrl();
				
		if ($this->getDebug ()) {
			$request = '';
			foreach ( $this->_fieldsArr as $k => $v ) {
				$request .= '<' . $k . '>' . $v . '</' . $k . '>';
			}
			
			Mage::log(sprintf('%s::debug: %s', $this->getCode(), $request), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}
		
		$msg = null;
		$iReturnCode = null;
        $request = new GiroCheckout_SDK_Request($this->_transaction_type);
		try {
			// Sends request to Girocheckout.
			$request->setSecret($this->getProjectPassword());
			foreach ($this->_fieldsArr as $param => $value) {
				$request->addParam($param, $value);
			}
			$request->submit();

			if ($request->requestHasSucceeded()) {
				$strUrlRedirect = $request->getResponseParam('redirect');

				return $strUrlRedirect;
			}

            $iReturnCode = $request->getResponseParam('rc');
            $strResponseMsg = $request->getResponseMessage($iReturnCode, Mage::helper('egovs_girosolution')->getLanguageCode());
            if (!$strResponseMsg) {
                $strResponseMsg = $this->_getHelper()->__("Unkown server error.");
            }
            if ($request->getResponseParam('reference')) {
                $params = var_export($request->getResponseParams(), true);
                $msg = "{$this->getCode()}::Failed to start transaction on Girosolution REFID:{$request->getResponseParam('reference')}\n{$strResponseMsg}\nAdditional Information:\n{$params}";
                Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            } else {
                $params = var_export($request->getResponseParams(), true);
                $msg = "{$this->getCode()}::Failed to start transaction on Girosolution\n{$strResponseMsg}\nAdditional Information:\n{$params}";
                Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            }

            $msg = 'Failed to start transaction on GiroSolution';
            throw new Exception($msg);
		} catch ( Exception $e ) {
			Mage::logException($e);

            //Roll Back
            $_source = $this->_getOrder();
            if (!$_source) {
                /** @var $_source Mage_Sales_Model_Quote */
                $_source = $this->getInfoInstance()->getQuote();
            } else {
                /** @var $_source Mage_Sales_Model_Order */
                /** @var $payment Mage_Sales_Model_Order_Payment */
                $payment = $_source->getPayment();
                $payment->setTransactionId($request->getResponseParam('reference'));
                $transaction = $payment->addTransaction('order', null, false, '');
                if ($transaction) {
                    $transaction->setParentTxnId($_source->getIncrementId());
                    $transaction->setIsClosed(1);
                    $transaction->setAdditionalInformation(Mage_Sales_Model_Order_Payment_Transaction::RAW_DETAILS, $request->getResponseParams());
                    $transaction->save();
                }
                $_source->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
                $_source->cancel()->save();

                $_quoteId = $_source->getQuoteId();
                $_source = $_source->getQuote();
                if (!$_source) {
                    $_source = Mage::getModel('sales/quote')->load($_quoteId);
                }
            }

            if (!$_source->isEmpty()) {
                if (!$_source->getIsActive()) {
                    $_source->setIsActive(true)->save();
                }
                Mage::getSingleton('checkout/session')->replaceQuote($_source);
            }
		}

		if (is_null($msg)) {
			$msg = GiroCheckout_SDK_ResponseCode_helper::getMessage(5100, Mage::helper('egovs_girosolution')->getLanguageCode());
		}
		Mage::helper("paymentbase")->sendMailToAdmin($msg, 'Fehler bei getGirosolutionRedirectURL');
		
		if (!is_null($iReturnCode) && !is_null($request)) {
			$msg = $request->getResponseMessage($iReturnCode, Mage::helper('egovs_girosolution')->getLanguageCode());
		}
		Mage::throwException($msg);
	}
	
	/**
	 * Liefert Debug-Flag
	 *
	 * @return string
	 */
	public function getDebug() {
		return Mage::getStoreConfigFlag('payment/'.$this->getCode().'/debug_flag');
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

    /**
     * Ändert die Order nach der Bezahlung
     *
     * @param bool   $paymentSuccessful
     * @param string $merchantTxId
     * @param bool   $updateOrderState
     * @param string $orderStateComment
     * @param bool   $sendEmail
     * @param bool   $createInvoice
     * @param string $invoiceComment
     * @param string $gcRef
     * @param array  $gcTransInfo
     * @param string $orderStateFinished
     *
     * @return boolean
     * @throws \Exception
     * @throws \Mage_Core_Exception
     */
	public function modifyOrderAfterPayment(
        $paymentSuccessful = false,
        $merchantTxId = '',
        $updateOrderState = false,
        $orderStateComment = '',
        $sendEmail = false,
        $createInvoice = true,
        $invoiceComment = '',
        $gcRef = null,
        $gcTransInfo = null,
        $orderStateFinished = Mage_Sales_Model_Order::STATE_PROCESSING
    ) {
        //=======================================================================================================
        $this->_globalStartTime = $this->_getTimeStamp();

        $order = $this->_getOrder();
        // If order was not found, return false
        if(!$order || $order->isEmpty()) {
            Mage::log("{$this->getCode()}::Es ist keine Bestellung verfügbar!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            return false;
        }

        /*
         * 20110804:Frank Rochlitzer
         * Die parallele Ausführung dieser Funktion muss verhindert werden (Kritischer Abschnitt)!
         * Durch die BSI-Restriktionen kann die Session ID nicht an die NOTIFY URL angehängt werden,
         * da der Saferpay-Aufruf eine andere IP besitzt als der Kunde der entsprechenden Bestellung.
         * Jeder Aufruf der NOTIFY_ACTION wird als eigene Session behandelt, da in der URL keine
         * SID enthalten ist.
         *
         * Der einzige Parameter ist die REAL_ORDER_ID mit der die entsprechende Order identifiziert werden kann.
         * Es kann also nur ein Flag an der Order zur Kontrolle verwendet werden!
         * Diese Aktionen sind jedoch nicht atomar und bieten somit keine 100% Sicherheit.
         *
         * Die konsequente Lösung wäre die Benutzung eines Semaphores, diese sind in PHP aber nur unter Linux/Unix
         * verfügbar und sind standarmäßig deaktiviert.
         */
        $lockKey = 'girosolution_mutex'.$this->_getOrder()->getId();
        $lockHelper = $this->getLockHelper();
        $lockAlreadyObtainedMsg = "{$this->getCode()}::modifyOrderAfterPayment:%s:modifyOrderAfterPayment already called, disabling update order state!";
        $lockNotObtainableMsg = "{$this->getCode()}::modifyOrderAfterPayment:%s:Lock is free! ".'It seems %1$s timed out, so lock could not obtained.';
        $isLockedFlag = false;
        //APCU lock is optional
        $startTime = $this->_getTimeStamp();
        if (!$lockHelper->getApcuLock($lockKey)) {
            if ($lockHelper->isFreeLockApcu($lockKey) === false) {
                Mage::log(sprintf($lockAlreadyObtainedMsg, 'APCU_FETCH'), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
                $updateOrderState = false;
                $isLockedFlag = true;
            } else {
                Mage::log(sprintf($lockNotObtainableMsg, 'APCU_LOCK'), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
            }
        } else {
            $isLockedFlag = true;
            $this->_logLockTimeDiff($startTime, 'apcu');
        }

        //DB lock is mandatory
        $startTime = $this->_getTimeStamp();
        if (!$lockHelper->getDbLock($lockKey)) {
            if (!$lockHelper->isFreeLockDb($lockKey)) {
                Mage::log(sprintf($lockAlreadyObtainedMsg, 'DB_LOCK'), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
                $updateOrderState = false;
                $isLockedFlag = true;
            } else {
                Mage::log(sprintf($lockNotObtainableMsg, 'DB_LOCK'), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
            }
        } else {
            $isLockedFlag = true;
            $this->_logLockTimeDiff($startTime, 'DB:get_lock');
        }

        if (isset($paymentSuccessful)) {
            $paymentSuccessful = (is_bool($paymentSuccessful) ? $paymentSuccessful : false);
        } else {
            $paymentSuccessful = false;
        }
        $merchantTxId = isset($merchantTxId) ? $merchantTxId : '';
        if (isset($updateOrderState)) {
            $updateOrderState = (is_bool($updateOrderState) ? $updateOrderState : false);
        } else {
            $updateOrderState = false;
        }

        $extKassenzeichen = trim($merchantTxId);
        if (preg_match('/(?<=\/)[\w]+$/', $extKassenzeichen, $matches)) {
            $extKassenzeichen = $matches[0];
        }

        if ($extKassenzeichen != $order->getPayment()->getKassenzeichen()) {
            $msg = "Kassenzeichen stimmt nicht mit Kassenzeichen aus Girosolutiondaten überein!";
            $msg .= "\r\nTKonnekt:$extKassenzeichen != {$order->getPayment()->getKassenzeichen()}:Webshop";
            Mage::log("{$this->getCode()}::$msg", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            $lockHelper->releaseAllLocks($lockKey);
            return false;
        }

        $startTime = $this->_getTimeStamp();
        $orderState = $order->getState();
        //If order was already updated, do not update again.
        if($orderState != Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW) {
            Mage::log("{$this->getCode()}::modifyOrderAfterPayment:modifyOrderAfterPayment already called, omitting! State was: {$this->_getOrder()->getState()}", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
            $updateOrderState = false;
        } else {
            // Modify payment
            $order->setState(
                Mage_Sales_Model_Order::STATE_PENDING_PAYMENT,
                true,
                $this->__("Modifying state for further processing."),
                false
            );
            //Schnelles Speichern um Bereich zu verriegeln!
            $orderResource = $order->getResource();
            $orderResource->saveAttribute($order, 'state');
            $this->_logLockTimeDiff($startTime, 'DB_STATE');

            //update transaction
            $payment = $order->getPayment();
            $payment->setTransactionId($gcRef);
            $transaction = $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_ORDER, null, false, '');
            $transaction->setParentTxnId($this->getTransactionId($payment));
            $transaction->setIsClosed(1);
            $transaction->setAdditionalInformation(Mage_Sales_Model_Order_Payment_Transaction::RAW_DETAILS, $gcTransInfo);
            $transaction->save();

            $order->save();
        }

        if ($this->getDebug()) {
            $tmp = '';
            foreach ($gcTransInfo as $k => $v) {
                $tmp .= '<' .$k .'>' .$v .'</' .$k .'>';
            }
            Mage::log("{$this->getCode()}::\n$tmp", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        }

        //Some more inits
        $orderStateComment = isset($orderStateComment) ? $orderStateComment : '';
        if ($orderStateComment == '') {
            if ($paymentSuccessful == true) {
                $orderStateComment = 'Payment was successful';
            } else {
                $orderStateComment = 'Payment failed';
            }
        }
        if (isset($sendEmail)) {
            $sendEmail = (is_bool($sendEmail) ? $sendEmail : false);
        } else {
            $sendEmail = false;
        }
        if (isset($createInvoice)) {
            $createInvoice = (is_bool($createInvoice) ? $createInvoice : true);
        } else {
            $createInvoice = true;
        }
        $invoiceComment = isset($invoiceComment) ? $invoiceComment : '';
        if($invoiceComment == '') {
            $invoiceComment = Mage::helper('egovs_girosolution')->__('Automatically generated by payment confirmation');
        }

        if($paymentSuccessful == false) {
            // If no update was required, return true, because the order was found
            if($updateOrderState == false) {
                $lockHelper->releaseAllLocks($lockKey);
                return true;
            }

            if ($order->canCancel()) {
                $order->cancel();
                $order->addStatusHistoryComment($orderStateComment);
                $order->save();
                Mage::getSingleton('checkout/session')->addNotice($orderStateComment);
            }
            $lockHelper->releaseAllLocks($lockKey);
            return true;
        } // end failed payment


        // SUCCESSFUL PAYMENT
        // Set customers shopping cart inactive
        $quote = $this->_getOrder()->getQuoteId();
        $quote = $this->_getQuote($quote);
        $quote->setIsActive(false)->save();

        // If no update was required, return true, because the order was found
        if($isLockedFlag && $updateOrderState === false) {
            $lockHelper->releaseAllLocks($lockKey);
            return true;
        }

        //TODO : Providername ermitteln
        $_providerName = 'VISA';

        $_kassenzeichenActivated = $this->_activateKassenzeichen($merchantTxId, $gcRef, $_providerName);

        if ($_kassenzeichenActivated) {
            /** @var $payment Mage_Sales_Model_Order_Payment */
            $payment = $order->getPayment();
            $payment->setTransactionId($this->getTransactionId($payment));
            $transaction = $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_AUTH, null, false, $this->__('Kassenzeichen activated'));
            //$transaction->setParentTxnId($this->getTransactionId($payment));
            $transaction->setIsClosed(1);
            $transaction->save();
        } else {
            $order->setState(Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW, false, $this->__('Could not activate Kassenzeichen! See log files for further informations.'), false);
            $order->save();
            $lockHelper->releaseAllLocks($lockKey);
            return true;
        }

        // Send email
        if($sendEmail == true) {
            $order->sendNewOrderEmail();
            $order->setEmailSent(true);
        }

        if(empty($orderStateFinished)) {
            $orderStateFinished = true;
        }

        // Modify payment
        $order->setState(
                Mage_Sales_Model_Order::STATE_PROCESSING,
                $orderStateFinished,
                $orderStateComment,
                $sendEmail
        );

        if ($createInvoice == true) {
            if ($order->canInvoice()) {
                $invoice = $order->prepareInvoice();
                $invoice->addComment($invoiceComment);
                $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
                $invoice->register();

                try {
                    Mage::getModel('core/resource_transaction')->addObject($invoice)->addObject($invoice->getOrder())->save();
                    $invoice->sendEmail(true, '');
                    //$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $orderStateFinished, $invoiceComment);
                } catch (Exception $e) {
                    Mage::logException($e);
                }
                //Event muss aus Kompatibilitätsgründen so heißen!?
                Mage::log("{$this->getCode()}::dispatching event:egovs_paymentbase_saferpay_sales_order_invoice_after_pay", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
                Mage::dispatchEvent('egovs_paymentbase_saferpay_sales_order_invoice_after_pay', array('invoice'=>$invoice));
                Mage::dispatchEvent('egovs_paymentbase_gateway_sales_order_invoice_after_pay', array('invoice'=>$invoice));
                Mage::log("{$this->getCode()}::dispatched event:egovs_paymentbase_saferpay_sales_order_invoice_after_pay", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
                Mage::log("{$this->getCode()}::...invoice created", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            }
        }

        $order->save();

        $lockHelper->releaseAllLocks($lockKey);
        return true;
	}
	
	/**
	 * Kassenzeichen an ePayBL aktivieren
	 * 
	 * @param string $merchantTxId Bewirtschafter + / + Kassenzeichen
	 * @param string $refId        TranskationsID des Zahlungsproviders
	 * @param string $providerName Mögliche Werte sind: VISA, MASTER, GIROPAY, SEPASDD
	 * 
	 * @return boolean true falls Kassenzeichen aktiviert wurde, sonst false
	 */
	protected function _activateKassenzeichen($merchantTxId, $refId, $providerName = 'VISA') {
		/*
		 * now we are sure that the payment was successful as the result xml
		 * element from the command line tool contains an attribute MSGTYPE
		 * with value PayConfirm. We process the payment.
		 */
		 
		/*
		 * Die notify Action wird direkt von Girosolution aufgerufen (URL wird vorher übergeben)
		 *
		 */
		Mage::log("{$this->getCode()}::WS aktiviereTempKassenzeichen() kann aufgerufen werden", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
			
		// so, jetzt Zugriff auf SOAP-Schnittstelle beim eGovernment
		$objSOAPClient = Mage::helper('paymentbase')->getSoapClient();
		$objResult = null;
		for ($i = 0; $i < 3 && !($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis) && (!$objResult || !$objResult->isOk()); $i++) {
			Mage::log(sprintf("{$this->getCode()}::Try %s to activate kassenzeichen...", $i+1), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			try {
				//Aktiviert z. B. das Kassenzeichen
				$objResult = $this->_callSoapClientImpl($objSOAPClient, $merchantTxId, Mage::helper('paymentbase')->getMandantNr(), $refId, $providerName);
			} catch (Exception $e) {
				Mage::log(sprintf("{$this->getCode()}::Activating Kassenzeichen failed: %s", $e->getMessage()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			}
		}
		Mage::log(sprintf("{$this->getCode()}::Tried to activate Kassenzeichen, validating result...", $i+1), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$order = $this->_getOrder();
		
		// wenn Web-Service nicht geklappt hat
		if (!$objResult || !$objResult->isOk()) {
			$kassenzeichen = 'empty';
			$subject = "{$this->getCode()}::WS aktiviereTempKassenzeichen() nicht erfolgreich";
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
			return false;
		}
		
		//Kassenzeichen erfolgreich aktiviert
		$kassenzeichen = 'empty';
		if ($order->getPayment()->hasData('kassenzeichen')) {
			$kassenzeichen = $order->getPayment()->getKassenzeichen();
			Mage::log("{$this->getCode()}::Using Kassenzeichen: $kassenzeichen", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} else {
			Mage::log("{$this->getCode()}::Fehler:WS kein Kassenzeichen im Payment enthalten", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			$sMailText = "WS kein Kassenzeichen im Payment enthalten!";
				
			Mage::helper("paymentbase")->sendMailToAdmin($sMailText);
		}
		Mage::log("{$this->getCode()}::WS Kassenzeichen successfully activated : $kassenzeichen", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		
		return true;
	}
	
	/**
	 * SOAP-Aufruf am ePayment-Server
	 *
	 * Modulspzifische Implementation des Aufrufs
	 *
	 * @param Egovs_Paymentbase_Model_Webservice_PaymentServices $objSOAPClient SOAPClient
	 * @param string $wId           WebshopID zur Identifizierung des Bewirtschafter plus Kassenzeichen. Zusammengesetzt aus Bewirtschafter + '/' + Kassenzeichen
	 * @param string $mandantNr     Mandanten Nr.
	 * @param string $refId			TranskationsID des Zahlungsproviders
	 * @param string $providerName  VISA,MASTER,GIROPAY,SEPASDD
	 *
	 * @return Egovs_Paymentbase_Model_Abstract Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
	 *
	 * @throws Exception
	 */
	protected abstract function _callSoapClientImpl($objSOAPClient, $wId, $mandantNr, $refId, $providerName);
	
	public function validate() {
		parent::validate();
		
		//Validate
		$this->getMerchantId();
		$this->getProjectId();
		$this->getProjectPassword();
		
		return $this;
	}

	protected function _logLockTimeDiff($startTime, $lockMethod = '') {
        if (function_exists('microtime')) {
            $endTime = microtime(true);
        } else {
            $endTime = time();
        }
        $runTime = $endTime - $startTime;
        $totalRunTime = $endTime - $this->_globalStartTime;

        if ($totalRunTime > 0) {
            $totalRunTimeMsg = "Total run time is $totalRunTime seconds.";
        } else {
            $totalRunTimeMsg = '';
        }
        if ($runTime > 8) {
            Mage::log("{$this->getCode()}::modifyOrderAfterPayment:Server seems to be under heavy load! It took $runTime seconds until the lock ($lockMethod) was set! $totalRunTimeMsg", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
        } else {
            Mage::log(sprintf("{$this->getCode()}::modifyOrderAfterPayment:Measured runtime for LOCK ($lockMethod) was %s seconds. $totalRunTimeMsg", $runTime), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        }
    }

    /**
     * @return int|mixed
     */
    protected function _getTimeStamp() {
        if (function_exists('microtime')) {
            $startTime = microtime(true);
        } else {
            $startTime = time();
        }

        return $startTime;
    }
}