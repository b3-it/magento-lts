<?php
/**
* Observer für Zahlungen auf Rechnung
*
* @category   	Egovs
* @package    	Egovs_Openaccountpayment
* @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
* @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
* @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*
* @see Mage_Core_Model_Abstract
*/
class Egovs_Openaccountpayment_Model_Observer extends Mage_Core_Model_Abstract
{
	
	/**
	 * Setzt den korrekten State einer Zahlung bei Stornierungen
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 * 
	 */
	public function onSalesOrderInvoiceCancel(Varien_Event_Observer $observer) {
		$invoice = $observer->getEvent()->getInvoice();
		if (is_null($invoice))
			return;

		//darf nur für Openaccountpayments passieren
		if (!($invoice->getOrder()->getPayment()->getMethodInstance() instanceof Egovs_Openaccountpayment_Model_Openaccount))
			return;
			
		$invoice->getOrder()->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true);
	}
	
	/**
	 * Setzt den korrekten State bei Offline-Bezahlung einer Rechnung
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 * 
	 */
	public function onSalesOrderInvoiceOfflinePay(Varien_Event_Observer $observer) {
		$invoice = $observer->getEvent()->getInvoice();
		if (is_null($invoice))
			return;

		//darf nur für Openaccountpayments passieren
		if (!($invoice->getOrder()->getPayment()->getMethodInstance() instanceof Egovs_Openaccountpayment_Model_Openaccount))
			return;

		//gilt nur für Offline payments
		if (Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE != $invoice->getRequestedCaptureCase()) {
			return;
		}

		$invoice->getOrder()->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true);
	}
}