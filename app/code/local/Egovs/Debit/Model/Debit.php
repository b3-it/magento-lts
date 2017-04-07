<?php
/**
 * Bezahlung per Lastschrift mit elektronischer Einzugsermächtigung. 
 *
 * @category	Egovs
 * @package		Egovs_Debit
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 */
class Egovs_Debit_Model_Debit extends Egovs_Paymentbase_Model_Debit
{
	/**
	 * Eindeutige interne Bezeichnung für Payment [a-z0-9_]
	 *
	 * @var string $_code
	 */
	protected $_code = 'debit';
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
	 * @var boolean $_canCapturePartial
	 */
	protected $_canCapturePartial = false;
	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'debit/form';
	/**
	 * Infoblock Type
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'debit/info';

	/**
	 * Prüft ob die Bezahlform verfügbar ist.
	 * 
	 * Bezahlung wurde durch SEPA ersetzt und wird nicht mehr unterstützt.
	 *
	 * @param Mage_Sales_Model_Quote $quote Warenkrob
	 * 
	 * @return false
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
	 * Individueller Error-Handler für SOAP-Result Validierung. 
	 * 
	 * Diese Funktion erzeugt immer eine Exception
	 * 
	 * @param object $objResult SOAP-Result
	 * 
	 * @throws Exception
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::validateSoapResult
	 */
	protected function _customErrorHandler($objResult) {
		// Fehlermeldung suchen
		if ($objResult && Mage::helper('debit')->__('TEXT_PROCESS_ERROR_'.$objResult->ergebnis->getCode()) != 'TEXT_PROCESS_ERROR_'.$objResult->ergebnis->getCode()) {
			$mail = "";
			$iErrorCode = $objResult->ergebnis->getCodeAsInt();
			if ($iErrorCode == -405 || ($iErrorCode <= -510 && $iErrorCode >= -511)) {
				$mail = Mage::helper("paymentbase")->getAdminMail();
			} elseif (($iErrorCode <= -406 && $iErrorCode >= -411 )
						|| $iErrorCode == -513
						|| $iErrorCode == -428
						|| $iErrorCode == -426
				) {
				$mail = Mage::helper("paymentbase")->getCustomerSupportMail();
			} else {
				$mail = Mage::helper("paymentbase")->getCustomerSupportMail();
			}
			Mage::throwException(Mage::helper('debit')->__('TEXT_PROCESS_ERROR_'.$objResult->ergebnis->getCode(), $mail));
		} else {
			Mage::throwException(Mage::helper('debit')->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
		}
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
}
