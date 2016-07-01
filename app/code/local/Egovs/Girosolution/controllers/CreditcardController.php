<?php
/**
 * Saferpay Controller
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Girosolution_CreditcardController extends Egovs_Paymentbase_Controller_Abstract
{
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'egovs_girosolution/redirect';
	/**
	 * Implementation der abstrakten Methode
	 * 
	 * @param Mage_Sales_Model_Order $order Bestellinstanz
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_redirectActionAddStatusToHistory($order)
	 */
	protected function _redirectActionAddStatusToHistory($order) {
		
	}
	/**
	 * Implementation der abstrakten Methode
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_successActionRedirectFailure()
	 */
	protected function _successActionRedirectFailure() {
		// something is wrong -> redirect to failure controller
		$this->_redirect('saferpay/saferpay/failure', array('_secure'=>$this->isSecureUrl()));
	}
	/**
	 * Gibt den Modulnamen zurück
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @return string 'saferpay'
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_getModuleName()
	 */
	protected function _getModuleName() {
		return "saferpay";
	}

	/**
	 * Zeigt den Warenkorb an falls Saferpay mit eiem Fehler antwortet
	 * 
	 * @return void
	 */
	public function failureAction() {
		$this->_cancel('saferpay','There was an error at Saferpay Payment. Customers payment was not valid.');
	}

	/**
	 * Zeigt den Warenkorb an falls der Benutzer den Zahlvorgang abbricht
	 * 
	 * @return void
	 */
	public function cancelAction() {
		$this->_cancel('saferpay', 'Customer canceled Saferpay Payment.');
	}

	/**
	 * Liefert Debug-Flag
	 *
	 * @return string
	 */
	public function getDebug() {

		return Mage::getStoreConfig('payment/saferpay/debug_flag');
	}

	/**
	 * Ruft aktiviereTempKreditkartenKassenzeichen am ePayBL-Server auf
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @param object $objSOAPClient SOAPClient
	 * @param object $idp           Saferpay-Nachrichten-Objekt
	 * @param string $mandantNr     Mandanten Nr.
	 * @param string $_providerName  Providername
	 * 
	 * @return Ergebnis Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_callSoapClientImpl()
	 */
	protected function _callSoapClientImpl($objSOAPClient, $idp, $mandantNr, $_providerName) {
		return $objSOAPClient->aktiviereTempKreditkartenKassenzeichen($idp->getAttribute('ORDERID'), $mandantNr, $idp->getAttribute('ID'), $_providerName);
	}
}