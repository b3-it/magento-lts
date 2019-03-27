<?php
/**
 * Klasse für Kunden an der ePayBL
 *
 * @property string $EShopKundenNr 100 Zeichen
 * @property string $sprache 10 Zeichen Notation entspricht dem Alpha-2 Standard gemäß ISO 639
 * @property string $titel 15 Zeichen (Optional)
 * @property string $anrede  15 Zeichen (Optional)
 * @property string $vorname 27 Zeichen (Optional)
 * @property string $nachname 27 Zeichen (Optional)
 * @property string $EMailAdresse  100 Zeichen (Optional)
 * @property string $geburtsdatum DateTime (Optional)
 * @property string $geschlecht 15 Zeichen (Optional)
 * @property string $telefonNrPrivat 30 Zeichen (Optional)
 * @property string $telefonNrJob 30 Zeichen (Optional)
 * @property string $telefonNrMobil 30 Zeichen (Optional)
 * @property Egovs_Paymentbase_Model_Webservice_Types_Adresse $rechnungsAdresse Rechnungsadresse (Optional)
 * @property Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung Bankverbindung (Optional)
 * @property int $bonitaetsLevelUeberweisung Bonitätsstatus eines Kunden für Zahlverfahren 'Überweisung nach Lieferung', zugelassen sind 0, 1, 2, 3 und 4. (Optional)
 * @property int $bonitaetsLevelLastschrift Bonitätsstatus eines Kunden für Zahlverfahren 'elektronische Lastschrift', zugelassen sind 0, 1, 2, 3 und 4 (Optional)
 * @property int $bonitaetsLevelKreditkarte Bonitätsstatus eines Kunden für Zahlverfahren 'Kreditkarte', zugelassen sind 0, 1, 2 und 3 (Optional)
 * @property string $archivdatei 100 Zeichen Name einer möglichen Archivdatei (Optional)
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $status Status des Kunden (Optional)
 * @property string $sepaMandatReferenz 35 Zeichen Referenz auf ein SEAP-Mandat (Optional
 * 
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_Kunde extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	protected $bonitaetsLevelKreditkarte;
	protected $bonitaetsLevelUeberweisung;
	protected $bonitaetsLevelLastschrift;
	
	/**
	 * Konstruktor
	 * 
	 * @param string                                                  $EShopKundenNr              ePayBL Kundennummer
	 * @param string                                                  $sprache                    Sprache
	 * @param string                                                  $titel                      Titel
	 * @param string                                                  $anrede                     Anrede
	 * @param string                                                  $vorname                    Vorname
	 * @param string                                                  $nachname                   Nachname
	 * @param string                                                  $EMailAdresse               E-Mail
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Adresse        $rechnungsAdresse           Rechnungsadresse
	 * @param string                                                  $geburtsdatum               Geburtsdatum
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung             Bankverbindung
	 * @param string                                                  $geschlecht                 Geschlecht
	 * @param string                                                  $telefonNrPrivat            Telefonnummer Privat
	 * @param string                                                  $telefonNrJob               Telefonnummer Geschäft
	 * @param string                                                  $telefonNrMobil             Telefonnummer Mobil
	 * @param string                                                  $bonitaetsLevelUeberweisung Bonitätslevel für Überweisung
	 * @param string                                                  $bonitaetsLevelLastschrift  Bonitätslevel für Lastschrift
	 * @param string                                                  $bonitaetsLevelKreditkarte  Bonitätslevel für Kreditkarte
	 * 
	 * @return void
	 */
	public function Egovs_Paymentbase_Model_Webservice_Types_Kunde(
			$EShopKundenNr = null,
			$sprache = null,
			$titel = null,
			$anrede = null,
			$vorname = null,
			$nachname = null,
			$EMailAdresse = null,
			$rechnungsAdresse = null,
			$geburtsdatum = null,
			$bankverbindung = null,
			$geschlecht = null,
			$telefonNrPrivat = null,
			$telefonNrJob = null,
			$telefonNrMobil = null,
            $bonitaetsLevelUeberweisung = null,
			$bonitaetsLevelLastschrift = null,
			$bonitaetsLevelKreditkarte = null
	) {
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$this->EShopKundenNr = (string) $EShopKundenNr;
		//ISO 639
		$this->sprache = strtolower($sprache);
		
		if ($anrede != null)
			$this->anrede = $anrede;
		if ($vorname != null)
			$this->vorname = $vorname;
		if ($nachname != null)
			$this->nachname = $nachname;
		if ($EMailAdresse !== null)
			$this->EMailAdresse = $EMailAdresse;
		if ($rechnungsAdresse != null) {
			$this->rechnungsAdresse = $rechnungsAdresse;
		}
		if ($geburtsdatum != null)
			$this->geburtsdatum = $geburtsdatum;
		if ($bankverbindung != null)
			$this->bankverbindung = $bankverbindung;
		if ($geschlecht != null)
			$this->geschlecht = $geschlecht;
		if ($telefonNrPrivat !== null)
			$this->telefonNrPrivat = $telefonNrPrivat;
		if ($telefonNrJob !== null)
			$this->telefonNrJob = $telefonNrJob;
		if ($telefonNrMobil !== null)
			$this->telefonNrMobil = $telefonNrMobil;
		if ($bonitaetsLevelUeberweisung !== null)
			$this->bonitaetsLevelUeberweisung = (int) $bonitaetsLevelUeberweisung;
		if ($bonitaetsLevelLastschrift !== null)
			$this->bonitaetsLevelLastschrift = (int) $bonitaetsLevelLastschrift;
		if ($bonitaetsLevelKreditkarte !== null)
			$this->bonitaetsLevelKreditkarte = (int) $bonitaetsLevelKreditkarte;
		parent::Egovs_Paymentbase_Model_Webservice_Types_Abstract();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>sprache = 10</li>
	 *  <li>titel = 15</li>
	 *  <li>anrede = 15</li>
	 *  <li>geschlecht = 15</li>
	 *  <li>vorname = 27</li>
	 *  <li>nachname = 27</li>
	 *  <li>telefonNrPrivat = 30</li>
	 *  <li>telefonNrJob = 30</li>
	 *  <li>telefonNrMobil = 30</li>
	 *  <li>EShopKundenNr = 100</li>
	 *  <li>EMailAdresse = 100</li>
	 *  <li><strong>default</strong> = 1000</li>
	 * </ul>
	 *
	 * @param string $name Parametername
	 *
	 * @return int
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::_getParamLength()
	 */
	protected function _getParamLength($name) {
		switch ($name) {
			case 'sprache':
				$length = 10;
				break;
			case 'titel':
			case 'anrede':
			case 'geschlecht':
				$length = 15;
				break;
			case 'vorname':
			case 'nachname':
				$length = 27;
				break;
			case 'telefonNrPrivat':
			case 'telefonNrJob':
			case 'telefonNrMobil':
				$length = 30;
				break;
			case 'sepaMandatReferenz':
				$length = 35;
				break;
			case 'EShopKundenNr':
			case 'EMailAdresse':
				$length = 100;
				break;
			default:
				$length = 1000;
		}
	
		return $length;
	}
	
	/**
	 * Mapped eine Magento-Adresse auf eine ePayBL-Adresse
	 *
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Adresse|Mage_Customer_Model_Address|Varien_Object|array $adresse Eine Adresse
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Adresse
	 */
	public function parseRechnungsadresse($adresse) {
		if ($adresse instanceof Egovs_Paymentbase_Model_Webservice_Types_Adresse || empty($adresse)) {
			return $adresse;
		}
		
		if ($adresse instanceof Mage_Customer_Model_Address) {
			// Kunde mit richtigen Adressdaten aus DB anlegen
			$objRechnungsAdresse = new Varien_Object();
			$errors = array();
			//Straße
			if (strlen($adresse->getStreetFull()) > 0) {
				$objRechnungsAdresse->setStrasse($adresse->getStreetFull());
			} else {
// 				$errors[] = $this->__('Street is a required field');
			}
			//Land
			if (strlen($adresse->getCountryId()) > 0) {
				$objRechnungsAdresse->setLand($adresse->getCountryId());
			} else {
				$errors[] = $this->__('Country is a required field');
			}
			//PLZ
			$plz = $adresse->getPostcode();
			$tmp = Mage::helper('paymentbase/validation')->validatePostcode($plz, $adresse->getCountryId());
			$errors = array_merge($errors, $tmp);
			//Stadt
			if (strlen($adresse->getCity()) > 0) {
				$objRechnungsAdresse->setOrt($adresse->getCity());
			} else {
				$errors[] = $this->__('City is a required field');
			}
			
			if (!empty($errors)) {
				$errors = implode('<br/>', $errors);
				throw new Egovs_Paymentbase_Exception_Validation($errors);
				//Mage::throwException($errors);
			}
			$objRechnungsAdresse->setData('PLZ', $plz);
			
			$adresse = $objRechnungsAdresse;
		}
		
		if ($adresse instanceof Varien_Object) {
			return new Egovs_Paymentbase_Model_Webservice_Types_Adresse($adresse);
		}
		
		if (is_array($adresse)) {
			return new Egovs_Paymentbase_Model_Webservice_Types_Adresse($adresse);
		}		
		
		return $adresse;
	}
	
	public function __()
    {
        $args = func_get_args();
       	$expr = new Mage_Core_Model_Translate_Expr(array_shift($args), 'paymentbase');
        array_unshift($args, $expr);
        return Mage::app()->getTranslator()->translate($args);
    }
	
	/**
	 * Wrapper für Bankverbidnung
	 * 
	 * Liefert die Bankverbindung als Paymentbase-Klasse<br/>
	 * Soap nutzt nur die Properties und nicht die Getter-Methoden.
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung
	 * 
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::__get
	 */
	public function getBankverbindung() {
		$_bankverbindung = $this->bankverbindung;
		if ($_bankverbindung instanceof SoapVar) {
			/* @var $_bankverbindung SoapVar */
			return $_bankverbindung->enc_value;
		}
		
		return $_bankverbindung;		
	}
	
	/**
	 * Wrapper für Rechnunsadresse
	 *
	 * Liefert die Rechnunsadresse als Paymentbase-Klasse<br/>
	 * Soap nutzt nur die Properties und nicht die Getter-Methoden.
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Adresse
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::__get
	 */
	public function getRechnungsAdresse() {
		$_addresse = $this->rechnungsAdresse;
		
		if ($_addresse instanceof SoapVar) {
			return $_addresse->enc_value;
		}
		
		return $_addresse;
	}
}