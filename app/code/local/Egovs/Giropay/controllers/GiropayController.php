<?php
/**
 * Giropay Controller
 *
 * @category   	Egovs
 * @package    	Egovs_Giropay
 * @name       	Egovs_Giropay_GiropayController
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Giropay_GiropayController extends Egovs_Paymentbase_Controller_Abstract
{
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'giropay/redirect';
	
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
		$order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, Mage::helper('giropay')->__('Customer was redirected to giropay.'));
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
		$this->_redirect('giropay/giropay/failure', array('_secure'=>$this->isSecureUrl()));
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
		return "giropay";
	}

	/**
	 * Zeigt den Warenkorb an falls Saferpay mit einem Fehler antwortet.
	 * 
	 * @return void
	 * 
	 */
	public function failureAction() {
		$this->_cancel('giropay', 'There was an error at giropay Payment. Customers payment was not valid.');
	}

	/**
	 * Zeigt den Warenkorb an falls der Kunde die Zahlung abbricht
	 * 
	 * @return void
	 * 
	 */
	public function cancelAction() {
		$this->_cancel('giropay', 'Customer canceled giropay Payment.');
	}

	/**
	 * Liefert das Debug flag
	 *
	 * @return string
	 */
	public function getDebug() {

		return Mage::getStoreConfig('payment/giropay/debug_flag');
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
	 * @return Egovs_Paymentbase_Controller_Abstract Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_callSoapClientImpl()
	 */
	protected function _callSoapClientImpl($objSOAPClient, $idp, $mandantNr, $_providerName) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $objSOAPClient->aktiviereTempKassenzeichen($idp->getAttribute('ORDERID'), $idp->getAttribute('ID'), "GIROPAY");
		}
		return $objSOAPClient->aktiviereTempGiropayKassenzeichen($idp->getAttribute('ORDERID'), $mandantNr, $idp->getAttribute('ID'));
	}
}