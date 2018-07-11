<?php

/**
 * Model für Zahlungen auf Rechnung
 * 
 * Der Kunde bekommt eine Zahlungsfrist eingeräumt und die Ware kann sofort an den Kunden versendet werden.<br>
 * Der Kunde zahlt in der Regel nach erhalt der Ware.
 *
 * @category   	Egovs
 * @package    	Egovs_Openaccountpayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Egovs_Paymentbase_Model_Abstract
 */
class Egovs_Openaccountpayment_Model_Openaccount extends Egovs_Paymentbase_Model_Abstract
{

	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'openaccount';
	/**
	 * Hält das aktuelle Kassenzeichen
	 *
	 * @var boolean $__kassenzeichen
	 */
	private $__kassenzeichen = false;
	/**
	 * Flag ob der Aufruf der capture Methode erlaubt ist
	 *
	 * Capture wird in der Regel bei der Rechnungserstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapture				= true;

	/**
	 * Flag ob die Erstellung von Teilrechnungen erlaubt ist
	 *
	 * paymentbase.getZahlungseingänge erfasst keine einzelnen Rechnungen!
	 *
	 * @var boolean $_canCapturePartial
	 */
	protected $_canCapturePartial 		= false;
	/**
	 * Wichtig um eigene States und Statuse setzen zu können
	 * @var boolean
	 */
	protected $_isInitializeNeeded      = true;
	/**
	 * Flag ob der Aufruf der authorize Methode erlaubt ist
	 *
	 * Authorize wird in der Regel bei der Bestellerstellung aufgerufen.
	 *
	 * @var boolean $_canAuthorize
	 */
	protected $_canAuthorize            = true;

	/**
	 * Spielt nur eine Rolle wenn canCapture = false ist!
	 * Ist wichtig in Invoice->register() da die Rechnung sonst sofort bezahlt wird!
	 * @var boolean
	 */
	protected $_isGateway				= true;
	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'openaccount/form';
	/**
	 * Infoblock Type
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'openaccount/info';
	
	/**
	 * Registriert diese Rechnung und ruft capture auf
	 *
	 * Erstellt eine Rechnung mit alle Produkten aus der Bestellung.
	 * 
	 * @param boolean $pendingPayment Soll diese Rechnung bezahlt werden?
	 *
	 * @return Mage_Sales_Model_Order_Invoice
	 */
	protected function _invoice($pendingPayment = false)
	{
		$invoice = $this->_getPayment()->getOrder()->prepareInvoice();

		$invoice->register();
		if (!$pendingPayment && $this->canCapture()) {
			$invoice->capture();
		}

		$this->_getPayment()->getOrder()->addRelatedObject($invoice);
		return $invoice;
	}

	/**
	 * Retrieves the Payment instance
	 *
	 * @return Mage_Sales_Model_Order_Payment
	 */
	protected function _getPayment() {
		$payment = $this->getInfoInstance();
		 
		if (!($payment instanceof Mage_Sales_Model_Order_Payment)) {
			Mage::throwException($this->_getHelper()->__('Can not retrieve payment information object instance'));
		}

		return $payment;
	}

	/**
	 * Gibt true zurück falls diese Bezahlform verwendet werden kann
	 * 
	 * Folgende Bedingungen werden geprüft:
	 * <ul>
	 * 	<li>Warenkorb-Gesamtbetrag muss größer 0.0 sein.</li>
	 * </ul>
	 * 
	 * @param Mage_Sales_Model_Quote $quote Warenkorb
	 *
	 * @return boolean
	 */
	public function isAvailable($quote=null)
	{
		if ($quote && $quote->getGrandTotal() <= 0.001) {
			return false;
		}
		 
		return parent::isAvailable($quote);
	}
	/**
	 * Liefert den Kontoinhaber aus Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getAccountHolder() {
		return $this->getConfigData('bankaccountholder');
	}
	/**
	 * Liefert die Kontonummer aus Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getAccountNumber() {
		return $this->getConfigData('bankaccountnumber');
	}
	/**
	 * Gibt den Sortcode aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getSortCode() {
		return $this->getConfigData('sortcode');
	}
	/**
	 * Gibt den Banknamen aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getBankName()
	{
		return $this->getConfigData('bankname');
	}
	/**
	 * Gibt die IBAN aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getIBAN()
	{
		return $this->getConfigData('bankiban');
	}
	/**
	 * Gibt die BIC aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getBIC()
	{
		return $this->getConfigData('bankbic');
	}

	/**
	 * Gibt das Zahlungsziel entweder aus den Admineinstellungen oder der Paymentinstanz zurück
	 * 
	 * @param int $storeId Store ID
	 * 
	 * @return integer Pay within X days
	 */
	public function getPayWithinXDays($storeId = null) {
		$payment = $this->getInfoInstance();
				
		if (is_null($payment) || !$payment) {
			return intval($this->getConfigData('paywithinxdays', $storeId));
		}
				
		//FIXME: Falls im Frontend bestellt wird ist der Inhalt immer 0 -> sollte vielleicht bei Kassenzeichen gesetzt werden
		$pwxd = $payment->getData('paywithinxdays');
		if ($pwxd == null || $pwxd < 1) {
			$payment->setData('paywithinxdays', intval($this->getConfigData('paywithinxdays', $storeId)));
		}
		return intval($payment->getData('paywithinxdays'));
	}
	
