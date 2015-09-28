<?php

/**
 * Bezahlung per Lastschrift mit schriftlicher Einzugsermächtigung.
 *
 * @category	Egovs
 * @package		Egovs_DebitPIN
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_DebitPIN_Model_PaymentLogic extends Egovs_Paymentbase_Model_Debit
{
	/**
	 * unique internal payment method identifier [a-z0-9_]
	 *
	 * @var string $_code
	 */
	protected $_code = 'debitpin';
	/**
	 * Flag ob der Aufruf der authorize Methode erlaubt ist
	 *
	 * Authorize wird in der Regel bei der Bestellerstellung aufgerufen.
	 *
	 * @var boolean $_canAuthorize
	 */
	protected $_canAuthorize = false;
	/**
	 * Flag ob der Aufruf der capture Methode erlaubt ist
	 *
	 * Capture wird in der Regel bei der Rechnungserstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapture = false;
	/**
	 * Flag ob die Erstellung von Teilrechnungen erlaubt ist
	 *
	 * paymentbase.getZahlungseingänge erfasst keine einzelnen Rechnungen!
	 *
	 * @var boolean $_canCapturePartial
	 */
	protected $_canCapturePartial = false;
	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'debitpin/payment_form_debitpin';
	/**
	 * Infoblock Type
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'debit/info';

	/**
     * Liefert die magento customer id
     * 
     * Die Customer ID bei DebitPIN zwingend notwendig!
     * 
     * @return integer Customer ID
     * @see Egovs_Paymentbase_Model_Abstract::_getCustomerId
     */
    protected function _getCustomerId() {
    	if (!$this->__customerId) {
	    	$customer_id = null;
	    	if ($this->_getOrder()) {
	    		$customer_id = $this->_getOrder()->getCustomerId();
	    	} elseif ($quote = $this->getInfoInstance()->getQuote()) {
	    		$customer_id = $quote->getCustomerId();
	    	}
			
			if (!isset($customer_id) || strlen(trim($customer_id)) <= 0) {
				$msg = 'Customer not registered';
				Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				self::parseAndThrow($msg);
			}
			
			$this->__customerId = $customer_id;
    	}
    	
    	return $this->__customerId;
    }
    
	/**
     * Liefert die Kundennummer für die ePayment Plattform
     * 
     * Die Kundennummer kann maximal 100 Zeichen lang sein.
     * Hier wird sie wie folgt erzeugt:
     * <p>
     * "WebShopDesMandanten-CustomerId"
     * </p>
     * 
     * @param boolean $throwIfNotExists <strong>Dieser Parameter wird hier ignoriert!</strong>
     * 
     * @return String ePayment Kundennummer
     * 
     * @see Egovs_Paymentbase_Model_Abstract::_getECustomerId
     * @see Egovs_DebitPIN_Helper_Data::getECustomerId
     */
    protected function _getECustomerId($throwIfNotExists = false) {
    	if (!$this->__eCustumerId) {
    		$this->__eCustumerId = Mage::helper('debitpin')->getECustomerIdNonVolatile($this->_getCustomerId());
    	}
    	
    	return $this->__eCustumerId;
    }
    
	/**
	 * Prüft ob die Bezahlform verfügbar ist.
	 * 
	 * Bezahlung wurde durch SEPA ersetzt und wird nicht mehr unterstützt.
	 *
	 * @param Mage_Sales_Model_Quote $quote Angebot
	 * 
	 * @return bool
	 */
	public function isAvailable($quote=null) {
		return false;
	}
	
	/**
	 * Authorize
	 *
	 * Nur noch Dummy-Funktion
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		return $this;
	}
	
	/**
	 * Capture
	 * 
	 * Nur noch Dummy-Funktion
	 * 
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return Egovs_Debit_Model_Debit
	 * 
	 * @see Mage_Payment_Model_Method_Abstract::capture()
	 */
	public function capture(Varien_Object $payment, $amount) {
		return $this;
	}

	/**
	 * Liefert den Banknamen - hier immer als leeren String
	 * 
	 * @return string Leerer String
	 * @see Egovs_Paymentbase_Model_Debit::getAccountBankname
	 */
	public function getAccountBankname()
	{
		//TODO siehe getAccountBLZ
		/* 20110119 Frank Rochlitzer
		 * Da getAccountBLZ nicht funktioniert, liefert diese Funktion immer 'existiert nicht' zurück
		 * und erzeugt so im Backend immer eine Warnung-/Fehlermeldung
		 */
		//		if($name == '') return 'existiert nicht';
		//		else return $name;
		return '';
	}
}
