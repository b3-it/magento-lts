<?php
/**
 * Model für Terminalpay
 *
 * @category   	Gka
 * @package    	Gka_Terminalpay
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @see Egovs_Paymentbase_Model_Girosolution
 */
class Gka_Terminalpay_Model_Payment_Terminalpay extends Egovs_Paymentbase_Model_Girosolution
{
	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'gka_terminalpay';
	/**
	 * Flag: Ist dieses Model ein Gateway
	 *
	 * @var boolean $_isGateway
	 */
	protected $_isGateway = true;
	/**
	 * Flag: Ob der Aufruf der authorize Methode erlaubt ist
	 *
	 * Authorize wird in der Regel bei der Bestellerstellung aufgerufen.
	 *
	 * @var boolean $_canAuthorize
	 */
	protected $_canAuthorize = true;
	/**
	 * Flag: Ob der Aufruf der capture Methode erlaubt ist
	 *
	 * Capture wird in der Regel bei der Rechnungserstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapture = true;
	/**
	 * Flag: Ob die Erstellung von Teilrechnungen erlaubt ist
	 *
	 * @var boolean $_canCapturePartial
	 */
	protected $_canCapturePartial = true;
	/**
	 * Kann dieses Payment-Methode im administrations Bereich genutzt werden?
	 *
	 * @var boolean $_canUseInternal
	 */
	protected $_canUseInternal = false;
	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'gka_terminalpay/form_terminalpay';
	/**
	 * Infoblock Type
	 *
	 * Type als String oder 'paymentbase/noinfo' für keinen Infoblock
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'paymentbase/noinfo';
	/**
	 * Unterscheidet zwischen Giropay und Kreditkarte für die ePayBL
	 *
	 * @var string $_epaybl_transaction_type
	 */
	protected $_epaybl_transaction_type = 'KREDITKARTE';
	
	/**
	 * Unterscheidet zwischen Giropay und Kreditkarte für Girosolution
	 *
	 * @var string $_transaction_type
	 */
	protected $_transaction_type = 'creditCardTransaction';
	/**
	 * Initialisiert das Array mit den zu übergebenden Parametern
	 *
	 * @return void
	 *
	 * @see Egovs_Paymentbase_Model_Girosolution::_getGirosolutionRedirectUrl()
	 */
	protected function _getGirosolutionRedirectUrl() {
		/**
		 * 20170308::Frank Rochlitzer
		 * ZV_AM-813 ZV_AM-814 Unterstützung zur Konfiguration von Pseudokartennummern-Nutzung
		 */
		if (Mage::getStoreConfigFlag("payment/{$this->getCode()}/use_pseudo")) {
			//Pseudokartennummern
			$this->_fieldsArr['pkn'] = 'create';
		}
	}
	
	protected function _callSoapClientImpl($objSOAPClient, $wId, $mandantNr, $refId, $providerName) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $objSOAPClient->aktiviereTempKassenzeichen($wId, $refId, $providerName);
		}
		return $objSOAPClient->aktiviereTempKreditkartenKassenzeichen($wId, $mandantNr, $refId, $providerName);
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
		$buchungsListeParameter['ppCCaction'] = 'authorization';
	
		return $buchungsListeParameter;
	}
	
	public function getTransactionType() {
		return $this->_transaction_type;
	}
}
