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
	 * Get Merchant Id
	 *
	 * @return string
	 */
	public function getMerchantId() {
		$merchantId =  Mage::getStoreConfig ( 'payment/' . $this->getCode () . '/merchant_id' );
		
		if (empty($merchantId)) {
			if (!array_key_exists('merid', $this->_errors)) {
				$helper = Mage::helper($this->getCode());
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Merchant ID is missing in Girosolution configuration')}", $helper->__('Girosolution Error').':', $this->getCode());
			
				$sModul = ucwords(substr($this->getCode(), 6), '_');
			
				Mage::log($this->getCode()."::".$helper->__("$sModul Merchant ID is missing in Girosolution configuration. Please contact the shop operator."), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['merid'] = true;
			}
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
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
	
		if (empty($projectId)) {
			if (!array_key_exists('prjid', $this->_errors)) {
				$helper = Mage::helper($this->getCode());
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Project ID is missing in Girosolution configuration')}", $helper->__('Girosolution Error').':', $this->getCode());
					
				$sModul = ucwords(substr($this->getCode(), 6), '_');
					
				Mage::log($this->getCode()."::".$helper->__("$sModul Project ID is missing in Girosolution configuration. Please contact the shop operator."), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['prjid'] = true;
			}
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
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
	
		if (empty($projectPassword)) {
			if (!array_key_exists('prjpwd', $this->_errors)) {
				$helper = Mage::helper($this->getCode());
				$helper->sendMailToAdmin("{$this->getCode()}::{$helper->__('Project password is missing in Girosolution configuration')}", $helper->__('Girosolution Error').':', $this->getCode());
					
				$sModul = ucwords(substr($this->getCode(), 6), '_');
					
				Mage::log($this->getCode()."::".$helper->__("$sModul Project password is missing in Girosolution configuration. Please contact the shop operator."), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_errors['prjpwd'] = true;
			}
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getAdminMail()));
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
		return Mage::getUrl("girosolution/{$this->getCode()}/redirect");
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
        } else {
        	$kassenzeichen = $payment->getKassenzeichen();
        	Mage::log("{$this->getCode()}::KASSENZEICHEN BEREITS VORHANDEN:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);        	
        }
        
        //TODO : Kann eigentlich entfernt werden, da $this->_anlegenKassenzeichen(...) die Fehlerbehandlung macht!
        if (substr($kassenzeichen, 0, 6) == 'ERROR:') {
        	switch (intval(substr($kassenzeichen, 6))) {
        		case -611:
        			Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR_-0611', Mage::helper('paymentbase')->getCustomerSupportMail()));
        		default :
        			$base = 'TEXT_PROCESS_'. $kassenzeichen;
        			$translate = Mage::helper('egovs_girosolution')->__($base, Mage::helper('paymentbase')->getCustomerSupportMail());
        			if ($base == $translate) {
        				Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR:UNKNOWN CURL ERROR', Mage::helper('paymentbase')->getCustomerSupportMail()));
        			} else Mage::throwException($translate);
        	}	
        }
        
		Mage::log("{$this->getCode()}::KASSENZEICHEN ANGELEGT:$kassenzeichen, OrderID: {$this->getInfoInstance()->getOrder()->getIncrementId()}", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
        $payment->setData('kassenzeichen', $kassenzeichen);
        
        //Verhindert im Kommentarverlauf den grünen Haken für die Kundenbenachrichtigung.
        $order = $this->_getOrder();
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
	 * @param string $transactionType Type
	 * 
	 * @return int Kassenzeichen
	 */
	protected function _anlegenKassenzeichen($transactionType) {

		// prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert
		$this->createCustomerForPayment();
	
		//Buchungsliste erstellen
		$arrBuchungsliste = $this->createAccountingListParts();
	
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
			if ($objResult instanceof SoapFault && $objResult->faultcode == 'Client' && $objResult->code == '0' && stripos($objResult->faultstring, self::SOAP_METHOD_NOT_AVAILABLE) > 0) {
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
			&& ($order->getState() == Mage_Sales_Model_Order::STATE_NEW
				|| $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT)
		) {
			
    		//STATE_COMPLETE ist in Magento ab 1.6 geschützt
    		//wird für Virtuelle Produkte aber automatisch gesetzt
    		$orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
	    	
			$order->setState($orderState);
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
	 * Prepariert die Argumente die an Girosolution übertragen werden sollen
	 *
	 * Template method
	 *
	 * Abgeleitete Klassen müssen _getGirosolutionRedirectUrl() überschreiben!
	 *
	 * @return array
	 */
	public final function getGirosolutionRedirectUrl() {

        $this->_fieldsArr = array ();

        $this->_fieldsArr['merchantId'] = $this->getMerchantId();
        $this->_fieldsArr['projectId'] = $this->getProjectId();
        
		$this->_fieldsArr['amount'] = ($this->_getOrder()->getTotalDue() * 100);
		$this->_fieldsArr['currency'] = $this->_getOrder()->getOrderCurrencyCode();
		
		$controllerName = str_replace('egovs_girosolution_', '', $this->getCode());
		$this->_fieldsArr ['urlRedirect'] = $this->_getLinkUrl("girosolution/$controllerName/success"). '?real_order_id='.$this->_getOrder()->getRealOrderId();
		$this->_fieldsArr ['urlNotify'] = $this->_getLinkUrl("girosolution/$controllerName/notify"). '?real_order_id='.$this->_getOrder()->getRealOrderId();
		
		$desc = $this->_getPayerNote();

		$this->_fieldsArr['desc'] = htmlentities($desc);
		
        $this->_fieldsArr['merchantTxId'] = "{$this->_getBewirtschafterNr()}/{$this->getInfoInstance()->getKassenzeichen()}";
        
        if (Mage::getStoreConfigFlag("payment/{$this->getCode()}/epa_purpose")) {
        	$this->_fieldsArr['purpose'] = $this->_fieldsArr['merchantTxId'];
        } else {
        	$this->_fieldsArr['purpose'] = "{$this->getInfoInstance()->getKassenzeichen()} : $desc";
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
		
		try {
			// Sends request to Girocheckout.
			$request = new GiroCheckout_SDK_Request($this->_transaction_type);
			$request->setSecret($this->getProjectPassword());
			foreach ($this->_fieldsArr as $param => $value) {
				$request->addParam($param, $value);
			}
			$request->submit ();
			
			if ($request->requestHasSucceeded ()) {
				$strUrlRedirect = $request->getResponseParam('redirect');
				
				$result ["status"] = 1001;
				$result ["redirect"] = $strUrlRedirect;
				$result ["reference"] = $request->getResponseParam('reference');
				$result ["gcTransInfo"] = $request->getResponseParams();
				
				$url = $strUrlRedirect;
			} else {
				$iReturnCode = $request->getResponseParam('rc');
				$strResponseMsg = $request->getResponseMessage($iReturnCode, Mage::helper('egovs_girosolution')->getLanguageCode());
				
				if ($request->getResponseParam('reference')) {
					$order = $this->_getOrder();
					$payment = $order->getPayment ();
					$payment->setTransactionId($request->getResponseParam('reference'));
					$transaction = $payment->addTransaction('order', null, false, '');
					$transaction->setParentTxnId ($request->getResponseParam('reference'));
					$transaction->setIsClosed(1);
					$transaction->setAdditionalInformation("arrInfo", serialize($request->getResponseParams()));
					$transaction->save ();
					$order->save ();
				}
				
				return Mage::getUrl('checkout/cart', array('_secure' => true));
			}
		} catch ( Exception $e ) {
			Mage::getSingleton('core/session' )->addError(GiroCheckout_SDK_ResponseCode_helper::getMessage(5100, Mage::helper('egovs_girosolution')->getLanguageCode()));
			return Mage::getUrl('checkout/cart', array('_secure' => true));
		}
		
		
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
	 * @param unknown $gcRef
	 * @param unknown $gcTransInfo
	 * @param unknown $orderStateFinished
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
			$gcRef = null,
			$gcTransInfo = null,
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
					$invoiceComment = 'Automatically generated by payment confirmation';
				}
	
				$merchantTxId = str_replace("{$this->_getBewirtschafterNr()}/", "", $merchantTxId);
				
				if ($merchantTxId != $this->getInfoInstance()->getKassenzeichen()) {
					Mage::log("{$this->getCode()}::Kassenzeichen stimmt nicht mit Kassenzeichen aus Girosolutiondaten überein!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
					return false;
				}
				$order = $this->_getOrder();
				// If order was not found, return false
				if(!$order || $order->isEmpty()) {
					Mage::log("{$this->getCode()}::Es ist keine Bestellung verfügbar!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
					return false;
				}
				$orderId = $order->getIncrementId();
				
				//If order was already updated, do not update again.
				if($order->getState() != Mage_Sales_Model_Order::STATE_PENDING_PAYMENT) {
					$updateOrderState = false;
				} else {
					//update transaction
					$payment = $order->getPayment();
					$payment->setTransactionId($orderid);
					$transaction = $payment->addTransaction('order', null, false, '');
					$transaction->setParentTxnId($orderid);
					$transaction->setIsClosed(1);
					$transaction->setAdditionalInformation("arrInfo", serialize($gcTransInfo));
					$transaction->save();
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
						$orderStateComment
				);
	
				if($createInvoice == true) {
					if($order->canInvoice()) {
						$invoice = $order->prepareInvoice()->addComment($invoiceComment)->register()->pay();
						Mage::getModel('core/resource_transaction')->addObject($invoice)->addObject($invoice->getOrder())->save();
						$invoice->sendEmail(true, '');
						$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $orderStateFinished, $invoiceComment);
					}
				}
	
				$order->save();
				return true;
	}
	
	public function validate() {
		parent::validate();
		
		//Validate
		$this->getMerchantId();
		$this->getProjectId();
		$this->getProjectPassword();
		
		return $this;
	}
}