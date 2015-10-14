<?php
/**
 * ZUEV/F15Z  Adapter.
 *
 * <p>
 * Bei diesm Adapter werden für Firmen zusätzlich noch der Nachname und ggf. der Vorname übertragen.
 * </p>
 * Für jede neue individuell einsetzbare Funktion muss die Modulversion erhöht werden, um eine Zuordnung in der Dokumentation zu gewährleisten.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Adapter_Zuev extends Egovs_Paymentbase_Model_Adapter_Abstract
{
	public function getLabel() {
		return Mage::helper('paymentbase')->__('ZUEV');
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
			//20140304::Frank Rochlitzer
			//META Daten für bessere Behandlung von Firmen setzen
			$data->setIsCompany(true);
			$data->setCompany($company);
			$data->setCompanyRepresented(sprintf("%s %s", $this->_getFirstname($src, $address), $this->_getLastname($src, $address)));
			
			if (mb_strlen($company, 'UTF-8') > 27) {
				//Dieser Teil dürfte für ZUEV nie aufgerufen werden, da die maximale Feldlänge im Shop auf 27 beschränkt ist.
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
				$data->setFirstname($this->_getLastname($src, $address));
				
				$firstname = $this->_getFirstname($src, $address);
				$firstNameLength = mb_strlen($firstname, 'UTF-8');
				if ($firstNameLength > 0) {
					//-1 ist für Leerzeichen
					$restLength = 27 - mb_strlen($data->getFirstname(), 'UTF-8') - 1;
					if ($restLength >= $firstNameLength) {
						$data->setFirstname($data->getFirstname()." ".$firstname);
					} elseif ($restLength > 2) {
						$data->setFirstname($data->getFirstname()." ".mb_substr($firstname, 0, 1, 'UTF-8').'.');
					}
				}
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
}