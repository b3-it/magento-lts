<?php
/**
 * Terminalpay Controller
 *
 * @category   	Gka
 * @package    	Gka_Terminalpay
 * @name       	Gka_Terminalpay_TerminalpayController
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Terminalpay_TerminalpayController extends Egovs_Paymentbase_Controller_Abstract
{
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'terminalpay/redirect';
	
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
		$order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, Mage::helper('terminalpay')->__('Customer was redirected to terminalpay.'));
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
		$this->_redirect('terminalpay/terminalpay/failure', array('_secure'=>$this->isSecureUrl()));
	}
	/**
	 * Gibt den Modulnamen zurück
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @return string
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_getModuleName()
	 */
	protected function _getModuleName() {
		return "terminalpay";
	}

	/**
	 * Zeigt den Warenkorb an falls Saferpay mit einem Fehler antwortet.
	 * 
	 * @return void
	 * 
	 */
	public function failureAction() {
		$this->_cancel('terminalpay', 'There was an error at terminalpay Payment. Customers payment was not valid.');
	}

	/**
	 * Zeigt den Warenkorb an falls der Kunde die Zahlung abbricht
	 * 
	 * @return void
	 * 
	 */
	public function cancelAction() {
		$this->_cancel('terminalpay', 'Customer canceled terminalpay Payment.');
	}

	/**
	 * Liefert das Debug flag
	 *
	 * @return string
	 */
	public function getDebug() {

		return Mage::getStoreConfig('payment/terminalpay/debug_flag');
	}
	/**
	 * Ruft aktiviereTempGiropayKassenzeichen am ePayBL-Server auf
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @param object $objSOAPClient SOAPClient
	 * @param object $idp           Saferpay-Nachrichten-Objekt
	 * @param string $mandantNr     Mandanten Nr.
	 * @param string $_providerName  Wird hier nicht benutzt
	 * 
	 * @return Ergebnis Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_callSoapClientImpl()
	 */
	protected function _callSoapClientImpl($objSOAPClient, $idp, $mandantNr, $_providerName) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $objSOAPClient->aktiviereTempKassenzeichen($idp->getAttribute('ORDERID'), $idp->getAttribute('ID'), "TERMINALPAY");
		}
		return $objSOAPClient->aktiviereTempGiropayKassenzeichen($idp->getAttribute('ORDERID'), $mandantNr, $idp->getAttribute('ID'));
	}
}