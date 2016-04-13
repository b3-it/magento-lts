<?php
/**
 * Validiert die VAT - Nummer
 *
 * Diese Klasse kapselt die Methoden für Aufrufe die von Events ausgelöst wurden.
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Adminhtml_Customer_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Deaktiviert die automatische Kundengruppenzuordnung falls die Kundengruppe geändert wurde
	 * 
	 * Diese Funktion darf nur im Adminhtml-Kontext aufgerufen werden
	 * 
	 * @param Varien_Object $observer
	 * 
	 * @return void
	 */
	public function onAdminCustomerSaveBefore($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		
		if (!$customer || $customer->isEmpty() || !$customer->getUseGroupAutoassignment()) {
			return;
		}
		
		if ($customer->getOrigData('group_id') > 0 && $customer->getGroupId() != $customer->getOrigData('group_id')) {
			//Autozuordnung deaktivieren
			$customer->setUseGroupAutoassignment(false);
		}
	}
}