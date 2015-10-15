<?php

class Egovs_Zahlpartnerkonten_Model_Observer extends Mage_Core_Model_Abstract
{

	/**
	 * Speichert eine Adressänderung im Kassenzeichenpool
	 * 
	 * Wird nach dem speichern eines Kunden aufgerufen.<br>
	 *  
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onCustomerSaveAfter($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		
		if (!$customer || $customer->getId() < 1) {
			return;
		}		
		
		if ($customer->getUseZpkonto() != 1) {
			return;
		}
				
		$pool = Mage::getModel('zpkonten/pool')->loadByCustomer($customer);
		if ($pool->getZpkontenPoolId() == 0) {
			return;
		} 
		if ($pool->getStatus()!= Egovs_Zahlpartnerkonten_Model_Status::STATUS_ZPKONTO) {
			return;
		}
		
		$pool->setData('customer_name', $customer->getFirstname().' '.$customer->getLastname());
		$pool->setData('customer_company', $customer->getCompany());
				
		$address = $customer->getDefaultBillingAddress();
		
		if ($address instanceof Mage_Customer_Model_Address) {
			$pool->setData('customer_street', $address->getStreetFull());
			$pool->setData('customer_city', $address->getCity());
			$pool->setData('customer_postcode', $address->getPostcode());
		}
		
		$pool->save();	
	}
	
	
}