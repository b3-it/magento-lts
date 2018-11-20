<?php
class Egovs_Informationservice_Model_Customer_Observer
{
    public function rejectAddressEditing(Varien_Event_Observer $observer) {
		$block = $observer ['block'];

		/**
		 * @var Mage_Customer_Model_Address $address
		 */
		$address = $observer->getAddress();
		$address_id =  $address->getAddressId();
		if ($address_id == 0)
			return;
		
		if ($block instanceof Mage_Core_Block_Abstract) {
			if (! $block->getAddressEditingIsDenied()) {
				$collection = Mage::getModel ( 'informationservice/request' )->getCollection ();
				$collection->getSelect ()->where ( 'address_id= ?', intval($address_id));
				// echo ($collection->getSelect()->__toString());
				if (count ( $collection->getItems () ) > 0) {
					$block->setAddressEditingIsDenied(true);
				}
			}
		}
	}
}