	/**
	 * Gibt einen einstellbaren Text aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getCustomText() {
		return nl2br($this->getConfigData('customtext'));
	}
	/**
	 * Gibt das Kassenzeichen der aktuellen Instanz zurück
	 *
	 * @return <string, false>
	 */
	public function getKassenzeichen() {
		return $this->__kassenzeichen;
	}
	/**
	 * Behandelt die unterschiedlichen Payment Actions
	 *
	 * Setzt unter anderem den State der Bestellung.<br>
	 * Bei ACTION_AUTHORIZE_CAPTURE (default) wird auch automatisch eine Rechnung erstellt.
	 * 
	 * @param string        $paymentAction Payment-Action
	 * @param Varien_Object $stateObject   Das Object welches den State, Status etc enthält
	 * 
	 * @return Egovs_Openaccountpayment_Model_Openaccount
	 *
	 * (non-PHPdoc)
	 * @see Mage_Payment_Model_Method_Abstract::initialize()
	 */
	public function initialize($paymentAction, $stateObject) {
		if ($paymentAction != self::ACTION_AUTHORIZE_CAPTURE
			&& $paymentAction != self::ACTION_AUTHORIZE
		) {
			Mage::throwException(
				Mage::helper($this->getCode())->__('This payment action is not available!').' Action: '.$paymentAction
			);
		}
		$payment = $this->_getPayment();

		$order = $payment->getOrder();

		$orderState = Mage_Sales_Model_Order::STATE_NEW;
		 
		switch ($paymentAction) {
			case Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE:
				//Rechnung muss hier händisch erstellt werden!
				$this->authorize($this->_getPayment(), $order->getBaseTotalDue());

				$this->setAmountAuthorized($order->getTotalDue());
				$this->setBaseAmountAuthorized($order->getBaseTotalDue());

				$orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
				break;
			case Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE_CAPTURE:
				$this->authorize($this->_getPayment(), $order->getBaseTotalDue());
				//Rechnung erstellen, aber nicht bezahlen!
				$invoice = $this->_invoice(true);

				$this->setAmountAuthorized($order->getTotalDue());
				$this->setBaseAmountAuthorized($order->getBaseTotalDue());

				$orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
				break;
			default:
				break;
		}
		 
		$orderStatus = $this->getConfigData('order_status');

		if (!$orderStatus || $order->getIsVirtual()) {
			$orderStatus = $order->getConfig()->getStateDefaultStatus($orderState);
		}
		 
		$stateObject->setState($orderState);
		$stateObject->setStatus($orderStatus);
		$stateObject->setIsNotified(false);
		 
		return $this;
	}

	/**
	 * Authorize
	 *
	 * @param Varien_Object $payment Payment
	 * @param integer 	    $amount  Betrag
	 * 
	 * @return Egovs_Paymentbase_Model_Abstract
	 *
	 * @see		Egovs_Paymentbase_Model_Abstract::_authorize
	 */
	protected function _authorize(Varien_Object $payment, $amount)
	{
		//	Kommunikation mit dem ePayment-Server
		//	zur Registrierung der Zahlung im Zahlverfahren
		//
		//	"Vorkasse / Offene Rechnung"

		// prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert, sonst anlegen
		$this->createCustomerForPayment();

		// Fälligkeitsdatum berechnen
		$iDatumFaelligkeit = strtotime("+{$this->getPayWithinXDays()} days");

		// Objekt für Buchungsliste erstellen
		$objBuchungsliste = $this->createAccountingList($payment, $amount, null, $iDatumFaelligkeit);
			
		// Webservice aufrufen
		$objResult = null;
		
		$objResult = $this->_getSoapClient()->ueberweisenNachLieferungMitBLP($this->_getECustomerId(), $objBuchungsliste, $this->getBuchungsListeParameter($payment, $amount));

		$this->validateSoapResult($objResult, $objBuchungsliste, 'ueberweisenNachLieferung');

		//das kassenzeichen sollte erst abgeholt werden wenn das ergebniss geprueft wurde
		$payment->setData('kassenzeichen', $objResult->buchungsListe->kassenzeichen);
		$this->loeschenKunde();
		
		return $this;
	}

	/**
	 * Capture payment
	 *
	 * siehe dazu Trac ticket #306, #492, #496
	 * 
	 * @param Varien_Object $payment Payment
	 * @param integer       $amount  Betrag
	 * 
	 * @return Egovs_Openaccountpayment_Model_Openaccount
	 */
	public function capture(Varien_Object $payment, $amount)
	{
		$order = $payment->getOrder();

		if (!$this->canCapture()) {
			Mage::throwException(Mage::helper($this->getCode())->__('Capture action is not available')."!");
		}

		if (class_exists('Egovs_Paymentbase_Model_Paymentbase') && Egovs_Paymentbase_Model_Paymentbase::isRunning()) {
			return $this;
		}
		
		$paid = false;
		try {
			$model = Mage::getModel('paymentbase/paymentbase');
			$model->getZahlungseingaenge();

			$kzeichen = $payment->getKassenzeichen();
			$paid = $model->isKassenzeichenPaid($kzeichen);
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
		}
			
		//getZahlungseingaenge verändert Rechnungen
		$hasOpen = false;
		foreach ($order->getInvoiceCollection() as $invoice) {
			if ($invoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_OPEN) {
				$hasOpen = true;
				break;
			}
		}
		 
		if (!$paid || $hasOpen || $order->getInvoiceCollection()->getSize() < 1) {
			Mage::throwException(Mage::helper($this->getCode())->__("Invoice isn't paid yet")."!");
		}

		return $this;
	}
}
