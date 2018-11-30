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
class Gka_Barkasse_Model_Cashpayment extends Egovs_Paymentbase_Model_Abstract
{
	
	
    /**
     * Unique internal payment method identifier
     * 
     * @var string $_code
     */
    protected $_code = 'epaybl_cashpayment';
	
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
    protected $_formBlockType = 'gka_barkasse/form';
    
    /**
     * Infoblock Type
     * 
     * @var string $_infoBlockType
     */
    protected $_infoBlockType = 'gka_barkasse/info';
	
	
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
     * Gibt das Zahlungsziel entweder aus den Admineinstellungen oder der Paymentinstanz zurück
     *
     * @param int $storeId Store ID
     *
     * @return integer Pay within X days
     */
    public function getPayWithinXDays($storeId = null) {
    	return 0;
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
    	
    	$journal = $this->_getJournal($quote);
    	if(($journal == null)|| ($journal->getId() == 0)){
    		return false;
    	}
    	
    	return parent::isAvailable($quote);
    }
    
	/**
	 * Ermittelt das Kassenbuch für den Kunden
	 * @param Mage_Sales_Model_Quote $quote
	 * @return NULL | Gka_Barkasse_Model_Kassenbuch_Journal
	 */
    protected function _getJournal($quote)
    {
    	$customerId = 0;
    	if($quote != null){
    		$customerId = intval($quote->getCustomerId());
    	}
    	
    	if($customerId == 0) return null;
    	$collection = Mage::getResourceModel('gka_barkasse/kassenbuch_journal_collection');
    	$collection->getSelect()
    		->where('customer_id = ' . $customerId)
    		->where('status = '. Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_OPEN);
    	
    	return $collection->getFirstItem();
    	
    }
    
    public function getBuchungsListeParameter($payment, $amount) {
    	$params = parent::getBuchungsListeParameter($payment, $amount);
    	$params['paymentmethod'] = 'cashpayment';
    	return $params;
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
     * Assign data to info model instance
     *
     * @param   mixed $data
     * @return  Mage_Payment_Model_Info
     */
    public function assignData($data)
    {
    	parent::assignData($data);
    	if (!($data instanceof Varien_Object)) {
    		$data = new Varien_Object($data);
    	}
    	$info = $this->getInfoInstance();
    	$cntr = Mage::app()->getFrontController();
    	$ga = $cntr->getRequest()->getParam('givenamount',0);
    	$ga = str_replace(',', '.', $ga);
    	$ga = floatval($ga);
    	$info->setGivenAmount($ga);
    	return $this;
    }
    
    /**
     * Wechselgeld überprüfen
     * {@inheritDoc}
     * @see Mage_Payment_Model_Method_Abstract::validate()
     */
    public function validate() {
    	Mage_Payment_Model_Method_Abstract::validate();
    
    	$payment = $this->getInfoInstance();
    	$ga = $payment->getGivenAmount();
    	
    	$quote = $payment->getQuote();
    	
    	$total= 0;
    	if ($this->_isPlaceOrder()) {
    		$total = $payment->getOrder()->getGrandTotal();
    	} else {
    		$total = $payment->getQuote()->getGrandTotal();
    	}
    	
    	
    	
    	
    	if($total > $ga)
    	{
    		Mage::throwException(Mage::helper('gka_barkasse')->__('Change Amount not plausible!'));
    	}
    }
 
    
    /**
     * Whether current operation is order placement
     *
     * @return bool
     */
    private function _isPlaceOrder()
    {
    	$info = $this->getInfoInstance();
    	if ($info instanceof Mage_Sales_Model_Quote_Payment) {
    		return false;
    	} elseif ($info instanceof Mage_Sales_Model_Order_Payment) {
    		return true;
    	}
    }
    
    /**
     * Authorize
     *
     * @param Varien_Object $payment Payment
     * @param integer       $amount  Betrag
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
		try {
			$objResult = $this->_getSoapClient()->anlegenKassenzeichenMitZahlverfahrenlisteMitBLP(
					$this->_getECustomerId(),
					$objBuchungsliste,
					null,
					null,
					'KREDITKARTE',
					$this->getBuchungsListeParameter($payment, (float)$amount)
			);
		} catch (Exception $e) {
			Mage::log($e, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		$this->validateSoapResult($objResult, $objBuchungsliste, 'anlegenKassenzeichen[Barzahlung]');
		
    	//das kassenzeichen sollte erst abgeholt werden wenn das ergebniss geprueft wurde
    	$payment->setData('kassenzeichen', $objResult->buchungsListe->kassenzeichen);
    	
    	
    	
    	$objResult = null;
    	try {
    		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
    			$objResult = $objSOAPClient->aktiviereTempKassenzeichen(
    					sprintf("%s/%s", Mage::helper('paymentbase')->getBewirtschafterNr(), $payment->getKassenzeichen()),
    					$payment->getKassenzeichen(),
    					'BARZAHLUNG'
    			);
    		} else {
	    		$objResult = $this->_getSoapClient()->aktiviereTempKreditkartenKassenzeichen(
	    				sprintf("%s/%s", Mage::helper('paymentbase')->getBewirtschafterNr(), $payment->getKassenzeichen()),
	    				null,
	    				$payment->getKassenzeichen(),
	    				'BARZAHLUNG'
	    		);
    		}
    	} catch (Exception $e) {
    		Mage::log($e, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    	}
    	$this->validateSoapResult($objResult, $objBuchungsliste, 'anlegenKassenzeichen[Barzahlung]');
		
    	$this->loeschenKunde();
    	
    	return $this;
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
    					$invoice = $this->_invoice();
    
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
    		$customerNote = $this->__("Your order is complete.");    		
    	} else {
    		$customerNote = $this->__("We received your payment.");
    	}
    	
    	// Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

    	$order->sendOrderUpdateEmail(true, $customerNote);
    	
    	$order->addStatusHistoryComment(
    			$customerNote,
    			$order->getStatus());

        return $this;
    }
    
  
}
