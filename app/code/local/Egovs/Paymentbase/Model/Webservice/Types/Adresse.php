<?php
/**
 * Klasse für Adressen an der ePayBL
 * 
 * @property string                                        $PLZ			     10 Zeichen
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $validationStatus VALIDIERT|NICHT_VALIDIERT|NICHT_GESENDET|NICHT_VERFUEGBAR
 * @property string                                        $land			 3 Zeichen gemäß ISO 3166-1
 * @property string                                        $ort			     22 Zeichen
 * @property string                                        $hausNr           10 Zeichen
 * @property string                                        $postfach         10 Zeichen
 * @property string                                        $status			 AKTIV oder GESPERRT
 * @property string                                        $strasse 		 100 Zeichen
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $geaendertStatus  GEAENDERT|NICHT_GEAENDERT
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_Adresse
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
implements Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
{
	/**
	 * Konstruktor
	 * 
	 * Als Parameter kann eine Adresse als Array oder Varien_Object übergeben werden
     *
     * @param \Varien_Object|array addressData
	 * 
	 * @return void
	 */
	public function __construct() {
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$adresse = func_get_args();
		
		if (count($adresse) <= 1) {
			if (isset($adresse[0])) {
				$adresse = $adresse[0];
			} else {
				$adresse = array();
			}
		}
		if ($adresse instanceof Varien_Object) {
			$adresse = $adresse->getData();
		}
		
		if (is_array($adresse)) {
			foreach ($adresse as $key => $value) {
				if (!is_string($key)) {
					continue;
				}
				$this->$key = $value;
			}
			
			return;
		}

		parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 * 
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>land = 3</li>
	 *  <li>hausNr = 10</li>
	 *  <li>postfach = 10</li>
	 *  <li>PLZ = 10</li>
	 *  <li>Ort = 22</li>
	 *  <li>Strasse = 100</li>
	 *  <li><strong>default</strong> = 100</li>
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
			case 'land':
				$length = 3;
				break;
			case 'hausNr':
			case 'postfach':
			case 'PLZ':
				$length = 10;
				break;
			case 'ort':
				$length = 22;
				break;
			case 'strasse':
				$length = 100;
				break;
			default:
				$length = 100;
		}
		
		return $length;
	}
	
	/**
	 * Mapped ein Magento-Feld auf ein ePayBL-Feld
	 * 
	 * Mapping:<br/>
	 * <ul>
	 *  <li>country_id => land</li>
	 * </ul>
	 * 
	 * @param string $value Wert
	 * 
	 * @return string|NULL Bei Erfolg NULL sonst $value
	 */
	public function parseCountryId($value) {
		if (!is_string($value)) {
			return $value;
		}
		
		$this->land = $value;
		
		return null;
	}
	
	/**
	 * Mapped ein Magento-Feld auf ein ePayBL-Feld
	 *
	 * Mapping:<br/>
	 * <ul>
	 *  <li>street => strasse</li>
	 * </ul>
	 *
	 * @param string $value Wert
	 *
	 * @return string|NULL Bei Erfolg NULL sonst $value
	 */
	public function parseStreet($value) {
		if (!is_string($value)) {
			return $value;
		}
	
		$this->strasse = $value;
	
		return null;
	}
	
	/**
	 * Mapped ein Magento-Feld auf ein ePayBL-Feld
	 *
	 * Mapping:<br/>
	 * <ul>
	 *  <li>postcode => PLZ</li>
	 * </ul>
	 *
	 * @param string $value Wert
	 *
	 * @return string|NULL Bei Erfolg NULL sonst $value
	 */
	public function parsePostcode($value) {
		if (!is_string($value)) {
			return $value;
		}
	
		$this->PLZ = $value;
	
		return null;
	}
	
	/**
	 * Mapped ein Magento-Feld auf ein ePayBL-Feld
	 *
	 * Mapping:<br/>
	 * <ul>
	 *  <li>city => ort</li>
	 * </ul>
	 *
	 * @param string $value Wert
	 *
	 * @return string|NULL Bei Erfolg NULL sonst $value
	 */
	public function parseCity($value) {
		if (!is_string($value)) {
			return $value;
		}
	
		$this->ort = $value;
	
		return null;
	}
	
	public function getCity() {
		return $this->ort;
	}
	/**
	 * Gibt die Straße mit Hausnummer (optional) zurück
	 * 
	 * Der Parameter $withHouseNr gibt nur an ob das Feld $hausNr zu Straße hinzugefügt werden soll.
	 * 
	 * @param boolean $withHouseNr Straße mit oder ohne Hausnummer
	 * 
	 * @return boolean
	 * 
	 * @see Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address::getStreet()
	 */
	public function getStreet($withHouseNr = true) {
		$street = $this->strasse;
		if ($withHouseNr && isset($this->hausNr) && !empty($this->hausNr)) {
			$street .= " ".$this->hausNr;
		} 
		return $street;
	}
	public function getHousenumber() {
		return $this->hausNr;
	}
	public function getZip() {
		return $this->PLZ;
	}
	public function getPostofficeBox() {
		return $this->postfach;
	}
	public function getCountry() {
		return $this->land;
	}
	
	public function setCity($city) {
		$this->ort = $city;
		return $this;
	}
	public function setStreet($street) {
		$this->strasse = $street;
		return $this;
	}
	public function setHousenumber($number) {
		$this->hausNr = $number;
		return $this;
	}
	public function setZip($zip) {
		$this->PLZ = $zip;
		return $this;
	}
	public function setPostofficeBox($pob) {
		$this->postfach = $pob;
		return $this;
	}
	public function setCountry($country) {
		$this->land = $country;
		return $this;
	}
}