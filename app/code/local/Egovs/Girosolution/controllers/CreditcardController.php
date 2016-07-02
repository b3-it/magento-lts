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
		Mage::getSingleton('core/session')->addError(Mage::helper($this->_getModuleName())->__('Payment with Creditcard failed'));
		$this->_redirect('checkout/cart', array('_secure' => true));
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
		return "egovs_girosolution";
	}

	/**
	 * Liefert Debug-Flag
	 *
	 * @return string
	 */
	public function getDebug() {

		return Mage::getStoreConfig('payment/egovs_girosolution_creditcard/debug_flag');
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