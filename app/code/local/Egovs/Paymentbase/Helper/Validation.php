<?php
/**
 * Validierungshelperklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * Hier finden gemeinsam genutzte Validierungen statt.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Helper_Validation extends Mage_Core_Helper_Abstract
{
	public function validatePostcode($plz, $countryId = 'DE') {
		$errors = array();
		
		$plz = trim($plz);
		if (strlen($plz) > 0) {
			$isPlzOk = true;
			if ($countryId == 'DE' || $countryId == 'de') {
				/*
				 * ePayBL Bedingung:
				* -0202: Die Postleitzahl ist nicht gültig: sie muss gefüllt sein und darf maximal 10 Zeichen lang
				* sein. Deutsche Postleitzahlen müssen fünfstellig und nummerisch sowie größer als 00000 sein.
				*/
				if (intval($plz) == 0) {
					$errors[] = $this->__("Postcode can't be 0");
				}
				if (!is_numeric($plz) || strlen($plz) != 5) {
					$errors[] = $this->__("German postal codes must be five digits.");
				}
			}
			if (strlen($plz) > 10) {
				$errors[] = $this->__("Postcode can only be 10 characters long.");
			}
		} else {
			$errors[] = $this->__('Postcode is a required field');
		}
		
		return $errors;
	}
	
	public function isAllowed(Mage_Core_Model_Config_Element $config) {
		$name = array();
		$name[] = $config->getName();
		$parent = $config->getParent();
		$_filter = array (
				'fields' => true,
				'groups' => true,
				'sections' => true,
		);
		do {
			$_name = $parent->getName();
			//getParent verursacht bei nicht vorhandenem Parent Undefined offset: 0  in /var/www/dwd/lib/Varien/Simplexml/Element.php on line 72
			$parent = $parent->xpath('..');
			if (isset($parent[0])) {
				$parent = $parent[0];
			} else {
				$parent = false;
			}
			if (isset($_filter[$_name])) {
				continue;
			}
			$name[] = $_name;
		} while ($parent != false);
		$name = array_reverse($name);
		$configPath = implode('/', $name);
		$resourceLookup = "admin/system/{$configPath}";
		$session = Mage::getSingleton('admin/session');
		if ($session->getData('acl') instanceof Mage_Admin_Model_Acl) {
			if ($session->getData('acl')->has($resourceLookup)) {
				$resourceId = $session->getData('acl')->get($resourceLookup)->getResourceId();
				if (!$session->isAllowed($resourceId)) {
					return false;
				}
			}
		}
		return true;
	}
}