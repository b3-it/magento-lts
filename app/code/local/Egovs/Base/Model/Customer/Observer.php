<?php

/**
 * Observer f�r von Kundenoperationen ausgel�sten Events
 *
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @copyright  	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Base_Model_Customer_Observer
{
	/**
	 * Wird beim Speichern eines Kunden aufgerufen
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onCustomerSave($observer) {
		$customer = $observer->getCustomer();
		//nur für neue Kunden
		/* @var $customer Mage_Customer_Model_Customer */
		if (($customer != null) && (!$customer->getId())) {
			$adr = $customer->getAddressById($customer->getBaseAddress());
			if (!$adr || $adr->isEmpty()) {
				$adr = $customer->getDefaultBillingAddress();
				if ($adr == null) {
					$adresses = $customer->getAddresses();
					if (count($adresses) > 0 ) {
						$adr = $adresses[0];
					}
				}
			}
			
			if ($adr != null && !$adr->isEmpty()) {
				//falls keine company angegeben
				if (strlen($customer->getCompany()) < 1) {
					$customer->setCompany($adr->getCompany());
				}
			}
			
			$store_id = $customer->getStoreId();
			$website = $customer->getWebsiteId();
			if (($store_id != null) && ($website != 0)) {
				$store = Mage::getModel('core/store')->load($store_id);
				if ($website != $store->getWebsiteId()) {
					Mage::log(sprintf("WebsiteId=%s; StoreId=%s not associated.",$website, $store_id),Zend_Log::ERR, Egovs_Helper::LOG_FILE);
					Mage::throwException(Mage::helper('egovsbase')->__("Selected store and website are not associated!"));				
				}
			}
			
		}
	}
	
	/**
	 * Loggt das Löschen von Kunden
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onCustomerDeleteAfter($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		
		if (!$customer || $customer->isEmpty()) {
			return;
		}
		
		/* @var $adminSession Mage_Admin_Model_Session */
		$adminSession = Mage::getSingleton('admin/session');
		
		$remoteAddr = "empty";
		$validatorData = new Varien_Object($adminSession->getValidatorData());
		if ($validatorData->getRemoteAddr() != '') {
			$remoteAddr = $validatorData->getRemoteAddr();
		}
		$userName = "unknown";
		if ($adminSession->getUser()) {
			$userName = $adminSession->getUser()->getUsername();
		}
		
		Mage::log(
				sprintf('CUSTOMER_DELETE::Customer with ID: %d was deleted by user "%s" with IP: %s',
						$customer->getId(),
						$userName,
						$remoteAddr
				),
				Zend_Log::NOTICE,
				Egovs_Helper::CUSTOMER_LOG,
				true
		);
	}
}