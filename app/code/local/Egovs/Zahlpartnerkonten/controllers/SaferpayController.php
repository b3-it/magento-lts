<?php
require_once "Egovs/Saferpay/controllers/SaferpayController.php";
/**
 * Saferpay Controller
 *
 * @category   	Egovs
 * @package    	Egovs_Zahlpartenkonten
 * @name       	Egovs_Zahlpartenkonten_SaferpayController
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Zahlpartnerkonten_SaferpayController extends Egovs_Saferpay_SaferpayController
{
	/**
	 * Ruft aktiviereTempKassenzeichen am ePayBL-Server auf
	 *
	 * Implementation der abstrakten Methode
	 *
	 * @param Egovs_Paymentbase_Model_Webservice_PaymentServices $objSOAPClient SOAPClient
	 * @param object                                             $idp           Saferpay-Nachrichten-Objekt
	 * @param string                                             $mandantNr     Mandanten Nr.
	 * @param string                                             $PROVIDERNAME  Providername
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_PaymentServices|bool Ergebnis|false Ein Objekt vom Typ "Ergebnis" siehe ePayBL Schnittstelle
	 *
	 * @see Egovs_Paymentbase_Controller_Abstract::_callSoapClientImpl()
	 */
	protected function _callSoapClientImpl($objSOAPClient, $idp, $mandantNr, $PROVIDERNAME) {
		Mage::log(sprintf('saferpayZP::Current store: %d', Mage::app()->getStore()->getId()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$order = $this->_getOrder();
		//Das Kassenzeichen muss zurückgesetzt werden!
		$order->getPayment()->unsetData('kassenzeichen');
		$order->getPayment()->setSaferpayTransactionId($idp->getAttribute('ID'));
		try {
			$order->getPayment()->getMethodInstance()->authorize($order->getPayment(), $order->getPaymentAuthorizationAmount());
		} catch (Exception $e) {
			//Das logging wird schon vorher gemacht wir müssen hier nur den State der Order in einen Fehlerstatus bringen
			if ($order->getId() && $order->canCancel()) {
				$order->cancel();
			}
			$order->addStatusHistoryComment(Mage::helper('zpkonten')->__($e->getMessage()));
			return false;
		}
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $objSOAPClient->aktiviereTempKassenzeichen(sprintf('%s/%s', $objSOAPClient->getBewirtschafterNr(), $order->getPayment()->getKassenzeichen()), $idp->getAttribute('ID'), $PROVIDERNAME);
		}
		return $objSOAPClient->aktiviereTempKreditkartenKassenzeichen(sprintf('%s/%s', $objSOAPClient->getBewirtschafterNr(), $order->getPayment()->getKassenzeichen()), $mandantNr, $idp->getAttribute('ID'), $PROVIDERNAME);
	}
}