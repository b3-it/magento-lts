<?php

/**
 * Class Egovs_SepaDebitSax_Helper_Data
 *
 * @category  Egovs
 * @package   Egovs_SepaDebitSax
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2013 - 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitSax_Helper_Data extends Egovs_Paymentbase_Helper_Data
{

    const ATTRIBUTE_ESHOP_TRANSACTION_ID = 'eshop_transaction_id';
    const ATTRIBUTE_SEPA_MATURITY = 'maturity';


    /**
     * Soap Client Instance
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Soap_Service
     */
    private $__objZmvSoapClient = NULL;

    /**
     * Ist Mandatsverwaltung verfügbar?
     *
     * @return Egovs_Paymentbase_Helper_Data
     *
     * @throws Egovs_SepaDebitSax_Model_SepaMvException
     * @throws Exception
     */
    public function isZmvAlive() {
        // Webservice aufrufen
        $objResult = NULL;
        $code = 'sepadebitsax';

        try {
            /* @var $objResult Egovs_SepaDebitSax_Model_Webservice_Types_Result_IsAliveResult */

            $identity = $this->getIdentifierzierung();
            $objResult = $this->getZmvSoapClient()->isAlive($identity);
        } catch (Exception $e) {
            Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            throw $e;
        }

        // wenn Fehler
        if (!$objResult || $objResult instanceof SoapFault || $objResult->getResult()->getResultCode()->getCode() != 0) {
            $sErrorText = "Während der Kommunikation mit dem Mandats-Server trat folgender Fehler auf:\n\n";
            if ($objResult instanceof SoapFault) {
                $sErrorText .= "SOAP: " . $objResult->getMessage() . "\n\n";
            } elseif (!$objResult) {
                $sErrorText .= $this->__("Error: Couldn't check status of mandate server, no result returned!") . "\n";
            } else {
                $result = $objResult->getResult();
                $sErrorText .= "Code: {$result->getResultCode()->getCode()}\n";
                $sErrorText .= "State: {$result->getResultState()}\n";
                $sErrorText .= "Beschreibung: {$result->getResultCode()->getDescription()}\n";
                throw new Egovs_SepaDebitSax_Model_SepaMvException("Der Server der Mandatsverwaltung ist erreichbar, lieferte aber folgende Fehlermeldung: " . $sErrorText);
            }

            Mage::log("$code::Fehler in WebService-Funktion: 'isAlive'\n" . $sErrorText, 3, Egovs_Helper::EXCEPTION_LOG_FILE);
            throw new Exception("$code::Fehler in WebService-Funktion: 'isAlive'\n" . $sErrorText);

        }

        Mage::log("$code::{$this->__('Mandate management server is alive')}", 3, Egovs_Helper::LOG_FILE);

        return $this;
    }

    /**
     * Identifiziereung aus Konfiguration erstellen
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
     */
    public function getIdentifierzierung() {
        $_konzernname = Mage::getStoreConfig('payment_services/sepadebitsax/enterprisename');
        $_glaeubigerId = Mage::getStoreConfig('payment/sepadebitsax/creditor_id');
        $_geschaeftsbereichskennung = Mage::getStoreConfig('payment/sepadebitsax/business_unit_id');
        $_geschaeftsbereichsId = new  Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId($_glaeubigerId, $_geschaeftsbereichskennung);
        $identity = new Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung($_konzernname, $_geschaeftsbereichsId);
        return $identity;
    }

    /**
     * Gibt den existierenten SOAP-Client zurück oder erstellt ihn neu.
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Soap_Service client
     *
     * @see Egovs_Paymentbase_Model_Webservice_PaymentServices
     * @throws \Mage_Core_Exception
     */
    public function getZmvSoapClient() {
        if (!$this->__objZmvSoapClient) {
            try {
                //Damit Service überladbar wird
                $this->__objZmvSoapClient = Mage::getSingleton('sepadebitsax/webservice_soap_service');
            } catch (Exception $e) {
                throw $e;
            }
            if (!($this->__objZmvSoapClient instanceof Egovs_SepaDebitSax_Model_Webservice_WsdlClass)) {
                Mage::log("sepadebitsax::Can't initiate SoapClient! See log for further information.", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                Mage::throwException($this->__("Internal server error occurred, please try again later."));
            }
        }

        return $this->__objZmvSoapClient;
    }

    public function getAgent() {
        return Mage::getStoreConfig('payment_services/sepadebitsax/agent_id');

    }

    /**
     * Die wirkliche Gläubiger Id ohne Platzhalter
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
     */
    public function getRealGlaeubigerId() {
        $_glaeubigerId = Mage::getStoreConfig('payment/sepadebitsax/creditor_id');
        $_geschaeftsbereichskennung = Mage::getStoreConfig('payment/sepadebitsax/business_unit_id');
        $res = substr_replace($_glaeubigerId, $_geschaeftsbereichskennung, 4, 3);
        return $res;
    }


    /**
     * Fehler text für Mandatsstatus ermitteln
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $mandate
     * @param boolean                                          $throwError soll ein Fehler geworfen werden oder der
     *                                                                     Text zurückgegeben werden
     *
     * @throws Egovs_Paymentbase_Exception_Validation
     * @throws \Mage_Core_Exception
     * @return string
     */
    public function getMandateStatusText($mandate, $throwError = false) {
        //Fallback falls aktiv
        if ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AKTIV) {
            return "";
        }

        /* @var $mandate Egovs_SepaDebitSax_Model_Webservice_Types_Mandat */
        if ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFUNTERSCHRIFTWARTEND) {
            $message = $this->__("Your SEPA Mandate is still waiting for signig!");

            if ($throwError) {
                Mage::throwException($message);
            } else {
                return $message;
            }
        }
        if ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT) {
            $message = $this->__("Your SEPA Mandate is canceled! Please create a new one.");

            if ($throwError) {
                throw new Egovs_Paymentbase_Exception_Validation ($message);
            }

            return $message;
        }

        if ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN) {
            $message = $this->__("Your SEPA Mandate is canceled! Please create a new one.");

            if ($throwError) {
                throw new Egovs_Paymentbase_Exception_Validation ($message);
            }

            return $message;
        }

        $message = $this->__("Your SEPA Mandate is not available at the moment! Please contact the Webshop Owner");

        if ($throwError) {
            Mage::throwException($message);
        } else {
            return $message;
        }
    }


    public function maskValue($value) {
        if (!is_string($value)) {
            return $value;
        }

        if (strlen($value) > 4) {
            $_visible = 4;
        } else {
            $_visible = 1;
        }
        $_aS = str_split($value);
        for ($i = 0; $i < strlen($value) - $_visible; $i++) {
            $_aS[$i] = '*';
        }
        $value = implode('', $_aS);
        return $value;
    }
}