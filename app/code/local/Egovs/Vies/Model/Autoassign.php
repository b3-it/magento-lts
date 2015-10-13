<?php
/**
 * Erweitert die Kundengruppen um Regeln zur automatischen Zuordnung
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Autoassign extends Mage_Core_Model_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->_init('egovsvies/group');
	}
	
	/**
	 * Liefert die Zuordnung für die angegebene Kundengruppe
	 * 
	 * @param Mage_Customer_Model_Group|int $group Kundengrupper
	 * 
	 * @return Egovs_Vies_Model_Resource_Group_Collection Collection oder null
	 */
	public function getCollectionByGroup($group) {
		if (empty($group)) {
			$group = Mage::registry('current_group');
				
			if (empty($group)) {
				return null;
			}
		} elseif (is_numeric($group)) {
			$group = Mage::getModel('customer/group')->load($group);
				
			if (!$group || $group->isEmpty()) {
				return null;
			}
		}
		
		if (!($group instanceof Mage_Customer_Model_Group)) {
			return null;
		}
		
		/* @var $collection Egovs_Vies_Model_Resource_Group_Collection */
		$collection = $this->getCollection();
		$collection->getSelect()
			->where('customer_group_id = ?', $group->getId())
		;
		
		return $collection;
	}
	
	/**
	 * Liefert alle ausgewählten Länder
	 * 
	 * @param Mage_Customer_Model_Group $group Kundengruppe
	 * 
	 * @return array
	 */
	public function getSelectedCountriesArray($group)	{
		$collection = $this->getCollectionByGroup($group);
		if (!$collection) {
			return array();
		}
		$collection->getSelect()
			->columns('country_id')
		;
		$res = array();
		
		//$res[] = array('value' => '0', 'label'=>'Not Selected');
		foreach ($collection->getItems() as $item) {
			$res[] = $item->getCountryId();
		}
	
		 
		return $res;	
	}
	
	/**
	 * Macht die Zuordnung von Kundengruppe zu Land
	 * 
	 * @param Mage_Customer_Model_Group $group             Kundengruppe
	 * @param array                     $countriesToAssign Liste von Länder-Codes
	 * 
	 * @return void
	 * 
	 * @throws Egovs_Vies_Model_Resource_Exception_Duplicate
	 */
	public function assignCountries($group, $countriesToAssign) {
		$collection = $this->getCollectionByGroup($group);
		if (!$collection) {
			return;
		}
		
		/*
		 * 20150907::Frank Rochlitzer
		 * Support für EU-Länder für Magento 1.9 hinzugefügt
		 * Für Anzeige werden EU-Länder aus Liste gefilter und durch einen Eintrag EU ersetzt.
		 * Dies muss hier wieder rückgängig gemacht werden.
		 */
		$euCountries = explode(',', Mage::getStoreConfig(Mage_Core_Helper_Data::XML_PATH_EU_COUNTRIES_LIST, $storeId));
		if (($key = array_search('EU', $countriesToAssign)) !== false) {
			unset($countriesToAssign[$key]);
			$countriesToAssign = array_merge($countriesToAssign, $euCountries);
		}
		
		/* @var Egovs_Vies_Model_Group */
		$items = $collection->getItems();
		
		//Da wir über ein Event agieren, macht Magento das Transaktionsmanagement
		$errors = array();
		if (empty($items)) {
			foreach ($countriesToAssign as $countryId) {
				$emptyItem=$collection->getNewEmptyItem();
				$emptyItem->setCountryId($countryId);
				$emptyItem->setCustomerGroupId($group->getId());
				
				//Primärschlüssel setzen
				$emptyItem->setEntityId(
						sprintf(
								'%s%s%s',
								$emptyItem->getCountryId(),
								$group->getCompany(),
								$group->getTaxvat()
						)
				);
					
				try {
					$emptyItem->save();
				} catch (Egovs_Vies_Model_Resource_Exception_Duplicate $dup) {
					$errors[] = $dup;
				}
			}
		} else {
			//Neue items behandeln
			foreach ($countriesToAssign as $countryId) {
				if (isset($items[sprintf('%s%s%s', $countryId, $group->getCompany(), $group->getTaxvat())])) {
					continue;
				}
				/*
				 * 20130121::#1393
				* Änderung von Company und taxvat für Primärschlüsselt berücksichtigen
				*/
				$entityId = sprintf('%s%s%s', $countryId, $group->getOrigData('company'), $group->getOrigData('taxvat'));
				if (isset($items[$entityId])) {
					$items[$entityId]->delete();
				}
					
				$emptyItem=$collection->getNewEmptyItem();
				$emptyItem->setCountryId($countryId);
				$emptyItem->setCustomerGroupId($group->getId());
				
				//Primärschlüssel setzen
				$emptyItem->setEntityId(
						sprintf(
								'%s%s%s',
								$emptyItem->getCountryId(),
								$group->getCompany(),
								$group->getTaxvat()
						)
				);
				
				try {
					$emptyItem->save();
				} catch (Egovs_Vies_Model_Resource_Exception_Duplicate $dup) {
					$errors[] = $dup;
				}
			}

			//alte items löschen
			foreach ($items as $toDelete) {
				if (array_search($toDelete->getCountryId(), $countriesToAssign) !== false) {
					continue;
				}
					
				$toDelete->delete();
			}
		}

		if (!empty($errors)) {
			$message = '';
			//Maximal 10 Fehler anzeigen!
			$i = 0;
			for ($i; $i < count($errors) && $i < 10; $i++) {
				$message .= $errors[$i]->getMessage().'<br/>';
			}
			if (count($errors) > $i) {
				$message .= Mage::helper('egovsvies')->__('Showing %s from %s errors.', $i, count($errors));
			}
				
			throw new Egovs_Vies_Model_Resource_Exception_Duplicate($message);
		}
		
	}
}