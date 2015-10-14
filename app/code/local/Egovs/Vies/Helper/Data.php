<?php
/**
 * Validiert die VAT - Nummer
 *
 * Diese Klasse kapselt die Methoden für Aufrufe die gemeinsam verwendet werden.
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Helper_Data extends Mage_Customer_Helper_Data {
	
	public function getGroupIdByCustomerGroupRules($data) {
		$ruleSet = Mage::getModel('customer/group')->getCollection()
			->addOrder('taxvat', Varien_Data_Collection_Db::SORT_ORDER_ASC)
			->getItems()
		;
		$rules = array(
				'company', 'taxvat'
		);
		foreach ($ruleSet as $id => $rule) {
			$ruleMatches = true;
			foreach ($rules as $ruleName) {
				$validate = null;
				switch (strtolower($ruleName)) {
					case 'priority':
						continue 2;
					case 'company':
						//type cast geht sonst nicht
						$validate = ((bool)((int) $rule->getData($ruleName)));
						break;
					case 'taxvat':
						/*
						 * 0 Nein => Darf nicht vorhanden sein
						 * 1 Ja => Muss vorhanden und valide sein.
						 * 2 Irrelevant => Kann vorhanden sein, es ist jedoch egal ob sie valide ist
						 */
						$validate = ((int) $rule->getData($ruleName));
						//Auf neue 1.9er VAT ID mappen!
						$ruleName = 'vat_id';
						break;
					default :
						$validate = false;//((bool)((int) $rule->$ruleName));
				}
	
				if (array_key_exists($ruleName, $data) && $validate === true) {
					if (empty($data[$ruleName])) {
						$ruleMatches = false;
						break;
					}
				} elseif (!array_key_exists($ruleName, $data) && $validate === true) {
					$ruleMatches = false;
					break;
				} elseif (array_key_exists($ruleName, $data) && $validate == false) {
					if (!empty($data[$ruleName])) {
						$ruleMatches = false;
						break;
					}
				}
			}
	
			if ($ruleMatches) {
				//VAT Validierung findet schon bei der Eingabe statt, muss hier trotzdem erneut erfolgen falls USt.ID gelöscht wird.
				//Die Validierung der VAT bei der Eingabe schließt die Validerierung von VAT zu Land mit ein!
				if ($rule->getTaxvat() == 1) {
					if (!isset($data['taxvat_valid']) || $data['taxvat_valid'] != true) {
						continue;
					}
				}
				$groupToCountry = Mage::getModel('egovsvies/group')->load(
						isset($data['country_id']) ?
						sprintf(
								'%s%s%s',
								$data['country_id'],
								$rule->getCompany(),
								$rule->getTaxvat()
						) : null
				);
	
				if ($groupToCountry && !$groupToCountry->isEmpty()) {
					if ($rule->getId() == $groupToCountry->getCustomerGroupId()) {
						return $rule->getId();
					}
				}
			}
		}
	
		return null;
	}

	public function getEuCountries($exludeDefaultCountry = true)
	{
		$euCountries = explode(',', Mage::getStoreConfig(Mage_Core_Helper_Data::XML_PATH_EU_COUNTRIES_LIST, 0));
		
		if($exludeDefaultCountry)
		{
			$default = Mage::getStoreConfig("general/country/default");
			$euCountries = array_diff($euCountries, array($default));
		}
		
		return $euCountries;
	}

}