<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * @category  Egovs
 * @package   Egovs_Paymentbase
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2011 - 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @method Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis getKassenzeichenInfo() Kassenzeichen Info
 */
class Egovs_Paymentbase_Model_Paymentbase extends Mage_Core_Model_Abstract
{
	/**
	 * Maximale Anzahl an Rechnungen die unausgeglichen sind.
	 * Wird zur Anzeige von Warnmeldungen benötigt
	 * 
	 * @var int
	 */
	const MAX_UNBALANCED = 15;

	const KASSENZEICHEN_STATUS_NEW = 0;
    const KASSENZEICHEN_STATUS_PROCESSING = 1;
    const KASSENZEICHEN_STATUS_DONE = 2;
    const KASSENZEICHEN_STATUS_ERROR = 3;
	
	/**
	 * Bezahlte Kassenzeichen
	 * 
	 * @var array
	 */
	protected $_grantedKassenzeichen = array();
	/**
	 * Vollständig bezahlte Kassenzeichen
	 * 
	 * @var int
	 */
	protected $_paidKassenzeichen = 0;
	/**
	 * Unausgeglichene Kassenzeichen
	 * 
	 * @var int
	 */
	protected $_notBalanced = 0;
	/**
	 * Gibt an ob das Object bereits initialisiert wurde
	 * 
	 * @var boolean
	 */
	protected $_initialized = false;
	
	protected static $_running = false;
	
	/**
	 * Gibt an ob diese Klasse gerade Zahlungseingänge prüft
	 * 
	 * @return boolean
	 */
	public static function isRunning() {
		return self::$_running;
	}
	
	/**
	 * Liefert die Bestellung zur aktuellen Rechnungsinstanz
	 * 
	 * @return Mage_Sales_Model_Order
	 */
	protected function _getOrder() {
		if (!self::isRunning() || !$this->hasInvoice()) {
			return Mage::getModel('sales/order');
		}
		
		return $this->getInvoice()->getOrder();
	}
	
	/**
	 * Liefert das Kassenzeichen zur aktuellen Bestellinstanz
	 * 
	 * @return string|null
	 */
	protected function _getKassenzeichen() {
		if (!self::isRunning() || !$this->hasInvoice()) {
			return null;
		}
		
		return $this->_getOrder()->getPayment()->getKassenzeichen();
	}

