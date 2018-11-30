<?php
/**
 * Klasse für ePayment-Kommunikation im Saferpay-Verfahren (Kreditkarte).
 *
 * @category	Egovs
 * @package		Egovs_Zahlpartnerkonten
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011-2013 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Zahlpartnerkonten_Model_Payment_Saferpay extends Egovs_Saferpay_Model_Saferpay
{
	const MAX_RETRIES = 1;
	
	private $__kZModel = null;
	
	private $__kennzMahn = null;
	
	/**
	 * Anzahl Fehlversuche für anlegenKassenzeichen
	 * 
	 * @var int
	 */
	protected $_fails = 0;
	
	/**
	 * Gibt an ob bei einem Fehler in der Kommunikation mit der ePayBL ein weiterer Versuch erfolgen soll
	 * 
	 * @var bool
	 */
	protected $_retry = false;
	
	/**
	 * Liefert das Kennzeichen für Mahnverfahren und setzt den Status für ZP-Konten
	 *
	 * Nur für ZÜV mit 5 Stelligen Mahnkennzeichen verwendbar
	 *
	 * @param Mage_Sales_Model_Order_Payment $payment Payment
	 * @param float 						 $amount  Betrag
	 *
	 * @return string
	 */
	public function getKennzeichenMahnverfahren($payment, $amount) {
		if (is_null($this->__kennzMahn)) {
			$this->__kennzMahn = parent::getKennzeichenMahnverfahren($payment, $amount);
			$kennzMahn = str_split($this->__kennzMahn);
				
			if (!empty($kennzMahn)) {
				if (!isset($kennzMahn[1])) {
					$kennzMahn[] = '0';
				}
				if (!isset($kennzMahn[2])) {
					$kennzMahn[] = '0';
				}
				if (!($order = $this->_getOrder())) {
					$order = $payment->getOrder();
				}
				if (!($customer = $order->getCustomer())) {
					$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
					$order->setCustomer($customer);
				}
				$kennzMahn[2] = (int) $customer->getUseZpkonto();
				$this->__kennzMahn = implode('', $kennzMahn);
			}
		}
	
		return $this->__kennzMahn;
	}
	
	/**
	 * Liefert das vom Shop verwaltete Kassenzeichen
	 * 
	 * @return string
	 */
	protected function _getKassenzeichen() {
		$customer = $this->_getOrder()->getCustomer();
    	if ($customer->getId() > 0 && Mage::helper('zpkonten')->isUseZpkonto($customer) == true) {
			$kassenzeichenInfo = Mage::helper('paymentbase')->lesenKassenzeichenInfo($this->_getKZModel()->getKassenzeichen());
			if (Mage::helper('zpkonten')->kassenzeichenExists($kassenzeichenInfo)) {
				Mage::helper('zpkonten')->validateSaldoWithLastPaymentMethode($kassenzeichenInfo,$this->_getKZModel(), $this);
				$this->validateSoapResult($kassenzeichenInfo, array(), 'lesenKassenzeichenInfo');
			}
		}
    	return $this->_getKZModel()->getKassenzeichen();
    }
    
    /**
     * Kassenzeichen Daten zusammenstellen
     * 
     * @return Egovs_Zahlpartnerkonten_Model_Pool
     */
	protected function _getKZModel() {
    	if ($this->__kZModel == null) {
    		/* @var $model Egovs_Zahlpartnerkonten_Model_Pool */
	    	$model = Mage::getModel('zpkonten/pool');
	    	$customer = $this->_getOrder()->getCustomer();
	    	$data = array();
	    	$data ['mandant'] = $this->_getMandantNr();
	    	$data ['bewirtschafter'] = $this->_getBewirtschafterNr();
	    	$data ['currency'] = 'EUR';
	    	$data ['paymentmethod'] = $this->_code;

    		$this->__kZModel = $model->findKassenzeichen($customer, $data);
    	}
    	return $this->__kZModel;
    }
    
    /**
     * SOAP Result validieren
     * 
     * @param mixed 												 $objResult        ePayBL Result
     * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $objBuchungsliste Buchungsliste
     * @param string												 $soapFunction     Name der Soap-Funktion
     * @param bool													 $keepCustomer     Kunden löschen?
     * 
     * @return Mage_Core_Exception|bool true|throws Exception
     * 
     * @throws Exception
     * 
     * @see Egovs_Paymentbase_Model_Abstract::validateSoapResult($objResult, $objBuchungsliste, $soapFunction, $keepCustomer)
     */
  	public function validateSoapResult($objResult, $objBuchungsliste, $soapFunction = '', $keepCustomer = false) {
  		$this->_retry = false;
  		try {
    		return parent::validateSoapResult($objResult, $objBuchungsliste, $soapFunction, $keepCustomer);
    	} catch (Exception $ex) {
    		/*
    		 * Folgendes gilt nur für Giropay/Kreditkarte über Saferpay
    		 * DIMDI Telko am 24.01.2013: ZVM725 Anlegen eines neuen Zahlpartnerkontos bei abgebrochener Saferpay-Verbindung
    		 */
    		if ($this->_fails < self::MAX_RETRIES
    			&& $objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis
    			&& $objResult->ergebnis->getCodeAsInt() == -594
    			) {
    			$msg = Mage::helper('zpkonten')->__('There was an error while activating the new accounting list for Kassenzeichen %s, we have to create a new Zahlpartnerkonto.', $this->_getKZModel()->getKassenzeichen());
    			$this->_getKZModel()->setStatus(Egovs_Zahlpartnerkonten_Model_Status::STATUS_ERROR)
    				->setComment($msg)
    				->save()
    			;
    			$this->getOrder()->addStatusHistoryComment($msg);
    			$this->__kZModel = null;
    			$this->_retry = true;
    		}
    		if (Mage::helper('zpkonten')->isUseZpkonto($this->_getOrder()->getCustomer()) != true) {
    			$this->__kZModel->setStatus(Egovs_Zahlpartnerkonten_Model_Status::STATUS_ERROR)
    				->save()
    			;
    		}
    		throw $ex;
    	}	
    	
    	return false;
    }
    
    /**
     * Legt den Kunden und die Buchungsliste am ePayment an und löscht (optional) den Kunden nach erhalt des Kassenzeichens wieder.
     *
     * @param string $saferpayType Type
     *
     * @return int Kassenzeichen
     * 
     * @throws Exception
     */
    protected function _anlegenKassenzeichen($saferpayType) {
    	$this->_fails = 0;
    	$lastException = new Exception(Mage::helper('zpkonten')->__('TEXT_PROCESS_ERROR_STANDARD'));
    	do {
    		try {
    			return parent::_anlegenKassenzeichen($saferpayType);
    		} catch (Exception $e) {
    			$lastException = $e;
    			$this->_fails++;
    		}
    	} while ($this->_retry && $this->_fails < self::MAX_RETRIES);
    	
    	throw $lastException;
    }
    
    /**
     * Verhindert die Kommunikation mit der ePayBL bis Saferpay abgeschlossen ist
     * 
     * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
     * @return Egovs_Paymentbase_Model_Saferpay
     * 
     * @see Egovs_Paymentbase_Model_Saferpay::_authorize()
     */
    protected function _authorize(Varien_Object $payment, $amount) {
    	Mage::log(sprintf("%s::ZPK: _authorize called...", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	   	if ($payment->getSaferpayTransactionId()) {
	   		Mage::log(sprintf("%s::ZPK: Saferpay transaction ID already exists, try to authorize...", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	   		/*
	   		 * 20140110::Frank Rochlitzer
	   		 * Bei vorhandenen KZs wird die Paymentmethod nicht aktualisiert
	   		 * Bei Saferpay sollte die Method erst nach der Rückkehr von Saferpay gesetzt werden!
	   		 */
	   		Mage::log(sprintf("%s::ZPK: Checking if the customer uses ZPK...", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	   		/*
	   		 * 20140206::Frank Rochlitzer
	   		 * In NOTIFY-ACTION existiert kein Customer-Object, der Kunde muss zuerst über die ID geladen werden!
	   		 */
	   		$customer = $this->_getOrder()->getCustomer();
	   		if (!$customer) {
	   			$customer = $this->_getOrder()->getCustomerId();
	   		}
	   		if (Mage::helper('zpkonten')->isUseZpkonto($customer) == true) {
	   			Mage::log(sprintf("%s::ZPK: Customer uses ZPK.", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		   		/* @var $model Egovs_Zahlpartnerkonten_Model_Pool */
		   		$model = Mage::getModel('zpkonten/pool');
		   		Mage::log(sprintf("%s::Try to load existing Kassenzeichen-Object from pool...", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		   		$model->loadByKzMandantBewirtschafter($payment->getKassenzeichen(), $this->_getMandantNr(), $this->_getBewirtschafterNr());
		   		Mage::log(sprintf("%s::Loaded existing Kassenzeichen-Object from pool...", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		   		if (!$model->isEmpty() && $model->getLastPayment() != $this->getCode()) {
		   			$model->setLastPayment($this->getCode())->save();
		   		}
	   		} else {
	   			Mage::log(sprintf("%s::ZPK: Customer doesn't use ZPK.", $this->getCode()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	   		}
    		return parent::_authorize($payment, $amount);
    	}
    	
    	if (Mage::helper('zpkonten')->isUseZpkonto($this->_getOrder()->getCustomer())) {
    		Mage::log("saferpay::Zahlpartnerkonto : Customers uses Zahlpartnerkonten, OrderID: {$this->_getOrder()->getIncrementId()}", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    		$payment->setKassenzeichen($this->_getKassenzeichen());
    		Mage::log("saferpay::KASSENZEICHEN :{$payment->getKassenzeichen()}, OrderID: {$this->_getOrder()->getIncrementId()}", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    	} else {
    		Mage::log("saferpay::Zahlpartnerkonto : Customers doesn't use Zahlpartnerkonten we don't set a Kassenzeichen now, OrderID: {$this->_getOrder()->getIncrementId()}", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    	}
    	/*
    	 * 20130129 :: Frank Rochlitzer
    	 * ZVM725
    	 * Wir machen die gesamten ePayBL-Prozesse erst nach Saferpay
    	 */
    	Mage::log(Mage::helper('paymentbase')->__('Payment not confirmed from payment gateway, we omit the ePayBL transactions for now.'),
    			Zend_Log::INFO,
    			Egovs_Helper::LOG_FILE
    	);
    	
    	//Verhindert im Kommentarverlauf den grünen Haken für die Kundenbenachrichtigung.
    	$order = $this->getOrder();
    	if ($order) {
    		$order->setCustomerNoteNotify(false);
    	}
    }
}