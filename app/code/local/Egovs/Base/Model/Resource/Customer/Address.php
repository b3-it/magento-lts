<?php

class Egovs_Base_Model_Resource_Customer_Address extends Mage_Customer_Model_Resource_Address
{

	private static  $isSaved = false;
	
	
	
	protected function _afterSave(Varien_Object $address) {
		/*
		 * speichern der Adresseinstellungen für den Kunden
		 */
		$address->setIsSaved ( true );
		if (self::$isSaved) {
			return $this;
		}
		
		// BE
		if (Mage::app ()->getStore ()->isAdmin () || Mage::getDesign ()->getArea () == 'adminhtml') {
			if ($address->getId ()) {
				// f�r BE -- f�r neue Adressen
				$account = Mage::app ()->getRequest ()->getParam ( 'account', false );
				
				$customer = Mage::getModel ( 'customer/customer' );
				$customer->setId ( $address->getParentId () );
				$resource = $customer->getResource ();
				
				if ($address->getIsDefaultBilling ()) {
					$customer->setDefaultBilling ( $address->getId () );
					$resource->saveAttribute ( $customer, 'default_billing' );
				}
				if ($address->getIsDefaultShipping ()) {
					$customer->setDefaultShipping ( $address->getId () );
					$resource->saveAttribute ( $customer, 'default_shipping' );
				}
				
				if (isset($account ['base_address'])) {
    				$base = $account ['base_address'];
    				
    				if ($base == $address->getPostIndex ()) {
    					self::$isSaved = true;
    					$customer->setBaseAddress ( $address->getId () );
    					$resource->saveAttribute ( $customer, 'base_address' );
    					
    				}
				}
			}
		// FE
		} else {
			$base = Mage::app ()->getRequest ()->getParam ( 'base_address', false );
			
			if ($address->getId () && $address->getParentId ()) {
				$customer = Mage::getModel ( 'customer/customer' );
				
				$customer->setId ( $address->getParentId () );
				$resource = $customer->getResource ();
				
				if ($address->getIsDefaultBilling ()) {
					$customer->setDefaultBilling ( $address->getId () );
					$resource->saveAttribute ( $customer, 'default_billing' );
				}
				if ($address->getIsDefaultShipping ()) {
					$customer->setDefaultShipping ( $address->getId () );
					$resource->saveAttribute ( $customer, 'default_shipping' );
				}
				
				if ($address->getIsDefaultBaseAddress()) {
					$base = true;
				}
				
				if ($base) {
					self::$isSaved = true;
					$customer->setBaseAddress ( $address->getId () );
					$resource->saveAttribute ( $customer, 'base_address' );
					
				}
			}
		}
		return $this;
	}
}