    /**
     * Liefert den Kassenzeichen-Status zur aktuellen Bestellinstanz
     *
     * @return int|null
     */
    protected function _getKassenzeichenStatus() {
        if (!self::isRunning() || !$this->hasInvoice()) {
            return null;
        }

        return (int)$this->_getOrder()->getPayment()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS);
    }

    /**
     * Liefert den Kassenzeichen-Error-Zähler zur aktuellen Bestellinstanz
     *
     * @return int
     */
    protected function _getKassenzeichenErrorCount() {
        if (!self::isRunning() || !$this->hasInvoice()) {
            return 0;
        }

        return (int)$this->_getOrder()->getPayment()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT);
    }

    /**
     * Verarbeitet die Informationen die von der ePayment Plattform geliefert werden.
     *
     * Die ePayment Plattform wird auf aktuelle Zahlungsinformationen abgefragt. Mit den erhaltenen Kassenzeichen,
     * wird eine Liste von Bestellungen im Shop abgearbeitet.
     * Die Bestellungen erhalten somit den korrekten State im Shop.
     *
     * Der aktuelle Saldo des BKZ wird in der Order im Feld 'total_paid' und 'base_total_paid' mitgeführt.
     *
     * Für den Fall einer Unterzahlung zu einem BKZ wird dem Backendbenutzer eine Rückmeldung gegeben
     * (max:MAX_UNBALANCED). Diese sollte neben dem BKZ, auch die Bestellnummer sowie die Rechnungsnummer beinhalten.
     *
     * Für den Fall einer Überzahlung zu einem BKZ wird dem BE-Benutzer eine sprechende Rückmeldung gegeben
     * (max:MAX_UNBALANCED). Diese sollte neben dem BKZ, auch die Bestellnummer sowie die Rechnungsnummer beinhalten.
     * Der Hinweis erfolgt nur einmal. Überzahlte BKZ werden nicht erneut abgerufen.
     *
     * Unterzahle BKZ werden erneut abgerufen.
     *
     * @return Egovs_Paymentbase_Model_Paymentbase
     *
     * @see Egovs_Paymentbase_Model_Paymentbase::_lesenKassenzeichenInfo
     * @see Egovs_Paymentbase_Model_Paymentbase::_ePaymentUpdatePaymentStatus
     * @see Egovs_Paymentbase_Model_Paymentbase::_ePaymentZahlungenGelesen
     *
     * @throws \Mage_Core_Model_Store_Exception
     */
	public function getZahlungseingaenge() {
		self::$_running = true;
	 	
		$collection = $this->_getUnbalancedInvoices();

		$kassenzeichenCount = 0;
	 	$this->_paidKassenzeichen = 0;
	 	$this->_notBalanced = 0;
	 	$errors = array();
	 	$_currentStore = null;
        // Alle relevanten Bestellungen durchgehen und übereinstimmende Kassenzeichen auf processing setzen
		foreach ($collection->getItems() as $invoice) {
	 		
			$this->setInvoice($invoice);
	 		/* @var $order Mage_Sales_Model_Order */
			$order = $invoice->getOrder();
			$_currentStore = Mage::app()->getStore();
			Mage::app()->setCurrentStore($order->getStore());
			
			$kzeichen = $this->_getKassenzeichen();
			Mage::log(
			    sprintf(
			        "paymentbase::Kassenzeichen %s für Store '%s'(ID:%s) und Mandant '%s' abfragen:",
                    $kzeichen,
                    Mage::app()->getStore()->getName(),
                    Mage::app()->getStore()->getId(),
                    Mage::helper('paymentbase')->getMandantNr()
                ),
                Zend_Log::DEBUG, Egovs_Helper::LOG_FILE
            );

			if (empty($kzeichen) || $this->_getKassenzeichenErrorCount() >= $this->_getKassenzeichenMaxErrorCount()) {
                $this->unsKassenzeichenInfo();
                continue;
            }

            //Wenn Kassenzeichen verfügbar
            $this->setKassenzeichenInfo($this->_lesenKassenzeichenInfo($kzeichen));

            $kInfo = $this->getKassenzeichenInfo();
            if ($kInfo instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis) {
                if ($kInfo->ergebnis->istOk == false) {
                    $msg = sprintf(
                            "%s; Error code: %s; Kassenzeichen: %s",
                            $this->getKassenzeichenInfo()->ergebnis->getLongText(),
                            $this->getKassenzeichenInfo()->ergebnis->getCode(),
                            $kzeichen
                    );
                    Mage::log("paymentbase::$msg", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
                    if (!isset($errors[$this->getKassenzeichenInfo()->ergebnis->getCode()])) {
                        $errors[$this->getKassenzeichenInfo()->ergebnis->getCode()] = $msg;
                    } elseif (isset($errors[$this->getKassenzeichenInfo()->ergebnis->getCode()])
                        && mb_strlen($errors[$this->getKassenzeichenInfo()->ergebnis->getCode()]) <= 104) {
                        $errors[$this->getKassenzeichenInfo()->ergebnis->getCode()] .= " ".Mage::helper('paymentbase')->__("The error file contains further information...");
                    }
                    $this->_saveIncomingPayment(self::KASSENZEICHEN_STATUS_ERROR, $msg);
                    $this->unsKassenzeichenInfo();
                } else {
                    //Alles OK Kassenzeichen wurde abgerufen
                    $kassenzeichenCount++;
                }
            } else {
                $msg = Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR_STANDARD');
                Mage::log("paymentbase::Kassenzeichen:$kzeichen:$msg", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
                if (!isset($errors[-9999])) {
                    $errors[-9999] = $msg;
                }
                $this->_saveIncomingPayment(self::KASSENZEICHEN_STATUS_ERROR, $msg);
                $this->unsKassenzeichenInfo();
            }
			
			$this->_processIncomingPayments();
            Mage::app()->setCurrentStore($_currentStore);
		}

		foreach ($errors as $errorCode => $msg) {
            Mage::getSingleton('adminhtml/session')->addError($msg);
        }
		
		Mage::log("paymentbase::Bezahlte Kassenzeichen wurden abgerufen", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('Anzahl der abgerufenen Kassenzeichen: ').$kassenzeichenCount);
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('Anzahl der vollständig bezahlten Kassenzeichen: ').$this->_paidKassenzeichen);
		if ($this->_paidKassenzeichen != $kassenzeichenCount) {
			Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('paymentbase')->__('Anzahl der unvollständig bezahlten Kassenzeichen: ').($kassenzeichenCount - $this->_paidKassenzeichen));
		}
		
 		$this->_initialized = true;
 		
 		self::$_running = false;
 		
		return $this;		
    }
    
    /**
     * Ordnet die Zahlungseingänge für ein Kassenzeichen einer Bestellung zu
     * 
     * @return void
     */
    protected function _processIncomingPayments() {
    	//Wenn Rechnung bezahlt wurde
    	if ($this->getKassenzeichenInfo() && $this->getKassenzeichenInfo()->saldo <= 0.0) {
            $_saldo = $this->getKassenzeichenInfo()->saldo;

            /**
             * #3026 ZV_FM-720
             * Stornierungen nicht verarbeiten
             *
             * betragHauptforderungen - betragStornos == 0
             */
            if ($_saldo == 0.0
                && round($this->getKassenzeichenInfo()->betragHauptforderungen - $this->getKassenzeichenInfo()->betragStornos, 4) == 0.0
                && round($this->getKassenzeichenInfo()->betragZahlungseingaenge, 4) == 0.0
            ) {
                //TODO Stornierung implementieren
                return;
            }

            //Reset möglicher Teilzahlungen
    		$this->_getOrder()->setBaseTotalPaid(0);
    		$this->_getOrder()->setTotalPaid(0);
            $msg = null;

            if ($_saldo < 0.0 && $this->_notBalanced <= self::MAX_UNBALANCED) {
    			Mage::getSingleton('adminhtml/session')->addNotice(
    				Mage::helper('paymentbase')->__('The balance of invoice #%s for order #%s is %s', $this->getInvoice()->getIncrementId(), $this->_getOrder()->getIncrementId(), $_saldo)
    			);
    			$this->_notBalanced++;
    		} elseif ($_saldo < 0.0 && $this->_notBalanced == self::MAX_UNBALANCED+1) {
    			Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('paymentbase')->__('...'));
    			$this->_notBalanced++;
    		}
            $msg = Mage::helper('paymentbase')->__('The balance of this invoice is %s', $_saldo);
    		if ($_saldo < 0.0) {
    			$this->getInvoice()->addComment($msg)
    				->save()
    			;
    		}

    		$orderStatus = $this->_setOrderStateAfterPayment($this->_getOrder());
    		$this->_getOrder()->setStatus($orderStatus);
    		//Hier Rechnungen noch auf bezahlt setzen!
    		//Muss nach State-Änderung der Order stehen!!
    		$this->_setInvoicePaymentStatus($this->_getOrder());
    		$_betrag = max(0, $this->getKassenzeichenInfo()->betragZahlungseingaenge - $this->getKassenzeichenInfo()->betragStornos);
    		if ($this->getKassenzeichenInfo()->saldo < 0.0) {
    			$this->_getOrder()->setBaseTotalPaid($_betrag);
    			/* $this->getKassenzeichenInfo()->betragZahlungseingaenge kommt als base price */
    			$this->_getOrder()->setTotalPaid($this->_getOrder()->getStore()->convertPrice($_betrag));

    			$this->_saveIncomingPayment(self::KASSENZEICHEN_STATUS_DONE, $msg);
    		}

    		$this->_getOrder()->getPayment()->setEpayblCaptureDate(Varien_Date::now());
    		$this->_getOrder()->save();
    		$this->_paidKassenzeichen++;
    		$this->_grantedKassenzeichen[] = $this->_getKassenzeichen();
    	} elseif ($this->getKassenzeichenInfo() && $this->getKassenzeichenInfo()->saldo > 0.0 && $this->getKassenzeichenInfo()->saldo < $this->_getOrder()->getBaseGrandTotal()) {
    		$_betrag = max(0, $this->getKassenzeichenInfo()->betragZahlungseingaenge - $this->getKassenzeichenInfo()->betragStornos);
    		//Nur für Teilzahlungen
    		if ($this->_notBalanced <= self::MAX_UNBALANCED) {
    			Mage::getSingleton('adminhtml/session')->addNotice(
    			Mage::helper('paymentbase')->__('The balance of invoice #%s for order #%s is %s', $this->getInvoice()->getIncrementId(), $this->_getOrder()->getIncrementId(), $this->getKassenzeichenInfo()->saldo));
    			$this->_notBalanced++;
    		} elseif ($this->_notBalanced == self::MAX_UNBALANCED+1) {
    			Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('paymentbase')->__('...'));
    			$this->_notBalanced++;
    		}
    		$msg = Mage::helper('paymentbase')->__('The balance of this invoice is %s', $this->getKassenzeichenInfo()->saldo);
    		$this->getInvoice()->addComment($msg)
    			->save()
    		;
    		$this->_getOrder()->setBaseTotalPaid(
    				min($_betrag, $this->_getOrder()->getBaseGrandTotal())
    		);
    		/* $this->getKassenzeichenInfo()->betragZahlungseingaenge kommt als base price */
    		$this->_getOrder()->setTotalPaid(
    				min($this->_getOrder()->getStore()->convertPrice($_betrag), $this->_getOrder()->getGrandTotal())
    		);
            $this->_saveIncomingPayment(self::KASSENZEICHEN_STATUS_PROCESSING, $msg);

            $this->_getOrder()->getResource()->saveAttribute($this->_getOrder(), array('base_total_paid', 'total_paid'));
    	}
    }
    
    /**
     * Gibt eine Liste offener Rechnungen zurück
     * 
     * @return Mage_Sales_Model_Mysql4_Order_Invoice_Collection
     */
    protected function _getUnbalancedInvoices() {
    	if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
    		//cached ID verwenden
    		$orderPaymentEntityType = Mage::getSingleton('eav/config')->getEntityType('order_payment');
    		$attrMethodId = Mage::getSingleton('eav/entity_attribute')->getIdByCode('order_payment', 'method');
    		$attributeTableName = $orderPaymentEntityType->getEntity()
	    		->getAttribute('method')
	    		->getBackendTable()
    		;
    	
    		//Brauchen collection mit offenen Rechnungen
    		$collection = Mage::getResourceModel('sales/order_invoice_collection')
	    		//Brauchen order_id im Ergebnis
	    		->addAttributeToFilter(array(array('attribute'=>'order_id', 'gt' => '0')))
	    		//nach offenen Rechnungen Filtern
	    		->addAttributeToFilter('state', Mage_Sales_Model_Order_Invoice::STATE_OPEN)
	    		//Verweis auf Payment wird benötigt
	    		->joinTable('sales/order_entity',
	    				'parent_id=order_id',
	    				array('payment_entity_id' => 'entity_id'),
	    				'{{table}}.entity_type_id='.$orderPaymentEntityType->getId()
	    		)
	    		//method Attribute mit einbinden
	    		->joinTable($attributeTableName,
	    				'entity_id=payment_entity_id',
	    				array('method' => 'value'),
	    				'{{table}}.attribute_id='.$attrMethodId
	    		)
	    		//Benötigen nur 'Offene Rechnung' und 'Vorkasse'
	    		->addAttributeToFilter('method', array('openaccount', 'bankpayment'))
	    		//Es gibt nur ein Kassenzeichen --> bei Teilrechnungen hätten wir sonst mehrmals die gleiche Order
	    		->groupByAttribute('order_id')
    		;
    	} else {
    		//Magento 1.6
    		//Brauchen collection mit offenen Rechnungen
    		/* @var $collection Mage_Sales_Model_Resource_Order_Invoice_Collection */
    		$collection = Mage::getResourceModel('sales/order_invoice_collection');
    		$quotedParentId = $collection->getConnection()->quoteIdentifier('parent_id');
    		$quotedMethod = $collection->getConnection()->quoteIdentifier('method');
    		$quotedOrderId = $collection->getConnection()->quoteIdentifier('order_id');
    		$collection->addFieldToFilter('order_id', array('gt' => '0'))
    			->addFieldToFilter('state', Mage_Sales_Model_Order_Invoice::STATE_OPEN)
    		;
    		$collection
    			->join('sales/order_payment', $collection->getConnection()->quoteInto("$quotedParentId=$quotedOrderId AND $quotedMethod IN (?)", array('openaccount', 'bankpayment')), 'method')
    			->getSelect()->group('order_id')
    		;
    		//Älteste als erstes
    		$collection->addOrder('order_id', 'asc');
    	}
    	Mage::log(sprintf('paymentbase::getZahlungseingänge: %s', $collection->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	
    	return $collection;
    }
    
    /**
	 * Prüft ob seit dem letzten Abfragen Zahlungseingänge für den Mandanten verzeichnet werden konnten
	 *
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>listeUngeleseneZahlungseingaenge</li>
	 * </ul>
	 * 
	 * @return <array,int> Das Array Beinhaltet einerseits den Returncode einer Abfrage nach
	 * einer Liste der verbuchten Zahlungseingänge zu Kassenzeichen des anfragenden
	 * Mandanten und andererseits die Liste der von ZÜV zurückgemeldeten Zahlungseingangselemente oder den Fehlercode
	 * 
	 * @deprecated Wird mit SäHO nicht mehr verwendet!
	 */
	protected function _ePaymentGetNewPayments() {

		// Webservice-Client holen
		$objSOAPClientBfF = Mage::helper('paymentbase')->getSoapClient();

	 	// Prüfung von Parametern
    	if (!Mage::helper('paymentbase')->getMandantNr()
    		|| strlen(Mage::helper('paymentbase')->getMandantNr()) <= 0
    	) {
    		Mage::log("paymentbase::ePayment isn't correctly configured, check your settings!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return -9999;
		}

		// Liste abfragen
		$arrResult = null;
		try {
			$arrResult = $objSOAPClientBfF->listeUngeleseneZahlungseingaenge(false);
		} catch (Exception $e) {
			Mage::log($e, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}

		// wenn SOAP-Fehler
		if (!$arrResult || $arrResult instanceof SoapFault) {
			// dann Abbruch mit Fehler
			return -999989;
		}

		return $arrResult;
	}
	
	/**
	 * Liefert Informationen zum übergebenen Kassenzeichen am ePayBL
	 * 
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>lesenKassenzeichenInfo</li>
	 * </ul>
	 * 
	 * @param string $kzeichen Kassenzeichen
	 *
	 * @return Array beinhaltet einerseits den Returncode einer Abfrage nach
	 * einer Liste der verbuchten Zahlungseingänge zu Kassenzeichen des anfragenden
	 * Mandanten und andererseits wird die Liste der von ZÜV zurückgemeldeten Zahlungseingangselemente zurückgegeben
	 */
	protected function _lesenKassenzeichenInfo($kzeichen) {
		return Mage::helper('paymentbase')->lesenKassenzeichenInfo($kzeichen);
	}
	
	/**
	 * Bestätigt die gelesenen Zahlungseingänge
	 * 
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>bestaetigenGeleseneZahlungseingaenge</li>
	 * </ul>
	 * 
	 * @param string $ePaymentID ePaymentID
	 * 
	 * @return Egovs_Paymentbase_Controller_Abstract ePayment-Ergebnisstruktur 
	 * 
	 * @deprecated Wird mit SäHO nicht mehr verwendet!
	 */
	protected function _ePaymentZahlungenGelesen($ePaymentID) {
		// Webservice-Client holen
		$objSOAPClientBfF = Mage::helper('paymentbase')->getSoapClient();

	 	// Prüfung von Parametern
    	if (!Mage::helper('paymentbase')->getMandantNr()
    		|| strlen(Mage::helper('paymentbase')->getMandantNr()) <= 0
    	) {
    		Mage::log("paymentbase::ePayment isn't correctly configured, check your settings!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			return -9999;
		}

		// Liste abfragen
		$arrResult = null;
		try {		
			$arrResult = $objSOAPClientBfF->bestaetigenGeleseneZahlungseingaenge(Mage::helper('paymentbase')->getMandantNr(), $ePaymentID);
		} catch (Exception $e) {
			Mage::log($e, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}

		// wenn SOAP-Fehler
		if (!$arrResult || $arrResult instanceof SoapFault) {
			// dann Abbruch mit Fehler
			return -999989;
		}

		return $arrResult;
	}
    
    /**
     * Prüft ob ein Kassenzeichen bezahlt wurde.
     * Wird zur Gewährleistung für "Online erfassen" benötigt.
     * 
     * Das Objekt muss zuvor mit getZahlungseingaenge initialisiert worden sein!
     * 
     * @param string $kassenzeichen Kassenzeichen
     * 
     * @return TRUE | FALSE
     */
    public function isKassenzeichenPaid($kassenzeichen=null) {
    	if (!$this->_initialized) {
    		Mage::throwException('Modul not initialized - call getZahlungseingaenge() first!');
    	}
    		
    	if ($kassenzeichen != null && in_array($kassenzeichen, $this->_grantedKassenzeichen)) {
    		return true;
    	} else return false;
    }
    
    
    
	/**
     * Setzt den initialen State auf PROCESSING oder COMLETE.
     * 
     * @param Mage_Sales_Model_Order $order Bestellung
     * 
     * @return string Order status
     */
    protected  function _setOrderStateAfterPayment($order) {
    	if (($orderState = $order->getState()) == Mage_Sales_Model_Order::STATE_COMPLETE) {
    		return $order->getConfig()->getStateDefaultStatus($orderState);
    	}
    	
    	if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	    	$orderState = $order->getIsVirtual()
	    		? Mage_Sales_Model_Order::STATE_COMPLETE
	    		: Mage_Sales_Model_Order::STATE_PROCESSING;
    	} else {
    		//STATE_COMPLETE ist in Magento 1.6 geschützt
    		//wird für Virtuelle Produkte aber automatisch gesetzt
    		$orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
    	}

    	/**
    	 * Change order status if it specified
    	 */
    	$orderStatus = $order->getConfig()->getStateStatuses($orderState, false);
		if (in_array("processing", $orderStatus)) {
			$orderStatus = "processing";
		} else unset($orderStatus);
		
    	if (!$orderStatus || $order->getIsVirtual()) {
    		$orderStatus = $order->getConfig()->getStateDefaultStatus($orderState);
    	}

    	$order->setState($orderState);
    	$customerNote = Mage::helper('paymentbase')->__('Your payment has been received');
    	$isCustomerNotified = false;

    	$order->addStatusHistoryComment(
                $customerNote,
                $orderStatus
            )->setIsCustomerNotified($isCustomerNotified)
        ;
    	//Erst muss Status gesetzt sein.
    	if ($isCustomerNotified) {
    		$order->sendOrderUpdateEmail(true, $customerNote);
    	}
    	
    	return $orderStatus;
    }

    /**
     * Setzt den Status aller Rechnungen der Bestellung
     *
     * @param Mage_Sales_Model_Order $order Bestellung
     *
     * @return Egovs_Paymentbase_Model_Paymentbase
     *
     * @throws \Exception
     */
	protected  function _setInvoicePaymentStatus(Mage_Sales_Model_Order $order) {
    	if (is_null($order)) {
    		return $this;
    	}
    	//Paymentmodul wird schon bei getZahlungseingaenge abgefragt!
		/*TODO : Sollte hier vielleicht noch zwischen Paymentmodulen (Vorkasse und Rechnung) bzgl. des States differenziert werden?
		*/
    	if ($order->getState() != Mage_Sales_Model_Order::STATE_PROCESSING
            && $order->getState() != Mage_Sales_Model_Order::STATE_PENDING_PAYMENT
            && $order->getState() != Mage_Sales_Model_Order::STATE_COMPLETE) {
	    	return $this;
	    }
	    	
    	foreach ($order->getInvoiceCollection() as $invoice) {
    		if ($invoice->isCanceled() || $invoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_PAID) {
    			continue;
    		}
    		
    		/* @var $invoice Mage_Sales_Model_Order_Invoice */
    		$invoice->capture()
    			->save();
    	}
    	
    	return $this;
    }

    protected function _saveIncomingPayment($status, $msg = null) {
        if (!self::isRunning() || !$this->hasInvoice()) {
            return $this;
        }

        $force = false;
        if ($status == self::KASSENZEICHEN_STATUS_ERROR) {
            $this->_getOrder()->getPayment()->setData(
                Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT,
                $this->_getKassenzeichenErrorCount()+1
            );
            $force = true;
        } else {
            $this->_getOrder()->getPayment()->setData(
                Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT,
                0
            );
        }
        $this->_getOrder()->getPayment()->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS, $status);
        /** @var \Mage_Sales_Model_Resource_Order_Payment $resource */
        $resource = $this->_getOrder()->getPayment()->getResource();
        $resource->saveAttribute($this->_getOrder()->getPayment(), array(
            Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT,
            Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS
        ));

        //Normale Bezahlungen werden über Observer behandelt
        //@see Egovs_Paymentbase_Model_Observer::onSalesOrderInvoicePay
        $incomingPayment = Mage::getModel('paymentbase/incoming_payment');
        $incomingPayment->saveIncomingPayment(
            $this->_getOrder()->getId(),
            $this->_getOrder()->getBaseTotalPaid(),
            $this->_getOrder()->getTotalPaid(),
            $msg,
            $force
        );

        return $this;
    }

    protected function _getKassenzeichenMaxErrorCount() {
	    return (int)Mage::getStoreConfig('payment_services/paymentbase/apr_max_error_count');
    }
}