<?php
/**
 * Model für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
 * @see Egovs_Paymentbase_Model_Abstract
 */
class Egovs_BankPayment_Model_Bankpayment extends Egovs_Paymentbase_Model_Abstract
{
	/**
	 * Controller Action für Vorkasse-Bestellungen
	 * 
	 * @var string ACTION_EGOVS_PENDING_BANKPAYMENT
	 */
	const ACTION_EGOVS_PENDING_BANKPAYMENT  = 'egovs_pending_bankpayment';
	
    /**
     * Unique internal payment method identifier
     * 
     * @var string $_code
     */
    protected $_code = 'bankpayment';
	
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
     * 
     * @var boolean $_isInitializeNeeded
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
	 * 
	 * @var boolean $_isGateway
	 */
	protected $_isGateway				= true;
	
	/**
	 * Formblock Type
	 * 
	 * @var string $_formBlockType
	 */
    protected $_formBlockType = 'bankpayment/form';
    
    /**
     * Infoblock Type
     * 
     * @var string $_infoBlockType
     */
    protected $_infoBlockType = 'bankpayment/info';
	
	
	/**
	 * Erstellt eine neue Rechnung mit dem Bestellinhalt.
	 * 
	 * Die Rechnung wird bezahlt falls $pending_payment TRUE ist.
     *	
     * @param boolean $pending_payment Steht die Zahlung noch aus?
     *
     * @return Mage_Sales_Model_Order_Invoice
     */
    protected function _invoice($pending_payment = false) {
        $invoice = $this->_getPayment()->getOrder()->prepareInvoice();

        $invoice->register();
        if (!$pending_payment && $this->canCapture()) {
            $invoice->capture();
        }

        $this->_getPayment()->getOrder()->addRelatedObject($invoice);
        return $invoice;
    }
    
    /**
     * Gibt die Payment instance zurück
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
	 * Prüft ob die Bezahlform verwendet werden kann.
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
    public function getAccountHolder()
    {
        return $this->getConfigData('bankaccountholder');
    }

    /**
     * Liefert die Kontonummer aus Admineinstellungen zurück
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getConfigData('bankaccountnumber');
    }

    /**
     * Gibt den Sortcode aus den Admineinstellungen zurück
     * 
     * @return string
     */
    public function getSortCode()
    {
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
    public function getCustomText()
    {
        return nl2br($this->getConfigData('customtext'));
    }
    
    /**
     * Gibt das Kassenzeichen der aktuellen Instanz zurück
     * 
     * @return <string, false>
     */
	public function getKassenzeichen()
    {
        return $this->__kassenzeichen;
    }
    
    /**
     * Behandelt die unterschiedlichen Payment Actions
     *
     * Setzt unter anderem den State der Bestellung.<br>
     * Bei ACTION_AUTHORIZE_CAPTURE (default) wird auch automatisch eine Rechnung erstellt.
     *
     * @param string        $paymentAction Die Payment-Action
     * @param Varien_Object $stateObject   Das State Object
     * 
     * @return Egovs_BankPayment_Model_Bankpayment
     * 
     * @see Mage_Payment_Model_Method_Abstract::initialize()
     */
	public function initialize($paymentAction, $stateObject) {
    	if ($paymentAction != self::ACTION_EGOVS_PENDING_BANKPAYMENT
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

    			$orderState = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
    			break;
    		case self::ACTION_EGOVS_PENDING_BANKPAYMENT:
    			$this->authorize($this->_getPayment(), $order->getBaseTotalDue());
				//Rechnung erstellen, aber nicht bezahlen!
    			$invoice = $this->_invoice(true);
				
    			$this->setAmountAuthorized($order->getTotalDue());
    			$this->setBaseAmountAuthorized($order->getBaseTotalDue());

    			$orderState = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
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
     * @param integer       $amount  Betrag
     * 
     * @return Mage_Payment_Model_Method_Abstract
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
		try {
			$objResult = $this->_getSoapClient()->ueberweisenVorLieferungMitBLP($this->_getECustomerId(), $objBuchungsliste, $this->getBuchungsListeParameter($payment, $amount));
			if ($objResult instanceof SoapFault && $objResult->faultcode == 'Client' && $objResult->getCode() == '0' && stripos($objResult->faultstring, self::SOAP_METHOD_NOT_AVAILABLE) > 0) {
				//Fallback zu alter Methode
				Mage::log($this->getCode().'::Fallback new Method MitBLP not available try old method without parameter list.', Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			        $objResult = $this->_getSoapClient()->ueberweisenVorLieferung($this->_getECustomerId(), $objBuchungsliste);
			}
		} catch (Exception $e) {
			Mage::log($e, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		$this->validateSoapResult($objResult, $objBuchungsliste, 'ueberweisenVorLieferung');
		
    	//das kassenzeichen sollte erst abgeholt werden wenn das ergebniss geprueft wurde
    	$payment->setData('kassenzeichen', $objResult->buchungsListe->kassenzeichen);
		
    	$this->loeschenKunde();
    	
    	return $this;
    }
    
    /**
     * Capture payment
     * 
     * Bringt die Bestellung abhängig vom Status der Rechnung in den State 'Verarbeitung'.
     * <p>
     * siehe dazu Trac ticket #306, #492, #496
     * </p>
     * 
     * @param Varien_Object $payment Payment Object
     * @param float         $amount  Betrag
     * 
     * @return $this
     */
    public function capture(Varien_Object $payment, $amount)
    {
        if (!$this->canCapture()) {
            Mage::throwException(Mage::helper($this->getCode())->__('Capture action is not available')."!");
        }
        
        if (!($payment instanceof Mage_Sales_Model_Order_Payment))
    		return $this;
    	
    	$order = $payment->getOrder();
    	
    	if (is_null($order))
    		return $this;
    	
    	if ($order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT) {
    		Mage::throwException(Mage::helper($this->getCode())->__("Invoice isn't paid yet")."!");
    	}
    	// Start store emulation process
    	$appEmulation = Mage::getSingleton('core/app_emulation');
    	$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($order->getStoreId());
    	
    	if ($order->getIsVirtual()) {
    		$customerNote = $this->__("Your order is complete.<br/>If your order contains downloads, so you can now download these.");    		
    	} else {
    		$customerNote = $this->__("We received your payment and your order will now prepared for delivery.<br/>If your order contains downloads, so you can now download these.");
    	}
    	
    	// Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

    	$order->sendOrderUpdateEmail(true, $customerNote);
    	
    	$order->addStatusToHistory(
    			$order->getStatus(),
    			$customerNote,
    			true
    	);

        return $this;
    }
    
    /**
     * Gibt an ob die Bankverbindung bei den Zahlungsinformationen
     * angezeigt werden soll.
     * 
     * @return boolean
     */
    public function showBankDetails() {
    	return (bool)$this->getConfigData('show_bank_details');
    }
}
