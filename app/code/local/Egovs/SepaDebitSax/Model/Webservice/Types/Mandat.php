<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
 *
 * @package    SepaMv
 * @subpackage Structs
 * @date       2014-03-12
 * @author     Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version    0.9.0.0
 */

/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Mandat originally named WSMandat
 * Documentation : Mandat
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 *
 * @category       Egovs
 * @package        Egovs_SepaDebitSax
 * @author         Holger Kögel <h.koegel@b3-it.de>
 * @author         Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      Copyright (c) 2013 - 2018 B3 IT System GmbH <hhtps://www.b3-it.de>
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @version        0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
    extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
    implements Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
{

    //für die Überprüfung ob sich ein Mandat geändert hat
    const MANDATE_CHANGE_NONE = 0;    //keine Änderung
    const MANDATE_CHANGE_ACCOUNT = 1; //neues Mandat
    const MANDATE_CHANGE = 2;    //nur Ändern
    const MANDATE_CHANGE_NEW = 3; //neues Mandat


    public $eShopKundenNr = NULL;

    /**
     * The MandatStatus
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus
     */
    public $MandatStatus = Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFUNTERSCHRIFTWARTEND;
    /**
     * The Mandatsreferenz
     *
     * @var string
     */
    public $Mandatsreferenz;
    /**
     * The MandatsTyp
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp
     */
    public $MandatsTyp = Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_CORE;
    /**
     * The SequenzTyp
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp
     */
    public $SequenzTyp = Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_RCUR;
    /**
     * The Kategorie
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie
     */
    public $Kategorie;
    /**
     * The PruefStatus
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus
     */
    public $PruefStatus;
    /**
     * The Geschaeftsbereichkennung
     *
     * @var string
     */
    public $Geschaeftsbereichkennung;
    /**
     * The KreditorName
     *
     * @var string
     */
    public $KreditorName;
    /**
     * The KreditorVorname
     *
     * @var string
     */
    public $KreditorVorname;
    /**
     * The KreditorAdresse
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public $KreditorAdresse;
    /**
     * The KreditorBankverbindung
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public $KreditorBankverbindung;
    /**
     * The KreditorGlaeubigerId
     *
     * @var string
     */
    public $KreditorGlaeubigerId;
    /**
     * The DebitorName
     *
     * @var string
     */
    public $DebitorName;
    /**
     * The DebitorVorname
     *
     * @var string
     */
    public $DebitorVorname;
    /**
     * The DebitorAdresse
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public $DebitorAdresse;
    /**
     * The DebitorBankverbindung
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public $DebitorBankverbindung;
    /**
     * The DatumUnterschrift
     *
     * @var dateTime
     */
    public $DatumUnterschrift;
    /**
     * The OrtUnterschrift
     *
     * @var string
     */
    public $OrtUnterschrift;
    /**
     * The AblageortOriginalmandat
     *
     * @var string
     */
    public $AblageortOriginalmandat;
    /**
     * The DebitorIstKontoinhaber
     *
     * @var boolean
     */
    public $DebitorIstKontoinhaber;
    /**
     * The KontoinhaberName
     *
     * @var string
     */
    public $KontoinhaberName;
    /**
     * The KontoinhaberVorname
     *
     * @var string
     */
    public $KontoinhaberVorname;
    /**
     * The KontoinhaberAdresse
     *
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public $KontoinhaberAdresse;
    /**
     * The NachfolgeMandatId
     *
     * @var float
     */
    public $NachfolgeMandatId;
    /**
     * The Bearbeiter
     *
     * @var string
     */
    public $Bearbeiter = 'Webshop';
    /**
     * The DatumStatusaenderung
     *
     * @var dateTime
     */
    public $DatumStatusaenderung;
    /**
     * The DatumLetzteFaelligkeit
     *
     * @var dateTime
     */
    public $DatumLetzteFaelligkeit;
    /**
     * The DatumKuendigung
     *
     * @var dateTime
     */
    public $DatumKuendigung;
    /**
     * The DatumLetzteAenderung
     *
     * @var dateTime
     */
    public $DatumLetzteAenderung;
    /**
     * The DatumErstellung
     *
     * @var dateTime
     */
    public $DatumErstellung;
    /**
     * The DatumNachfolgemandat
     *
     * @var dateTime
     */
    public $DatumNachfolgemandat;
    /**
     * The DatumLetzteNutzung
     *
     * @var dateTime
     */
    public $DatumLetzteNutzung;
    /**
     * The DatumPruefung
     *
     * @var dateTime
     */
    public $DatumPruefung;

    /**
     * Constructor method for WSMandat
     *
     * @see parent::__construct()
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus    $_mandatStatus
     * @param string                                                   $_mandatsreferenz
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp      $_mandatsTyp
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp      $_sequenzTyp
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie $_kategorie
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus     $_pruefStatus
     * @param string                                                   $_geschaeftsbereichkennung
     * @param string                                                   $_kreditorName
     * @param string                                                   $_kreditorVorname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse        $_kreditorAdresse
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_kreditorBankverbindung
     * @param string                                                   $_kreditorGlaeubigerId
     * @param string                                                   $_debitorName
     * @param string                                                   $_debitorVorname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse        $_debitorAdresse
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_debitorBankverbindung
     * @param dateTime                                                 $_datumUnterschrift
     * @param string                                                   $_ortUnterschrift
     * @param string                                                   $_ablageortOriginalmandat
     * @param boolean                                                  $_debitorIstKontoinhaber
     * @param string                                                   $_kontoinhaberName
     * @param string                                                   $_kontoinhaberVorname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse        $_kontoinhaberAdresse
     * @param float                                                    $_nachfolgeMandatId
     * @param string                                                   $_bearbeiter
     * @param dateTime                                                 $_datumStatusaenderung
     * @param dateTime                                                 $_datumLetzteFaelligkeit
     * @param dateTime                                                 $_datumKuendigung
     * @param dateTime                                                 $_datumLetzteAenderung
     * @param dateTime                                                 $_datumErstellung
     * @param dateTime                                                 $_datumNachfolgemandat
     * @param dateTime                                                 $_datumLetzteNutzung
     * @param dateTime                                                 $_datumPruefung
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
     */
    public function __construct($_mandatStatus = NULL, $_mandatsreferenz = NULL, $_mandatsTyp = NULL, $_sequenzTyp = NULL, $_kategorie = NULL, $_pruefStatus = NULL, $_geschaeftsbereichkennung = NULL, $_kreditorName = NULL, $_kreditorVorname = NULL, $_kreditorAdresse = NULL, $_kreditorBankverbindung = NULL, $_kreditorGlaeubigerId = NULL, $_debitorName = NULL, $_debitorVorname = NULL, $_debitorAdresse = NULL, $_debitorBankverbindung = NULL, $_datumUnterschrift = NULL, $_ortUnterschrift = NULL, $_ablageortOriginalmandat = NULL, $_debitorIstKontoinhaber = NULL, $_kontoinhaberName = NULL, $_kontoinhaberVorname = NULL, $_kontoinhaberAdresse = NULL, $_nachfolgeMandatId = NULL, $_bearbeiter = NULL, $_datumStatusaenderung = NULL, $_datumLetzteFaelligkeit = NULL, $_datumKuendigung = NULL, $_datumLetzteAenderung = NULL, $_datumErstellung = NULL, $_datumNachfolgemandat = NULL, $_datumLetzteNutzung = NULL, $_datumPruefung = NULL) {
        parent::__construct(array('MandatStatus' => $_mandatStatus, 'Mandatsreferenz' => $_mandatsreferenz, 'MandatsTyp' => $_mandatsTyp, 'SequenzTyp' => $_sequenzTyp, 'Kategorie' => $_kategorie, 'PruefStatus' => $_pruefStatus, 'Geschaeftsbereichkennung' => $_geschaeftsbereichkennung, 'KreditorName' => $_kreditorName, 'KreditorVorname' => $_kreditorVorname, 'KreditorAdresse' => $_kreditorAdresse, 'KreditorBankverbindung' => $_kreditorBankverbindung, 'KreditorGlaeubigerId' => $_kreditorGlaeubigerId, 'DebitorName' => $_debitorName, 'DebitorVorname' => $_debitorVorname, 'DebitorAdresse' => $_debitorAdresse, 'DebitorBankverbindung' => $_debitorBankverbindung, 'DatumUnterschrift' => $_datumUnterschrift, 'OrtUnterschrift' => $_ortUnterschrift, 'AblageortOriginalmandat' => $_ablageortOriginalmandat, 'DebitorIstKontoinhaber' => $_debitorIstKontoinhaber, 'KontoinhaberName' => $_kontoinhaberName, 'KontoinhaberVorname' => $_kontoinhaberVorname, 'KontoinhaberAdresse' => $_kontoinhaberAdresse, 'NachfolgeMandatId' => $_nachfolgeMandatId, 'Bearbeiter' => $_bearbeiter, 'DatumStatusaenderung' => $_datumStatusaenderung, 'DatumLetzteFaelligkeit' => $_datumLetzteFaelligkeit, 'DatumKuendigung' => $_datumKuendigung, 'DatumLetzteAenderung' => $_datumLetzteAenderung, 'DatumErstellung' => $_datumErstellung, 'DatumNachfolgemandat' => $_datumNachfolgemandat, 'DatumLetzteNutzung' => $_datumLetzteNutzung, 'DatumPruefung' => $_datumPruefung), false);
    }

    protected function _getParamLength($name) {
        switch ($name) {

            default:
                $length = 100;
        }

        return $length;
    }

    /**
     * Gibt die maximale Länge von Parameterwerten zurück.
     *
     * @param string $name Name
     *
     * @return int
     */
    public function getParamLength($name) {
        return $this->_getParamLength($name);
    }

    /**
     * Get MandatStatus value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus|null
     */
    public function getMandatStatus() {
        return $this->MandatStatus;
    }

    /**
     * Set MandatStatus value
     *
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::valueIsValid()
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus $_mandatStatus the MandatStatus
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus|bool
     */
    public function setMandatStatus($_mandatStatus) {
        if (!Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::valueIsValid($_mandatStatus)) {
            return false;
        }
        return ($this->MandatStatus = $_mandatStatus);
    }

    /**
     * Get Mandatsreferenz value
     *
     * @return string|null
     */
    public function getReference() {
        return $this->Mandatsreferenz;
    }

    /**
     * Set Mandatsreferenz value
     *
     * @param string $_mandatsreferenz the Mandatsreferenz
     *
     * @return string
     */
    public function setMandatsreferenz($_mandatsreferenz) {
        return ($this->Mandatsreferenz = $_mandatsreferenz);
    }

    /**
     * Get MandatsTyp value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp|null
     */
    public function getType() {
        return $this->MandatsTyp;
    }

    /**
     * Set MandatsTyp value
     *
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::valueIsValid()
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp $_mandatsTyp the MandatsTyp
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp|bool
     */
    public function setType($_mandatsTyp) {
        if (!Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::valueIsValid($_mandatsTyp)) {
            return false;
        }
        return ($this->MandatsTyp = $_mandatsTyp);
    }

    /**
     * Get SequenzTyp value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp|null
     */
    public function getSequenceType() {
        return $this->SequenzTyp;
    }

    /**
     * Set SequenzTyp value
     *
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::valueIsValid()
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp $_sequenzTyp the SequenzTyp
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp|bool
     */
    public function setSequenceType($_sequenzTyp) {
        if (!Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::valueIsValid($_sequenzTyp)) {
            return false;
        }
        return ($this->SequenzTyp = $_sequenzTyp);
    }

    /**
     * Get Kategorie value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie|null
     */
    public function getKategorie() {
        return $this->Kategorie;
    }

    /**
     * Set Kategorie value
     *
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::valueIsValid()
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie $_kategorie the Kategorie
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie|bool
     */
    public function setKategorie($_kategorie) {
        if (!Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::valueIsValid($_kategorie)) {
            return false;
        }
        return ($this->Kategorie = $_kategorie);
    }

    /**
     * Get PruefStatus value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus|null
     */
    public function getPruefStatus() {
        return $this->PruefStatus;
    }

    /**
     * Set PruefStatus value
     *
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::valueIsValid()
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus $_pruefStatus the PruefStatus
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus|bool
     */
    public function setPruefStatus($_pruefStatus) {
        if (!Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::valueIsValid($_pruefStatus)) {
            return false;
        }
        return ($this->PruefStatus = $_pruefStatus);
    }

    /**
     * Get Geschaeftsbereichkennung value
     *
     * @return string|null
     */
    public function getGeschaeftsbereichkennung() {
        return $this->Geschaeftsbereichkennung;
    }

    /**
     * Set Geschaeftsbereichkennung value
     *
     * @param string $_geschaeftsbereichkennung the Geschaeftsbereichkennung
     *
     * @return string
     */
    public function setGeschaeftsbereichkennung($_geschaeftsbereichkennung) {
        return ($this->Geschaeftsbereichkennung = $_geschaeftsbereichkennung);
    }

    /**
     * Get KreditorName value
     *
     * @return string|null
     */
    public function getKreditorName() {
        return $this->KreditorName;
    }

    /**
     * Set KreditorName value
     *
     * @param string $_kreditorName the KreditorName
     *
     * @return string
     */
    public function setKreditorName($_kreditorName) {
        return ($this->KreditorName = $_kreditorName);
    }

    /**
     * Get KreditorVorname value
     *
     * @return string|null
     */
    public function getKreditorVorname() {
        return $this->KreditorVorname;
    }

    /**
     * Set KreditorVorname value
     *
     * @param string $_kreditorVorname the KreditorVorname
     *
     * @return string
     */
    public function setKreditorVorname($_kreditorVorname) {
        return ($this->KreditorVorname = $_kreditorVorname);
    }

    /**
     * Get KreditorAdresse value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse|null
     */
    public function getKreditorAdresse() {
        return $this->KreditorAdresse;
    }

    /**
     * Set KreditorAdresse value
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_kreditorAdresse the KreditorAdresse
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function setKreditorAdresse($_kreditorAdresse) {
        return ($this->KreditorAdresse = $_kreditorAdresse);
    }

    /**
     * Get KreditorBankverbindung value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung|null
     */
    public function getKreditorBankverbindung() {
        return $this->KreditorBankverbindung;
    }

    /**
     * Set KreditorBankverbindung value
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_kreditorBankverbindung the KreditorBankverbindung
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public function setKreditorBankverbindung($_kreditorBankverbindung) {
        return ($this->KreditorBankverbindung = $_kreditorBankverbindung);
    }

    /**
     * Get KreditorGlaeubigerId value
     *
     * @return string|null
     */
    public function getCreditorId() {
        return $this->KreditorGlaeubigerId;
    }

    /**
     * Set KreditorGlaeubigerId value
     *
     * @param string $_kreditorGlaeubigerId the KreditorGlaeubigerId
     *
     * @return string
     */
    public function setCreditorId($_kreditorGlaeubigerId) {
        return ($this->KreditorGlaeubigerId = $_kreditorGlaeubigerId);
    }

    /**
     * Get DebitorName value
     *
     * @return string|null
     */
    public function getDebitorSurname() {
        return $this->DebitorName;
    }

    /**
     * Set DebitorName value
     *
     * @param string $_debitorName the DebitorName
     *
     * @return string
     */
    public function setDebitorSurname($_debitorName) {
        return ($this->DebitorName = $_debitorName);
    }

    /**
     * Get DebitorVorname value
     *
     * @return string|null
     */
    public function getDebitorName() {
        return $this->DebitorVorname;
    }


    public function getDebitorFullname() {
        return $this->getDebitorName() . " " . $this->getDebitorSurname();
    }

    /**
     * Set DebitorVorname value
     *
     * @param string $_debitorVorname the DebitorVorname
     *
     * @return string
     */
    public function setDebitorName($_debitorVorname) {
        return ($this->DebitorVorname = $_debitorVorname);
    }

    /**
     * Get DebitorAdresse value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse|null
     */
    public function getDebitorAddress() {
        return $this->DebitorAdresse;
    }

    /**
     * Set DebitorAdresse value
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_debitorAdresse the DebitorAdresse
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function setDebitorAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $_debitorAdresse) {
        return ($this->DebitorAdresse = $_debitorAdresse);
    }

    /**
     * Get DebitorBankverbindung value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung|null
     */
    public function getBankingAccount() {
        return $this->DebitorBankverbindung;
    }

    /**
     * Set DebitorBankverbindung value
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_debitorBankverbindung the DebitorBankverbindung
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public function setBankingAccount($_debitorBankverbindung) {
        return ($this->DebitorBankverbindung = $_debitorBankverbindung);
    }

    /**
     * Get DatumUnterschrift value
     *
     * @return dateTime|null
     */
    public function getDatumUnterschrift() {
        return $this->DatumUnterschrift;
    }

    /**
     * Set DatumUnterschrift value
     *
     * @param dateTime $_datumUnterschrift the DatumUnterschrift
     *
     * @return dateTime
     */
    public function setDatumUnterschrift($_datumUnterschrift) {
        return ($this->DatumUnterschrift = $_datumUnterschrift);
    }

    public function getDateSignedAsString() {
        return $this->getDatumUnterschrift();
    }

    public function setDateSignedAsString($date) {
        $this->setDatumUnterschrift($date);
    }

    /**
     * Get OrtUnterschrift value
     *
     * @return string|null
     */
    public function getLocationSigned() {
        return $this->OrtUnterschrift;
    }

    /**
     * Set OrtUnterschrift value
     *
     * @param string $_ortUnterschrift the OrtUnterschrift
     *
     * @return string
     */
    public function setLocationSigned($_ortUnterschrift) {
        return ($this->OrtUnterschrift = $_ortUnterschrift);
    }

    /**
     * Get AblageortOriginalmandat value
     *
     * @return string|null
     */
    public function getAblageortOriginalmandat() {
        return $this->AblageortOriginalmandat;
    }

    /**
     * Set AblageortOriginalmandat value
     *
     * @param string $_ablageortOriginalmandat the AblageortOriginalmandat
     *
     * @return string
     */
    public function setAblageortOriginalmandat($_ablageortOriginalmandat) {
        return ($this->AblageortOriginalmandat = $_ablageortOriginalmandat);
    }

    /**
     * Get DebitorIstKontoinhaber value
     *
     * @return boolean|null
     */
    public function getAccountholderDiffers() {
        return !$this->DebitorIstKontoinhaber;
    }

    /**
     * Set DebitorIstKontoinhaber value
     *
     * @param boolean $_debitorIstKontoinhaber the DebitorIstKontoinhaber
     *
     * @return boolean
     */
    public function setAccountholderDiffers($_debitorIstKontoinhaber) {
        return ($this->DebitorIstKontoinhaber = !$_debitorIstKontoinhaber);
    }

    /**
     * Get KontoinhaberName value
     *
     * @return string|null
     */
    public function getAccountholderSurname() {
        if ($this->getAccountholderDiffers()) {
            return $this->KontoinhaberName;
        }

        return $this->DebitorName;
    }

    /**
     * Set KontoinhaberName value
     *
     * @param string $_kontoinhaberName the KontoinhaberName
     *
     * @return string
     */
    public function setAccountholderSurname($_kontoinhaberName) {
        if ($this->getAccountholderDiffers()) {
            $this->KontoinhaberName = $_kontoinhaberName;
        } else {
            $this->DebitorName = $_kontoinhaberName;
        }
        return $this;
    }

    /**
     * Get KontoinhaberVorname value
     *
     * @return string|null
     */
    public function getAccountholderName() {
        if ($this->getAccountholderDiffers()) {
            return $this->KontoinhaberVorname;
        }

        return $this->DebitorVorname;
    }

    /**
     * Set KontoinhaberVorname value
     *
     * @param string $_kontoinhaberVorname the KontoinhaberVorname
     *
     * @return string
     */
    public function setAccountholderName($_kontoinhaberName) {

        if ($this->getAccountholderDiffers()) {
            $this->KontoinhaberVorname = $_kontoinhaberName;
        } else {
            $this->DebitorVorname = $_kontoinhaberName;
        }
        return $this;
    }


    public function getAccountholderFullname() {
        return $this->getAccountholderName() . " " . $this->getAccountholderSurname();
    }

    /**
     * Get KontoinhaberAdresse value
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse|null
     */
    public function getAccountholderAddress() {
        if ($this->getAccountholderDiffers()) {
            return $this->KontoinhaberAdresse;
        }
        return $this->getDebitorAddress();
    }

    /**
     * Set KontoinhaberAdresse value
     *
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_kontoinhaberAdresse the KontoinhaberAdresse
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function setAccountholderAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $_kontoinhaberAdresse) {
        return ($this->KontoinhaberAdresse = $_kontoinhaberAdresse);
    }

    /**
     * Get NachfolgeMandatId value
     *
     * @return float|null
     */
    public function getNachfolgeMandatId() {
        return $this->NachfolgeMandatId;
    }

    /**
     * Set NachfolgeMandatId value
     *
     * @param float $_nachfolgeMandatId the NachfolgeMandatId
     *
     * @return float
     */
    public function setNachfolgeMandatId($_nachfolgeMandatId) {
        return ($this->NachfolgeMandatId = $_nachfolgeMandatId);
    }

    /**
     * Get Bearbeiter value
     *
     * @return string|null
     */
    public function getBearbeiter() {
        return $this->Bearbeiter;
    }

    /**
     * Set Bearbeiter value
     *
     * @param string $_bearbeiter the Bearbeiter
     *
     * @return string
     */
    public function setBearbeiter($_bearbeiter) {
        return ($this->Bearbeiter = $_bearbeiter);
    }

    /**
     * Get DatumStatusaenderung value
     *
     * @return dateTime|null
     */
    public function getDatumStatusaenderung() {
        return $this->DatumStatusaenderung;
    }

    /**
     * Set DatumStatusaenderung value
     *
     * @param dateTime $_datumStatusaenderung the DatumStatusaenderung
     *
     * @return dateTime
     */
    public function setDatumStatusaenderung($_datumStatusaenderung) {
        return ($this->DatumStatusaenderung = $_datumStatusaenderung);
    }

    /**
     * Get DatumLetzteFaelligkeit value
     *
     * @return dateTime|null
     */
    public function getDatumLetzteFaelligkeit() {
        return $this->DatumLetzteFaelligkeit;
    }

    /**
     * Set DatumLetzteFaelligkeit value
     *
     * @param dateTime $_datumLetzteFaelligkeit the DatumLetzteFaelligkeit
     *
     * @return dateTime
     */
    public function setDatumLetzteFaelligkeit($_datumLetzteFaelligkeit) {
        return ($this->DatumLetzteFaelligkeit = $_datumLetzteFaelligkeit);
    }

    /**
     * Get DatumKuendigung value
     *
     * @return dateTime|null
     */
    public function getCancellationDate() {
        return $this->DatumKuendigung;
    }

    /**
     * Set DatumKuendigung value
     *
     * @param dateTime $_datumKuendigung the DatumKuendigung
     *
     * @return dateTime
     */
    public function setDatumKuendigung($_datumKuendigung) {
        return ($this->DatumKuendigung = $_datumKuendigung);
    }

    /**
     * Get DatumLetzteAenderung value
     *
     * @return dateTime|null
     */
    public function getDatumLetzteAenderung() {
        return $this->DatumLetzteAenderung;
    }

    /**
     * Set DatumLetzteAenderung value
     *
     * @param dateTime $_datumLetzteAenderung the DatumLetzteAenderung
     *
     * @return dateTime
     */
    public function setDatumLetzteAenderung($_datumLetzteAenderung) {
        return ($this->DatumLetzteAenderung = $_datumLetzteAenderung);
    }

    /**
     * Get DatumErstellung value
     *
     * @return dateTime|null
     */
    public function getDatumErstellung() {
        return $this->DatumErstellung;
    }

    /**
     * Set DatumErstellung value
     *
     * @param dateTime $_datumErstellung the DatumErstellung
     *
     * @return dateTime
     */
    public function setDatumErstellung($_datumErstellung) {
        return ($this->DatumErstellung = $_datumErstellung);
    }

    /**
     * Get DatumNachfolgemandat value
     *
     * @return dateTime|null
     */
    public function getDatumNachfolgemandat() {
        return $this->DatumNachfolgemandat;
    }

    /**
     * Set DatumNachfolgemandat value
     *
     * @param dateTime $_datumNachfolgemandat the DatumNachfolgemandat
     *
     * @return dateTime
     */
    public function setDatumNachfolgemandat($_datumNachfolgemandat) {
        return ($this->DatumNachfolgemandat = $_datumNachfolgemandat);
    }

    /**
     * Get DatumLetzteNutzung value
     *
     * @return dateTime|null
     */
    public function getDateOfLastUsage() {
        return $this->DatumLetzteNutzung;
    }

    /**
     * Set DatumLetzteNutzung value
     *
     * @param dateTime $_datumLetzteNutzung the DatumLetzteNutzung
     *
     * @return dateTime
     */
    public function setDateOfLastUsage($_datumLetzteNutzung) {
        return ($this->DatumLetzteNutzung = $_datumLetzteNutzung);
    }

    /**
     * Get DatumPruefung value
     *
     * @return dateTime|null
     */
    public function getDatumPruefung() {
        return $this->DatumPruefung;
    }

    /**
     * Set DatumPruefung value
     *
     * @param dateTime $_datumPruefung the DatumPruefung
     *
     * @return dateTime
     */
    public function setDatumPruefung($_datumPruefung) {
        return ($this->DatumPruefung = $_datumPruefung);
    }

    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     *
     * @see  Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     *
     * @param array $_array the exported values
     *
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
     */
    public static function __set_state(array $_array, $_className = __CLASS__) {
        return parent::__set_state($_array, $_className);
    }

    /**
     * Method returning the class name
     *
     * @return string __CLASS__
     */
    public function __toString() {
        return __CLASS__;
    }

    public static function createEmptyAddress() {
        return Mage::getModel('sepadebitsax/webservice_types_adresse');
    }

    public function saveAsPdf($path) {
        return $this;
    }

    public function isActive() {
        return $this->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AKTIV;
    }

    public function isCancelled() {
        return $this->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT;
    }

    public function isMultiPayment() {
        return ($this->getSequenceType() != Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_OOFF);
    }

    public function importData($payment, $CreditorId, $AllowOneof) {
        /* @var $mandate Egovs_Paymentbase_Model_Sepa_Mandate_Interface */
        $this->setCreditorId($CreditorId);
        if ($AllowOneof && $payment->getAdditionalInformation('sequence_type') == Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF) {
            $this->setSequenceType(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF);
        } else {
            $this->setSequenceType(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_RCUR);
        }
        $this->setType($payment->getAdditionalInformation('mandate_type'));

        $this->DebitorName = $payment->getAdditionalInformation('debitor_surname');
        $this->DebitorVorname = $payment->getAdditionalInformation('debitor_firstname');
        $this->DebitorAdresse = $this->createEmptyAddress();
        $this->DebitorAdresse->Strasse = $payment->getAdditionalInformation('debitor_street');
        $this->DebitorAdresse->Stadt = $payment->getAdditionalInformation('debitor_city');
        $this->DebitorAdresse->Land = $payment->getAdditionalInformation('debitor_country');
        $this->DebitorAdresse->Plz = $payment->getAdditionalInformation('debitor_zip');
        $this->DebitorAdresse->Postfach = $payment->getAdditionalInformation('debitor_postbox');

        if ($payment->getAdditionalInformation('custom_owner')) {
            $this->DebitorIstKontoinhaber = false;
            $this->KontoinhaberName = $payment->getAdditionalInformation('custom_accountholder_surname');
            $this->KontoinhaberVorname = $payment->getAdditionalInformation('custom_accountholder_name');
            $this->KontoinhaberAdresse = $this->createEmptyAddress();
            $this->KontoinhaberAdresse->Strasse = $payment->getAdditionalInformation('custom_accountholder_street');
            $this->KontoinhaberAdresse->Stadt = $payment->getAdditionalInformation('custom_accountholder_city');
            $this->KontoinhaberAdresse->Land = $payment->getAdditionalInformation('custom_accountholder_land');
            $this->KontoinhaberAdresse->Plz = $payment->getAdditionalInformation('custom_accountholder_zip');
            $this->KontoinhaberAdresse->Postfach = $payment->getAdditionalInformation('custom_accountholder_postbox');
        } else {
            $this->DebitorIstKontoinhaber = true;
            $this->KontoinhaberName = NULL;
            $this->KontoinhaberVorname = NULL;
            $this->KontoinhaberAdresse = $this->createEmptyAddress();
            $this->KontoinhaberAdresse->Strasse = NULL;
            $this->KontoinhaberAdresse->Stadt = NULL;
            $this->KontoinhaberAdresse->Land = NULL;
            $this->KontoinhaberAdresse->Plz = NULL;
            $this->KontoinhaberAdresse->Postfach = NULL;
        }

        $ba = self::_createNewBankingAccount($this);
        $ba->setIban($payment->getCcNumber());
        if ($payment->getCcType()) {
            $ba->setBic($payment->getCcType());
        }
        $this->DebitorBankverbindung = $ba;

        return $this;
    }

    protected function _createNewBankingAccount() {
        return Mage::getModel('sepadebitsax/webservice_types_bankverbindung');
    }


    public function hasChanged($payment = NULL) {
        $mandate = $this;

        if ($mandate == NULL) {
            return self::MANDATE_CHANGE_NEW;
        }

        if ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN) {
            return self::MANDATE_CHANGE_NEW;
        }

        if ($mandate->getMandatStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT) {
            return self::MANDATE_CHANGE_NEW;
        }

        if ((!$mandate->isActive())) {
            //Mage::throwException("You can not change your inactive Mandate!");
        }

        if ($mandate->getSequenceType() == Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF) {
            if ($mandate->isActive() && !$mandate->isMultiPayment()) {
                return self::MANDATE_CHANGE_NEW;
            }
        }

        if ($this->getAllowOneoff() && $payment->getAdditionalInformation('sequence_type') == Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF) {
            if ($mandate->getSequenceType() != Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF) {
                return self::MANDATE_CHANGE_ACCOUNT;
            }
        }

        /* @var $payment Mage_Sales_Model_Order_Payment */
        if ($payment->getCcType() != $mandate->getBankingAccount()->getBic() && $payment->getMethodInstance()->getIbanOnly()) {
            return self::MANDATE_CHANGE_ACCOUNT;
        }

        $enc = $payment->getCcNumber();
        if ($enc != $mandate->getBankingAccount()->getIban()) {
            return self::MANDATE_CHANGE_ACCOUNT;
        }

        $infos = new Varien_Object($payment->getAdditionalInformation());
        if ($payment->getAdditionalInformation('custom_owner')) {
            if (!$mandate->getAccountholderDiffers()) {
                return self::MANDATE_CHANGE_ACCOUNT;
            }
            if ($payment->getAdditionalInformation('custom_accountholder_surname') != $mandate->KontoinhaberName) {
                return self::MANDATE_CHANGE_ACCOUNT;
            }
        } else {
            if ($mandate->getAccountholderDiffers()) {
                return self::MANDATE_CHANGE_ACCOUNT;
            }
            if ($payment->getAdditionalInformation('debitor_surname') != $mandate->DebitorName) {
                return self::MANDATE_CHANGE_ACCOUNT;
            }
        }

        if ($payment->getAdditionalInformation('debitor_street') != $mandate->DebitorAdresse->Strasse) {
            return self::MANDATE_CHANGE;
        }

        if ($payment->getAdditionalInformation('debitor_city') != $mandate->DebitorAdresse->Stadt) {
            return self::MANDATE_CHANGE;
        }

        if ($payment->getAdditionalInformation('debitor_zip') != $mandate->DebitorAdresse->Plz) {
            return self::MANDATE_CHANGE;
        }

        if ($payment->getAdditionalInformation('debitor_country') != $mandate->DebitorAdresse->Land) {
            return self::MANDATE_CHANGE;
        }

        if ($payment->getAdditionalInformation('debitor_postbox') != $mandate->DebitorAdresse->Postfach) {
            return self::MANDATE_CHANGE;
        }

        if ($payment->getAdditionalInformation('debitor_firstname') != $mandate->DebitorVorname) {
            return self::MANDATE_CHANGE;
        }

        if ($payment->getAdditionalInformation('debitor_surname') != $mandate->DebitorName) {
            return self::MANDATE_CHANGE;
        }

        return self::MANDATE_CHANGE_NONE;
    }

    public function getAllowOneoff() {
        return Mage::getStoreConfig('payment/sepadebitsax/allow_ooff') == 0 ? false : true;
    }
}
