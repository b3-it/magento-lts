<?php
/**
 * Saferpay Controller
 *
 * @category   	Egovs
 * @package    	Egovs_Saferpay
 * @name       	Egovs_Saferpay_SaferpayController
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Saferpay_SaferpayController extends Egovs_Paymentbase_Controller_Abstract
{
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'saferpay/redirect';
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
		$order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, Mage::helper('saferpay')->__('Customer was redirected to Saferpay.'));
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
	 * Ruft aktiviereTempKassenzeichen am ePayBL-Server auf
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @param object $objSOAPClient SOAPClient
	 * @param object $idp           Saferpay-Nachrichten-Objekt
	 * @param string $mandantNr     Mandanten Nr.
	 * @param string $_providerName  Providername
	 * 
	 * @return Egovs_Paymentbase_Controller_Abstract Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_callSoapClientImpl()
	 */
	protected function _callSoapClientImpl($objSOAPClient, $idp, $mandantNr, $_providerName) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $objSOAPClient->aktiviereTempKassenzeichen($idp->getAttribute('ORDERID'), $idp->getAttribute('ID'), $_providerName);
		}
		return $objSOAPClient->aktiviereTempKreditkartenKassenzeichen($idp->getAttribute('ORDERID'), $mandantNr, $idp->getAttribute('ID'), $_providerName);
	}
}