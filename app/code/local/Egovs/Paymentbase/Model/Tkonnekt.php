<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im TKonnekt-Verfahren (Debitkarten).
 *
 * Überschreibt hier nur Egovs_Paymentbase_Helper_Data
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Tkonnekt extends Egovs_Paymentbase_Model_Abstract
{
    const TKONNEKT_DEBUG_OFF = 0;
    const TKONNEKT_DEBUG_ON = 1;
    const TKONNEKT_DEBUG_ON_EPAYBL_OFF = 2;

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
	
	public function __construct() {
		Egovs_Paymentbase_Helper_Tkonnekt_Factory::initTkonnekt();
		
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
     * Die Transaktions ID setzt sich wie folgt zusammen:
     * "BewirtschafterNr/Kassenzeichen"
     * oder ohne ePayBL-Kommunikation
     * "BewirtschafterNr/OrderIncrementID"
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

        /**
         * 20180525::Frank Rochlitzer
         * TransactionId aus Payment enthält im Order Payment die tkRef
         * @see modifyOrderAfterPayment
         */
        $txId = $payment->getTransactionId();
    	if (!$txId || $payment->getTransactionIdIsProviderId()) {
    	    if (!($txId = $payment->getEpayblTransactionId())) {
                $txId = $payment->getOrder()->getExternesKassenzeichen();
            }
        }
    	if ($txId) {
            $_matches = array();
    	    if (preg_match('/[\w]+\/[\w]+$/', $txId, $_matches)) {
                return $_matches[0];
            }
            $helper = Mage::helper('gka_tkonnektpay');
            $msg = $helper->__('Invalid external Kassenzeichen: %s. Please check ePayBL-Client setting configuration!', $txId);
    	    $helper->sendMailToAdmin("{$this->getCode()}::$msg", $helper->__('TKonnekt Error').':', $this->getCode());
            Mage::log($this->getCode()."::".$msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            Mage::throwException($helper->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
        }

    	if (!$payment->hasKassenzeichen() || !$payment->getKassenzeichen()) {
            if (self::TKONNEKT_DEBUG_ON_EPAYBL_OFF == $this->getDebug()) {
                $incrementId = $this->_getOrderIncrementId();
                $incrementId = array_shift($incrementId);

                $payment->setKassenzeichen($incrementId);
            } else {
                Mage::throwException($this->__('No kassenzeichen available!'));
            }
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
				$helper = Mage::helper('gka_tkonnektpay');
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Merchant ID is missing in TKonnekt configuration')}", $helper->__('TKonnekt Error').':', $this->getCode());
			
				$sModul = ucwords(substr($this->getCode(), 6), '_');
			
				Mage::log($this->getCode()."::".$helper->__("%s Merchant ID is missing in TKonnekt configuration. Please contact the shop operator.", $sModul), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['merid'] = true;
			}
			Mage::throwException(Mage::helper('gka_tkonnektpay')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
		}
		
		return $merchantId;
	}

    /**
     * Get Server URL
     *
     * @return string
     */
    public function getServerUrl() {
        $serverUrl =  Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/server_url' );
        if (empty($serverUrl)) {
            if (!array_key_exists('srvurl', $this->_errors)) {
                $helper = Mage::helper('gka_tkonnektpay');
                $helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Server URL is missing in TKonnekt configuration')}", $helper->__('TKonnekt Error').':', $this->getCode());

                $sModul = ucwords(substr($this->getCode(), 6), '_');

                Mage::log($this->getCode()."::".$helper->__("%s Server URL is missing in TKonnekt configuration. Please contact the shop operator.", $sModul), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                $this->_errors['srvurl'] = true;
            }
            Mage::throwException(Mage::helper('gka_tkonnektpay')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
        }

        return $serverUrl;
    }
	
	/**
	 * Get Project password
	 *
	 * @return string
	 */
	public function getProjectPassword() {
		$projectPassword =  $this->_getHelper()->getProjectPassword();
	
		if (empty($projectPassword)) {
			if (!array_key_exists('prjpwd', $this->_errors)) {
				$helper = Mage::helper('gka_tkonnektpay');
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Project password is missing in TKonnekt configuration')}", $helper->__('TKonnekt Error').':', $this->getCode());
					
				$sModul = ucwords(substr($this->getCode(), 6), '_');
					
				Mage::log($this->getCode()."::".$helper->__("%s Project password is missing in TKonnekt configuration. Please contact the shop operator.", $sModul), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['prjpwd'] = true;
			}
			Mage::throwException(Mage::helper('gka_tkonnektpay')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
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
	 * @return the URL to be redirected to
	 */
	public function getOrderPlaceRedirectUrl() {
		return $this->getTkonnektRedirectUrl();
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
	 * @return Egovs_Paymentbase_Model_Tkonnekt
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::_authorize()
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		//Validate
		$this->getMerchantId();
		$this->getProjectPassword();
		
		if (self::TKONNEKT_DEBUG_ON_EPAYBL_OFF != $this->getDebug()) {
            //20110801 :  Frank Rochlitzer : Doppelte Kassenzeichen vermeiden
            if (!$this->hasKassenzeichen($payment)) {
                $kassenzeichen = $this->_anlegenKassenzeichen($this->_epaybl_transaction_type);

                Mage::log("{$this->getCode()}::KASSENZEICHEN ANGELEGT:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
                $payment->setKassenzeichen($kassenzeichen);
                $payment->setPayClient(Mage::helper('paymentbase')->getMandantNr());
                $payment->setPayOperator(Mage::helper('paymentbase')->getBewirtschafterNr());
                //20160712 :: Frank Rochlitzer : Kassenzeichen auch in Quote ablegen
                $payment->getOrder()->getQuote()->getPayment()->setKassenzeichen($kassenzeichen);

                /** @var $payment Mage_Sales_Model_Order_Payment */
                $payment->setTransactionId($this->getTransactionId($payment));
            } else {
                $kassenzeichen = $payment->getKassenzeichen();
                Mage::log("{$this->getCode()}::KASSENZEICHEN BEREITS VORHANDEN:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
            }
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
	 * die Buchungslisten Paramter um die Zahlmethode terminalpayment
	 * {@inheritDoc}
	 * @see Egovs_Paymentbase_Model_Abstract::getBuchungsListeParameter()
	 */
	public function getBuchungsListeParameter($payment, $amount) {
		$params = parent::getBuchungsListeParameter($payment, $amount);
		$params['paymentmethod'] = 'terminalpayment';
		return $params;
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

        if (self::TKONNEKT_DEBUG_ON_EPAYBL_OFF != $this->getDebug()) {
            if (!$this->hasKassenzeichen($payment)) {
                $this->authorize($payment, $amount);
            }
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
	 * Eigene Anpassungen für $this->_fieldsArr für TKonnekt
	 *
	 * @return string
	 *
	 */
	protected abstract function _getTkonnektRedirectUrl();

	/**
	 * Liefert die PayerNote
	 *
	 * Falls es keine PayerNote gibt wird null zurückgegeben
	 *
	 * @return string|null
         */
	protected function _getPayerNote() {
		if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/payernote")) <= 0) {
			$desc = null;
		} else {
			$desc = Mage::getStoreConfig("payment/{$this->getCode()}/payernote");
		}

		return $desc;
	}
	/**
	 * Prepariert die Argumente die an TKonnekt übertragen werden sollen
	 *
	 * Template method
	 *
	 * Abgeleitete Klassen müssen _getTkonnektRedirectUrl() überschreiben!
	 *
	 * @return string
	 */
	public final function getTkonnektRedirectUrl() {

        $this->_fieldsArr = array ();

        $this->_fieldsArr['merchantId'] = $this->getMerchantId();
        $this->_fieldsArr['userId'] = $this->_getCustomerId();

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

		$controllerName = str_replace('gka_tkonnektpay_', '', $this->getCode());
		$this->_fieldsArr ['urlRedirect'] = $this->_getLinkUrl("tkonnekt/$controllerName/success"). '?real_order_id='.$_realOrderId;
		$this->_fieldsArr ['urlNotify'] = $this->_getLinkUrl("tkonnekt/$controllerName/notify"). '?real_order_id='.$_realOrderId;

		$desc = $this->_getPayerNote();

        $this->_fieldsArr['merchantTxId'] = $this->getTransactionId();

        if (!empty($desc)) {
            $this->_fieldsArr['purpose'] = "{$this->_fieldsArr['merchantTxId']}:$desc";
        } else {
            $this->_fieldsArr['purpose'] = $this->_fieldsArr['merchantTxId'];
        }

		//Call to the implementation method for childrens
		$this->_getTkonnektRedirectUrl();

		if ($this->getDebug() > 0) {
			$request = '';
			foreach ( $this->_fieldsArr as $k => $v ) {
				$request .= '<' . $k . '>' . $v . '</' . $k . '>';
			}

			Mage::log(sprintf('%s::debug: %s', $this->getCode(), $request), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}

		$msg = null;
		$additionalMsg = null;
		$iReturnCode = null;
        $request = new TKonnekt_SDK_Request('debitCardTransaction');
		try {
			// Sends request to TKonnekt.
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
            $strResponseMsg = $request->getResponseMessage();
            if (!$strResponseMsg) {
                $strResponseMsg = $this->_getHelper()->__("Unknown server error.");
            }
            if ($request->getResponseParam('reference')) {
                $params = var_export($request->getResponseParams(), true);
                $msg = "{$this->getCode()}::Failed to start transaction on TKonnekt REFID:{$request->getResponseParam('reference')}\n{$strResponseMsg}\nAdditional Information:\n{$params}";
                Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            } else {
                $params = var_export($request->getResponseParams(), true);
                $msg = "{$this->getCode()}::Failed to start transaction on TKonnekt\n{$strResponseMsg}\nAdditional Information:\n{$params}";
                Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            }

            throw new Exception('Failed to start transaction on TKonnekt');
		} catch ( Exception $e ) {
			Mage::logException($e);
			$msg = $e->getMessage();
			if ($e->getPrevious()) {
			    $additionalMsg = "\r\n\r\n".$e->getPrevious()->getMessage();
            }

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
			$msg = Mage::helper('gka_tkonnektpay')->__("Unknown server error");
		}
		Mage::helper("paymentbase")->sendMailToAdmin(sprintf('%s%s', $msg, $additionalMsg), 'Fehler bei getTkonnektRedirectURL');

		if (!is_null($request) && $request->getResponseMessage()) {
			$msg = $request->getResponseMessage();
		}
		Mage::throwException($msg);
	}

	/**
	 * Liefert Debug-Level
	 *
	 * @return int
     *
     * @see Gka_Tkonnketpay_Model_Adminhtml_System_Config_Source_Debug
	 */
	public function getDebug() {
		return Mage::getStoreConfig('payment/'.$this->getCode().'/debug_level');
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
	 * @param string $paymentSuccessful
	 * @param string $merchantTxId
	 * @param string $updateOrderState
	 * @param string $orderStateComment
	 * @param string $sendEmail
	 * @param string $createInvoice
	 * @param string $invoiceComment
	 * @param string $tkRef
	 * @param unknown $tkTransInfo
	 * @param string $orderStateFinished
	 *
	 * @return boolean
	 */
	public function modifyOrderAfterPayment(
        $paymentSuccessful = false,
        $merchantTxId = '',
        $updateOrderState = false,
        $orderStateComment = '',
        $sendEmail = false,
        $createInvoice = true,
        $invoiceComment = '',
        $tkRef = null,
        $tkTransInfo = null,
        $orderStateFinished = Mage_Sales_Model_Order::STATE_PROCESSING) {

				$paymentSuccessful = isset($paymentSuccessful) ? (is_bool($paymentSuccessful) ? $paymentSuccessful : false) : false;
				$merchantTxId = isset($merchantTxId) ? $merchantTxId : '';
				$updateOrderState = isset($updateOrderState) ? (is_bool($updateOrderState) ? $updateOrderState : false) : false;
				$orderStateComment = isset($orderStateComment) ? $orderStateComment : '';

				if($orderStateComment == '') {
					if($paymentSuccessful == true)
						$orderStateComment = 'Payment was successful';
						else
							$orderStateComment = 'Payment failed';
				}
				$sendEmail = isset($sendEmail) ? (is_bool($sendEmail) ? $sendEmail : false) : false;
				$createInvoice = isset($createInvoice) ? (is_bool($createInvoice) ? $createInvoice : true) : true;
				$invoiceComment = isset($invoiceComment) ? $invoiceComment : '';
				if($invoiceComment == '') {
					$invoiceComment = Mage::helper('gka_tkonnektpay')->__('Automatically generated by payment confirmation');
				}

				if ($this->getDebug()) {
					$tmp = '';
					foreach ($tkTransInfo as $k => $v) {
						$tmp .= '<' .$k .'>' .$v .'</' .$k .'>';
					}
					Mage::log("{$this->getCode()}::\n$tmp", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				}

				$extKassenzeichen = trim($merchantTxId);
				if (preg_match('/(?<=\/)[\w]+$/', $extKassenzeichen, $matches)) {
				    $extKassenzeichen = $matches[0];
                }

				$order = $this->_getOrder();
				// If order was not found, return false
				if(!$order || $order->isEmpty()) {
					Mage::log("{$this->getCode()}::Es ist keine Bestellung verfügbar!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
					return false;
				}

                if (self::TKONNEKT_DEBUG_ON_EPAYBL_OFF != $this->getDebug()) {
                    if ($extKassenzeichen != $order->getPayment()->getKassenzeichen()) {
                        $msg = "Kassenzeichen stimmt nicht mit Kassenzeichen aus TKonnektdaten überein!";
                        $msg .= "\r\nTKonnekt:$extKassenzeichen != {$order->getPayment()->getKassenzeichen()}:Webshop";
                        Mage::log("{$this->getCode()}::$msg", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
                        return false;
                    }
                }

				//If order was already updated, do not update again.
				if($order->getState() != Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW) {
					$updateOrderState = false;
				} else {
					//update transaction
					$payment = $order->getPayment();
					if ($payment->getTransactionId()) {
					    $payment->setEpayblTransactionId($payment->getTransactionId());
                    }
					$payment->setTransactionId($tkRef);
					$payment->setTransactionIdIsProviderId(true);
					$transaction = $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_ORDER, null, false, '');
					$transaction->setParentTxnId($this->getTransactionId($payment));
					$transaction->setIsClosed(1);
					$transaction->setAdditionalInformation(Mage_Sales_Model_Order_Payment_Transaction::RAW_DETAILS, $tkTransInfo);
					$transaction->save();
					// Modify payment
					$order->setState(
							Mage_Sales_Model_Order::STATE_PENDING_PAYMENT,
							false,
							$this->__("Modifying state for further processing."),
							false
							);
					$order->save();
				}

				if($paymentSuccessful == false) {
					// If no update was required, return true, because the order was found
					if($updateOrderState == false) {
						return true;
					}

					$order->cancel();
					$order->addStatusHistoryComment($orderStateComment);
					$order->save();
					Mage::getSingleton('checkout/session')->addNotice($orderStateComment);
					return true;
				} // end failed payment


				// SUCCESSFUL PAYMENT
				// Set customers shopping cart inactive
				$quote = $this->_getOrder()->getQuoteId();
				$quote = Mage::getModel('sales/quote')->load($quote);
				//Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();
				$quote->setIsActive(false)->save();

				// If no update was required, return true, because the order was found
				if($updateOrderState == false) {
					return true;
				}

				$_providerName = 'TERMINALZAHLUNG';

                if (!$order->getExternesKassenzeichen() && self::TKONNEKT_DEBUG_ON_EPAYBL_OFF != $this->getDebug()) {
                    $_kassenzeichenActivated = $this->_activateKassenzeichen($merchantTxId, $tkRef, $_providerName);
                } else {
                    $_kassenzeichenActivated = true;
                }

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

				if($createInvoice == true) {
					if($order->canInvoice()) {
						$invoice = $order->prepareInvoice();
						$invoice->addComment($invoiceComment);
						$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
						$invoice->register();

						Mage::getModel('core/resource_transaction')->addObject($invoice)->addObject($invoice->getOrder())->save();
						$invoice->sendEmail(true, '');
						//$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $orderStateFinished, $invoiceComment);
					}
				}

				$order->save();
				//Event muss aus Kompatibilitätsgründen so heißen!?
				Mage::log("{$this->getCode()}::dispatching event:egovs_paymentbase_saferpay_sales_order_invoice_after_pay", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				Mage::dispatchEvent('egovs_paymentbase_saferpay_sales_order_invoice_after_pay', array('invoice'=>$invoice));
				Mage::log("{$this->getCode()}::dispatched event:egovs_paymentbase_saferpay_sales_order_invoice_after_pay", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				Mage::log("{$this->getCode()}::...invoice created", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
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
		 * Die notify Action wird direkt von TKonnekt aufgerufen (URL wird vorher übergeben)
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
		$this->getProjectPassword();
		
		return $this;
	}

	protected function _afterAuthorize($payment, $amount) {
        parent::_afterAuthorize($payment, $amount);

        //Verhindert im Kommentarverlauf den grünen Haken für die Kundenbenachrichtigung.
        $order = $this->_getOrder();
        if ($order) {
            $order->setCustomerNoteNotify(false);
        }

        //Wichtig für richtigen State und Status
        $payment->setIsTransactionPending(true);

        return $this;
    }
}