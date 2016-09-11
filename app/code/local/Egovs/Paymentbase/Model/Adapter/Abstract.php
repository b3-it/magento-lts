<?php
/**
 * Abstrake Basisklasse für individualiserbare Adapter.
 *
 * Für jede neue individuell einsetzbare Funktion muss die Modulversion erhöht werden, um eine Zuordnung in der Dokumentation zu gewährleisten.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Adapter_Abstract extends Mage_Core_Model_Abstract
{
	protected $_translateCode = 'paymentbase';
	
	public abstract function getLabel();
	
	public function getCode() {
		$class = get_class($this);
		
		if (!$class) {
			return '';
		}
		
		return strtolower(substr($class, strrpos($class, '_')+1));
	}
	
	/**
	 * Liefert den Code für Übersetzungen
	 * 
	 * Default: paymentbase
	 * 
	 * @return string
	 */
	public function getTranslateCode() {
		return $this->_translateCode;
	}
	
	/**
	 * Übersetzt den übergebenen String
	 *
	 * @return string
	 *
	 */
	public function __() {
		$args = func_get_args();
		$expr = new Mage_Core_Model_Translate_Expr(array_shift($args), $this->getTranslateCode());
		array_unshift($args, $expr);
		return Mage::app()->getTranslator()->translate($args);
	}
	
	/**
	 * Erzeugt den Hash-Wert zu $str
	 * 
	 * Default: md5 Hash
	 * 
	 * @param string $str String
	 * 
	 * @return string
	 */
	public function hash($str) {
		//Um zu bisherigen Verfahren kompatibel zu sein
		return substr(md5($str), -32);
	}
	
	/**
	 * Liefert aus der Order die Kundeninformationen
	 *
	 * Primär wird versucht die Daten aus der Rechnungsadresse der Bestellung zu extrahieren, falls dies nicht funktioniert
	 * werden die Daten direkt aus der Order benutzt.
	 * <strong>Die Daten für Firma können nur aus der Rechnungsadresse geholt werden!</strong>
	 *
	 * @param Mage_Sales_Model_Order|Mage_Customer_Model_Address_Abstract $src Quelle für Daten
	 *
	 * @return Varien_Object
	 */
	public function extractCustomerInformation($src) {
		if (!($src instanceof Mage_Sales_Model_Order) && !($src instanceof Mage_Customer_Model_Address_Abstract)) {
			Mage::throwException($this->__('No order or address available'));
		}
	
		if ($src instanceof Mage_Sales_Model_Order) {
			$address = $src->getBillingAddress();
		} else {
			$address = $src;
		}
	
		if (!($address instanceof Mage_Customer_Model_Address_Abstract)) {
			Mage::throwException($this->__('No billing address available'));
		}
	
		$data = new Varien_Object();
		//TODO: customer_company steht noch nicht zur Verfügung
		if (strlen($address->getCompany()) > 0) {
			//Firma
			$data->setPrefix($this->__('Company'));
			$company = trim(sprintf('%s %s %s', $address->getCompany(), $address->getCompany2(), $address->getCompany3()));
			/** @var $helper Egovs_Paymentbase_Helper_Data */
			$helper = Mage::helper('paymentbase');
			
			//20140304::Frank Rochlitzer
			//META Daten für bessere Behandlung von Firmen setzen
			$data->setIsCompany(true);
			$data->setCompany($company);
			$data->setCompanyRepresented(sprintf("%s %s", $this->_getFirstname($src, $address), $this->_getLastname($src, $address, $helper->isCompanyLastNameRequired())));
			
			if (mb_strlen($company, 'UTF-8') > 27) {
				if (mb_strlen($company, 'UTF-8') > 54) {
					Mage::log($this->__('There are only 54 characters allowed for company, truncating string to match requirements.'), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
					$company = mb_substr($company, 0, 54, 'UTF-8');
				}
				//Company ist max 54 Zeichen lang
				$len = ceil(mb_strlen($company, 'UTF-8') / 2);
				//20120808:Frank Rochlitzer
				//ePayBL übergibt Namensdaten in der Form: 'Nachname Vorname' an SaxMBS
				$data->setLastname(mb_substr($company, 0, $len, 'UTF-8'));
				$data->setFirstname(mb_substr($company, $len, mb_strlen($company, 'UTF-8')-$len, 'UTF-8'));
			} else {
				//Company wird in Lastname gespeichert
				$data->setLastname($company);
				//Nachname in Vornamen speichern
				$data->setFirstname($this->_getLastname($src, $address, $helper->isCompanyLastNameRequired()));
			}
		} else {
			//Person
			// Anrede
			// Magento unterscheidet nicht zwischen Titel und Anrede
			if (strlen($address->getPrefix()) > 0) {
				$data->setPrefix($address->getPrefix());
			} else {
				if ($src instanceof Mage_Sales_Model_Order && strlen($src->getCustomerPrefix()) > 0) {
					$data->setPrefix($src->getCustomerPrefix());
				} elseif ($address instanceof Mage_Customer_Model_Address && $address->getCustomer() != false) {
					$data->setPrefix($address->getCustomer()->getPrefix());
				}
			}
			// Vorname => optional && <= 27 Zeichen
			if ($firstname = $this->_getFirstname($src, $address)) {
				$data->setFirstname($firstname);
			}
			// Nachname
			if ($lastname = $this->_getLastname($src, $address)) {
				$data->setLastname($lastname);
			}
		}
	
		return $data;
	}
	
	/**
	 * Liefert den Vornamen
	 *
	 * @param Mage_Sales_Model_Order|Mage_Customer_Model_Address_Abstract $src     Source
	 * @param Mage_Customer_Model_Address_Abstract                        $address Adresse
	 *
	 * @return string|NULL
	 */
	protected function _getFirstname($src, $address) {
		// Vorname => optional && <= 27 Zeichen
		if (strlen($address->getFirstname()) > 0) {
			return $address->getFirstname();
		} else {
			if ($src instanceof Mage_Sales_Model_Order && strlen($src->getCustomerFirstname()) > 0) {
				return $src->getCustomerFirstname();
			} elseif ($address instanceof Mage_Customer_Model_Address && $address->getCustomer() != false) {
				return $address->getCustomer()->getFirstname();
			}
		}
	
		return null;
	}
	
	/**
	 * Liefert den Nachnamen
	 *
	 * @param Mage_Sales_Model_Order|Mage_Customer_Model_Address_Abstract $src            Source
	 * @param Mage_Customer_Model_Address_Abstract                        $address        Adresse
	 * @param boolean                                                     $throwException If not set throw exception
	 *
	 * @return string
	 *
	 * @throws Exception falls kein Nachname verfügbar
	 */
	protected function _getLastname($src, $address, $throwException = true) {
		// Nachname
		if (strlen($address->getLastname()) > 0) {
			return $address->getLastname();
		}
	
		if ($src instanceof Mage_Sales_Model_Order && strlen($src->getCustomerLastname()) > 0) {
			return $src->getCustomerLastname();
		} elseif ($address instanceof Mage_Customer_Model_Address && $address->getCustomer() != false) {
			return $address->getCustomer()->getLastname();
		}

		if ($throwException) {
			Mage::throwException($this->__('Lastname is a required field'));
		}
		
		return null;
	}
}