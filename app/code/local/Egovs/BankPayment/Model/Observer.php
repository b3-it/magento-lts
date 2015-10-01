<?php
/**
 * Observer für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Core_Model_Abstract
 */
class Egovs_BankPayment_Model_Observer extends Mage_Core_Model_Abstract
{
	
	/**
	 * Setzt den korrekten State einer Vorkassezahlung bei Stornierungen
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onSalesOrderInvoiceCancel(Varien_Event_Observer $observer) {
		$invoice = $observer->getEvent()->getInvoice();
		if (is_null($invoice))
			return;

		//darf nur für BankPayments passieren
		if (!($invoice->getOrder()->getPayment()->getMethodInstance() instanceof Egovs_BankPayment_Model_Bankpayment))
			return;
			
		$invoice->getOrder()->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, true);
	}
	
	/**
	 * Setzt den korrekten State einer Vorkassezahlung bei Offline-Zahlungen
	 *  
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onSalesOrderInvoiceOfflinePay(Varien_Event_Observer $observer) {
		$invoice = $observer->getEvent()->getInvoice();
		if (is_null($invoice))
			return;

		//darf nur für BankPayments passieren
		if (!($invoice->getOrder()->getPayment()->getMethodInstance() instanceof Egovs_BankPayment_Model_Bankpayment))
			return;

		//gilt nur für Offline payments
		if (Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE != $invoice->getRequestedCaptureCase()) {
			return;
		}

		$invoice->getOrder()->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true);
	}
}