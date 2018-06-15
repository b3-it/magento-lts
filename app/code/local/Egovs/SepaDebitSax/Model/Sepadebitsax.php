<?php

/**
 * ePayment-Kommunikation im SEPA-Debit-Verfahren (Lastschrift) für Bund.
 *
 * @category       Egovs
 * @package        Egovs_Paymentbase
 * @author         Holger Kögel <h.koegel@b3-it.de>
 * @author         Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      Copyright (c) 2013 - 2018 B3 IT System GmbH <hhtps://www.b3-it.de>
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitSax_Model_Sepadebitsax extends Egovs_Paymentbase_Model_SepaDebit
{

    const SEPA_MANDATE_EXCEPTION_CODE_INACTIVE = 1000;
    const SEPA_MANDATE_EXCEPTION_CODE_CANCEL = 1100;


    /**
     * Identifiziereung des Gläubigers aus Config
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
     */
    protected $_identity = NULL;

    protected $_isInitializeNeeded = true;
    protected $_isGateway = true;
    /**
     * Fachverfahren für Mandatsverwaltung
     *
     * @var string
     */
    protected $_agent = NULL;


    protected $_MandateIsActiv = false;

    /**
     * Eindeutige interne Bezeichnung für Payment [a-z0-9_]
     *
     * @var string $_code
     */
    protected $_code = 'sepadebitsax';
    /**
     * Formblock Type
     *
     * @var string $_formBlockType
     */
    protected $_formBlockType = 'sepadebitsax/form';
    /**
     * Infoblock Type
     *
     * @var string $_infoBlockType
     */
    protected $_infoBlockType = 'sepadebitsax/info';
    /**
     * Gibt an ob auch eine externe Mandatsverwaltung untersützt wird.
     *
     * @var bool
     */
    protected $_canExternalMandateManagement = true;
    /**
     * Gibt an ob die interne ePayBL Mandatsverwaltung untersützt wird.
     *
     * @var bool
     */
    protected $_canInternalMandateManagement = false;


    /**
     * Erstellt das Mandats-Objekt mit individuellen Erweiterungen
     *
     * Die eShopKundennummer wird nicht gesetzt!</br>
     * Die dateOfLastUsage wird nicht gesetzt!
     *
     * @param Egovs_Paymentbase_Model_Sepa_Mandate_Abstract $mandate Mandat als Adapter
     * @param Mage_Payment_Model_Info                       $payment Payment
     *
     * @return Egovs_Paymentbase_Model_Webservice_Types_SepaMandat
     * @throws Exception
     */
    protected function _constructSepaMandate($mandate, $payment = NULL) {
        if (!$payment) {
            $payment = $this->getInfoInstance();
        }

        if ($payment->getAdditionalInformation('custom_owner')) {
            $infos = new Varien_Object($payment->getAdditionalInformation());
            $mandate->setAccountholderBankname($infos->getCustomAccountholderBankname());
        }
        /*
         * CreditorId aus importData entfernen
         * CreditorId aus Konfiguration != KreditorGläubigerId der MV
         */
        $mandate->setCreditorId(NULL);

        /*
         * [5934] | hkoegel | 2014-04-04 17:14:10 MESZ
         * SEPA SAX EKunde immer neu anlegen bei neuem Mandate
         */
        /*
		$customer = $this->getCustomer();
		Mage::helper('paymentbase')->loeschenKunde($customer,"sepadebitsax");
		$customer->unsetData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);

		$resource = $customer->getResource();
		$resource->saveAttribute($customer,Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
        */
        return $mandate;
    }

    /**
     * Ein SEPA Mandat aus Mandatsverwaltung lesen
     *
     * @param string $_mandateReference Mandatsreferenz
     *
     * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
     * @throws Exception
     */
    protected function _getMandate($_mandateReference) {
        $objResult = NULL;

        /* @var $client Egovs_SepaDebitSax_Model_Webservice_Soap_Service */
        $client = Mage::helper('sepadebitsax')->getZmvSoapClient();
        try {
            $objResult = $client->LesenSEPAMandat($this->_getIdentifierzierung(), $_mandateReference, $this->_getAgent());
        } catch (Exception $e) {
            Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            Mage::logException($e);
        }

        if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatResult) {
            if ($objResult->getResult()->getResultCode()->getCode() == 0) {
                $mandate = $objResult->getMandat();
                Mage::unregister('sepadebitsaxmandate');
                Mage::register('sepadebitsaxmandate', $mandate);
                return $mandate;
            }
        }
        if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result) {
            $msg = $objResult->getResult()->getResultCode()->getDescription();
            Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
        }

        $client->saveError();
        return NULL;
    }

    public function readMandate($_mandateReference) {
        $adaptee = $this->_getMandate($_mandateReference);
        if ($adaptee) {
            $mandate = $this->_createNewAdapterMandate($adaptee);
            return $mandate;
        }
        return NULL;
    }

    private function __getMandateFromSession($_mandateReference) {
        $mandate = Mage::registry('sepadebitsaxmandate');
        if (($mandate) && ($mandate->getReference() == $_mandateReference)) {
            return $mandate;
        }

        return NULL;
    }


    public function getMandateMitPdf($_mandateReference) {
        $objResult = NULL;
        try {
            $objResult = Mage::helper('sepadebitsax')->getZmvSoapClient()->LesenSEPAMandatMitPdf($this->_getIdentifierzierung(), $_mandateReference, $this->_getAgent());
        } catch (Exception $e) {
            Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            Mage::logException($e);
        }

        if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult) {
            if ($objResult->getResult()->getResultCode()->getCode() == 0) {
                $mandate = $objResult;

                return $mandate;
            }
        }
    }

    /**
     * Erstellt das Mandat an der Mandatsverwaltung
     *
     * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface $mandate Mandat
     *
     * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface Sepa-Mandat mit Referenz
     * @throws Exception
     */
    protected function _createSepaMandate($mandate) {
        $soapFunction = 'AnlegenSEPAKreditorenMandatMitPDF()';
        Mage::log("{$this->getCode()}::Rufe auf $soapFunction: Mandant Nr.: {$this->_getMandantNr()} , EKundenNr: {$this->_getECustomerId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

        $mandate->setLocationSigned($mandate->DebitorAdresse->Stadt);
        $date = Mage::app()->getLocale()->date()->toString('c');//yyyy-MM-ddTH:i:');
        $mandate->setDateSignedAsString($date);

        $mandate->Geschaeftsbereichkennung = $this->_getIdentifierzierung()->getGeschaeftsbereichsId()->getGeschaeftsbereichskennung();
        $mandate->PruefStatus = Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_GEPRUEFT;
        $mandate->setDatumErstellung($date);

        $objResult = NULL;
        /* @var $client Egovs_SepaDebitSax_Model_Webservice_Soap_Service */
        $client = Mage::helper('sepadebitsax')->getZmvSoapClient();
        try {
            $objResult = $client->AnlegenSEPAKreditorenMandatMitPdf($this->_getIdentifierzierung(), $mandate, $this->_getAgent());
        } catch (Exception $e) {
            Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            Mage::logException($e);
        }
        $sMailText = '';
        if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult) {
            if ($objResult->getResult()->getResultCode()->getCode() == 0) {
                $mandate->setMandatsreferenz($objResult->getMandatsdaten()->getMandatsreferenz());
                /*
                 * ZV_FM-1465
                 * CreditorId aus Konfiguration != KreditorGläubigerId der MV
                 */
                $mandate->setCreditorId($objResult->getMandatsdaten()->getKreditorGlaeubigerId());

                //mandate versenden
                $email = Mage::getModel('sepadebitsax/email');
                $email->setTemplate("payment/sepadebitsax/mandate_template");
                try {
                    $email->send($this->getCustomer(), $objResult->getMandatPdf());
                } catch (Exception $e) {
                    Mage::logException($e);
                    $sMailText = sprintf("Exception:\n%s\n\n", $e->getMessage());
                    $sMailText .= sprintf(
                        "Mandatsreferenz: %s\n",
                        $mandate->getMandatsreferenz()
                    );
                    Mage::helper("paymentbase")->sendMailToAdmin(
                        "Fehler beim Senden des SEPA Mandats:\n\n" . $sMailText,
                        "Senden des SEPA Mandats fehlgeschlagen"
                    );
                }

                return $mandate;
            }
            $client->saveError();
            $sMailText .= "Code: {$objResult->getResult()->getResultCode()->getCode()}\n";
            $sMailText .= "Beschreibung: {$objResult->getResult()->getResultCode()->getDescription()}\n";
        } elseif ($objResult instanceof SoapFault) {
            $sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
        } else {
            $sMailText .= "Error: No result returned\n";
        }
        Mage::log("{$objResult->getResult()->getResultCode()->getCode()}::Fehler in WebService-Funktion: $soapFunction\n" . $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);


        $msg = Mage::helper($this->getCode())->__($objResult->getResult()->getResultCode()->getDescription());
        $ev = new Egovs_Paymentbase_Exception_Validation($msg);
        /* @var $eMsg Mage_Core_Model_Message_Error */
        $eMsg = Mage::getModel('core/message_error', $msg);
        $ev->addMessage($eMsg);
        throw $ev;
    }

    /**
     * Idendität aus Konfig
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
     */
    protected function _getIdentifierzierung() {
        if ($this->_identity == NULL) {
            $this->_identity = Mage::helper('sepadebitsax')->getIdentifierzierung();
        }
        return $this->_identity;
    }

    /**
     * Fachverfahren für Mandatsverwaltung aus Konfig
     *
     * @return string
     */
    protected function _getAgent() {
        if ($this->_agent == NULL) {
            $this->_agent = Mage::helper('sepadebitsax')->getAgent();
        }
        return $this->_agent;
    }

    protected function _getEmptyAddressInstance() {
        return Egovs_SepaDebitSax_Model_Sepa_Mandate::createEmptyAddress();
    }

    /**
     * Liefert eine Mandatsinstanz
     *
     * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate Mandate
     *
     * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
     */
    protected function _createNewAdapterMandate($mandate) {
        $args = array();
        if ($mandate) {
            $args['mandate'] = $mandate;
        }
        return Mage::getModel('sepadebitsax/sepa_mandate', $args);
    }


    protected function _canChange($mandateref) {

        if ($mandateref) {
            $mandate = $this->_getMandate($mandateref);
            return ($mandate->isActive());
        }

        //mandate nicht gefunden also neu
        return true;
    }

    protected function _removeCurrentMandate($mandateref) {
        Mage::unregister('sepadebitsaxmandate');
        $this->getCustomer()->unsetData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
        return $this;
    }

    public function validate() {
        Mage_Payment_Model_Method_Abstract::validate();

        $payment = $this->getInfoInstance();
        if (($this->getIbanOnly() || $payment->getData('cc_type')) && $payment->getData('cc_number')) {
            $this->_validateBankdata();
        }

        if (($this->getIbanOnly() || $payment->getData('cc_type')) && $payment->getData('cc_number')) {
            $payment->setCcNumberEnc($payment->encrypt($payment->getCcNumber()));
            $mandate = $this->getMandateWithChanges($payment);

            $payment->setAdditionalInformation('mandate_reference', $mandate->getReference());
            $payment->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandate->getReference());
        } else {
            $customer = $this->getCustomer();
            $ref = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
            if ($ref) {
                $mandate = $this->_getMandate($ref);
                if ($mandate) {
                    if (($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFFREIGABEWARTEND)
                        || ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFUNTERSCHRIFTWARTEND)
                    ) {
                        Mage::throwException(Mage::helper('sepadebitsax')->__('Your SEPA Mandate is still waiting for signig!'));
                    }
                }
            }
        }
    }


    /**
     * Mandate zurückgeben evt. mit Änderungen
     *
     * @param Egovs_Paymentbase_Model_Paymentbase $payment Payment
     *
     * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
     */
    protected function getMandateWithChanges($payment) {
        $customer = $this->getCustomer();

        $ref = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
        $has_changed = Egovs_SepaDebitSax_Model_Webservice_Types_Mandat::MANDATE_CHANGE_NEW;
        if ($ref) {
            $mandate = $this->_getMandate($ref);
            if ($mandate) {
                //hat sich was verändert?
                $has_changed = $mandate->hasChanged($payment);
            } else {
                $customer->unsetData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
            }
        }

        if ($has_changed == Egovs_SepaDebitSax_Model_Webservice_Types_Mandat::MANDATE_CHANGE_NEW) {
            $mandate = $this->createNewAdapterMandate();
            $mandate->importData($payment, NULL, $this->getAllowOneoff(), NULL);
            $mandate = $this->_constructSepaMandate($mandate, $payment);
            $mandate = $this->createSepaMandate($mandate);
            $customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandate->getReference());
            if ($customer->getId() > 0) {
                /* @var $resource Mage_Customer_Model_Resource_Customer */
                $resource = $customer->getResource();
                $resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
            }

            $adr = Mage::getStoreConfig('payment/sepadebitsax/adr_mandatsverwaltung');
            $message = Mage::helper('sepadebitsax')->__("You will get a new SEPA Mandate via email. Please subscribe and send it back to %s", $adr);
            Mage::getSingleton('checkout/session')->addUniqueMessages(Mage::getModel('core/message_notice', $message));

            Mage::helper('paymentbase')->changeAdditionalCustomerMandateData($this->getCustomer(), array("new_mandate" => $mandate->getReference()));

        } elseif ($has_changed == Egovs_SepaDebitSax_Model_Webservice_Types_Mandat::MANDATE_CHANGE_ACCOUNT) {
            $old = $mandate;
            $mandate = $this->createNewAdapterMandate();
            $mandate->importData($payment, NULL, $this->getAllowOneoff(), NULL);
            $mandate = $this->_constructSepaMandate($mandate, $payment);
            $mandate = $this->createSepaMandate($mandate);
            $customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandate->getReference());
            if ($customer->getId() > 0) {
                /* @var $resource Mage_Customer_Model_Resource_Customer */
                $resource = $customer->getResource();
                $resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
            }

            Mage::helper('paymentbase')->changeAdditionalCustomerMandateData($this->getCustomer(), array("new_mandate" => $mandate->getReference()));

            $old->DatumNachfolgemandat = $mandate->getAdapteeMandate()->DatumErstellung;
            $this->closeMandate($old);
            $adr = Mage::getStoreConfig('payment/sepadebitsax/adr_mandatsverwaltung');
            $message = Mage::helper('sepadebitsax')->__("You will get a new SEPA Mandate via email. Please subscribe and send it back to %s", $adr);
            Mage::getSingleton('checkout/session')->addUniqueMessages(Mage::getModel('core/message_notice', $message));
        } elseif ($has_changed == Egovs_SepaDebitSax_Model_Webservice_Types_Mandat::MANDATE_CHANGE) {
            $mandate->importData($payment, NULL, $this->getAllowOneoff(), NULL);
            $pdf = $this->__changeMandate($mandate, true);
            //mandate versenden
            if ($pdf) {
                $email = Mage::getModel('sepadebitsax/email');
                $email->setTemplate("payment/sepadebitsax/mandate_amendment_template");
                $email->send($this->getCustomer(), $pdf);
            }
        }

        if ($mandate) {
            $this->createSepaCustomerForPayment($mandate);
        }

        return $mandate;
    }

    public function closeMandate($mandate) {
        if ($mandate instanceof Egovs_SepaDebitSax_Model_Sepa_Mandate) {
            $mandate = $mandate->getAdapteeMandate();
        }

        if ($mandate->MandatStatus == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN) {
            return $this;
        }
        $mandate->MandatStatus = Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN;

        try {
            $this->__changeMandate($mandate, false);
        } catch (Egovs_SepaDebitSax_Model_SepaMvException $e) {
            switch ($e->getCode()) {
                case 1601:
                    //Das Mandat ist geschlossen. Geschlossenen Mandat können nicht geändert werden.
                    break;
                default:
                    Mage::helper("paymentbase")->sendMailToAdmin("Altes Mandat konnte nicht geschlossen werden. Referenz: " . $mandate->getReference() . "\n" . $e->getMessage());
            }
        } catch (Exception $ex) {
            Mage::helper("paymentbase")->sendMailToAdmin("Altes Mandat konnte nicht geschlossen werden. Referenz: " . $mandate->getReference());
        }
        return $this;
    }


    /**
     * Bezahlvorgang abwickeln, ein aktives Mandat ruft sofort abbuchenMitSEPAMandatMitBLP auf
     * ein neues! nicht aktives anlegenKassenzeichenMitSEPAMandatMitBLP
     *
     * @see Egovs_Paymentbase_Model_SepaDebit::_authorize($payment, $amount)
     */
    protected function _authorize(Varien_Object $payment, $amount) {
        // prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert, sonst anlegen
        //$this->createCustomerForPayment();

        // Fälligkeitsdatum berechnen
        $iDatumFaelligkeit = strtotime("+" . $this->getPayWithinXDays() . " days");

        // Objekt für Buchungsliste erstellen
        $objBuchungsliste = $this->createAccountingList($payment, $amount, NULL, date('c', $iDatumFaelligkeit));

        $mandateNeu = false;

        $mandate_ref = $payment->getAdditionalInformation('mandate_reference');
        /* @var $mandate Egovs_Paymentbase_Model_Sepa_Mandate_Interface */
        $mandate = $this->getMandate($mandate_ref);

        //prüfung ob Mandate aktiv bzw. neu
        if ($mandate->isActive()) {
            $mandateNeu = false;
            $this->_MandateIsActiv = true;

            //falls mandat aktiv ist die erste Bestellung schon durch
            if (!$mandate->isMultiPayment()) {

                Mage::throwException($this->__("Your SEPA Mandate can not used for multi payment. Please create a new one!"));
            }
        } elseif ($this->isMandatNew($payment)) {
            $mandateNeu = true;
        } else {
            Mage::helper('sepadebitsax')->getMandateStatusText($mandate, true);
        }

        try {
            $emandate = $mandate->convertToEPayBlMandate($this->_getECustomerId());
            $lieferadresse = NULL;
            $emandate->betrag = $amount;
            $EShopTransaktionsNr = substr(md5($this->getCustomer()->getId() . "_" . time()), 0, 30);
            $objBuchungsliste->EShopTransaktionsNr = $EShopTransaktionsNr;
            $BLP = $this->getBuchungsListeParameter($payment, $amount);


            $objResult = NULL;

            if ($mandateNeu) {
                $objResult = $this->_getSoapClient()->anlegenKassenzeichenMitSEPAMandatMitBLP($this->_getECustomerId(), $emandate, $lieferadresse, $objBuchungsliste, $BLP);
            } else {
                $objResult = $this->_getSoapClient()->abbuchenMitSEPAMandatMitBLP($this->_getECustomerId(), $emandate, $objBuchungsliste, $BLP);
            }

        } catch (Exception $e) {
            Mage::log($e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
        }

        if ($mandateNeu) {
            $this->validateSoapResult($objResult, $objBuchungsliste, 'anlegenKassenzeichenMitSEPAMandatMitBLP');
        } else {
            $this->validateSoapResult($objResult, $objBuchungsliste, 'abbuchenMitSEPAMandatMitBLP');
        }


        //das kassenzeichen sollte erst abgeholt werden wenn das ergebniss geprueft wurde
        $payment->setData('kassenzeichen', $objResult->buchungsListe->kassenzeichen);
        $payment->setData(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_ESHOP_TRANSACTION_ID, $EShopTransaktionsNr);
        $payment->setData(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_SEPA_MATURITY, $objResult->buchungsListe->faelligkeitsdatum);
        $payment->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandate_ref);

        //das Flag das es sich um einen neues Mandat handelt wird wieder entfernt
        Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($this->getCustomer(), "new_mandate");

        //für den Fall, dass es ein neuse Mandat war wird die Referenz für capture gemerkt
        if ($mandateNeu) {
            $payment->setAdditionalInformation('pending_mandate', $mandate_ref);
        }

        //Rechnung anlegen
        $order = $payment->getOrder();
        if ($order) {
            $invoice = $order->prepareInvoice();
            $invoice->register();
            $order->addRelatedObject($invoice);
            $invoice->setOrder($order);
            $invoice->setState(Mage_Sales_Model_Order_Invoice::STATE_OPEN);
            if (!$mandateNeu) {
                $invoice->capture();
            }
        }

        if (!$mandateNeu) {
            $this->_preNotification($order, $payment, $mandate_ref, $mandate);
        }

        return $this;
    }


    /**
     * Invoke in Mage_Sales_Model_Order_Payment
     * Required for the initialize() callback to happen
     *
     * @return string
     */
    public function getConfigPaymentAction() {
        return 'init'; //set flag to initialize $this after order is created and the payment is placed
    }


    public function isInitializeNeeded() {
        return true;
    }


    /**
     * Status der Order setzten
     *
     * @see Mage_Payment_Model_Method_Abstract::initialize()
     */
    public function initialize($paymentAction, $stateObject) {
        if ($paymentAction != self::ACTION_AUTHORIZE) {
            Mage::throwException(
                Mage::helper($this->getCode())->__('This payment action is not available!') . ' Action: ' . $paymentAction
            );
        }
        $payment = $this->_getPayment();

        $order = $payment->getOrder();

        $orderState = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;


        $this->authorize($this->_getPayment(), $order->getBaseTotalDue());

        $this->setAmountAuthorized($order->getTotalDue());
        $this->setBaseAmountAuthorized($order->getBaseTotalDue());
        if ($this->_MandateIsActiv) {
            $orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
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
     * Überprüfen ob das Mandate aktiv ist
     *
     * @see Mage_Payment_Model_Method_Abstract::canCapture()
     */
    public function canCapture() {

        //falls schon geladen in Checkout
        if ($this->_MandateIsActiv) {
            return true;
        }

        //sonst neu laden
        $mandate_ref = $this->_getPayment()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
        $mandate = $this->_getMandate($mandate_ref);

        if (!$mandate) {
            return false;
        }

        return $mandate->isActive();
    }


    /**
     * Capture
     *
     * Der State wird hier auf "Verarbeitung geändert"
     *
     * @param Varien_Object $payment Payment
     * @param float         $amount  Betrag
     *
     * @return Egovs_Debit_Model_Debit
     *
     * @see Mage_Payment_Model_Method_Abstract::capture()
     */
    public function capture(Varien_Object $payment, $amount) {
        $mandate_ref = $payment->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
        if (!$mandate_ref) {
            throw new Exception($this->__('No Mandate available'));
        }

        $mandate = $this->_getMandate($mandate_ref);
        /* @var $order Mage_Sales_Model_Order */
        $order = $payment->getOrder();
        if (!$mandate->isActive()) {
            $status = $mandate->MandatStatus;
            if (($status == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN)
                || ($status == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT)) {

                /* @var $invoice Mage_Sales_Model_Order_Invoice */
                foreach ($order->getInvoiceCollection() as $invoice) {
                    if ($invoice->getState() != Mage_Sales_Model_Order_Invoice::STATE_OPEN) {
                        continue;
                    }
                    $invoice->cancel()
                        ->save();

                }
                $msg = Mage::helper('sepadebitsax')->__("Order was canceled by SEPA Mandate status.");
                $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED, $msg, false);
                $order->cancel();
                $order->save();
                throw new Exception($msg, self::SEPA_MANDATE_EXCEPTION_CODE_CANCEL);
            }
            $msg = $this->__("Mandate is not yet activated");
            $order->addStatusToHistory($order->getStatus(), $msg, false);
            throw new Exception($msg, self::SEPA_MANDATE_EXCEPTION_CODE_INACTIVE);
        }

        parent::capture($payment, $amount);


        if ($this->isMandatPending($payment)) {
            if ($this->__aktivierenKassenzeichen($payment)) {
                /* @var $order Mage_Sales_Model_Order */
                $order = $payment->getOrder();

                $state = Mage_Sales_Model_Order::STATE_PROCESSING;

                $order->setState($state, $state, $this->__('Cash mark activated'), false);

                if ($payment->hasAdditionalInformation('pending_mandate')) {
                    $payment->unsAdditionalInformation('pending_mandate');
                    $payment->save();
                }

            }
        }

        return $this;
    }


    public function isMandatNew($payment = NULL) {
        if ($payment == NULL) {
            $payment = $this->_getPayment();
        }
        $mandate_ref = $payment->getAdditionalInformation('mandate_reference');
        $customer = $this->getCustomer();

        return (Mage::helper('paymentbase')->getAdditionalCustomerMandateData($customer, "new_mandate") == $mandate_ref);
    }

    /**
     * Feststellen ob die Bezahlung noch vervollständigt werden muss
     *
     * @param string $payment Payment
     *
     * @return boolean
     */
    public function isMandatPending($payment = NULL) {

        if ($payment == NULL) {
            $payment = $this->_getPayment();
        }

        $mandate_ref = $payment->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
        return ($payment->getAdditionalInformation('pending_mandate') == $mandate_ref);
    }


    /**
     * Kunde wird nicht gelöscht
     *
     * return boolean true
     *
     * @see Egovs_Paymentbase_Model_Abstract::loeschenKunde()
     */
    public function loeschenKunde() {
        //kunde wird nicht gelöscht
        return true;
    }


    public function getPayWithinXDays($storeId = NULL) {
        return intval($this->getConfigData('paywithinxdays', $storeId));
    }


    protected function _getReferencedInformation($mandate) {
        if (!$this->getIsInternalManagement()) {
            return $this;
        }

        return $this;
    }

    /**
     * das temporäre Kassenzeichen an der ePayBl aktivieren
     * und eine Notification an Mandatsverwaltung und Kunden schicken
     *
     * @param Varien_Object $payment
     * @param string        $mandate
     *
     * @return boolean
     */
    private function __aktivierenKassenzeichen(Varien_Object $payment, $mandate = NULL) {
        $mandate_ref = $payment->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
        $EPaymentId = $payment->getData(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_ESHOP_TRANSACTION_ID);

        $wId = sprintf('%s/%s', Mage::helper('paymentbase')->getBewirtschafterNr(), $payment->getKassenzeichen());

        try {
            if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
                $soapFunction = 'aktiviereTempKassenzeichen';
                $objResult = $this->_getSoapClient()
                    ->aktiviereTempKassenzeichen($wId, $EPaymentId, "SEPASDD");
            } else {
                $soapFunction = 'aktiviereTempKreditkartenKassenzeichen';
                $objResult = $this->_getSoapClient()
                    ->aktiviereTempKreditkartenKassenzeichen($wId, '', $EPaymentId, "SEPASDD");
            }
        } catch (Exception $e) {
            Mage::log($e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            throw $e;
        }
        $this->_parseError($objResult, $objResult, $soapFunction);

        if (!$objResult || !isset($objResult->istOk) || $objResult->istOk != true) {
            Mage::throwException("$soapFunction unknown Error");
        }

        $mandateMaturityDate = $payment->getData(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_SEPA_MATURITY);

        try {
            $objResult = $this->_getSoapClient()
                ->lesenTransaktion($EPaymentId);
        } catch (Exception $e) {
            Mage::log($e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            throw $e;
        }
        $this->_parseError($objResult, $objResult->ergebnis, "lesenTransaktion");

        $epayBlMaturityDate = $objResult->buchungsListe->faelligkeitsdatum;

        //Datum für Fälligkeit vergleichen
        $alt = date("d.m.Y", strtotime($mandateMaturityDate));
        $neu = date("d.m.Y", strtotime($epayBlMaturityDate));

        $order = Mage::getModel('sales/order')->load($payment->getParentId());

        $payment->setAmountAuthorized($order->getTotalDue());
        $payment->setBaseAmountAuthorized($order->getBaseTotalDue());
        $payment->save();

        $payment->setData(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_SEPA_MATURITY, $epayBlMaturityDate);

        $this->_preNotification($order, $payment, $mandate_ref, $mandate);

        return true;
    }

    protected function _preNotification($order, $payment, $mandate_ref, $mandate = NULL) {
        $amount = $payment->getBaseAmountOrdered();
        $MaturityDate = $payment->getData(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_SEPA_MATURITY);
        try {
            $faellig = date("c", strtotime($MaturityDate));
            $kz = "Kassenzeichen: " . $payment->getData('kassenzeichen');
            $best = "Bestellung: " . $payment->getOrder()->getIncrementId();
            $objResult = Mage::helper('sepadebitsax')->getZmvSoapClient()->AnlegenSEPAPreNotificationMitPDF($this->_getIdentifierzierung(), $mandate_ref, $amount, $faellig, $kz, $best, $this->_getAgent());
        } catch (Exception $e) {
            Mage::log($e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
        }

        if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult) {
            if ($objResult->getResult()->getResultCode()->getCode() != 0) {

                Mage::helper('sepadebitsax')->getZmvSoapClient()->saveError();
            }
        }
        if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result) {
            $msg = $objResult->getResult()->getResultCode()->getDescription();
            Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            Mage::helper('sepadebitsax')->getZmvSoapClient()->saveError();

        }

        $date = Mage::app()->getLocale()->date(strtotime($faellig), NULL, NULL, true);
        $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $date = $date->toString($format);

        $_glaeubigerId = Mage::helper('sepadebitsax')->getRealGlaeubigerId();

        $email = Mage::getModel('sepadebitsax/email');
        $email->addTemplateVar('order', $payment->getOrder());
        $email->addTemplateVar('glaeubiger_id', $_glaeubigerId);

        $email->addTemplateVar('mandate_reference', $mandate_ref);
        $email->addTemplateVar('iban', Mage::helper('sepadebitsax')->maskValue($payment->getccNumber()));
        if (!$this->getIbanOnly()) {
            $email->addTemplateVar('bic', Mage::helper('sepadebitsax')->maskValue($payment->getCcType()));
        }
        $email->addTemplateVar('betrag', $payment->getOrder()->formatPrice($amount));
        $email->addTemplateVar('faellig', $date);
        try {
            $email->send($payment->getOrder()->getCustomerId(), $objResult->PreNotificationPdf);
        } catch (Exception $e) {
            Mage::logException($e);
            $sMailText = sprintf("Exception:\n%s\n\n", $e->getMessage());
            $sMailText .= sprintf(
                "Mandatsreferenz: %s\nBestellung: %s (ID: %s)",
                $mandate_ref, $payment->getOrder()->getIncrementId(), $payment->getOrder()->getId()
            );
            Mage::helper("paymentbase")->sendMailToAdmin(
                "Fehler beim Senden der SEPA Prenotification:\n\n" . $sMailText,
                "Senden der SEPA Prenotification fehlgeschlagen"
            );
        }

        $comment = Mage::helper('paymentbase')->__('SEPA Mandate Maturity Date has been changed to %s.', $date);

        $order->addStatusToHistory(
            $order->getStatus(),
            $comment,
            true
        );

        $order->save();

        return $this;
    }

    /**
     * Fehler der EPayBl auswerten
     *
     * @param SOAP_Value        $objResult    Result von ePayBL
     * @param SoapFault|SoapVar $ergebnis     Ergebnis von ePayBL
     * @param string            $soapFunction SOAP-Funktion
     *
     * @return void
     * @throws Exception
     */
    protected function _parseError($objResult, $ergebnis, $soapFunction = "aktivierenKassenzeichen") {
        if (!$objResult
            || is_null($objResult)
            || $objResult instanceof SoapFault
            || (isset($ergebnis) && ($ergebnis->istOk != true))
        ) {
            // Mail an Webmaster senden
            $sMailText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
            $sMailText .= sprintf("Shop Name: %s\n", Mage::getStoreConfig('general/imprint/shop_name'));
            $sMailText .= sprintf("Store Name: %s\n", Mage::getStoreConfig('general/store_information/name'));

            $sMailText .= "Order #: {$this->_getOrder()->getIncrementId()}\n";

            if ($objResult instanceof SoapFault) {
                $sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
            } else {
                $sMailText .= Mage::helper('paymentbase')->getErrorStringFromObjResult($ergebnis);
            }
            Mage::helper("paymentbase")->sendMailToAdmin("Fehler in WebService-Funktion: $soapFunction\n\n" . $sMailText);

            Mage::log("Fehler in WebService-Funktion: $soapFunction\n" . $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            Mage::throwException(Mage::helper('paymentbase')->__('ERROR_STANDARD'));
        }
    }

    /**
     * ePayBL Kunden erzeugen
     *
     * @param Varien_Object $data An object with the customers data
     *
     * @return boolean
     *
     * @see Egovs_Paymentbase_Model_Abstract::createCustomerForPayment($data)
     * @see Egovs_Paymentbase_Model_SepaDebit::createCustomerForPayment()
     */
    public function createCustomerForPayment($data = NULL) {
        if (empty($data)) {
            Mage::log($this->getCode() . '::Include personal data for customers', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            $objRechnungsAdresse = new Egovs_Paymentbase_Model_Webservice_Types_Adresse();
            $debitormadr = $this->_extractDebitorAddress();
            $objRechnungsAdresse->setCity($debitormadr->getCity());
            $objRechnungsAdresse->setCountry($debitormadr->getCountry());
            $objRechnungsAdresse->setStreet($debitormadr->getStreet());
            $objRechnungsAdresse->setZip($debitormadr->getZip());
            $objRechnungsAdresse->setPostofficeBox($debitormadr->getPostofficeBox());

            /*
             * Der Kunde soll mit einem Kompletten Datensatz zur Mahnung angelegt werden
            */
            $data = new Varien_Object();
            $errors = array();
            $address = $this->_getBillingAddress();

            try {
                $data = Mage::helper($this->getCode())->extractCustomerInformation($address);
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (!empty($errors)) {
                $errors = implode('<br/>', $errors);
                Mage::throwException($errors);
            }

            $data->setInvoiceAddress($objRechnungsAdresse);
        }
        $eId = $this->_getECustomerId();
        return Mage::helper('paymentbase')->createCustomerForPayment($eId, $data);
    }


    public function createSepaCustomerForPayment($mandate) {
        $data = new Varien_Object();
        $errors = array();

        $address = $this->_getBillingAddress();

        try {
            $data = Mage::helper($this->getCode())->extractCustomerInformation($address);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }

        //if(!$mandate->getAccountholderDiffers())
        {

            $bv = Mage::getModel('paymentbase/webservice_types_bankverbindung');
            $bv->setIban($mandate->getBankingAccount()->getIban());
            if (!$this->getIbanOnly()) {
                $bv->setBic($mandate->getBankingAccount()->getBic());
            }
            $bv->kontoinhaber = utf8_decode($mandate->getAccountholderFullname());
            $data->setBankverbindung($bv);
        }

        $objRechnungsAdresse = Mage::getModel('paymentbase/webservice_types_adresse');
        $debitormadr = $this->_extractDebitorAddress();
        $objRechnungsAdresse->setCity(utf8_decode($debitormadr->getCity()));
        $objRechnungsAdresse->setCountry(utf8_decode($debitormadr->getCountry()));
        $objRechnungsAdresse->setStreet(utf8_decode($debitormadr->getStreet()));
        $objRechnungsAdresse->setZip($debitormadr->getZip());
        $objRechnungsAdresse->setPostofficeBox($debitormadr->getPostofficeBox());


        if (!empty($errors)) {
            $errors = implode('<br/>', $errors);
            Mage::throwException($errors);
        }

        $data->setInvoiceAddress($objRechnungsAdresse);

        $eId = $this->_getECustomerId();
        return Mage::helper('paymentbase')->createCustomerForPayment($eId, $data);
    }


    /**
     * Mandat an der Mandatsverwaltung ändern
     *
     * @param Egovs_Paymentbase_Model_Sepa_Mandate $mandate   Mandat
     * @param boolean                              $Amendment | soll ein Amendment erstellt werden
     *
     * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
     */
    private function __changeMandate($mandate, $Amendment = true) {
        $objResult = NULL;
        $eMsg = "Mandat konnte nicht geändert werden!";
        $e = NULL;

        if ($mandate instanceof Egovs_SepaDebitSax_Model_Sepa_Mandate) {
            $_mandate = $mandate->getAdapteeMandate();
        } else {
            $_mandate = $mandate;
        }

        if ($Amendment) {
            try {
                $objResult = Mage::helper('sepadebitsax')->getZmvSoapClient()->AendernSEPAKreditorenMandatMitAmendmentMitPDF($this->_getIdentifierzierung(), $_mandate, $this->_getAgent());
            } catch (Exception $e) {
                Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                Mage::logException($e);
            }
            if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult) {
                if ($objResult->getResult()->getResultCode()->getCode() == 0) {
                    //$mandate = $objResult->getMandat();
                    return $objResult->MandatPdf;
                }
            }
        } else {
            try {
                $objResult = Mage::helper('sepadebitsax')->getZmvSoapClient()->AendernSEPAMandat($this->_getIdentifierzierung(), $_mandate, $this->_getAgent());
            } catch (Exception $e) {
                Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                Mage::logException($e);
            }
            if ($objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAMandatResult) {
                if ($objResult->getResult()->getResultCode()->getCode() == 0) {
                    //$mandate = $objResult->getMandat();
                    return NULL;//$mandate;
                }
            }
        }
        Mage::helper('sepadebitsax')->getZmvSoapClient()->saveError();
        if (
            $objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult ||
            $objResult instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAMandatResult
        ) {
            $eMsg = $objResult->getResult()->getResultCode()->getDescription();
            $code = $objResult->getResult()->getResultCode()->getCode();
            $code = intval($code);
            throw new Egovs_SepaDebitSax_Model_SepaMvException($eMsg, $code, $e);
        }

        Mage::throwException($eMsg);
    }


    /**
     * Liefert ein eCustomer Objekt falls vorhanden.
     *
     * @return Egovs_Paymentbase_Model_Webservice_Types_Kunde|null
     *
     * @see Egovs_Paymentbase_Helper_Data::createCustomerForPayment
     * @see Egovs_Paymentbase_Helper_Data::getCustomerFromEPayment
     */
    public function getECustomer() {
        $cust = Mage::helper('paymentbase')->getECustomer();

        //mandta REferenz am Kunden löschen
        $cust->sepaMandatReferenz = NULL;

        return $cust;
    }


    /**
     * Liefert die Einstellung ob OOFF erlaubt ist.
     *
     * @return boolean
     */
    public function getAllowOneoff() {
        return Mage::getStoreConfig('payment/sepadebitsax/allow_ooff') == 0 ? false : true;
    }

    public function getCreditorId() {
        if (is_null($this->_creditorId)) {
            $this->_creditorId = Mage::getStoreConfig('payment/sepadebitsax/creditor_id');
        }

        return $this->_creditorId;
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
}