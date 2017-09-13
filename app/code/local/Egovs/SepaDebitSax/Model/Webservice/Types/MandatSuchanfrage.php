<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage originally named WSMandatSuchanfrage
 * Documentation : MandatSuchanfrage
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The MandatStatus
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus
     */
    public $MandatStatus;
    /**
     * The Mandatsreferenz
     * @var string
     */
    public $Mandatsreferenz;
    /**
     * The MandatsTyp
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp
     */
    public $MandatsTyp;
    /**
     * The SequenzTyp
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp
     */
    public $SequenzTyp;
    /**
     * The Kategorie
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie
     */
    public $Kategorie;
    /**
     * The PruefStatus
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus
     */
    public $PruefStatus;
    /**
     * The Geschaeftsbereichkennung
     * @var string
     */
    public $Geschaeftsbereichkennung;
    /**
     * The KreditorName
     * @var string
     */
    public $KreditorName;
    /**
     * The KreditorVorname
     * @var string
     */
    public $KreditorVorname;
    /**
     * The KreditorAdresse
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public $KreditorAdresse;
    /**
     * The KreditorBankverbindung
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public $KreditorBankverbindung;
    /**
     * The KreditorGlaeubigerId
     * @var string
     */
    public $KreditorGlaeubigerId;
    /**
     * The DebitorName
     * @var string
     */
    public $DebitorName;
    /**
     * The DebitorVorname
     * @var string
     */
    public $DebitorVorname;
    /**
     * The DebitorAdresse
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public $DebitorAdresse;
    /**
     * The DebitorBankverbindung
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public $DebitorBankverbindung;
    /**
     * The DatumUnterschriftVon
     * @var dateTime
     */
    public $DatumUnterschriftVon;
    /**
     * The DatumUnterschriftBis
     * @var dateTime
     */
    public $DatumUnterschriftBis;
    /**
     * The OrtUnterschrift
     * @var string
     */
    public $OrtUnterschrift;
    /**
     * The AblageortOriginalmandat
     * @var string
     */
    public $AblageortOriginalmandat;
    /**
     * The DebitorIstKontoinhaber
     * @var boolean
     */
    public $DebitorIstKontoinhaber;
    /**
     * The KontoinhaberName
     * @var string
     */
    public $KontoinhaberName;
    /**
     * The KontoinhaberVorname
     * @var string
     */
    public $KontoinhaberVorname;
    /**
     * The KontoinhaberAdresse
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public $KontoinhaberAdresse;
    /**
     * The NachfolgeMandatId
     * @var float
     */
    public $NachfolgeMandatId;
    /**
     * The Bearbeiter
     * @var string
     */
    public $Bearbeiter;
    /**
     * The DatumStatusaenderungVon
     * @var dateTime
     */
    public $DatumStatusaenderungVon;
    /**
     * The DatumStatusaenderungBis
     * @var dateTime
     */
    public $DatumStatusaenderungBis;
    /**
     * The DatumLetzteFaelligkeitVon
     * @var dateTime
     */
    public $DatumLetzteFaelligkeitVon;
    /**
     * The DatumLetzteFaelligkeitBis
     * @var dateTime
     */
    public $DatumLetzteFaelligkeitBis;
    /**
     * The DatumKuendigungVon
     * @var dateTime
     */
    public $DatumKuendigungVon;
    /**
     * The DatumKuendigungBis
     * @var dateTime
     */
    public $DatumKuendigungBis;
    /**
     * The DatumLetzteAenderungVon
     * @var dateTime
     */
    public $DatumLetzteAenderungVon;
    /**
     * The DatumLetzteAenderungBis
     * @var dateTime
     */
    public $DatumLetzteAenderungBis;
    /**
     * The DatumErstellungVon
     * @var dateTime
     */
    public $DatumErstellungVon;
    /**
     * The DatumErstellungBis
     * @var dateTime
     */
    public $DatumErstellungBis;
    /**
     * The DatumNachfolgemandatVon
     * @var dateTime
     */
    public $DatumNachfolgemandatVon;
    /**
     * The DatumNachfolgemandatBis
     * @var dateTime
     */
    public $DatumNachfolgemandatBis;
    /**
     * The DatumLetzteNutzungVon
     * @var dateTime
     */
    public $DatumLetzteNutzungVon;
    /**
     * The DatumLetzteNutzungBis
     * @var dateTime
     */
    public $DatumLetzteNutzungBis;
    /**
     * The DatumPruefungVon
     * @var dateTime
     */
    public $DatumPruefungVon;
    /**
     * The DatumPruefungBis
     * @var dateTime
     */
    public $DatumPruefungBis;
    /**
     * Constructor method for WSMandatSuchanfrage
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus $_mandatStatus
     * @param string $_mandatsreferenz
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp $_mandatsTyp
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp $_sequenzTyp
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie $_kategorie
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus $_pruefStatus
     * @param string $_geschaeftsbereichkennung
     * @param string $_kreditorName
     * @param string $_kreditorVorname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_kreditorAdresse
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_kreditorBankverbindung
     * @param string $_kreditorGlaeubigerId
     * @param string $_debitorName
     * @param string $_debitorVorname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_debitorAdresse
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_debitorBankverbindung
     * @param dateTime $_datumUnterschriftVon
     * @param dateTime $_datumUnterschriftBis
     * @param string $_ortUnterschrift
     * @param string $_ablageortOriginalmandat
     * @param boolean $_debitorIstKontoinhaber
     * @param string $_kontoinhaberName
     * @param string $_kontoinhaberVorname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_kontoinhaberAdresse
     * @param float $_nachfolgeMandatId
     * @param string $_bearbeiter
     * @param dateTime $_datumStatusaenderungVon
     * @param dateTime $_datumStatusaenderungBis
     * @param dateTime $_datumLetzteFaelligkeitVon
     * @param dateTime $_datumLetzteFaelligkeitBis
     * @param dateTime $_datumKuendigungVon
     * @param dateTime $_datumKuendigungBis
     * @param dateTime $_datumLetzteAenderungVon
     * @param dateTime $_datumLetzteAenderungBis
     * @param dateTime $_datumErstellungVon
     * @param dateTime $_datumErstellungBis
     * @param dateTime $_datumNachfolgemandatVon
     * @param dateTime $_datumNachfolgemandatBis
     * @param dateTime $_datumLetzteNutzungVon
     * @param dateTime $_datumLetzteNutzungBis
     * @param dateTime $_datumPruefungVon
     * @param dateTime $_datumPruefungBis
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage
     */
    public function __construct($_mandatStatus = NULL,$_mandatsreferenz = NULL,$_mandatsTyp = NULL,$_sequenzTyp = NULL,$_kategorie = NULL,$_pruefStatus = NULL,$_geschaeftsbereichkennung = NULL,$_kreditorName = NULL,$_kreditorVorname = NULL,$_kreditorAdresse = NULL,$_kreditorBankverbindung = NULL,$_kreditorGlaeubigerId = NULL,$_debitorName = NULL,$_debitorVorname = NULL,$_debitorAdresse = NULL,$_debitorBankverbindung = NULL,$_datumUnterschriftVon = NULL,$_datumUnterschriftBis = NULL,$_ortUnterschrift = NULL,$_ablageortOriginalmandat = NULL,$_debitorIstKontoinhaber = NULL,$_kontoinhaberName = NULL,$_kontoinhaberVorname = NULL,$_kontoinhaberAdresse = NULL,$_nachfolgeMandatId = NULL,$_bearbeiter = NULL,$_datumStatusaenderungVon = NULL,$_datumStatusaenderungBis = NULL,$_datumLetzteFaelligkeitVon = NULL,$_datumLetzteFaelligkeitBis = NULL,$_datumKuendigungVon = NULL,$_datumKuendigungBis = NULL,$_datumLetzteAenderungVon = NULL,$_datumLetzteAenderungBis = NULL,$_datumErstellungVon = NULL,$_datumErstellungBis = NULL,$_datumNachfolgemandatVon = NULL,$_datumNachfolgemandatBis = NULL,$_datumLetzteNutzungVon = NULL,$_datumLetzteNutzungBis = NULL,$_datumPruefungVon = NULL,$_datumPruefungBis = NULL)
    {
        parent::__construct(array('MandatStatus'=>$_mandatStatus,'Mandatsreferenz'=>$_mandatsreferenz,'MandatsTyp'=>$_mandatsTyp,'SequenzTyp'=>$_sequenzTyp,'Kategorie'=>$_kategorie,'PruefStatus'=>$_pruefStatus,'Geschaeftsbereichkennung'=>$_geschaeftsbereichkennung,'KreditorName'=>$_kreditorName,'KreditorVorname'=>$_kreditorVorname,'KreditorAdresse'=>$_kreditorAdresse,'KreditorBankverbindung'=>$_kreditorBankverbindung,'KreditorGlaeubigerId'=>$_kreditorGlaeubigerId,'DebitorName'=>$_debitorName,'DebitorVorname'=>$_debitorVorname,'DebitorAdresse'=>$_debitorAdresse,'DebitorBankverbindung'=>$_debitorBankverbindung,'DatumUnterschriftVon'=>$_datumUnterschriftVon,'DatumUnterschriftBis'=>$_datumUnterschriftBis,'OrtUnterschrift'=>$_ortUnterschrift,'AblageortOriginalmandat'=>$_ablageortOriginalmandat,'DebitorIstKontoinhaber'=>$_debitorIstKontoinhaber,'KontoinhaberName'=>$_kontoinhaberName,'KontoinhaberVorname'=>$_kontoinhaberVorname,'KontoinhaberAdresse'=>$_kontoinhaberAdresse,'NachfolgeMandatId'=>$_nachfolgeMandatId,'Bearbeiter'=>$_bearbeiter,'DatumStatusaenderungVon'=>$_datumStatusaenderungVon,'DatumStatusaenderungBis'=>$_datumStatusaenderungBis,'DatumLetzteFaelligkeitVon'=>$_datumLetzteFaelligkeitVon,'DatumLetzteFaelligkeitBis'=>$_datumLetzteFaelligkeitBis,'DatumKuendigungVon'=>$_datumKuendigungVon,'DatumKuendigungBis'=>$_datumKuendigungBis,'DatumLetzteAenderungVon'=>$_datumLetzteAenderungVon,'DatumLetzteAenderungBis'=>$_datumLetzteAenderungBis,'DatumErstellungVon'=>$_datumErstellungVon,'DatumErstellungBis'=>$_datumErstellungBis,'DatumNachfolgemandatVon'=>$_datumNachfolgemandatVon,'DatumNachfolgemandatBis'=>$_datumNachfolgemandatBis,'DatumLetzteNutzungVon'=>$_datumLetzteNutzungVon,'DatumLetzteNutzungBis'=>$_datumLetzteNutzungBis,'DatumPruefungVon'=>$_datumPruefungVon,'DatumPruefungBis'=>$_datumPruefungBis),false);
    }
    /**
     * Get MandatStatus value
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus|null
     */
    public function getMandatStatus()
    {
        return $this->MandatStatus;
    }
    /**
     * Set MandatStatus value
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::valueIsValid()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus $_mandatStatus the MandatStatus
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus
     */
    public function setMandatStatus($_mandatStatus)
    {
        if(!Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::valueIsValid($_mandatStatus))
        {
            return false;
        }
        return ($this->MandatStatus = $_mandatStatus);
    }
    /**
     * Get Mandatsreferenz value
     * @return string|null
     */
    public function getMandatsreferenz()
    {
        return $this->Mandatsreferenz;
    }
    /**
     * Set Mandatsreferenz value
     * @param string $_mandatsreferenz the Mandatsreferenz
     * @return string
     */
    public function setMandatsreferenz($_mandatsreferenz)
    {
        return ($this->Mandatsreferenz = $_mandatsreferenz);
    }
    /**
     * Get MandatsTyp value
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp|null
     */
    public function getMandatsTyp()
    {
        return $this->MandatsTyp;
    }
    /**
     * Set MandatsTyp value
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::valueIsValid()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp $_mandatsTyp the MandatsTyp
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp
     */
    public function setMandatsTyp($_mandatsTyp)
    {
        if(!Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::valueIsValid($_mandatsTyp))
        {
            return false;
        }
        return ($this->MandatsTyp = $_mandatsTyp);
    }
    /**
     * Get SequenzTyp value
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp|null
     */
    public function getSequenzTyp()
    {
        return $this->SequenzTyp;
    }
    /**
     * Set SequenzTyp value
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::valueIsValid()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp $_sequenzTyp the SequenzTyp
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp
     */
    public function setSequenzTyp($_sequenzTyp)
    {
        if(!Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::valueIsValid($_sequenzTyp))
        {
            return false;
        }
        return ($this->SequenzTyp = $_sequenzTyp);
    }
    /**
     * Get Kategorie value
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie|null
     */
    public function getKategorie()
    {
        return $this->Kategorie;
    }
    /**
     * Set Kategorie value
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::valueIsValid()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie $_kategorie the Kategorie
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie
     */
    public function setKategorie($_kategorie)
    {
        if(!Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::valueIsValid($_kategorie))
        {
            return false;
        }
        return ($this->Kategorie = $_kategorie);
    }
    /**
     * Get PruefStatus value
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus|null
     */
    public function getPruefStatus()
    {
        return $this->PruefStatus;
    }
    /**
     * Set PruefStatus value
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::valueIsValid()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus $_pruefStatus the PruefStatus
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus
     */
    public function setPruefStatus($_pruefStatus)
    {
        if(!Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::valueIsValid($_pruefStatus))
        {
            return false;
        }
        return ($this->PruefStatus = $_pruefStatus);
    }
    /**
     * Get Geschaeftsbereichkennung value
     * @return string|null
     */
    public function getGeschaeftsbereichkennung()
    {
        return $this->Geschaeftsbereichkennung;
    }
    /**
     * Set Geschaeftsbereichkennung value
     * @param string $_geschaeftsbereichkennung the Geschaeftsbereichkennung
     * @return string
     */
    public function setGeschaeftsbereichkennung($_geschaeftsbereichkennung)
    {
        return ($this->Geschaeftsbereichkennung = $_geschaeftsbereichkennung);
    }
    /**
     * Get KreditorName value
     * @return string|null
     */
    public function getKreditorName()
    {
        return $this->KreditorName;
    }
    /**
     * Set KreditorName value
     * @param string $_kreditorName the KreditorName
     * @return string
     */
    public function setKreditorName($_kreditorName)
    {
        return ($this->KreditorName = $_kreditorName);
    }
    /**
     * Get KreditorVorname value
     * @return string|null
     */
    public function getKreditorVorname()
    {
        return $this->KreditorVorname;
    }
    /**
     * Set KreditorVorname value
     * @param string $_kreditorVorname the KreditorVorname
     * @return string
     */
    public function setKreditorVorname($_kreditorVorname)
    {
        return ($this->KreditorVorname = $_kreditorVorname);
    }
    /**
     * Get KreditorAdresse value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse|null
     */
    public function getKreditorAdresse()
    {
        return $this->KreditorAdresse;
    }
    /**
     * Set KreditorAdresse value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_kreditorAdresse the KreditorAdresse
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function setKreditorAdresse($_kreditorAdresse)
    {
        return ($this->KreditorAdresse = $_kreditorAdresse);
    }
    /**
     * Get KreditorBankverbindung value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung|null
     */
    public function getKreditorBankverbindung()
    {
        return $this->KreditorBankverbindung;
    }
    /**
     * Set KreditorBankverbindung value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_kreditorBankverbindung the KreditorBankverbindung
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public function setKreditorBankverbindung($_kreditorBankverbindung)
    {
        return ($this->KreditorBankverbindung = $_kreditorBankverbindung);
    }
    /**
     * Get KreditorGlaeubigerId value
     * @return string|null
     */
    public function getKreditorGlaeubigerId()
    {
        return $this->KreditorGlaeubigerId;
    }
    /**
     * Set KreditorGlaeubigerId value
     * @param string $_kreditorGlaeubigerId the KreditorGlaeubigerId
     * @return string
     */
    public function setKreditorGlaeubigerId($_kreditorGlaeubigerId)
    {
        return ($this->KreditorGlaeubigerId = $_kreditorGlaeubigerId);
    }
    /**
     * Get DebitorName value
     * @return string|null
     */
    public function getDebitorName()
    {
        return $this->DebitorName;
    }
    /**
     * Set DebitorName value
     * @param string $_debitorName the DebitorName
     * @return string
     */
    public function setDebitorName($_debitorName)
    {
        return ($this->DebitorName = $_debitorName);
    }
    /**
     * Get DebitorVorname value
     * @return string|null
     */
    public function getDebitorVorname()
    {
        return $this->DebitorVorname;
    }
    /**
     * Set DebitorVorname value
     * @param string $_debitorVorname the DebitorVorname
     * @return string
     */
    public function setDebitorVorname($_debitorVorname)
    {
        return ($this->DebitorVorname = $_debitorVorname);
    }
    /**
     * Get DebitorAdresse value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse|null
     */
    public function getDebitorAdresse()
    {
        return $this->DebitorAdresse;
    }
    /**
     * Set DebitorAdresse value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_debitorAdresse the DebitorAdresse
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function setDebitorAdresse($_debitorAdresse)
    {
        return ($this->DebitorAdresse = $_debitorAdresse);
    }
    /**
     * Get DebitorBankverbindung value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung|null
     */
    public function getDebitorBankverbindung()
    {
        return $this->DebitorBankverbindung;
    }
    /**
     * Set DebitorBankverbindung value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung $_debitorBankverbindung the DebitorBankverbindung
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public function setDebitorBankverbindung($_debitorBankverbindung)
    {
        return ($this->DebitorBankverbindung = $_debitorBankverbindung);
    }
    /**
     * Get DatumUnterschriftVon value
     * @return dateTime|null
     */
    public function getDatumUnterschriftVon()
    {
        return $this->DatumUnterschriftVon;
    }
    /**
     * Set DatumUnterschriftVon value
     * @param dateTime $_datumUnterschriftVon the DatumUnterschriftVon
     * @return dateTime
     */
    public function setDatumUnterschriftVon($_datumUnterschriftVon)
    {
        return ($this->DatumUnterschriftVon = $_datumUnterschriftVon);
    }
    /**
     * Get DatumUnterschriftBis value
     * @return dateTime|null
     */
    public function getDatumUnterschriftBis()
    {
        return $this->DatumUnterschriftBis;
    }
    /**
     * Set DatumUnterschriftBis value
     * @param dateTime $_datumUnterschriftBis the DatumUnterschriftBis
     * @return dateTime
     */
    public function setDatumUnterschriftBis($_datumUnterschriftBis)
    {
        return ($this->DatumUnterschriftBis = $_datumUnterschriftBis);
    }
    /**
     * Get OrtUnterschrift value
     * @return string|null
     */
    public function getOrtUnterschrift()
    {
        return $this->OrtUnterschrift;
    }
    /**
     * Set OrtUnterschrift value
     * @param string $_ortUnterschrift the OrtUnterschrift
     * @return string
     */
    public function setOrtUnterschrift($_ortUnterschrift)
    {
        return ($this->OrtUnterschrift = $_ortUnterschrift);
    }
    /**
     * Get AblageortOriginalmandat value
     * @return string|null
     */
    public function getAblageortOriginalmandat()
    {
        return $this->AblageortOriginalmandat;
    }
    /**
     * Set AblageortOriginalmandat value
     * @param string $_ablageortOriginalmandat the AblageortOriginalmandat
     * @return string
     */
    public function setAblageortOriginalmandat($_ablageortOriginalmandat)
    {
        return ($this->AblageortOriginalmandat = $_ablageortOriginalmandat);
    }
    /**
     * Get DebitorIstKontoinhaber value
     * @return boolean|null
     */
    public function getDebitorIstKontoinhaber()
    {
        return $this->DebitorIstKontoinhaber;
    }
    /**
     * Set DebitorIstKontoinhaber value
     * @param boolean $_debitorIstKontoinhaber the DebitorIstKontoinhaber
     * @return boolean
     */
    public function setDebitorIstKontoinhaber($_debitorIstKontoinhaber)
    {
        return ($this->DebitorIstKontoinhaber = $_debitorIstKontoinhaber);
    }
    /**
     * Get KontoinhaberName value
     * @return string|null
     */
    public function getKontoinhaberName()
    {
        return $this->KontoinhaberName;
    }
    /**
     * Set KontoinhaberName value
     * @param string $_kontoinhaberName the KontoinhaberName
     * @return string
     */
    public function setKontoinhaberName($_kontoinhaberName)
    {
        return ($this->KontoinhaberName = $_kontoinhaberName);
    }
    /**
     * Get KontoinhaberVorname value
     * @return string|null
     */
    public function getKontoinhaberVorname()
    {
        return $this->KontoinhaberVorname;
    }
    /**
     * Set KontoinhaberVorname value
     * @param string $_kontoinhaberVorname the KontoinhaberVorname
     * @return string
     */
    public function setKontoinhaberVorname($_kontoinhaberVorname)
    {
        return ($this->KontoinhaberVorname = $_kontoinhaberVorname);
    }
    /**
     * Get KontoinhaberAdresse value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse|null
     */
    public function getKontoinhaberAdresse()
    {
        return $this->KontoinhaberAdresse;
    }
    /**
     * Set KontoinhaberAdresse value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Adresse $_kontoinhaberAdresse the KontoinhaberAdresse
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function setKontoinhaberAdresse($_kontoinhaberAdresse)
    {
        return ($this->KontoinhaberAdresse = $_kontoinhaberAdresse);
    }
    /**
     * Get NachfolgeMandatId value
     * @return float|null
     */
    public function getNachfolgeMandatId()
    {
        return $this->NachfolgeMandatId;
    }
    /**
     * Set NachfolgeMandatId value
     * @param float $_nachfolgeMandatId the NachfolgeMandatId
     * @return float
     */
    public function setNachfolgeMandatId($_nachfolgeMandatId)
    {
        return ($this->NachfolgeMandatId = $_nachfolgeMandatId);
    }
    /**
     * Get Bearbeiter value
     * @return string|null
     */
    public function getBearbeiter()
    {
        return $this->Bearbeiter;
    }
    /**
     * Set Bearbeiter value
     * @param string $_bearbeiter the Bearbeiter
     * @return string
     */
    public function setBearbeiter($_bearbeiter)
    {
        return ($this->Bearbeiter = $_bearbeiter);
    }
    /**
     * Get DatumStatusaenderungVon value
     * @return dateTime|null
     */
    public function getDatumStatusaenderungVon()
    {
        return $this->DatumStatusaenderungVon;
    }
    /**
     * Set DatumStatusaenderungVon value
     * @param dateTime $_datumStatusaenderungVon the DatumStatusaenderungVon
     * @return dateTime
     */
    public function setDatumStatusaenderungVon($_datumStatusaenderungVon)
    {
        return ($this->DatumStatusaenderungVon = $_datumStatusaenderungVon);
    }
    /**
     * Get DatumStatusaenderungBis value
     * @return dateTime|null
     */
    public function getDatumStatusaenderungBis()
    {
        return $this->DatumStatusaenderungBis;
    }
    /**
     * Set DatumStatusaenderungBis value
     * @param dateTime $_datumStatusaenderungBis the DatumStatusaenderungBis
     * @return dateTime
     */
    public function setDatumStatusaenderungBis($_datumStatusaenderungBis)
    {
        return ($this->DatumStatusaenderungBis = $_datumStatusaenderungBis);
    }
    /**
     * Get DatumLetzteFaelligkeitVon value
     * @return dateTime|null
     */
    public function getDatumLetzteFaelligkeitVon()
    {
        return $this->DatumLetzteFaelligkeitVon;
    }
    /**
     * Set DatumLetzteFaelligkeitVon value
     * @param dateTime $_datumLetzteFaelligkeitVon the DatumLetzteFaelligkeitVon
     * @return dateTime
     */
    public function setDatumLetzteFaelligkeitVon($_datumLetzteFaelligkeitVon)
    {
        return ($this->DatumLetzteFaelligkeitVon = $_datumLetzteFaelligkeitVon);
    }
    /**
     * Get DatumLetzteFaelligkeitBis value
     * @return dateTime|null
     */
    public function getDatumLetzteFaelligkeitBis()
    {
        return $this->DatumLetzteFaelligkeitBis;
    }
    /**
     * Set DatumLetzteFaelligkeitBis value
     * @param dateTime $_datumLetzteFaelligkeitBis the DatumLetzteFaelligkeitBis
     * @return dateTime
     */
    public function setDatumLetzteFaelligkeitBis($_datumLetzteFaelligkeitBis)
    {
        return ($this->DatumLetzteFaelligkeitBis = $_datumLetzteFaelligkeitBis);
    }
    /**
     * Get DatumKuendigungVon value
     * @return dateTime|null
     */
    public function getDatumKuendigungVon()
    {
        return $this->DatumKuendigungVon;
    }
    /**
     * Set DatumKuendigungVon value
     * @param dateTime $_datumKuendigungVon the DatumKuendigungVon
     * @return dateTime
     */
    public function setDatumKuendigungVon($_datumKuendigungVon)
    {
        return ($this->DatumKuendigungVon = $_datumKuendigungVon);
    }
    /**
     * Get DatumKuendigungBis value
     * @return dateTime|null
     */
    public function getDatumKuendigungBis()
    {
        return $this->DatumKuendigungBis;
    }
    /**
     * Set DatumKuendigungBis value
     * @param dateTime $_datumKuendigungBis the DatumKuendigungBis
     * @return dateTime
     */
    public function setDatumKuendigungBis($_datumKuendigungBis)
    {
        return ($this->DatumKuendigungBis = $_datumKuendigungBis);
    }
    /**
     * Get DatumLetzteAenderungVon value
     * @return dateTime|null
     */
    public function getDatumLetzteAenderungVon()
    {
        return $this->DatumLetzteAenderungVon;
    }
    /**
     * Set DatumLetzteAenderungVon value
     * @param dateTime $_datumLetzteAenderungVon the DatumLetzteAenderungVon
     * @return dateTime
     */
    public function setDatumLetzteAenderungVon($_datumLetzteAenderungVon)
    {
        return ($this->DatumLetzteAenderungVon = $_datumLetzteAenderungVon);
    }
    /**
     * Get DatumLetzteAenderungBis value
     * @return dateTime|null
     */
    public function getDatumLetzteAenderungBis()
    {
        return $this->DatumLetzteAenderungBis;
    }
    /**
     * Set DatumLetzteAenderungBis value
     * @param dateTime $_datumLetzteAenderungBis the DatumLetzteAenderungBis
     * @return dateTime
     */
    public function setDatumLetzteAenderungBis($_datumLetzteAenderungBis)
    {
        return ($this->DatumLetzteAenderungBis = $_datumLetzteAenderungBis);
    }
    /**
     * Get DatumErstellungVon value
     * @return dateTime|null
     */
    public function getDatumErstellungVon()
    {
        return $this->DatumErstellungVon;
    }
    /**
     * Set DatumErstellungVon value
     * @param dateTime $_datumErstellungVon the DatumErstellungVon
     * @return dateTime
     */
    public function setDatumErstellungVon($_datumErstellungVon)
    {
        return ($this->DatumErstellungVon = $_datumErstellungVon);
    }
    /**
     * Get DatumErstellungBis value
     * @return dateTime|null
     */
    public function getDatumErstellungBis()
    {
        return $this->DatumErstellungBis;
    }
    /**
     * Set DatumErstellungBis value
     * @param dateTime $_datumErstellungBis the DatumErstellungBis
     * @return dateTime
     */
    public function setDatumErstellungBis($_datumErstellungBis)
    {
        return ($this->DatumErstellungBis = $_datumErstellungBis);
    }
    /**
     * Get DatumNachfolgemandatVon value
     * @return dateTime|null
     */
    public function getDatumNachfolgemandatVon()
    {
        return $this->DatumNachfolgemandatVon;
    }
    /**
     * Set DatumNachfolgemandatVon value
     * @param dateTime $_datumNachfolgemandatVon the DatumNachfolgemandatVon
     * @return dateTime
     */
    public function setDatumNachfolgemandatVon($_datumNachfolgemandatVon)
    {
        return ($this->DatumNachfolgemandatVon = $_datumNachfolgemandatVon);
    }
    /**
     * Get DatumNachfolgemandatBis value
     * @return dateTime|null
     */
    public function getDatumNachfolgemandatBis()
    {
        return $this->DatumNachfolgemandatBis;
    }
    /**
     * Set DatumNachfolgemandatBis value
     * @param dateTime $_datumNachfolgemandatBis the DatumNachfolgemandatBis
     * @return dateTime
     */
    public function setDatumNachfolgemandatBis($_datumNachfolgemandatBis)
    {
        return ($this->DatumNachfolgemandatBis = $_datumNachfolgemandatBis);
    }
    /**
     * Get DatumLetzteNutzungVon value
     * @return dateTime|null
     */
    public function getDatumLetzteNutzungVon()
    {
        return $this->DatumLetzteNutzungVon;
    }
    /**
     * Set DatumLetzteNutzungVon value
     * @param dateTime $_datumLetzteNutzungVon the DatumLetzteNutzungVon
     * @return dateTime
     */
    public function setDatumLetzteNutzungVon($_datumLetzteNutzungVon)
    {
        return ($this->DatumLetzteNutzungVon = $_datumLetzteNutzungVon);
    }
    /**
     * Get DatumLetzteNutzungBis value
     * @return dateTime|null
     */
    public function getDatumLetzteNutzungBis()
    {
        return $this->DatumLetzteNutzungBis;
    }
    /**
     * Set DatumLetzteNutzungBis value
     * @param dateTime $_datumLetzteNutzungBis the DatumLetzteNutzungBis
     * @return dateTime
     */
    public function setDatumLetzteNutzungBis($_datumLetzteNutzungBis)
    {
        return ($this->DatumLetzteNutzungBis = $_datumLetzteNutzungBis);
    }
    /**
     * Get DatumPruefungVon value
     * @return dateTime|null
     */
    public function getDatumPruefungVon()
    {
        return $this->DatumPruefungVon;
    }
    /**
     * Set DatumPruefungVon value
     * @param dateTime $_datumPruefungVon the DatumPruefungVon
     * @return dateTime
     */
    public function setDatumPruefungVon($_datumPruefungVon)
    {
        return ($this->DatumPruefungVon = $_datumPruefungVon);
    }
    /**
     * Get DatumPruefungBis value
     * @return dateTime|null
     */
    public function getDatumPruefungBis()
    {
        return $this->DatumPruefungBis;
    }
    /**
     * Set DatumPruefungBis value
     * @param dateTime $_datumPruefungBis the DatumPruefungBis
     * @return dateTime
     */
    public function setDatumPruefungBis($_datumPruefungBis)
    {
        return ($this->DatumPruefungBis = $_datumPruefungBis);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
